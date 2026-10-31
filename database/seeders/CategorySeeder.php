<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Category;

class CategorySeeder extends Seeder
{
    public function run(): void
    {
        $categories = [
            [
                'name' => 'Kaos',
                'description' => 'Produk kaos untuk acara dan merchandise.',
            ],
            [
                'name' => 'Hoodie',
                'description' => 'Produk hoodie untuk merchandise.',
            ],
            [
                'name' => 'Tote Bag',
                'description' => 'Tas kain untuk kebutuhan acara.',
            ],
        ];

        foreach ($categories as $category) {
            Category::firstOrCreate(
                ['name' => $category['name']],
                ['description' => $category['description']]
            );
        }
    }
}

