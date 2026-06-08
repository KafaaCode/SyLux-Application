<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Helpers\ApiTranslationHelper;
use App\Services\Front\CatalogService;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    /**
     * استرجاع جميع الفئات
     */
    public function index(Request $request)
    {
        try {
            // جلب الفئات النشطة
            $categories = Category::where('active', 1)
                ->get();

            if ($categories->isEmpty()) {
                return ApiTranslationHelper::errorResponse('لا توجد فئات متاحة', 404);
            }

            // تنسيق البيانات المترجمة
            $translatedCategories = $categories->map(function($category) {
                return ApiTranslationHelper::formatCategory($category);
            });

            return ApiTranslationHelper::successResponse($translatedCategories, 'تم استرجاع الفئات بنجاح');
            
        } catch (\Exception $e) {
            return ApiTranslationHelper::errorResponse('حدث خطأ في استرجاع الفئات', 500);
        }
    }

    /**
     * استرجاع فئة محددة
     */
    public function show($id)
    {
        try {
            $category = Category::with(['products'])
                ->find($id);

            if (!$category) {
                return ApiTranslationHelper::errorResponse('الفئة غير موجودة', 404);
            }

            if (!$category->active) {
                return ApiTranslationHelper::errorResponse('الفئة غير متاحة', 403);
            }

            $responseData = ApiTranslationHelper::formatCategory($category);
            
            // إضافة المنتجات إذا كانت مطلوبة
            if ($category->products->count() > 0) {
                $responseData['products'] = $category->products
                    ->where('active', 1)
                    ->map(function($product) {
                        return ApiTranslationHelper::formatProduct($product);
                    });
            }

            return ApiTranslationHelper::successResponse($responseData, 'تم استرجاع الفئة بنجاح');
            
        } catch (\Exception $e) {
            return ApiTranslationHelper::errorResponse('حدث خطأ في استرجاع الفئة', 500);
        }
    }

    /**
     * استرجاع جميع الفئات المتاحة
     */
    public function getByCountryAndSpecialization(Request $request)
    {
        try {
            $categories = Category::where('active', 1)
                ->get();

            if ($categories->isEmpty()) {
                return ApiTranslationHelper::errorResponse('لا توجد فئات متاحة', 404);
            }

            $translatedCategories = $categories->map(function($category) {
                return ApiTranslationHelper::formatCategory($category);
            });

            return ApiTranslationHelper::successResponse($translatedCategories, 'تم استرجاع الفئات بنجاح');
            
        } catch (\Exception $e) {
            return ApiTranslationHelper::errorResponse('حدث خطأ في استرجاع الفئات', 500);
        }
    }

    /**
     * استرجاع معلومات اللغات المدعومة
     */
    public function getSupportedLocales()
    {
        try {
            $locales = ApiTranslationHelper::getSupportedLocales();
            return ApiTranslationHelper::successResponse($locales, 'تم استرجاع اللغات المدعومة بنجاح');
            
        } catch (\Exception $e) {
            return ApiTranslationHelper::errorResponse('حدث خطأ في استرجاع اللغات المدعومة', 500);
        }
    }

    public function webIndex(CatalogService $catalog)
    {
        return view('front.categories.index', [
            'categories' => $catalog->activeCategories(),
        ]);
    }

    public function webshow(Category $category, CatalogService $catalog)
    {
        if (!$category->active) {
            abort(404);
        }

        try {
            return view('front.categories.show', $catalog->categoryWithProducts($category->id));
        } catch (ModelNotFoundException) {
            abort(404);
        }
    }
}