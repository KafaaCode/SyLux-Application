<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;

class CartController extends Controller
{
    public function index()
    {
        $cart = session('cart', []);
        return view('front.cart.index', compact('cart'));
    }

    public function add(Request $request, $id)
    {
        $product = Product::findOrFail($id);
        $cart = session('cart', []);
        if(isset($cart[$id])) {
            $cart[$id]['quantity'] += 1;
        } else {
            $cart[$id] = [
                'id' => $product->id,
                'name' => $product->name,
                'price' => $product->price,
                'quantity' => 1,
            ];
        }
        session(['cart' => $cart]);
        return redirect()->back()->with('success', 'تمت إضافة المنتج للسلة');
    }

    public function remove($id)
    {
        $cart = session('cart', []);
        if(isset($cart[$id])) {
            unset($cart[$id]);
            session(['cart' => $cart]);
        }
        return redirect()->back()->with('success', 'تمت إزالة المنتج من السلة');
    }

    public function clear()
    {
        session()->forget('cart');
        return redirect()->back()->with('success', 'تم إفراغ السلة');
    }
}
