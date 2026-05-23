<?php

namespace App\Http\Controllers;

use App\Models\Country;
use App\Models\Specialization;
use App\Helpers\ApiTranslationHelper;
use Illuminate\Http\Request;

class CountryController extends Controller
{
    /**
     * استرجاع جميع الدول
     */
    public function index(Request $request)
    {
        try {
            $countries = Country::with('translations')
                ->where('active', 1)
                ->get();

            if ($countries->isEmpty()) {
                return ApiTranslationHelper::errorResponse('لا توجد دول متاحة', 404);
            }

            $translatedCountries = $countries->map(function($country) {
                return ApiTranslationHelper::formatCountry($country);
            });

            return ApiTranslationHelper::successResponse($translatedCountries, 'تم استرجاع الدول بنجاح');
            
        } catch (\Exception $e) {
            return ApiTranslationHelper::errorResponse('حدث خطأ في استرجاع الدول', 500);
        }
    }

    /**
     * استرجاع دولة محددة
     */
    public function show($id)
    {
        try {
            $country = Country::with('translations')->find($id);

            if (!$country) {
                return ApiTranslationHelper::errorResponse('الدولة غير موجودة', 404);
            }

            if (!$country->active) {
                return ApiTranslationHelper::errorResponse('الدولة غير متاحة', 403);
            }

            $responseData = ApiTranslationHelper::formatCountry($country);
            
            // إضافة الفئات إذا كانت مطلوبة
            if ($country->categories->count() > 0) {
                $responseData['categories'] = $country->categories
                    ->where('active', 1)
                    ->map(function($category) {
                        return ApiTranslationHelper::formatCategory($category);
                    });
            }

            return ApiTranslationHelper::successResponse($responseData, 'تم استرجاع الدولة بنجاح');
            
        } catch (\Exception $e) {
            return ApiTranslationHelper::errorResponse('حدث خطأ في استرجاع الدولة', 500);
        }
    }
}

class SpecializationController extends Controller
{
    /**
     * استرجاع جميع التخصصات
     */
    public function index(Request $request)
    {
        try {
            $specializations = Specialization::with('translations')
                ->where('active', 1)
                ->get();

            if ($specializations->isEmpty()) {
                return ApiTranslationHelper::errorResponse('لا توجد تخصصات متاحة', 404);
            }

            $translatedSpecializations = $specializations->map(function($specialization) {
                return ApiTranslationHelper::formatSpecialization($specialization);
            });

            return ApiTranslationHelper::successResponse($translatedSpecializations, 'تم استرجاع التخصصات بنجاح');
            
        } catch (\Exception $e) {
            return ApiTranslationHelper::errorResponse('حدث خطأ في استرجاع التخصصات', 500);
        }
    }

    /**
     * استرجاع تخصص محدد
     */
    public function show($id)
    {
        try {
            $specialization = Specialization::with('translations')->find($id);

            if (!$specialization) {
                return ApiTranslationHelper::errorResponse('التخصص غير موجود', 404);
            }

            if (!$specialization->active) {
                return ApiTranslationHelper::errorResponse('التخصص غير متاح', 403);
            }

            $responseData = ApiTranslationHelper::formatSpecialization($specialization);
            
            // إضافة الفئات إذا كانت مطلوبة
            if ($specialization->categories->count() > 0) {
                $responseData['categories'] = $specialization->categories
                    ->where('active', 1)
                    ->map(function($category) {
                        return ApiTranslationHelper::formatCategory($category);
                    });
            }

            return ApiTranslationHelper::successResponse($responseData, 'تم استرجاع التخصص بنجاح');
            
        } catch (\Exception $e) {
            return ApiTranslationHelper::errorResponse('حدث خطأ في استرجاع التخصص', 500);
        }
    }
}