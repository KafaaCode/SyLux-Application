<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Discount;
use App\Models\Product;
use Illuminate\Http\Request;

class DiscountController extends Controller
{
    public function index(Request $request)
    {
        $query = Discount::with('products');

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('discount_percentage', 'like', "%{$search}%")
                  ->orWhereHas('products', function($pq) use ($search) {
                      $pq->where('name', 'like', "%{$search}%");
                  });
            });
        }

        if ($request->filled('status')) {
            $query->where('active', $request->status);
        }

        $perPage = $request->get('per_page', 10);
        $discounts = $query->paginate($perPage)->withQueryString();

        return view('admin.discounts.index', compact('discounts'));
    }

    public function create()
    {
        $products = Product::where('active', true)->pluck('name', 'id')->all();
        return view('admin.discounts.create', compact('products'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'discount_percentage' => 'required|numeric|min:0|max:100',
            'active' => 'nullable|boolean',
            'start_time' => 'nullable|date',
            'end_time' => 'nullable|date|after_or_equal:start_time',
            'apply_to_all' => 'nullable|boolean',
            'products' => 'nullable|array',
            'products.*' => 'exists:products,id',
        ]);

        $discount = Discount::create([
            'discount_percentage' => $validated['discount_percentage'],
            'active' => $request->boolean('active', true),
            'start_time' => $validated['start_time'] ?? null,
            'end_time' => $validated['end_time'] ?? null,
            'apply_to_all' => $request->boolean('apply_to_all', false),
        ]);

        if (!$discount->apply_to_all && !empty($validated['products'])) {
            $discount->products()->sync($validated['products']);
        }

        return redirect()->route('admin.discounts.index')
            ->with('success', 'تم إنشاء الخصم بنجاح');
    }

    public function edit($id)
    {
        $discount = Discount::with('products')->findOrFail($id);
        $products = Product::where('active', true)->pluck('name', 'id')->all();
        $selectedProducts = $discount->products->pluck('id')->toArray();

        return view('admin.discounts.edit', compact('discount', 'products', 'selectedProducts'));
    }

    public function update(Request $request, $id)
    {
        $discount = Discount::findOrFail($id);

        $validated = $request->validate([
            'discount_percentage' => 'required|numeric|min:0|max:100',
            'active' => 'nullable|boolean',
            'start_time' => 'nullable|date',
            'end_time' => 'nullable|date|after_or_equal:start_time',
            'apply_to_all' => 'nullable|boolean',
            'products' => 'nullable|array',
            'products.*' => 'exists:products,id',
        ]);

        $discount->update([
            'discount_percentage' => $validated['discount_percentage'],
            'active' => $request->boolean('active', true),
            'start_time' => $validated['start_time'] ?? null,
            'end_time' => $validated['end_time'] ?? null,
            'apply_to_all' => $request->boolean('apply_to_all', false),
        ]);

        if ($discount->apply_to_all) {
            $discount->products()->detach();
        } else {
            $discount->products()->sync($validated['products'] ?? []);
        }

        return redirect()->route('admin.discounts.index')
            ->with('success', 'تم تحديث الخصم بنجاح');
    }

    public function destroy($id)
    {
        $discount = Discount::findOrFail($id);
        $discount->delete();

        return redirect()->route('admin.discounts.index')
            ->with('success', 'تم حذف الخصم بنجاح');
    }
}
