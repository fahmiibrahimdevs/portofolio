<?php

namespace App\Livewire\Module\Projects;

use Livewire\Component;
use Livewire\WithPagination;
use Livewire\Attributes\Title;
use App\Models\ProjectCategory;
use App\Models\ProjectSubCategory;

class SubCategory extends Component
{
    use WithPagination;
    protected $paginationTheme = 'bootstrap';
    #[Title('Projects - Sub Category')]

    protected $listeners = [
        'delete'
    ];
    protected $rules = [
        'category_id'     => 'required',
        'sub_category_name'  => 'required',
    ];

    public $lengthData = 25;
    public $searchTerm;
    public $previousSearchTerm = '';
    public $isEditing = false;

    public $dataId, $category_id, $sub_category_name, $description, $categories;

    public function mount()
    {
        $this->categories = ProjectCategory::select('id', 'category_name')->get();

        $this->category_id    = ProjectCategory::min('id');
        $this->sub_category_name = '';
        $this->description      = '';
    }

    private function initSelect2()
    {
        $this->dispatch('initSelect2');
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

    public function render()
    {
        $this->initSelect2();

        $this->searchResetPage();
        $search = '%' . $this->searchTerm . '%';

        $data = ProjectSubCategory::select('project_sub_categories.*', 'project_categories.category_name')
            ->join('project_categories', 'project_categories.id', 'project_sub_categories.category_id')
            ->where('sub_category_name', 'LIKE', $search)
            ->orWhere('description', 'LIKE', $search)
            ->orWhere('category_name', 'LIKE', $search)
            ->orderBy('id', 'ASC')
            ->paginate($this->lengthData);

        return view('livewire.module.projects.sub-category', compact('data'));
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
    }

    private function resetInputFields()
    {
        $this->sub_category_name = '';
        $this->description      = '';
    }

    public function cancel()
    {
        $this->resetInputFields();
    }

    public function store()
    {
        $this->validate();

        ProjectSubCategory::create([
            'category_id'     => $this->category_id,
            'sub_category_name'  => $this->sub_category_name,
            'description'       => $this->description,
        ]);

        $this->dispatchAlert('success', 'Success!', 'Data created successfully.');
        $this->resetInputFields();
    }

    public function edit($id)
    {
        $this->isEditing = true;
        $data = ProjectSubCategory::where('id', $id)->first();
        $this->dataId           = $id;
        $this->category_id    = $data->category_id;
        $this->sub_category_name = $data->sub_category_name;
        $this->description      = $data->description;
    }

    public function update()
    {
        $this->validate();

        if ($this->dataId) {
            ProjectSubCategory::findOrFail($this->dataId)->update([
                'category_id'     => $this->category_id,
                'sub_category_name'  => $this->sub_category_name,
                'description'       => $this->description,
            ]);
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
        ProjectSubCategory::findOrFail($this->dataId)->delete();
        $this->dispatchAlert('success', 'Success!', 'Data deleted successfully.');
        $this->resetInputFields();
    }
}
