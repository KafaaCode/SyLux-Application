<?php

namespace App\Support;

use App\Models\Category;
use App\Models\Product;
use App\Models\Section;

class MediaHelper
{
    public static function storageUrl(?string $path, ?string $placeholder = null): string
    {
        if ($path) {
            return asset('storage/' . ltrim($path, '/'));
        }

        return $placeholder ?? asset('images/init_page.png');
    }

    public static function productImage(Product $product): string
    {
        if ($product->image) {
            return self::storageUrl($product->image);
        }

        $firstImage = $product->relationLoaded('images')
            ? $product->images->first()
            : $product->images()->first();

        if ($firstImage?->path) {
            return self::storageUrl($firstImage->path);
        }

        return asset('images/init_page.png');
    }

    public static function categoryImage(Category $category): string
    {
        return self::storageUrl($category->image);
    }

    public static function sectionImage(Section $section): string
    {
        return self::storageUrl($section->image);
    }
}
