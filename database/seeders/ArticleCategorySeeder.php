<?php

namespace Database\Seeders;

use App\Models\ArticleCategory;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class ArticleCategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $data = [
            ['category_name'  => 'Languages'],
            ['category_name'  => 'Databases'],
            ['category_name'  => 'JavaScript Library'],
            ['category_name'  => 'Framework'],
            ['category_name'  => 'Microcontroller'],
            ['category_name'  => 'Others'],
            ['category_name'  => 'Server'],
        ];

        ArticleCategory::insert($data);
    }
}
