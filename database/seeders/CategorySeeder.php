<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\Country;
use App\Models\Section;
use App\Models\Specialization;
use Illuminate\Database\Seeder;

class CategorySeeder extends Seeder
{
    public function run(): void
    {
        $countryIds = Country::pluck('id')->toArray();
        $specializationIds = Specialization::pluck('id')->toArray();
        $sections = Section::all();

        if (empty($countryIds) || empty($specializationIds) || $sections->isEmpty()) {
            return;
        }

        $categories = [
            ['name' => 'أكياس بلاستيك', 'section' => 'تغليف غذائي'],
            ['name' => 'علب كرتون', 'section' => 'تغليف تجاري'],
            ['name' => 'أغلفة طبية', 'section' => 'تغليف طبي'],
            ['name' => 'لفائف صناعية', 'section' => 'تغليف صناعي'],
            ['name' => 'سترش غذائي', 'section' => 'تغليف غذائي'],
            ['name' => 'صناديق شحن', 'section' => 'تغليف تجاري'],
        ];

        foreach ($categories as $item) {
            $section = $sections->firstWhere('name', $item['section']);

            Category::updateOrCreate(
                ['name' => $item['name']],
                [
                    'image' => null,
                    'section_id' => $section?->id,
                    'country_id' => $countryIds[array_rand($countryIds)],
                    'specialization_id' => $specializationIds[array_rand($specializationIds)],
                    'active' => true,
                ]
            );
        }
    }
}
