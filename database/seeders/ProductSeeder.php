<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Category;
use App\Models\Product;

class ProductSeeder extends Seeder
{
    public function run(): void
    {
        $kaos = Category::where('name', 'Kaos')->first();
        $hoodie = Category::where('name', 'Hoodie')->first();
        $toteBag = Category::where('name', 'Tote Bag')->first();

        $products = [
            [
                'category_id' => $kaos->id,
                'name' => 'Kaos Custom Event',
                'description' => 'Kaos custom untuk kebutuhan acara dan organisasi.',
                'price' => 75000,
                'stock' => 100,
                'is_active' => true,
            ],
            [
                'category_id' => $hoodie->id,
                'name' => 'Hoodie Custom',
                'description' => 'Hoodie custom untuk merchandise komunitas.',
                'price' => 150000,
                'stock' => 50,
                'is_active' => true,
            ],
            [
                'category_id' => $toteBag->id,
                'name' => 'Tote Bag Custom',
                'description' => 'Tote bag custom untuk seminar dan acara.',
                'price' => 35000,
                'stock' => 100,
                'is_active' => true,
            ],
        ];

        foreach ($products as $product) {
            Product::firstOrCreate(
                ['name' => $product['name']],
                $product
            );
        }
    }
}
