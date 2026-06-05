<?php

namespace Database\Seeders;

use App\Models\Specialization;
use Illuminate\Database\Seeder;

class SpecializationSeeder extends Seeder
{
    public function run(): void
    {
        $specializations = [
            'تجارة عامة',
            'صناعة',
        ];

        foreach ($specializations as $name) {
            Specialization::updateOrCreate(['name' => $name]);
        }
    }
}
