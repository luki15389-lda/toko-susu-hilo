<?php

namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Database\Seeder;

class CategorySeeder extends Seeder
{
    public function run(): void
    {
        $categories = [
            ['name' => 'HiLo Teen', 'image' => 'kategori1.webp'],
            ['name' => 'HiLo School', 'image' => 'kategori250g.webp'],
            ['name' => 'HiLo Active', 'image' => 'kategori500g.webp'],
            ['name' => 'HiLo Gold', 'image' => 'kategori1000g.webp'],
            ['name' => 'HiLo Platinum', 'image' => 'kategori2pcs500g.webp'],
        ];

        foreach ($categories as $category) {
            Category::updateOrCreate(['name' => $category['name']], $category);
        }
    }
}
