<?php

namespace App\Livewire\Articles;

use App\Models\ArticlePost;
use Livewire\Component;

class View extends Component
{
    public $date, $title, $description, $fill_content, $status_publish;

    public function mount($slug)
    {
        $data = ArticlePost::select('*')->where('slug', $slug)->firstOrFail();
        $this->date = $data->date ?? "";
        $this->title = $data->title ?? "";
        $this->description = $data->description ?? "";
        $this->fill_content = $data->fill_content ?? "";
        $this->status_publish = $data->status_publish ?? "";
    }

    public function render()
    {
        return view('livewire.articles.view')->extends('components.layouts.welcome')->title($this->title);
    }
}
