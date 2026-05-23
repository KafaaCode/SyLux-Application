<?php

namespace App\Http\Controllers;

use App\Models\Setting;
use Illuminate\Http\Request;

class SettingController extends Controller
{
    // استرجاع جميع الإعدادات
    public function index()
    {
        $settings = Setting::all();
        if ($settings->isEmpty()) {
            return response()->json([
                'status'  => 'error',
                'message' => 'لا توجد إعدادات متاحة'
            ], 404);
        }
        return response()->json([
            'status'  => 'success',
            'message' => 'تم استرجاع الإعدادات بنجاح',
            'data'    => $settings
        ], 200);
    }

    // إضافة إعدادات جديدة
    public function store(Request $request)
    {
        $validated = $request->validate([
            'whatsup_link'   => 'nullable|url',
            'facebook_link'  => 'nullable|url',
            'telegram_link'  => 'nullable|url',
            'sender_email'   => 'nullable|email'
        ]);

        $setting = Setting::create($validated);

        return response()->json([
            'status'  => 'success',
            'message' => 'تم إنشاء الإعدادات بنجاح',
            'data'    => $setting
        ], 201);
    }

    // استرجاع إعدادات محددة
    public function show($id)
    {
        $setting = Setting::find($id);
        if (!$setting) {
            return response()->json([
                'status'  => 'error',
                'message' => 'الإعدادات غير موجودة'
            ], 404);
        }
        return response()->json([
            'status'  => 'success',
            'message' => 'تم استرجاع الإعدادات بنجاح',
            'data'    => $setting
        ], 200);
    }

    // تعديل بيانات إعدادات
    public function update(Request $request, $id)
    {
        $setting = Setting::find($id);
        if (!$setting) {
            return response()->json([
                'status'  => 'error',
                'message' => 'الإعدادات غير موجودة'
            ], 404);
        }

        $validated = $request->validate([
            'whatsup_link'   => 'sometimes|nullable|url',
            'facebook_link'  => 'sometimes|nullable|url',
            'telegram_link'  => 'sometimes|nullable|url',
            'sender_email'   => 'sometimes|nullable|email'
        ]);

        $setting->update($validated);

        return response()->json([
            'status'  => 'success',
            'message' => 'تم تحديث الإعدادات بنجاح',
            'data'    => $setting
        ], 200);
    }

    // حذف إعدادات
    public function destroy($id)
    {
        $setting = Setting::find($id);
        if (!$setting) {
            return response()->json([
                'status'  => 'error',
                'message' => 'الإعدادات غير موجودة'
            ], 404);
        }
        $setting->delete();
        return response()->json([
            'status'  => 'success',
            'message' => 'تم حذف الإعدادات بنجاح'
        ], 200);
    }
}
