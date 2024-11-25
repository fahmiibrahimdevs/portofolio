<?php

namespace App\Livewire\Articles;

use App\Models\ArticleCategory;
use App\Models\ArticlePost;
use App\Models\ArticleSubCategory;
use Livewire\Component;
use Livewire\WithPagination;
use Livewire\Attributes\Title;

class Articles extends Component
{
    use WithPagination;
    #[Title('Articles')]

    protected $paginationTheme = 'tailwind';
    public $sub_category, $sub_category_id, $data;

    public function mount($sub_category = null)
    {
        $this->sub_category_id = ArticleSubCategory::where('sub_category_name', $sub_category)->first()->id ?? 0;
        $this->sub_category = $sub_category;
    }

    public function render()
    {
        if ($this->sub_category_id == 0) {
            $this->data = ArticleCategory::select('article_categories.category_name', 'article_sub_categories.image', 'article_sub_categories.sub_category_name')
                ->join('article_sub_categories', 'article_sub_categories.category_id', 'article_categories.id')
                ->get();

            $posts = [];
        } else {
            $posts = ArticlePost::select('*')
                ->whereRaw("FIND_IN_SET(?, sub_category_id) > 0", [$this->sub_category_id])
                ->where('status_publish', 'Published')
                ->paginate(10);
        }

        return view('livewire.articles.articles', compact('posts'))->extends('components.layouts.welcome');
    }
}
