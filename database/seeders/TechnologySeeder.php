<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Technology;
use Illuminate\Support\Str;


class TechnologySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $technologies = [
            'Laravel',
            'Vue.js',
            'React',
            'Node.js',
            'PHP',
            'JavaScript',
            'Python',
            'CSS',
            'HTML',
            'Docker',
        ];

        foreach ($technologies as $technology) {
            Technology::create(['name' => $technology,"slug"=>Str::slug($technology)]);
        }
    }
}
