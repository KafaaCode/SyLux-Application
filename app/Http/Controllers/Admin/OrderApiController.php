<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Routing\Controller as BaseController;
use App\Models\Order;
use Illuminate\Http\Request;

class OrderApiController extends BaseController
{
	public function index(Request $request)
	{
		$perPage = (int) $request->get('per_page', 20);
		$orders = Order::with(['user','orderDetails.product'])
			->latest()
			->paginate($perPage);
		return response()->json($orders);
	}

	public function show($id)
	{
		$order = Order::with(['user','orderDetails.product'])->findOrFail($id);
		return response()->json($order);
	}

	public function updateStatus(Request $request, $id)
	{
		$request->validate(['status' => 'required|string']);
		$order = Order::findOrFail($id);
		$order->status = (string) $request->input('status');
		$order->save();
		return response()->json([
			'message' => 'تم تحديث حالة الطلب بنجاح',
			'order' => $order,
		]);
	}
}


