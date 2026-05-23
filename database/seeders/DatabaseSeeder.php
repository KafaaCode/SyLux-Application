<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use DB;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // \App\Models\Category::truncate();
        // \App\Models\Product::truncate();
        // $this->call([
        //     RoleAndPermissionSeeder::class,
        //     CategorySeeder::class,
        //     ProductSeeder::class,
        // ]);

        DB::statement('SET FOREIGN_KEY_CHECKS=0;');

        $this->call([
            RoleAndPermissionSeeder::class,
            CategorySeeder::class,
            ProductSeeder::class,
        ]);

        DB::statement('SET FOREIGN_KEY_CHECKS=1;');
    }
}
