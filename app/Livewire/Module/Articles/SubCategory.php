<?php

namespace App\Livewire\Module\Articles;

use App\Models\ArticleCategory;
use App\Models\ArticleSubCategory;
use Livewire\Component;
use Livewire\WithPagination;
use Livewire\Attributes\Title;

class SubCategory extends Component
{
    use WithPagination;
    protected $paginationTheme = 'bootstrap';
    #[Title('Articles - Sub Category')]

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

    public $dataId, $category_id, $sub_category_name, $description, $image, $categories;

    public function mount()
    {
        $this->categories = ArticleCategory::select('id', 'category_name')->get();

        $this->category_id    = ArticleCategory::min('id');
        $this->sub_category_name = '';
        $this->description      = '';
        $this->image            = '';
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

        $data = ArticleSubCategory::select('article_sub_categories.*', 'article_categories.category_name')
            ->join('article_categories', 'article_categories.id', 'article_sub_categories.category_id')
            ->where('sub_category_name', 'LIKE', $search)
            ->orWhere('description', 'LIKE', $search)
            ->orWhere('category_name', 'LIKE', $search)
            ->orderBy('category_name', 'ASC')
            ->paginate($this->lengthData);

        return view('livewire.module.articles.sub-category', compact('data'));
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
        $this->image            = '';
    }

    public function cancel()
    {
        $this->resetInputFields();
    }

    public function store()
    {
        $this->validate();

        ArticleSubCategory::create([
            'category_id'     => $this->category_id,
            'sub_category_name'  => $this->sub_category_name,
            'description'       => $this->description,
            'image'             => $this->image,
        ]);

        $this->dispatchAlert('success', 'Success!', 'Data created successfully.');
        $this->resetInputFields();
    }

    public function edit($id)
    {
        $this->isEditing = true;
        $data = ArticleSubCategory::where('id', $id)->first();
        $this->dataId           = $id;
        $this->category_id    = $data->category_id;
        $this->sub_category_name = $data->sub_category_name;
        $this->description      = $data->description;
        $this->image            = $data->image;
    }

    public function update()
    {
        $this->validate();

        if ($this->dataId) {
            ArticleSubCategory::findOrFail($this->dataId)->update([
                'category_id'     => $this->category_id,
                'sub_category_name'  => $this->sub_category_name,
                'description'       => $this->description,
                'image'             => $this->image,
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
        ArticleSubCategory::findOrFail($this->dataId)->delete();
        $this->dispatchAlert('success', 'Success!', 'Data deleted successfully.');
        $this->resetInputFields();
    }
}
