<?php

namespace App\Livewire\Module\Projects;

use App\Models\ProjectTag;
use Livewire\Component;
use Livewire\WithPagination;
use Livewire\Attributes\Title;

class Tag extends Component
{
    use WithPagination;
    #[Title('Project - Tag')]
    protected $paginationTheme = 'bootstrap';

    protected $listeners = [
        'delete'
    ];
    protected $rules = [
        'tag_name'     => 'required',
    ];

    public $lengthData = 15;
    public $searchTerm;
    public $previousSearchTerm = '';
    public $isEditing = false;

    public $dataId, $tag_name;

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
        $this->searchResetPage();
        $search = '%' . $this->searchTerm . '%';

        $data = ProjectTag::where('tag_name', 'LIKE', $search)
            ->orderBy('id', 'ASC')
            ->paginate($this->lengthData);

        return view('livewire.module.projects.tag', compact('data'));
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
        $this->tag_name = '';
    }

    public function cancel()
    {
        $this->resetInputFields();
    }

    public function store()
    {
        $this->validate();

        ProjectTag::create([
            'tag_name'     => $this->tag_name,
        ]);

        $this->dispatchAlert('success', 'Success!', 'Data created successfully.');
        $this->resetInputFields();
    }

    public function edit($id)
    {
        $this->isEditing = true;
        $data = ProjectTag::where('id', $id)->first();
        $this->dataId           = $id;
        $this->tag_name    = $data->tag_name;
    }

    public function update()
    {
        $this->validate();

        if ($this->dataId) {
            ProjectTag::findOrFail($this->dataId)->update([
                'tag_name'     => $this->tag_name
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
        ProjectTag::findOrFail($this->dataId)->delete();
        $this->dispatchAlert('success', 'Success!', 'Data deleted successfully.');
        $this->resetInputFields();
    }
}
