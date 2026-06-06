<?php

namespace App\Services\Front;

use App\Models\Category;
use App\Models\Product;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class CatalogService
{
    public function activeCategories()
    {
        return Category::with(['section', 'translations'])
            ->where('active', 1)
            ->orderBy('name')
            ->get();
    }

    public function categoryWithProducts(int $id): array
    {
        $category = Category::with(['section', 'translations'])
            ->where('active', 1)
            ->find($id);

        if (!$category) {
            throw new ModelNotFoundException();
        }

        $products = $category->products()
            ->with(['images', 'translations'])
            ->where('active', 1)
            ->orderBy('name')
            ->get();

        return compact('category', 'products');
    }

    public function activeProducts()
    {
        return Product::with(['category', 'translations', 'images'])
            ->where('active', 1)
            ->orderByDesc('created_at')
            ->get();
    }

    public function findActiveProduct(Product $product): Product
    {
        if (!$product->active) {
            throw new ModelNotFoundException();
        }

        return $product->load(['images', 'category', 'translations']);
    }
}
