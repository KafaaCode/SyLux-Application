<?php

namespace App\Http\Controllers;

use App\Models\Support;
use Illuminate\Http\Request;

class SupportController extends Controller
{
    // استرجاع جميع طلبات الدعم
    public function index()
    {
        $supports = Support::all();
        if ($supports->isEmpty()) {
            return response()->json([
                'status' => 'error',
                'message' => 'لا توجد طلبات دعم متاحة'
            ], 404);
        }
        return response()->json([
            'status' => 'success',
            'message' => 'تم استرجاع طلبات الدعم بنجاح',
            'data' => $supports
        ], 200);
    }

    // إضافة طلب دعم جديد
    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'message' => 'required|string',
            'sender_name' => 'required|string|max:255',
            'sender_email' => 'required|email'
        ]);

        $support = Support::create($validated);

        return response()->json([
            'status' => 'success',
            'message' => 'تم إرسال طلب الدعم بنجاح',
            'data' => $support
        ], 201);
    }

    public function storeWeb(Request $request)
    {
        // التحقق من صحة البيانات
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'message' => 'required|string',
            'sender_name' => 'required|string|max:255',
            'sender_email' => 'required|email|max:255',
        ]);

        try {
            // حفظ الطلب
            $support = Support::create($validated);

            // رسالة نجاح مترجمة
            return redirect()->back()->with('success', __('messages.support_success'));
        } catch (\Exception $e) {
            // رسالة خطأ مترجمة
            return redirect()->back()->with('error', __('messages.support_error'));
        }
    }

    // استرجاع طلب دعم محدد
    public function show($id)
    {
        $support = Support::find($id);
        if (!$support) {
            return response()->json([
                'status' => 'error',
                'message' => 'طلب الدعم غير موجود'
            ], 404);
        }
        return response()->json([
            'status' => 'success',
            'message' => 'تم استرجاع طلب الدعم بنجاح',
            'data' => $support
        ], 200);
    }

    // تعديل بيانات طلب دعم
    public function update(Request $request, $id)
    {
        $support = Support::find($id);
        if (!$support) {
            return response()->json([
                'status' => 'error',
                'message' => 'طلب الدعم غير موجود'
            ], 404);
        }

        $validated = $request->validate([
            'title' => 'sometimes|required|string|max:255',
            'message' => 'sometimes|required|string',
            'sender_name' => 'sometimes|required|string|max:255',
            'sender_email' => 'sometimes|required|email'
        ]);

        $support->update($validated);

        return response()->json([
            'status' => 'success',
            'message' => 'تم تحديث طلب الدعم بنجاح',
            'data' => $support
        ], 200);
    }

    // حذف طلب دعم
    public function destroy($id)
    {
        $support = Support::find($id);
        if (!$support) {
            return response()->json([
                'status' => 'error',
                'message' => 'طلب الدعم غير موجود'
            ], 404);
        }
        $support->delete();
        return response()->json([
            'status' => 'success',
            'message' => 'تم حذف طلب الدعم بنجاح'
        ], 200);
    }
}
