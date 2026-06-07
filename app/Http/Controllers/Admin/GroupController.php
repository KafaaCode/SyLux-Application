<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Group;
use App\Models\Product;
use Illuminate\Http\Request;

class GroupController extends Controller
{
    public function index(Request $request)
    {
        $query = Group::with('products');

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where('name', 'like', "%{$search}%");
        }

        if ($request->filled('status')) {
            $query->where('active', $request->status);
        }

        $perPage = $request->get('per_page', 10);
        $groups = $query->paginate($perPage)->withQueryString();

        return view('admin.groups.index', compact('groups'));
    }

    public function create()
    {
        $products = Product::where('active', true)->pluck('name', 'id')->all();
        return view('admin.groups.create', compact('products'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255|unique:groups,name',
            'active' => 'nullable|boolean',
            'products' => 'nullable|array',
            'products.*' => 'exists:products,id',
        ]);

        $group = Group::create([
            'name' => $validated['name'],
            'active' => $request->boolean('active', true),
        ]);

        if (!empty($validated['products'])) {
            $group->products()->sync($validated['products']);
        }

        return redirect()->route('admin.groups.index')
            ->with('success', 'تم إنشاء المجموعة بنجاح');
    }

    public function edit($id)
    {
        $group = Group::with('products')->findOrFail($id);
        $products = Product::where('active', true)->pluck('name', 'id')->all();
        $selectedProducts = $group->products->pluck('id')->toArray();

        return view('admin.groups.edit', compact('group', 'products', 'selectedProducts'));
    }

    public function update(Request $request, $id)
    {
        $group = Group::findOrFail($id);

        $validated = $request->validate([
            'name' => 'required|string|max:255|unique:groups,name,' . $id,
            'active' => 'nullable|boolean',
            'products' => 'nullable|array',
            'products.*' => 'exists:products,id',
        ]);

        $group->update([
            'name' => $validated['name'],
            'active' => $request->boolean('active', true),
        ]);

        $group->products()->sync($validated['products'] ?? []);

        return redirect()->route('admin.groups.index')
            ->with('success', 'تم تحديث المجموعة بنجاح');
    }

    public function destroy($id)
    {
        $group = Group::findOrFail($id);
        $group->delete();

        return redirect()->route('admin.groups.index')
            ->with('success', 'تم حذف المجموعة بنجاح');
    }
}
