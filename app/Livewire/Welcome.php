<?php

namespace App\Livewire;

use App\Models\Project;
use Livewire\Component;
use App\Models\ArticlePost;
use Livewire\Attributes\Title;
use Illuminate\Support\Facades\DB;

class Welcome extends Component
{
    #[Title('Fahmi Ibrahim')]

    public $total_projects;

    public function mount()
    {
        $this->total_projects = DB::table('projects')->count();
    }

    public function render()
    {
        $projects = Project::select('projects.id', 'thumbnail', 'title', 'slug', 'link_demo', 'link_github', 'short_desc', 'project_categories.category_name')
            ->join('project_categories', 'project_categories.id', 'projects.category_id')
            ->orderBy('id', 'DESC')
            ->limit(4)
            ->get();

        $articles = ArticlePost::select('article_posts.id', 'thumbnail', 'date', 'title', 'slug', 'article_categories.category_name')
            ->join('article_categories', 'article_categories.id', 'article_posts.category_id')
            ->orderBy('id', 'DESC')
            ->limit(4)
            ->get();

        return view('livewire.welcome', compact('projects',  'articles'))->extends('components.layouts.welcome');
    }
}
