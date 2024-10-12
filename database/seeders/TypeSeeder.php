<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Type;

class TypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Usa firstOrCreate per evitare duplicati
        Type::firstOrCreate(['name' => 'Web App'], ['slug' => 'web-app']);
        Type::firstOrCreate(['name' => 'Mobile App'], ['slug' => 'mobile-app']);
        Type::firstOrCreate(['name' => 'Desktop App'], ['slug' => 'desktop-app']);
    }
}
