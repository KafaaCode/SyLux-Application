<?php

namespace App\Services\Front;

use App\Models\Category;
use App\Models\Product;
use App\Models\Section;

class HomeService
{
    public function getHomePageData(): array
    {
        return [
            'sections' => Section::where('active', 1)
                ->withCount(['categories' => fn ($query) => $query->where('active', 1)])
                ->orderBy('name')
                ->get(),
            'categories' => Category::where('active', 1)
                ->latest()
                ->take(12)
                ->get(),
            'featuredProducts' => Product::with(['images', 'translations', 'category'])
                ->where('active', 1)
                ->latest()
                ->take(8)
                ->get(),
        ];
    }
}
