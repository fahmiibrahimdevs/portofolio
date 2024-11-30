<?php

namespace App\Livewire\Module\Projects;

use Livewire\Component;
use Illuminate\Support\Str;
use Livewire\WithPagination;
use Livewire\WithFileUploads;
use Livewire\Attributes\Title;
use App\Models\ProjectCategory;
use App\Models\ProjectSubCategory;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use App\Models\Project as ModelsProject;
use App\Models\ProjectDetail;
use App\Models\ProjectImage;
use App\Models\ProjectTag;

class Project extends Component
{
    use WithFileUploads;
    use WithPagination;
    #[Title('Projects - Project')]
    protected $paginationTheme = 'bootstrap';

    protected $listeners = [
        'delete'
    ];
    protected $rules = [
        'title'     => 'required',
        'thumbnail' => 'nullable|image|mimes:jpg,jpeg,png,gif|max:4096', // max 4MB
        'images.*' => 'nullable|image|mimes:jpg,jpeg,png,gif|max:1024000', // max 1GB
    ];

    public $lengthData = 25;
    public $searchTerm;
    public $previousSearchTerm = '';
    public $isEditing = false;
    public $categories, $subcategories, $tags;
    public $dataId, $category_id, $sub_category_id, $tag_id, $thumbnail, $date, $title, $slug, $price, $description, $status_publish, $version, $link_demo;
    public $text, $images;

    public function mount()
    {
        $this->images = [];
        $this->date         = date('Y-m-d H:i');
        $this->categories       = ProjectCategory::select('id', 'category_name')->get()->toArray();
        $this->category_id     = ProjectCategory::min('id');
        $this->subcategories    = ProjectSubCategory::select('id', 'sub_category_name')->where('category_id', $this->category_id)->get()->toArray();
        $this->sub_category_id = [];
        $this->text = [];
        $this->tags = ProjectTag::select('id', 'tag_name')->get()->toArray();
        $this->tag_id     = [];
        $this->title           = '';
        $this->slug            = null;
        $this->price            = "0";
        $this->description       = '-';
        $this->status_publish  = 'Draft';
        $this->version  = '1.0.0';
        $this->link_demo  = 'http://';
    }

    public function addText()
    {
        $this->text[] = ['left_text' => '', 'right_text' => ''];
    }

    public function removeText($index)
    {
        unset($this->text[$index]);
        $this->text = array_values($this->text);
    }

    private function initSelect2()
    {
        $this->dispatch('initSelect2');
        $this->dispatch('initSummernote');
    }

    public function updatingLengthData()
    {
        $this->resetPage();
    }

    private function searchResetPage()
    {
        if ($this->searchTerm !== $this->previousSearchTerm) {
            $this->resetPage();
        }

        $this->previousSearchTerm = $this->searchTerm;
    }

    public function updatedCategoryId()
    {
        $this->subcategories    = ProjectSubCategory::select('id', 'sub_category_name')->where('category_id', $this->category_id)->get()->toArray();
        $this->dispatch('initSelect2SubCategory');
    }

    public function render()
    {
        $this->searchResetPage();
        $search = '%' . $this->searchTerm . '%';

        $data = ModelsProject::select('projects.id', 'thumbnail', 'date', 'title', 'slug', 'project_sub_categories.sub_category_name')
            ->join('project_sub_categories', 'project_sub_categories.id', 'projects.sub_category_id')
            ->where(function ($query) use ($search) {
                $query->where('title', 'LIKE', $search);
                $query->orWhere('date', 'LIKE', $search);
            })
            ->orderBy('id', 'ASC')
            ->paginate($this->lengthData);

        return view('livewire.module.projects.project', compact('data'));
    }

    private function dispatchAlert($type, $message, $text)
    {
        $this->dispatch('swal:modal', [
            'type'      => $type,
            'message'   => $message,
            'text'      => $text
        ]);

        $this->resetInputFields();
    }

    public function isEditingMode($mode)
    {
        $this->isEditing = $mode;
        $this->initSelect2();
    }

    private function resetInputFields()
    {
        $this->mount();
    }

    public function cancel()
    {
        $this->resetInputFields();
    }

    public function store()
    {
        $this->validate();
    
        if ($this->thumbnail) {
            $thumbnailPath = $this->thumbnail->storeAs('thumbnails', Str::slug(pathinfo($this->thumbnail->getClientOriginalName(), PATHINFO_FILENAME))
            . rand(0,999) . '.' . $this->thumbnail->getClientOriginalExtension(), 'public'); 
        } else {
            $thumbnailPath = null;
        }
    
        $projects = ModelsProject::create([
            'user_id'          => Auth::user()->id,
            'category_id'      => $this->category_id,
            'sub_category_id'  => implode(',', $this->sub_category_id),
            'tag_id'           => implode(',', $this->tag_id),
            'thumbnail'        => $thumbnailPath,
            'date'             => $this->date,
            'title'            => $this->title,
            'slug'             => strtolower(Str::slug($this->slug) != "" ? Str::slug($this->slug) : Str::slug($this->title)),
            'price'      => $this->price,
            'description'      => $this->description,
            'status_publish'   => $this->status_publish,
            'version'          => $this->version,
            'link_demo'        => $this->link_demo,
        ]);

        $project_image = [];
        foreach($this->images as $image) {
            $thumbnailPath = $image->storeAs('gallery-project', Str::slug(pathinfo($image->getClientOriginalName(), PATHINFO_FILENAME)) 
            . rand(0,999) . '.' . $image->getClientOriginalExtension(), 'public');
            $project_image[] = [
                'project_id' => $projects->id,
                'image'     => $thumbnailPath,
            ];
        }

        ProjectImage::insert($project_image);

        $project_detail = [];
        foreach ($this->text as $row) {
            $project_detail[] = [
                'project_id' => $projects->id,
                'left_text'  => $row['left_text'] ?? '-',
                'right_text' => $row['right_text'] ?? '-',
            ];
        }

        ProjectDetail::insert($project_detail);
    
        $this->dispatchAlert('success', 'Success!', 'Data created successfully.');
        $this->resetInputFields();
    }

    public function edit($id)
    {
        $this->isEditing = true;
        $data = ModelsProject::where('id', $id)->first();
        $this->dataId          = $id;
        $this->category_id     = $data->category_id;
        $this->sub_category_id = explode(',', $data->sub_category_id);
        $this->date         = $data->date;
        $this->title           = $data->title;
        $this->slug            = $data->slug;
        $this->description       = $data->description;
        $this->status_publish  = $data->status_publish;
        $this->subcategories    = ProjectSubCategory::select('id', 'sub_category_name')->where('category_id', $this->category_id)->get()->toArray();
        $this->version            = $data->version;
        $this->link_demo            = $data->link_demo;
        $this->text = ProjectDetail::select('left_text', 'right_text')->where('project_id', $id)->get()->toArray();
        $this->tag_id = explode(',', $data->tag_id);
        $this->dispatch('initSelect2SubCategory');

        $this->initSelect2();
    }

    public function update()
    {
        $this->validate();

        if ($this->dataId) {
            $project = ModelsProject::findOrFail($this->dataId);

            if ($this->thumbnail) {
                if ($project->thumbnail && Storage::exists($project->thumbnail)) {
                    Storage::delete($project->thumbnail);
                }
                $originalFileName = Str::slug(pathinfo($this->thumbnail->getClientOriginalName(), PATHINFO_FILENAME))
                                    . rand(0,999) . '.' . $this->thumbnail->getClientOriginalExtension();
                $thumbnailPath = $this->thumbnail->storeAs('thumbnails', $originalFileName, 'public');
            } else {
                $thumbnailPath = $project->thumbnail;
            }

            $project->update([
                'category_id'     => $this->category_id,
                'sub_category_id' => implode(',', $this->sub_category_id),
                'tag_id'           => implode(',', $this->tag_id),
                'thumbnail'       => $thumbnailPath,
                'date'             => $this->date,
                'title'            => $this->title,
                'slug'             => strtolower(Str::slug($this->slug) != "" ? Str::slug($this->slug) : Str::slug($this->title)),
                'price'      => $this->price,
                'description'      => $this->description,
                'status_publish'   => $this->status_publish,
                'version'          => $this->version,
                'link_demo'        => $this->link_demo,
            ]);

            // dd($this->images);

            $oldImages = ProjectImage::select('image')->where('project_id', $this->dataId)->get()->pluck('image')->toArray();

            if ($this->images && count($this->images) > 0) {
                // Hapus gambar lama jika ada
                if ($oldImages) {
                    foreach ($oldImages as $image) {
                        if (Storage::exists($image)) {
                            Storage::delete($image);
                        }
                    }
                    // Hapus data gambar lama dari database
                    ProjectImage::where('project_id', $this->dataId)->delete();
                }

                $project_image = [];
                // Simpan gambar baru
                foreach ($this->images as $image) {
                    $thumbnailPath = $image->storeAs(
                        'gallery-project', 
                        Str::slug(pathinfo($image->getClientOriginalName(), PATHINFO_FILENAME)) 
                        . rand(0, 999) . '.' . $image->getClientOriginalExtension(),
                        'public'
                    );
                    $project_image[] = [
                        'project_id' => $this->dataId, // Asumsi ingin menghubungkan gambar dengan project yang sedang diproses
                        'image' => $thumbnailPath,
                    ];
                }

                ProjectImage::insert($project_image);
            }

            ProjectDetail::where('project_id', $this->dataId)->delete();

            $project_detail = [];
            foreach ($this->text as $row) {
                $project_detail[] = [
                    'project_id' => $this->dataId,
                    'left_text'  => $row['left_text'] ?? '-',
                    'right_text' => $row['right_text'] ?? '-',
                ];
            }

            ProjectDetail::insert($project_detail);
    
            $this->dispatchAlert('success', 'Success!', 'Data updated successfully.');
            $this->resetInputFields();
            $this->dataId = null;
        }
    }

    public function deleteConfirm($id)
    {
        $this->dataId = $id;
        $this->dispatch('swal:confirm', [
            'type'      => 'warning',
            'message'   => 'Are you sure?',
            'text'      => 'If you delete the data, it cannot be restored!'
        ]);
    }

    public function delete()
    {
        ModelsProject::findOrFail($this->dataId)->delete();
        $this->dispatchAlert('success', 'Success!', 'Data deleted successfully.');
        $this->resetInputFields();
    }
}
