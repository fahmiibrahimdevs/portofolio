<?php

namespace App\Livewire;

use App\Models\ArticlePost;
use App\Models\Project;
use Livewire\Component;
use Livewire\Attributes\Title;

class Welcome extends Component
{
    #[Title('Fahmi Ibrahim')]
    
    public function render()
    {
        $projects = Project::select('projects.id', 'thumbnail', 'date', 'title', 'slug', 'link_demo', 'project_sub_categories.sub_category_name')
            ->join('project_sub_categories', 'project_sub_categories.id', 'projects.sub_category_id')
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
