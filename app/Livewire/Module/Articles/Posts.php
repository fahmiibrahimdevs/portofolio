<?php

namespace App\Livewire\Module\Articles;

use Livewire\Component;
use App\Models\ArticlePost;
use Illuminate\Support\Str;
use Livewire\WithPagination;
use Livewire\Attributes\Title;
use App\Models\ArticleCategory;
use App\Models\ArticleSubCategory;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Livewire\WithFileUploads;

class Posts extends Component
{
    use WithPagination;
    use WithFileUploads;
    #[Title('Article - Posts')]

    protected $listeners = [
        'delete'
    ];
    protected $rules = [
        'category_id' => 'required',
        'sub_category_id' => 'required',
        'title' => 'required',
        'thumbnail' => 'nullable|image|mimes:jpg,jpeg,png,gif|max:4096', // max 4MB
    ];

    public $lengthData = 25;
    public $searchTerm;
    public $previousSearchTerm = '';
    public $isEditing = false;
    public $categories, $subcategories;
    public $dataId, $category_id, $sub_category_id, $thumbnail, $date, $title, $slug, $description, $fill_content, $status_publish;

    public function mount()
    {
        $this->date         = date('Y-m-d H:i');
        $this->categories       = ArticleCategory::select('id', 'category_name')->get()->toArray();
        $this->category_id     = ArticleCategory::min('id');
        $this->subcategories    = ArticleSubCategory::select('id', 'sub_category_name')->where('category_id', $this->category_id)->get()->toArray();
        $this->sub_category_id = [];
        $this->title           = '';
        $this->slug            = null;
        $this->description       = '';
        $this->fill_content      = '';
        $this->status_publish  = 'Draft';
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
        $this->subcategories    = ArticleSubCategory::select('id', 'sub_category_name')->where('category_id', $this->category_id)->get()->toArray();
        $this->dispatch('initSelect2SubCategory');
    }

    public function render()
    {
        $this->searchResetPage();
        $search = '%' . $this->searchTerm . '%';

        $data = ArticlePost::select('id', 'sub_category_id', 'thumbnail', 'date', 'title', 'slug', 'status_publish')
            ->where(function ($query) use ($search) {
                $query->where('title', 'LIKE', $search);
                $query->orWhere('date', 'LIKE', $search);
            })
            ->orderBy('id', 'DESC')
            ->paginate($this->lengthData);

        return view('livewire.module.articles.posts', compact('data'));
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

        ArticlePost::create([
            'user_id'         => Auth::user()->id,
            'category_id'     => $this->category_id,
            'sub_category_id' => implode(',', $this->sub_category_id),
            'thumbnail'     => $thumbnailPath,
            'date'         => $this->date,
            'title'           => $this->title,
            'slug'            => strtolower(Str::slug($this->slug) != "" ? Str::slug($this->slug) : Str::slug($this->title)),
            'description'       => $this->description,
            'fill_content'      => $this->fill_content,
            'status_publish'  => $this->status_publish,
        ]);

        $this->dispatchAlert('success', 'Success!', 'Data created successfully.');
    }

    public function edit($id)
    {
        $this->isEditing       = true;
        $data                  = ArticlePost::findOrFail($id);
        $this->dataId          = $id;
        $this->category_id     = $data->category_id;
        $this->sub_category_id = explode(',', $data->sub_category_id);
        $this->date         = $data->date;
        $this->title           = $data->title;
        $this->slug            = $data->slug;
        $this->description       = $data->description;
        $this->fill_content      = $data->fill_content;
        $this->status_publish  = $data->status_publish;
        $this->subcategories    = ArticleSubCategory::select('id', 'sub_category_name')->where('category_id', $this->category_id)->get()->toArray();
        // dd($this->subcategories);
        $this->dispatch('initSelect2SubCategory');

        $this->initSelect2();
    }

    public function update()
    {
        $this->validate();

        if ($this->dataId) {
            $posts = ArticlePost::findOrFail($this->dataId);

            if ($this->thumbnail) {
                if ($posts->thumbnail && Storage::exists($posts->thumbnail)) {
                    Storage::delete($posts->thumbnail);
                }
                $originalFileName = Str::slug(pathinfo($this->thumbnail->getClientOriginalName(), PATHINFO_FILENAME))
                                    . rand(0,999) . '.' . $this->thumbnail->getClientOriginalExtension();
                $thumbnailPath = $this->thumbnail->storeAs('thumbnails', $originalFileName, 'public');
            } else {
                $thumbnailPath = $posts->thumbnail;
            }

            ArticlePost::findOrFail($this->dataId)->update([
                'user_id'         => Auth::user()->id,
                'category_id'     => $this->category_id,
                'sub_category_id' => implode(',', $this->sub_category_id),
                'thumbnail'     => $thumbnailPath,
                'date'         => $this->date,
                'title'           => $this->title,
                'slug'            => strtolower(Str::slug($this->slug) != "" ? Str::slug($this->slug) : Str::slug($this->title)),
                'description'       => $this->description,
                'fill_content'      => $this->fill_content,
                'status_publish'  => $this->status_publish,
            ]);

            $this->dispatchAlert('success', 'Success!', 'Data updated successfully.');
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
        ArticlePost::findOrFail($this->dataId)->delete();
        $this->dispatchAlert('success', 'Success!', 'Data deleted successfully.');
    }
}