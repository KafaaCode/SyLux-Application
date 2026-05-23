<?php

namespace App\Http\Controllers;

use App\Models\OrderDetail;
use Illuminate\Http\Request;

class OrderDetailController extends Controller
{
    // استرجاع جميع تفاصيل الطلبات
    public function index()
    {
        $orderDetails = OrderDetail::all();
        return response()->json([
            'status'  => 'success',
            'message' => 'تم استرجاع تفاصيل الطلب بنجاح',
            'data'    => $orderDetails
        ], 200);
    }

    // إضافة تفاصيل طلب جديد
    public function store(Request $request)
    {
        $validated = $request->validate([
            'order_id'   => 'required|exists:orders,id',
            'product_id' => 'required|exists:products,id',
            'quantity'   => 'required|integer|min:1'
        ]);

        $orderDetail = OrderDetail::create($validated);

        return response()->json([
            'status'  => 'success',
            'message' => 'تم إضافة تفاصيل الطلب بنجاح',
            'data'    => $orderDetail
        ], 201);
    }

    // استرجاع تفاصيل طلب محددة
    public function show($id)
    {
        $orderDetail = OrderDetail::find($id);
        if (!$orderDetail) {
            return response()->json([
                'status'  => 'error',
                'message' => 'تفاصيل الطلب غير موجودة'
            ], 404);
        }
        return response()->json([
            'status'  => 'success',
            'message' => 'تم استرجاع تفاصيل الطلب بنجاح',
            'data'    => $orderDetail
        ], 200);
    }

    // تعديل تفاصيل طلب
    public function update(Request $request, $id)
    {
        $orderDetail = OrderDetail::find($id);
        if (!$orderDetail) {
            return response()->json([
                'status'  => 'error',
                'message' => 'تفاصيل الطلب غير موجودة'
            ], 404);
        }

        $validated = $request->validate([
            'order_id'   => 'sometimes|required|exists:orders,id',
            'product_id' => 'sometimes|required|exists:products,id',
            'quantity'   => 'sometimes|required|integer|min:1'
        ]);

        $orderDetail->update($validated);

        return response()->json([
            'status'  => 'success',
            'message' => 'تم تحديث تفاصيل الطلب بنجاح',
            'data'    => $orderDetail
        ], 200);
    }

    // حذف تفاصيل طلب
    public function destroy($id)
    {
        $orderDetail = OrderDetail::find($id);
        if (!$orderDetail) {
            return response()->json([
                'status'  => 'error',
                'message' => 'تفاصيل الطلب غير موجودة'
            ], 404);
        }
        $orderDetail->delete();
        return response()->json([
            'status'  => 'success',
            'message' => 'تم حذف تفاصيل الطلب بنجاح'
        ], 200);
    }
}
