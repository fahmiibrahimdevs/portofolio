<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ArticlePost extends Model
{
    protected $table    = "article_posts";
    protected $guarded  = [];

    public function getTags()
    {
        $IdSubCategory = explode(',', $this->sub_category_id);
        return ArticleSubCategory::select('sub_category_name')->whereIn('id', $IdSubCategory)->get();
    }
}
