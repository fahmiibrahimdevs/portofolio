<?php

namespace Database\Seeders;

use App\Models\ProjectSubCategory;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ProjectSubCategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $data = [
            [
                'category_id'     => '1',
                'sub_category_name'  => 'Data Mining',
                'description'       => '-',
            ],
            [
                'category_id'     => '1',
                'sub_category_name'  => 'Genetika',
                'description'       => '-',
            ],
            [
                'category_id'     => '1',
                'sub_category_name'  => 'SPK',
                'description'       => '-',
            ],
            [
                'category_id'     => '1',
                'sub_category_name'  => 'Sistem Pakar',
                'description'       => '-',
            ],

            [
                'category_id'     => '2',
                'sub_category_name'  => 'Blog',
                'description'       => '-',
            ],
            [
                'category_id'     => '2',
                'sub_category_name'  => 'Platform',
                'description'       => '-',
            ],
            [
                'category_id'     => '2',
                'sub_category_name'  => 'Portal',
                'description'       => '-',
            ],
            [
                'category_id'     => '2',
                'sub_category_name'  => 'Sosial',
                'description'       => '-',
            ],

            [
                'category_id'     => '3',
                'sub_category_name'  => 'PPOB',
                'description'       => '-',
            ],
            [
                'category_id'     => '3',
                'sub_category_name'  => 'SMM',
                'description'       => '-',
            ],

            [
                'category_id'     => '4',
                'sub_category_name'  => 'Perusahaan',
                'description'       => '-',
            ],
            [
                'category_id'     => '4',
                'sub_category_name'  => 'Serbaguna',
                'description'       => '-',
            ],
            [
                'category_id'     => '4',
                'sub_category_name'  => 'Tokoh Publik',
                'description'       => '-',
            ],

            [
                'category_id'     => '5',
                'sub_category_name'  => 'Marketplace',
                'description'       => '-',
            ],
            [
                'category_id'     => '5',
                'sub_category_name'  => 'Point Of Sale',
                'description'       => '-',
            ],
            [
                'category_id'     => '5',
                'sub_category_name'  => 'Toko Online',
                'description'       => '-',
            ],

            [
                'category_id'     => '6',
                'sub_category_name'  => 'Analisis',
                'description'       => '-',
            ],
            [
                'category_id'     => '6',
                'sub_category_name'  => 'Downloader',
                'description'       => '-',
            ],
            [
                'category_id'     => '6',
                'sub_category_name'  => 'Generator',
                'description'       => '-',
            ],
            [
                'category_id'     => '6',
                'sub_category_name'  => 'Manager',
                'description'       => '-',
            ],
            [
                'category_id'     => '6',
                'sub_category_name'  => 'Marketing',
                'description'       => '-',
            ],
            [
                'category_id'     => '6',
                'sub_category_name'  => 'Shortener',
                'description'       => '-',
            ],

            [
                'category_id'     => '7',
                'sub_category_name'  => 'Arduino',
                'description'       => '-',
            ],

            [
                'category_id'     => '8',
                'sub_category_name'  => 'Flutter App',
                'description'       => '-',
            ],
            [
                'category_id'     => '8',
                'sub_category_name'  => 'Java App',
                'description'       => '-',
            ],
            [
                'category_id'     => '8',
                'sub_category_name'  => 'Kotlin App',
                'description'       => '-',
            ],
            [
                'category_id'     => '8',
                'sub_category_name'  => 'React Native',
                'description'       => '-',
            ],
            [
                'category_id'     => '8',
                'sub_category_name'  => 'Swift App',
                'description'       => '-',
            ],

            [
                'category_id'     => '9',
                'sub_category_name'  => 'Banner',
                'description'       => '-',
            ],
            [
                'category_id'     => '9',
                'sub_category_name'  => 'CV & Resume',
                'description'       => '-',
            ],
            [
                'category_id'     => '9',
                'sub_category_name'  => 'Dokumen',
                'description'       => '-',
            ],
            [
                'category_id'     => '9',
                'sub_category_name'  => 'Font',
                'description'       => '-',
            ],
            [
                'category_id'     => '9',
                'sub_category_name'  => 'Kartu',
                'description'       => '-',
            ],
            [
                'category_id'     => '9',
                'sub_category_name'  => 'Logo',
                'description'       => '-',
            ],
            [
                'category_id'     => '9',
                'sub_category_name'  => 'Undangan',
                'description'       => '-',
            ],

            [
                'category_id'     => '10',
                'sub_category_name'  => 'Backend',
                'description'       => '-',
            ],
            [
                'category_id'     => '10',
                'sub_category_name'  => 'Frontend',
                'description'       => '-',
            ],

            [
                'category_id'     => '11',
                'sub_category_name'  => 'EasyEDA',
                'description'       => '-',
            ],
            [
                'category_id'     => '11',
                'sub_category_name'  => 'Protheus',
                'description'       => '-',
            ],

            [
                'category_id'     => '12',
                'sub_category_name'  => 'Fusion360',
                'description'       => '-',
            ],

            [
                'category_id'     => '13',
                'sub_category_name'  => 'Akun',
                'description'       => '-',
            ],
            [
                'category_id'     => '13',
                'sub_category_name'  => 'Artikel',
                'description'       => '-',
            ],
            [
                'category_id'     => '13',
                'sub_category_name'  => 'Ebook',
                'description'       => '-',
            ],
            [
                'category_id'     => '13',
                'sub_category_name'  => 'Umum',
                'description'       => '-',
            ],
        ];

        ProjectSubCategory::insert($data);
    }
}
