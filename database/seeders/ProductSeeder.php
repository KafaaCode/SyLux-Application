<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Product;
use App\Models\Category;

class ProductSeeder extends Seeder
{
    public function run()
    {
        $categoryIds = Category::pluck('id')->toArray();

        $products = [
            'جهاز قياس ضغط',
            'كمبيوتر مكتبي',
            'مثقاب كهربائي',
            'طابعة ليزر',
            'مضخة مياه صناعية',
        ];

        foreach ($products as $name) {
            Product::create([
                'name' => $name,
                'serial_number' => strtoupper(uniqid('SN-')),
                'description' => $name . ' - منتج عالي الجودة.',
                'image' => null,
                'request_number' => rand(0, 100),
                'price' => rand(100, 1000),
                'category_id' => $categoryIds[array_rand($categoryIds)],
                'active' => true,
            ]);
        }
    }
}
