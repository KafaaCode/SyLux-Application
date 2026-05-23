<?php

namespace App\Http\Controllers;

use App\Models\Specialization;
use Illuminate\Http\Request;

class SpecializationController extends Controller
{
    // استرجاع جميع التخصصات
    public function index()
    {
        $specializations = Specialization::with('translations')->get();

        if ($specializations->isEmpty()) {
            return response()->json([
                'status'  => 'error',
                'message' => 'لا توجد تخصصات متاحة'
            ], 404);
        }

        $translatedSpecializations = $specializations->map(function($specialization) {
            return [
                'id' => $specialization->id,
                'name' => $specialization->getTranslatedName(),
                'created_at' => $specialization->created_at,
                'updated_at' => $specialization->updated_at
            ];
        });
        
        return response()->json([
            'status'  => 'success',
            'message' => 'تم استرجاع التخصصات بنجاح',
            'data'    => $translatedSpecializations
        ], 200);
    }

    // إضافة تخصص جديد
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255'
        ]);

        $specialization = Specialization::create($validated);

        return response()->json([
            'status'  => 'success',
            'message' => 'تم إنشاء التخصص بنجاح',
            'data'    => $specialization
        ], 201);
    }

    // استرجاع تخصص محدد
    public function show($id)
    {
        $specialization = Specialization::with('translations')->find($id);
        if (!$specialization) {
            return response()->json([
                'status'  => 'error',
                'message' => 'التخصص غير موجود'
            ], 404);
        }

        $translatedSpecialization = [
            'id' => $specialization->id,
            'name' => $specialization->getTranslatedName(),
            'created_at' => $specialization->created_at,
            'updated_at' => $specialization->updated_at
        ];

        return response()->json([
            'status'  => 'success',
            'message' => 'تم استرجاع التخصص بنجاح',
            'data'    => $translatedSpecialization
        ], 200);
    }

    // تعديل بيانات تخصص
    public function update(Request $request, $id)
    {
        $specialization = Specialization::find($id);
        if (!$specialization) {
            return response()->json([
                'status'  => 'error',
                'message' => 'التخصص غير موجود'
            ], 404);
        }

        $validated = $request->validate([
            'name' => 'sometimes|required|string|max:255'
        ]);

        $specialization->update($validated);

        return response()->json([
            'status'  => 'success',
            'message' => 'تم تحديث التخصص بنجاح',
            'data'    => $specialization
        ], 200);
    }

    // حذف تخصص
    public function destroy($id)
    {
        $specialization = Specialization::find($id);
        if (!$specialization) {
            return response()->json([
                'status'  => 'error',
                'message' => 'التخصص غير موجود'
            ], 404);
        }
        $specialization->delete();
        return response()->json([
            'status'  => 'success',
            'message' => 'تم حذف التخصص بنجاح'
        ], 200);
    }
}
