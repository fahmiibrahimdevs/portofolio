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
    public $project_categories, $total_projects, $cat;
    public $category_id;

    public function mount()
    {
        $this->category_id = 0;

        if ($this->category_id == 0) {
            $this->cat = (object)[
                'id' => 0,
                'category_name' => 'Semua',
                'category_desc' => 'Download berbagai source code dan script web lengkap untuk mendukung proyekmu, mulai dari aplikasi hingga fitur custom.'
            ];
        } else {
            $this->cat = ProjectCategory::find($this->category_id) ?? null;
        }

        $this->total_projects = DB::table('projects')->count();
    }

    public function changeCategoryId($id)
    {
        $this->category_id = $id;

        if ($id == 0) {
            $this->cat = (object)[
                'id' => 0,
                'category_name' => 'Semua',
                'category_desc' => 'Download berbagai source code dan script web lengkap untuk mendukung proyekmu, mulai dari aplikasi hingga fitur custom.'
            ];
        } else {
            $this->cat = ProjectCategory::find($id) ?? null;
        }

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
            ->leftJoin('projects', 'projects.category_id', '=', 'project_categories.id')
            ->select(
                'project_categories.id as category_id',
                'project_categories.category_name',
                DB::raw('COUNT(projects.id) as total_projects')
            )
            ->groupBy('project_categories.id', 'project_categories.category_name')
            ->get()
            ->keyBy('category_id'); // KeyBy lebih cocok dari groupBy di sini

        $projects = Project::select('thumbnail', 'title', 'slug', 'link_github', 'short_desc', 'category_name', 'category_id')
            ->leftJoin('project_categories', 'project_categories.id', '=', 'projects.category_id')
            ->when($this->category_id != 0, function ($query) {
                return $query->where('projects.category_id', $this->category_id);
            })
            ->where(function ($query) use ($search) {
                $query->where('title', 'LIKE', $search);
            })
            ->orderBy('projects.id', 'DESC')
            ->paginate($this->lengthData);

        return view('livewire.projects.projects', compact('projects'))->extends('components.layouts.welcome');
    }
}
