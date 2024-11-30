<?php

namespace Database\Seeders;

use App\Models\ProjectCategory;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ProjectCategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $data = [
            ['category_name'  => 'Web Algoritma'],
            ['category_name'  => 'Web Media'],
            ['category_name'  => 'Web Panel'],
            ['category_name'  => 'Web Profil'],
            ['category_name'  => 'Web Toko'],
            ['category_name'  => 'Web Tool'],
            ['category_name'  => 'App IoT'],
            ['category_name'  => 'App Mobile'],
            ['category_name'  => 'Desain Grafis'],
            ['category_name'  => 'Desain Web'],
            ['category_name'  => 'Desain Circuit'],
            ['category_name'  => 'AutoCAD'],
            ['category_name'  => 'Lainnya'],
        ];

        ProjectCategory::insert($data);
    }
}
