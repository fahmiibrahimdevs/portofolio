<?php

namespace App\Livewire\Projects;

use App\Models\Project;
use App\Models\ProjectDetail;
use App\Models\ProjectImage;
use Livewire\Component;

class View extends Component
{
    public $data, $title;
    public $project_image, $project_detail;

    public function mount($slug)
    {
        $this->data = Project::select('projects.*', 'project_categories.category_name', 'users.name')->join('users', 'users.id', 'projects.user_id')->join('project_categories', 'project_categories.id', 'projects.category_id')->where('projects.slug', $slug)->firstOrFail();
        $this->title = $data->title ?? "";
        $this->project_image = ProjectImage::where('project_id', $this->data->id)->get();
        $this->project_detail = ProjectDetail::where('project_id', $this->data->id)->get();
    }

    public function render()
    {
        return view('livewire.projects.view')->extends('components.layouts.welcome')->title($this->title);
    }
}
