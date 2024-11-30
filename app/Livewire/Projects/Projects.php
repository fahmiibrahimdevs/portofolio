<?php

namespace App\Livewire\Projects;

use App\Models\Project;
use Livewire\Component;
use Livewire\WithPagination;
use Livewire\Attributes\Title;
use App\Models\ProjectCategory;
use Illuminate\Support\Facades\DB;

class Projects extends Component
{
    use WithPagination;
    #[Title('Projects')]
    protected $paginationTheme = 'simple-tailwind';

    public $lengthData = 9;
    public $searchTerm;
    public $previousSearchTerm = '';
    public $project_categories;
    public $category_id, $sub_category_id;

    public function mount()
    {
        $this->category_id = 1;
        $this->sub_category_id = 0;
    }

    public function changeCategoryId($id)
    {
        $this->category_id = $id;
        $this->sub_category_id = 0;
        $this->dispatch('removeOverlay');
    }

    public function changeSubCategoryId($id)
    {
        $this->sub_category_id = $id;
        $this->dispatch('removeOverlay');
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
        $this->searchResetPage();
        $search = '%' . $this->searchTerm . '%';

        $this->project_categories = DB::table('project_categories')
            ->leftJoin('project_sub_categories', 'project_sub_categories.category_id', '=', 'project_categories.id')
            ->select(
                'project_categories.id as category_id',
                'project_categories.category_name',
                'project_sub_categories.id as sub_category_id',
                'project_sub_categories.sub_category_name'
            )
            ->get()
            ->groupBy('category_id'); // Grupkan berdasarkan kategori

        $projects = Project::select('thumbnail', 'title', 'slug', 'price', 'sub_category_name')
            ->join('project_sub_categories', 'project_sub_categories.id', '=', 'projects.sub_category_id')
            ->where('projects.category_id', $this->category_id)
            ->when($this->sub_category_id != 0, function ($query) {
                return $query->where('projects.sub_category_id', $this->sub_category_id);
            })
            ->where(function($query) use ($search) {
                $query->where('title', 'LIKE', $search);
                $query->orWhere('price', 'LIKE', $search);
            })
            ->paginate($this->lengthData);

        return view('livewire.projects.projects', compact('projects'))->extends('components.layouts.welcome');
    }
}
