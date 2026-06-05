<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Schema;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        Schema::disableForeignKeyConstraints();

        $this->call([
            CountrySeeder::class,
            SpecializationSeeder::class,
            RoleAndPermissionSeeder::class,
            AppSettingSeeder::class,
            SectionSeeder::class,
            CategorySeeder::class,
            ProductSeeder::class,
            OrderSeeder::class,
        ]);

        Schema::enableForeignKeyConstraints();
    }
}
