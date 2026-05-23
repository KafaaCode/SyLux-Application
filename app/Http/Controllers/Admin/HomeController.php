<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Order;
use App\Models\Product;
use App\Models\Support;
use App\Models\User;
use DB;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index()
    {
        $usersCount = User::count();
        $categoriesCount = Category::count();
        $productsCount = Product::count();
        $ordersCount = Order::count();
        $supportsCount = Support::count();

        // أحدث 5 طلبات
        $latestOrders = Order::with('user')->latest()->take(5)->get();

        // أحدث 5 طلبات دعم
        $latestSupports = Support::latest()->take(5)->get();

        // إحصائيات الطلبات الشهرية
        $monthlyOrders = Order::select(
            DB::raw("MONTH(created_at) as month"),
            DB::raw("COUNT(*) as total")
        )
            ->groupBy('month')
            ->orderBy('month')
            ->pluck('total', 'month');

        return view('admin.dashboard', compact(
            'usersCount',
            'categoriesCount',
            'productsCount',
            'ordersCount',
            'supportsCount',
            'latestOrders',
            'latestSupports',
            'monthlyOrders'
        ));
    }
}
