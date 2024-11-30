<?php

namespace Database\Seeders;

use App\Models\ProjectTag;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class ProjectTagSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $data = [
            ['tag_name' => 'PHP'],
            ['tag_name' => 'Laravel'],
            ['tag_name' => 'MySQL'],
            ['tag_name' => 'MariaDB'],
            ['tag_name' => 'Bootstrap'],
            ['tag_name' => 'Tailwind'],
        ];

        ProjectTag::insert($data);
    }
}
