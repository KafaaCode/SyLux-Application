<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        // Copy existing single image paths from products.image into product_images
        $products = DB::table('products')->whereNotNull('image')->where('image', '!=', '')->get(['id', 'image']);

        foreach ($products as $product) {
            // Check if already backfilled to avoid duplicates
            $exists = DB::table('product_images')
                ->where('product_id', $product->id)
                ->where('path', $product->image)
                ->exists();

            if (!$exists) {
                DB::table('product_images')->insert([
                    'product_id' => $product->id,
                    'path' => $product->image,
                    'created_at' => now(),
                    'updated_at' => now(),
                ]);
            }
        }
    }

    public function down(): void
    {
        // No-op: keep backfilled data
    }
};


