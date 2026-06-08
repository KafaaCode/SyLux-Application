<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Spatie\Permission\Models\Role;
use App\Models\Category;
use App\Helpers\ApiTranslationHelper;

class CategoryController extends Controller
{

    /**
     * CategoryController constructor.
     */
    public function __construct()
    {
        // $this->middleware('permission:create-categories', ['only' => ['create', 'store']]);
        // $this->middleware('permission:edit-categories', ['only' => ['edit', 'update']]);
        // $this->middleware('permission:delete-categories', ['only' => ['destroy']]);
    }

    /**
     * API endpoint for admin to get all categories
     */
    public function adminIndex(Request $request)
    {
        try {
            $query = Category::with(['products']);
            
            // Search functionality
            if ($request->filled('search')) {
                $search = $request->search;
                $query->where('name', 'like', "%{$search}%");
            }
            
            // Filter by status
            if ($request->filled('active')) {
                $query->where('active', $request->active);
            }
            
            // Sorting
            $sortBy = $request->get('sort_by', 'created_at');
            $sortOrder = $request->get('sort_order', 'desc');
            
            $allowedSortFields = ['name', 'created_at', 'updated_at'];
            if (in_array($sortBy, $allowedSortFields)) {
                $query->orderBy($sortBy, $sortOrder);
            } else {
                $query->orderBy('created_at', 'desc');
            }
            
            // Pagination
            $perPage = $request->get('per_page', 15);
            $categories = $query->paginate($perPage);
            
            // Get statistics
            $stats = [
                'total' => Category::count(),
                'active' => Category::where('active', 1)->count(),
                'inactive' => Category::where('active', 0)->count(),
            ];
            
            // Format categories for API response
            $translatedCategories = $categories->map(function($category) {
                return ApiTranslationHelper::formatCategory($category);
            });
            
            return ApiTranslationHelper::successResponse([
                'data' => $translatedCategories,
                'pagination' => [
                    'current_page' => $categories->currentPage(),
                    'last_page' => $categories->lastPage(),
                    'per_page' => $categories->perPage(),
                    'total' => $categories->total(),
                ],
                'stats' => $stats
            ], 'تم استرجاع الفئات بنجاح');
            
        } catch (\Exception $e) {
            return ApiTranslationHelper::errorResponse('حدث خطأ في استرجاع الفئات: ' . $e->getMessage(), 500);
        }
    }

    public function index(Request $request)
    {
        $query = Category::with(['products']);
        
        // Search functionality
        if ($request->filled('search')) {
            $query->where('name', 'like', "%{$request->search}%");
        }
        
        // Filter by status
        if ($request->filled('status')) {
            $query->where('active', $request->status);
        }
        
        // Sorting
        $sortBy = $request->get('sort_by', 'created_at');
        $sortOrder = $request->get('sort_order', 'desc');
        
        $allowedSortFields = ['name', 'created_at', 'updated_at'];
        if (in_array($sortBy, $allowedSortFields)) {
            $query->orderBy($sortBy, $sortOrder);
        } else {
            $query->orderBy('created_at', 'desc');
        }
        
        // Get statistics before pagination
        $allCategories = $query->get();
        $stats = [
            'total' => $allCategories->count(),
            'active' => $allCategories->where('active', 1)->count(),
            'inactive' => $allCategories->where('active', 0)->count(),
            'total_products' => $allCategories->sum(function($category) {
                return $category->products->count();
            })
        ];
        
        // Pagination
        $perPage = $request->get('per_page', 10);
        $categories = $query->paginate($perPage)->withQueryString();
        
        return view('admin.categories.index', compact('categories', 'stats'));
    }

    public function create()
    {
        return view('admin.categories.create');
    }

    public function store(Request $request)
    {
        $this->validate($request, [
            'name' => 'required|unique:categories,name',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'active' => 'nullable|boolean',
        ]);

        $categoryData = [
            'name' => $request->input('name'),
            'active' => $request->input('active', 1),
        ];

        if ($request->hasFile('image')) {
            $categoryData['image'] = $request->file('image')->store('categories', 'public');
        }

        Category::create($categoryData);

        return redirect()->route('admin.categories.index')
            ->with('success', 'تم إنشاء الفئة بنجاح');
    }

    public function show($id)
    {
        $category = Category::with(['products'])->findOrFail($id);
        return view('admin.categories.show', compact('category'));
    }

    public function edit($id)
    {
        $category = Category::findOrFail($id);
        return view('admin.categories.edit', compact('category'));
    }

    public function update(Request $request, $id)
    {
        $this->validate($request, [
            'name' => 'required|unique:categories,name,' . $id,
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'active' => 'nullable|boolean',
        ]);

        $category = Category::findOrFail($id);
        
        $category->name = $request->input('name');
        $category->active = $request->input('active', 1);
        
        if ($request->hasFile('image')) {
            // Delete old image if exists
            if ($category->image && \Storage::disk('public')->exists($category->image)) {
                \Storage::disk('public')->delete($category->image);
            }
            $category->image = $request->file('image')->store('categories', 'public');
        }
        
        $category->save();

        return redirect()->route('admin.categories.index')
            ->with('success', 'تم تحديث الفئة بنجاح');
    }

    public function destroy($id)
    {
        $category = Category::findOrFail($id);
        
        // Check if category has products
        if ($category->products->count() > 0) {
            return redirect()->route('admin.categories.index')
                ->with('error', 'لا يمكن حذف هذه الفئة لأنها تحتوي على منتجات. يرجى نقل المنتجات إلى فئة أخرى أولاً.');
        }
        
        // Delete image if exists
        if ($category->image && \Storage::disk('public')->exists($category->image)) {
            \Storage::disk('public')->delete($category->image);
        }
        
        $category->delete();

        return redirect()->route('admin.categories.index')
            ->with('success', 'تم حذف الفئة بنجاح');
    }
}