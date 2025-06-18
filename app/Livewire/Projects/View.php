<?php

namespace App\Livewire\Projects;

use App\Models\Project;
use Livewire\Component;
use App\Models\ProjectImage;
use App\Models\ProjectDetail;
use Illuminate\Support\Facades\DB;

class View extends Component
{
    public $data, $title;
    public $project_image, $project_detail, $project_tags;

    public function mount($slug)
    {
        $this->data = Project::select('projects.*', 'project_categories.category_name', 'users.name')
            ->join('users', 'users.id', 'projects.user_id')
            ->join('project_categories', 'project_categories.id', 'projects.category_id')
            ->where('projects.slug', $slug)
            ->firstOrFail();

        $this->title = $this->data->title ?? "";

        // Split tag_id jadi array
        $tagIds = explode(',', $this->data->tag_id);

        // Ambil nama tag dari tabel project_tags
        $this->project_tags = DB::table('project_tags')
            ->whereIn('id', $tagIds)
            ->pluck('tag_name')
            ->toArray();

        // dd($this->project_tags);

        $this->project_image = ProjectImage::where('project_id', $this->data->id)->get();
        $this->project_detail = ProjectDetail::where('project_id', $this->data->id)->get();
    }

    public function render()
    {
        return view('livewire.projects.view')->extends('components.layouts.welcome')->title($this->title);
    }
}
