<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Category;

class CategorySeeder extends Seeder
{
    public function run()
    {
        $countries = [1, 2]; // عدل حسب الدول الموجودة
        $specializations = [1, 2]; // عدل حسب التخصصات الموجودة

        $categories = [
            'معدات طبية',
            'أجهزة كهربائية',
            'معدات صناعية',
            'مستلزمات مكتبية',
        ];

        foreach ($categories as $name) {
            Category::create([
                'name' => $name,
                'image' => null,
                'country_id' => $countries[array_rand($countries)],
                'specialization_id' => $specializations[array_rand($specializations)],
                'active' => true,
            ]);
        }
    }
}
