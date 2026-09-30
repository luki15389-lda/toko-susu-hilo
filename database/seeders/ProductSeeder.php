<?php

namespace Database\Seeders;

use App\Models\Product;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class ProductSeeder extends Seeder
{
    public function run(): void
    {
        $products = [
            [
                'name' => 'HiLo Teen Cokelat 250g',
                'category' => 'HiLo Teen',
                'price' => 45000,
                'stock' => 25,
                'description' => "Susu HiLo Teen rasa cokelat untuk remaja aktif.\nTinggi kalsium dan rendah lemak.",
                'benefits' => "Tinggi kalsium untuk tulang kuat\nRendah lemak\nDiperkaya vitamin dan mineral",
                'composition' => 'Susu bubuk skim, maltodekstrin, sukrosa, kalsium karbonat, vitamin A, D3, B1, B2, B6, B12, asam folat.',
                'is_featured' => true,
                'is_promo' => true,
                'discount_percent' => 15,
            ],
            [
                'name' => 'HiLo School Vanila 500g',
                'category' => 'HiLo School',
                'price' => 68000,
                'stock' => 15,
                'description' => "Nutrisi lengkap untuk anak usia sekolah.",
                'benefits' => "Membantu konsentrasi belajar\nKalsium tinggi\nRasa vanila yang disukai anak",
                'composition' => 'Susu bubuk skim, sukrosa, kalsium karbonat, vitamin A, D3, mineral.',
                'is_featured' => true,
                'is_promo' => false,
                'discount_percent' => 0,
            ],
            [
                'name' => 'HiLo Active 1000g',
                'category' => 'HiLo Active',
                'price' => 120000,
                'stock' => 8,
                'description' => "Untuk gaya hidup aktif sehari-hari.",
                'benefits' => "Rendah lemak\nMenjaga kebugaran tubuh\nTinggi kalsium",
                'composition' => 'Susu bubuk skim, maltodekstrin, kalsium karbonat, vitamin dan mineral.',
                'is_featured' => true,
                'is_promo' => true,
                'discount_percent' => 10,
            ],
            [
                'name' => 'HiLo Gold 700g',
                'category' => 'HiLo Gold',
                'price' => 95000,
                'stock' => 0,
                'description' => "Nutrisi untuk usia dewasa, tinggi serat.",
                'benefits' => "Tinggi serat\nTinggi kalsium\nRendah lemak",
                'composition' => 'Susu bubuk skim, serat pangan, kalsium karbonat, vitamin dan mineral.',
                'is_featured' => false,
                'is_promo' => false,
                'discount_percent' => 0,
            ],
            [
                'name' => 'HiLo Platinum 2x500g',
                'category' => 'HiLo Platinum',
                'price' => 180000,
                'stock' => 12,
                'description' => "Susu premium untuk usia lanjut dengan kolagen dan glucosamine.",
                'benefits' => "Mengandung kolagen\nGlucosamine untuk sendi\nKesehatan tulang optimal",
                'composition' => 'Susu bubuk skim, kolagen, glucosamine, kalsium karbonat, vitamin dan mineral.',
                'is_featured' => true,
                'is_promo' => true,
                'discount_percent' => 20,
            ],
        ];

        foreach ($products as $product) {
            Product::updateOrCreate(
                ['slug' => Str::slug($product['name'])],
                array_merge($product, [
                    'slug' => Str::slug($product['name']),
                    'is_active' => true,
                ])
            );
        }
    }
}
