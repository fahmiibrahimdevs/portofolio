<?php

namespace Database\Seeders;

use App\Models\ArticleSubCategory;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ArticleSubCategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $data = [
            [
                'category_id'     => '1',
                'sub_category_name'  => 'HTML5',
                'description'       => '',
                'image'             => 'HTML5.png',
            ],
            [
                'category_id'     => '1',
                'sub_category_name'  => 'CSS3',
                'description'       => '',
                'image'             => 'CSS3.png',
            ],
            [
                'category_id'     => '1',
                'sub_category_name'  => 'JavaScript',
                'description'       => '',
                'image'             => 'JavaScript.png',
            ],
            [
                'category_id'     => '1',
                'sub_category_name'  => 'PHP',
                'description'       => '',
                'image'             => 'php.svg',
            ],
            [
                'category_id'     => '1',
                'sub_category_name'  => 'Python',
                'description'       => '',
                'image'             => 'Python.png',
            ],
            [
                'category_id'     => '1',
                'sub_category_name'  => 'Dart',
                'description'       => '',
                'image'             => 'Dart.png',
            ],
            [
                'category_id'     => '1',
                'sub_category_name'  => 'C++',
                'description'       => '',
                'image'             => 'Cplusplus.png',
            ],
            [
                'category_id'     => '2',
                'sub_category_name'  => 'MySQL',
                'description'       => '',
                'image'             => 'MySQL.png',
            ],
            [
                'category_id'     => '2',
                'sub_category_name'  => 'MariaDB',
                'description'       => '',
                'image'             => 'MariaDB.png',
            ],
            [
                'category_id'     => '3',
                'sub_category_name'  => 'NodeJS',
                'description'       => '',
                'image'             => 'NodeJS.svg',
            ],
            [
                'category_id'     => '4',
                'sub_category_name'  => 'Laravel',
                'description'       => '',
                'image'             => 'Laravel.png',
            ],
            [
                'category_id'     => '4',
                'sub_category_name'  => 'Tailwind',
                'description'       => '',
                'image'             => 'tailwindcss.png',
            ],
            [
                'category_id'     => '4',
                'sub_category_name'  => 'Bootstrap',
                'description'       => '',
                'image'             => 'bootstrap.png',
            ],
            [
                'category_id'     => '5',
                'sub_category_name'  => 'Arduino',
                'description'       => '',
                'image'             => 'Arduino.png',
            ],
            [
                'category_id'     => '5',
                'sub_category_name'  => 'ESP8266',
                'description'       => '',
                'image'             => 'ESP8266.png',
            ],
            [
                'category_id'     => '5',
                'sub_category_name'  => 'ESP32',
                'description'       => '',
                'image'             => 'ESP32.png',
            ],
            [
                'category_id'     => '6',
                'sub_category_name'  => 'jQuery',
                'description'       => '',
                'image'             => 'jQuery.png',
            ],
            [
                'category_id'     => '6',
                'sub_category_name'  => 'Github',
                'description'       => '',
                'image'             => 'Github.png',
            ],
            [
                'category_id'     => '6',
                'sub_category_name'  => 'Postman',
                'description'       => '',
                'image'             => 'Postman.svg',
            ],
            [
                'category_id'     => '6',
                'sub_category_name'  => 'EasyEDA',
                'description'       => '',
                'image'             => 'EasyEDA.jpg',
            ],
            [
                'category_id'     => '6',
                'sub_category_name'  => 'NGINX',
                'description'       => '',
                'image'             => 'Nginx.png',
            ],
            [
                'category_id'     => '6',
                'sub_category_name'  => 'MQTT',
                'description'       => '',
                'image'             => 'MQTT.png',
            ],
            [
                'category_id'     => '7',
                'sub_category_name'  => 'Ubuntu',
                'description'       => '',
                'image'             => 'Ubuntu.png',
            ],
            [
                'category_id'     => '7',
                'sub_category_name'  => 'Filezilla',
                'description'       => '',
                'image'             => 'Filezilla.png',
            ],
            [
                'category_id'     => '7',
                'sub_category_name'  => 'CLI',
                'description'       => '',
                'image'             => 'CLI.jpg',
            ],
        ];

        ArticleSubCategory::insert($data);
    }
}
