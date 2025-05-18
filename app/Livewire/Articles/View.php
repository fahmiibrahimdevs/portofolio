<?php

namespace App\Livewire\Articles;

use Carbon\Carbon;
use Livewire\Component;
use App\Models\ArticlePost;

class View extends Component
{
    public $date, $title, $description, $fill_content, $status_publish;

    public function mount($slug)
    {
        Carbon::setLocale('id');
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
