<?php

namespace App\Http\Controllers;

use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class OrderController extends Controller
{
    public function indexFront()
    {
        $orders = Order::where('user_id', auth()->id())->with('orderDetails.product')->orderBy('created_at', 'desc')->get();
        return view('front.orders.index', compact('orders'));
    }

    public function index()
    {
        $page = $request->get('page', 1);
        $limit = $request->get('limit', 10);

        // جلب الطلبات مع علاقات المستخدم والتفاصيل
        $query = Order::with(['orderDetails.product'])->orderBy('created_at', 'desc');

        $ordersPaginated = $query->paginate($limit, ['*'], 'page', $page);

        if ($ordersPaginated->isEmpty()) {
            return response()->json([
                'status' => 'error',
                'message' => 'لا توجد طلبات'
            ], 404);
        }

        $formattedOrders = $ordersPaginated->getCollection()->map(function ($order) {
            return [
                'id' => $order->id,
                'serial_number' => $order->serial_number,
                'user_id' => $order->user_id,
                'user_name' => $order->user->name ?? null,
                'user_email' => $order->user->email ?? null,
                'user_phone' => $order->user->phone ?? null,
                'total_amount' => $order->total_amount,
                'status' => $order->status,
                'delivery_time' => $order->delivery_time,
                'reply_message' => $order->reply_message,
                'total_price' => $order->total_price,
                'created_at' => $order->created_at->toDateTimeString(),
                'updated_at' => $order->updated_at->toDateTimeString(),
                'products' => $order->orderDetails->map(function ($detail) {
                    $product = $detail->product;
                    return [
                        'id' => $product->id,
                        'name' => $product->name,
                        'serial_number' => $product->serial_number,
                        'description' => $product->description,
                        'image' => $product->image,
                        'request_number' => $product->request_number,
                        'price' => $product->price,
                        'category_id' => $product->category_id,
                        'active' => $product->active,
                        'created_at' => $product->created_at->toDateTimeString(),
                        'updated_at' => $product->updated_at->toDateTimeString(),
                        'quantity' => $detail->quantity,
                    ];
                }),
            ];
        });

        return response()->json([
            'status' => 'success',
            'message' => 'تم استرجاع الطلبات بنجاح',
            'data' => $formattedOrders,
            'pagination' => [
                'current_page' => $ordersPaginated->currentPage(),
                'last_page' => $ordersPaginated->lastPage(),
                'per_page' => $ordersPaginated->perPage(),
                'total' => $ordersPaginated->total(),
            ]
        ], 200);
    }



    public function show($id)
    {
        $order = Order::with(['user', 'orderDetails.product'])->find($id);

        if (!$order) {
            return response()->json([
                'status' => 'error',
                'message' => 'الطلب غير موجود'
            ], 404);
        }

        $formattedOrder = [
            'id' => $order->id,
            'serial_number' => $order->serial_number,
            'user_id' => $order->user_id,
            'user_name' => $order->user->name ?? null,
            'user_email' => $order->user->email ?? null,
            'user_phone' => $order->user->phone ?? null,
            'total_amount' => $order->total_amount,
            'status' => $order->status,
            'delivery_time' => $order->delivery_time,
            'reply_message' => $order->reply_message,
            'total_price' => $order->total_price,
            'created_at' => $order->created_at->toDateTimeString(),
            'updated_at' => $order->updated_at->toDateTimeString(),
            'products' => $order->orderDetails->map(function ($detail) {
                $product = $detail->product;
                return [
                    'id' => $product->id,
                    'name' => $product->name,
                    'serial_number' => $product->serial_number,
                    'description' => $product->description,
                    'image' => $product->image ? asset('storage/' . $product->image) : null,
                    'request_number' => $product->request_number,
                    'price' => $product->price,
                    'category_id' => $product->category_id,
                    'active' => $product->active,
                    'created_at' => $product->created_at->toDateTimeString(),
                    'updated_at' => $product->updated_at->toDateTimeString(),
                    'quantity' => $detail->quantity,
                ];
            }),
        ];

        return response()->json([
            'status' => 'success',
            'message' => 'تم استرجاع الطلب بنجاح',
            'data' => $formattedOrder
        ], 200);
    }


    public function myOrders(Request $request)
    {
        $user = $request->user();

        $orders = Order::with('orderDetails.product')
            ->where('user_id', $user->id)
            ->orderByDesc('created_at')->get();

        if ($orders->isEmpty()) {
            return response()->json([
                'status' => 'error',
                'message' => 'لا توجد طلبات لهذا المستخدم'
            ], 404);
        }

        $formattedOrders = $orders->map(function ($order) {
            return [
                'id' => $order->id,
                'serial_number' => $order->serial_number,
                'user_id' => $order->user_id,
                'total_amount' => $order->total_amount,
                'status' => $order->status,
                'delivery_time' => $order->delivery_time,
                'reply_message' => $order->reply_message,
                'total_price' => $order->total_price,
                'created_at' => $order->created_at,
                'updated_at' => $order->updated_at,
                'products' => $order->orderDetails->map(function ($detail) {
                    $product = $detail->product;
                    return [
                        'id' => $product->id,
                        'name' => $product->name,
                        'serial_number' => $product->serial_number,
                        'description' => $product->description,
                        'image' => $product->image,
                        'request_number' => $product->request_number,
                        'price' => $product->price,
                        'category_id' => $product->category_id,
                        'active' => $product->active,
                        'created_at' => $product->created_at,
                        'updated_at' => $product->updated_at,
                        'quantity' => $detail->quantity, // العدد مضاف هنا
                    ];
                }),
            ];
        });

        return response()->json([
            'status' => 'success',
            'message' => 'تم استرجاع الطلبات الخاصة بالمستخدم بنجاح',
            'data' => $formattedOrders
        ], 200);
    }



    public function storeWeb(Request $request)
    {
        $cart = session('cart', []);
        
        if (empty($cart)) {
            return redirect()->back()->with('error', 'السلة فارغة');
        }
        
        DB::beginTransaction();
        try {
            // حساب الإجمالي
            $total = 0;
            foreach ($cart as $item) {
                $total += $item['price'] * $item['quantity'];
            }
            
            // إنشاء الطلب
            $order = Order::create([
                'user_id' => auth()->id(),
                'total_amount' => $total,
                'total_price' => $total,
                'status' => 'pending',
            ]);
            
            // إنشاء تفاصيل الطلب
            foreach ($cart as $item) {
                $order->orderDetails()->create([
                    'product_id' => $item['id'],
                    'quantity' => $item['quantity']
                ]);
            }
            
            DB::commit();
            
            // مسح السلة
            session()->forget('cart');
            
            return redirect()->route('orders.index')->with('success', 'تم إنشاء الطلب بنجاح');
            
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()->with('error', 'حدث خطأ أثناء إنشاء الطلب: ' . $e->getMessage());
        }
    }

    public function store(Request $request)
    {
        $rules = [
            'delivery_time' => 'nullable|date',
            'reply_message' => 'nullable|string',
            'total_price' => 'required|numeric',
            'status' => 'string|in:Pending,delivery,partial delivery,completed,canceled',

            'order_details' => 'required|array|min:1',
            'order_details.*.product_id' => 'required|exists:products,id',
            'order_details.*.quantity' => 'required|integer|min:1',
        ];

        $validated = $request->validate($rules);
        $user = $request->user();
        DB::beginTransaction();
        try {
            $validated['status'] = 'Pending';
            $order = Order::create([
                'user_id' => $user->id,
                'total_amount' => $validated['total_price'],
                'status' => $validated['status'],
                'delivery_time' => $validated['delivery_time'] ?? null,
                'reply_message' => $validated['reply_message'] ?? null,
                'total_price' => $validated['total_price']
            ]);


            foreach ($validated['order_details'] as $detail) {
                $order->orderDetails()->create([
                    'product_id' => $detail['product_id'],
                    'quantity' => $detail['quantity']
                ]);
            }

            DB::commit();

            return response()->json([
                'status' => 'success',
                'message' => isset($validated['order_id'])
                    ? 'تم تحديث الطلب وتفاصيله بنجاح'
                    : 'تم إنشاء الطلب وتفاصيله بنجاح',
                'data' => $order->load('orderDetails')
            ], isset($validated['order_id']) ? 200 : 201);

        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json([
                'status' => 'error',
                'message' => 'حدث خطأ أثناء حفظ الطلب وتفاصيله: ' . $e->getMessage()
            ], 500);
        }
    }




    public function update(Request $request, $id)
    {
        $order = Order::find($id);
        if (!$order) {
            return response()->json([
                'status' => 'error',
                'message' => 'الطلب غير موجود'
            ], 404);
        }

        $rules = [
            'status' => 'sometimes|nullable|string|in:Pending,Partial Delivery,Completed,Canceled',
            'reply_message' => 'nullable|string',
        ];

        $validated = $request->validate($rules);

        $order->update([
            // 'user_id' => $validated['user_id'],
            // 'total_amount' => $validated['total_amount'],
            'status' => $validated['status'],
            // 'delivery_time' => $validated['delivery_time'] ?? null,
            'reply_message' => $validated['reply_message'] ?? null,
            // 'total_price' => $validated['total_price']
        ]);

        // $order->orderDetails()->delete();

        return response()->json([
            'status' => 'success',
            'message' => 'تم تحديث الطلب بنجاح',
            'data' => $order
        ], 200);
    }

    public function destroy($id)
    {
        $order = Order::find($id);
        if (!$order) {
            return response()->json([
                'status' => 'error',
                'message' => 'الطلب غير موجود'
            ], 404);
        }
        $order->delete();
        return response()->json([
            'status' => 'success',
            'message' => 'تم حذف الطلب بنجاح'
        ], 200);
    }
}
