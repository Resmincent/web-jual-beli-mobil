<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $categories = [
            ['name' => 'Mobil', 'slug' => Str::slug('Mobil')],
            ['name' => 'Motor', 'slug' => Str::slug('Motor')],

        ];

        DB::table('categories')->insert($categories);
    }
}
