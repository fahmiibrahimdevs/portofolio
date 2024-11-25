<?php

namespace App\Livewire\Module\Articles;

use Livewire\Component;
use Livewire\WithPagination;
use Livewire\Attributes\Title;
use App\Models\ArticleCategory;

class Category extends Component
{
    use WithPagination;
    #[Title('Category')]
    protected $paginationTheme = 'bootstrap';

    protected $listeners = [
        'delete'
    ];
    protected $rules = [
        'category_name'     => 'required',
    ];

    public $lengthData = 15;
    public $searchTerm;
    public $previousSearchTerm = '';
    public $isEditing = false;

    public $dataId, $category_name;

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

        $data = ArticleCategory::where('category_name', 'LIKE', $search)
            ->orderBy('id', 'ASC')
            ->paginate($this->lengthData);

        return view('livewire.module.articles.category', compact('data'));
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
        $this->category_name = '';
    }

    public function cancel()
    {
        $this->resetInputFields();
    }

    public function store()
    {
        $this->validate();

        ArticleCategory::create([
            'category_name'     => $this->category_name,
        ]);

        $this->dispatchAlert('success', 'Success!', 'Data created successfully.');
        $this->resetInputFields();
    }

    public function edit($id)
    {
        $this->isEditing = true;
        $data = ArticleCategory::where('id', $id)->first();
        $this->dataId           = $id;
        $this->category_name    = $data->category_name;
    }

    public function update()
    {
        $this->validate();

        if ($this->dataId) {
            ArticleCategory::findOrFail($this->dataId)->update([
                'category_name'     => $this->category_name
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
        ArticleCategory::findOrFail($this->dataId)->delete();
        $this->dispatchAlert('success', 'Success!', 'Data deleted successfully.');
        $this->resetInputFields();
    }
}