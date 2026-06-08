<?php

namespace App\Helpers;

use Illuminate\Support\Facades\App;

class ApiTranslationHelper
{
    /**
     * إرجاع البيانات المترجمة للمنتج
     */
    public static function formatProduct($product)
    {
        $locale = App::getLocale();
        
        // تنسيق الصور الإضافية
        $images = [];
        if ($product->relationLoaded('images') && $product->images) {
            $images = $product->images->map(function($image) {
                return [
                    'id' => $image->id,
                    'path' => asset('storage/' . $image->path),
                    'created_at' => $image->created_at,
                    'updated_at' => $image->updated_at,
                ];
            })->toArray();
        }
        
        return [
            'id' => $product->id,
            'name' => $product->getTranslatedName($locale),
            'description' => $product->getTranslatedDescription($locale),
            'price' => $product->price,
            'image' => $product->image ? asset('storage/' . $product->image) : null,
            'images' => $images, // إضافة جميع الصور الإضافية
            'serial_number' => $product->serial_number,
            'request_number' => $product->request_number,
            'active' => $product->active,
            'category' => $product->category ? self::formatCategory($product->category) : null,
            'created_at' => $product->created_at,
            'updated_at' => $product->updated_at,
            'locale' => $locale, // إضافة اللغة المستخدمة
        ];
    }
    
    /**
     * إرجاع البيانات المترجمة للفئة
     */
    public static function formatCategory($category)
    {
        $locale = App::getLocale();
        
        return [
            'id' => $category->id,
            'name' => $category->name,
            'image' => $category->image ? asset('storage/' . $category->image) : null,
            'active' => $category->active,
            'products_count' => $category->products->count(),
            'created_at' => $category->created_at,
            'updated_at' => $category->updated_at,
            'locale' => $locale,
        ];
    }
    
    /**
     * إرجاع البيانات المترجمة للدولة
     */
    public static function formatCountry($country)
    {
        $locale = App::getLocale();
        
        return [
            'id' => $country->id,
            'name' => $country->getTranslatedName($locale),
            'code' => $country->code ?? null,
            'active' => $country->active,
            'created_at' => $country->created_at,
            'updated_at' => $country->updated_at,
            'locale' => $locale,
        ];
    }
    
    /**
     * إرجاع البيانات المترجمة للتخصص
     */
    public static function formatSpecialization($specialization)
    {
        $locale = App::getLocale();
        
        return [
            'id' => $specialization->id,
            'name' => $specialization->getTranslatedName($locale),
            'active' => $specialization->active,
            'created_at' => $specialization->created_at,
            'updated_at' => $specialization->updated_at,
            'locale' => $locale,
        ];
    }
    
    /**
     * إرجاع استجابة API موحدة مع معلومات اللغة
     */
    public static function successResponse($data, $message = 'تم استرجاع البيانات بنجاح', $statusCode = 200)
    {
        return response()->json([
            'status' => 'success',
            'message' => $message,
            'data' => $data,
            'locale' => App::getLocale(),
            'available_locales' => array_keys(config('app.available_locales', [])),
            'timestamp' => now()->toISOString(),
        ], $statusCode);
    }
    
    /**
     * إرجاع استجابة خطأ موحدة
     */
    public static function errorResponse($message = 'حدث خطأ', $statusCode = 400, $errors = null)
    {
        $response = [
            'status' => 'error',
            'message' => $message,
            'locale' => App::getLocale(),
            'timestamp' => now()->toISOString(),
        ];
        
        if ($errors) {
            $response['errors'] = $errors;
        }
        
        return response()->json($response, $statusCode);
    }
    
    /**
     * إرجاع قائمة باللغات المدعومة
     */
    public static function getSupportedLocales()
    {
        return [
            'locales' => config('app.available_locales', []),
            'default' => config('app.locale', 'ar'),
            'fallback' => config('app.fallback_locale', 'en'),
        ];
    }
    
    /**
     * التحقق من صحة اللغة
     */
    public static function isValidLocale($locale)
    {
        return in_array($locale, array_keys(config('app.available_locales', [])));
    }
    
    /**
     * إرجاع اللغة الافتراضية إذا كانت اللغة غير مدعومة
     */
    public static function getValidLocale($locale)
    {
        return self::isValidLocale($locale) ? $locale : config('app.locale', 'ar');
    }
}
