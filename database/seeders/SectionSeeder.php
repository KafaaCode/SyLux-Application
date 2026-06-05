<?php

namespace Database\Seeders;

use App\Models\Section;
use Illuminate\Database\Seeder;

class SectionSeeder extends Seeder
{
    public function run(): void
    {
        $sections = [
            'تغليف غذائي',
            'تغليف صناعي',
            'تغليف طبي',
            'تغليف تجاري',
        ];

        foreach ($sections as $name) {
            Section::updateOrCreate(
                ['name' => $name],
                ['active' => true]
            );
        }
    }
}
