<?php

namespace Database\Seeders;

use App\Models\Order;
use App\Models\Product;
use App\Models\User;
use App\Support\OrderStatus;
use Illuminate\Database\Seeder;

class OrderSeeder extends Seeder
{
    public function run(): void
    {
        $user = User::where('email', 'user@example.com')->first();
        $admin = User::where('email', 'admin@example.com')->first();
        $products = Product::take(5)->get();

        if ($products->isEmpty() || !$user) {
            return;
        }

        $demoOrders = [
            [
                'serial_number' => 'ORD-DEMO-001',
                'user_id' => $user->id,
                'status' => OrderStatus::PENDING,
                'reply_message' => null,
                'items' => [0 => 2, 1 => 1],
            ],
            [
                'serial_number' => 'ORD-DEMO-002',
                'user_id' => $user->id,
                'status' => OrderStatus::PROCESSING,
                'reply_message' => 'جاري تجهيز الطلب',
                'items' => [1 => 3, 2 => 1],
            ],
            [
                'serial_number' => 'ORD-DEMO-003',
                'user_id' => $user->id,
                'status' => OrderStatus::PARTIAL_DELIVERY,
                'reply_message' => 'تم تسليم جزء من الطلب',
                'items' => [0 => 1, 3 => 2],
            ],
            [
                'serial_number' => 'ORD-DEMO-004',
                'user_id' => $user->id,
                'status' => OrderStatus::COMPLETED,
                'reply_message' => 'تم إنجاز الطلب بالكامل',
                'items' => [2 => 2, 4 => 1],
            ],
            [
                'serial_number' => 'ORD-DEMO-005',
                'user_id' => $user->id,
                'status' => OrderStatus::CANCELLED,
                'reply_message' => 'ألغى العميل الطلب',
                'items' => [3 => 1],
            ],
        ];

        if ($admin) {
            $demoOrders[] = [
                'serial_number' => 'ORD-DEMO-006',
                'user_id' => $admin->id,
                'status' => OrderStatus::DELIVERED,
                'reply_message' => 'تم الشحن',
                'items' => [0 => 1, 1 => 1, 2 => 1],
            ];
        }

        foreach ($demoOrders as $demo) {
            $total = 0;
            $details = [];

            foreach ($demo['items'] as $index => $qty) {
                $product = $products[$index] ?? null;
                if (!$product) {
                    continue;
                }
                $total += $product->price * $qty;
                $details[] = ['product_id' => $product->id, 'quantity' => $qty];
            }

            if (empty($details)) {
                continue;
            }

            $order = Order::updateOrCreate(
                ['serial_number' => $demo['serial_number']],
                [
                    'user_id' => $demo['user_id'],
                    'total_amount' => $total,
                    'total_price' => $total,
                    'status' => $demo['status'],
                    'reply_message' => $demo['reply_message'],
                    'delivery_time' => now()->addDays(rand(1, 7)),
                ]
            );

            $order->orderDetails()->delete();

            foreach ($details as $detail) {
                $order->orderDetails()->create($detail);
            }
        }
    }
}
