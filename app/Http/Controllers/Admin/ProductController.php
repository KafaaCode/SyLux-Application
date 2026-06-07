<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Spatie\Permission\Models\Role;
use App\Models\Category;
use App\Models\Product;
use App\Models\ProductTranslation;
use App\Models\ProductImage;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\DB;

class ProductController extends Controller
{
    public function index(Request $request)
    {
        $query = Product::with('category');
        
        // Search functionality
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('description', 'like', "%{$search}%")
                  ->orWhere('serial_number', 'like', "%{$search}%")
                  ->orWhere('request_number', 'like', "%{$search}%")
                  ->orWhereHas('category', function($categoryQuery) use ($search) {
                      $categoryQuery->where('name', 'like', "%{$search}%");
                  });
            });
        }
        
        // Filter by category
        if ($request->filled('category_id')) {
            $query->where('category_id', $request->category_id);
        }
        
        // Filter by status
        if ($request->filled('status')) {
            $query->where('active', $request->status);
        }
        
        // Filter by price range
        if ($request->filled('price_min')) {
            $query->where('price', '>=', $request->price_min);
        }
        if ($request->filled('price_max')) {
            $query->where('price', '<=', $request->price_max);
        }
        
        // Sorting
        $sortBy = $request->get('sort_by', 'created_at');
        $sortOrder = $request->get('sort_order', 'desc');
        
        $allowedSortFields = ['name', 'price', 'created_at', 'updated_at'];
        if (in_array($sortBy, $allowedSortFields)) {
            $query->orderBy($sortBy, $sortOrder);
        } else {
            $query->orderBy('created_at', 'desc');
        }
        
        // Get statistics before pagination
        $allProducts = $query->get();
        $stats = [
            'total' => $allProducts->count(),
            'active' => $allProducts->where('active', 1)->count(),
            'inactive' => $allProducts->where('active', 0)->count(),
            'avg_price' => $allProducts->avg('price')
        ];
        
        // Pagination
        $perPage = $request->get('per_page', 10);
        $products = $query->paginate($perPage)->withQueryString();
        
        // Get categories for filter dropdown
        $categories = Category::pluck('name', 'id')->all();
        
        return view('admin.products.index', compact('products', 'categories', 'stats'));
    }

    public function create()
    {
        // if (!auth()->user()->can('create-products')) {
        //     abort(403, 'Unauthorized');
        // }
        $categories = Category::pluck('name', 'id')->all();
        return view('admin.products.create', compact('categories'));
    }

    public function store(Request $request)
    {
        $this->validate($request, [
            'name' => 'required|unique:products,name',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg,webp',
            'images.*' => 'nullable|image|mimes:jpeg,png,jpg,webp,gif,svg',
            'category_id' => 'required|exists:categories,id',
            'price' => 'required|numeric|min:0',
            'serial_number' => 'nullable|string|max:255',
            'request_number' => 'nullable|string|max:255',
            'description' => 'nullable|string',
            'active' => 'nullable|boolean',
        ]);

        $productData = [
            'name' => $request->input('name'),
            'category_id' => $request->input('category_id'),
            'price' => $request->input('price'),
            'serial_number' => $request->input('serial_number'),
            'request_number' => $request->input('request_number'),
            'description' => $request->input('description'),
            'active' => $request->input('active', 1),
        ];

        if ($request->hasFile('image')) {
            $productData['image'] = $request->file('image')->store('products', 'public');
        }

        // Use database transaction to ensure data consistency
        DB::beginTransaction();
        try {
            $product = Product::create($productData);

            // Save multiple images if provided
            if ($request->hasFile('images')) {
                $uploadedImages = $request->file('images');
                
                // Ensure we have an array
                if (!is_array($uploadedImages)) {
                    $uploadedImages = [$uploadedImages];
                }
                
                foreach ($uploadedImages as $file) {
                    // Skip if file is null or invalid
                    if (!$file || !$file->isValid()) {
                        continue;
                    }
                    
                    try {
                        $path = $file->store("products/{$product->id}", 'public');
                        if ($path) {
                            ProductImage::create([
                                'product_id' => $product->id,
                                'path' => $path
                            ]);
                        }
                    } catch (\Exception $e) {
                        \Log::error('Error saving product image: ' . $e->getMessage());
                        continue;
                    }
                }
            }
            
            DB::commit();
        } catch (\Exception $e) {
            DB::rollBack();
            \Log::error('Error creating product: ' . $e->getMessage());
            return redirect()->back()
                ->withInput()
                ->withErrors(['error' => 'حدث خطأ أثناء إنشاء المنتج. يرجى المحاولة مرة أخرى.']);
        }

        return redirect()->route('admin.products.index')
            ->with('success', 'تم إنشاء المنتج بنجاح');
    }
    
    public function show($id)
    {
        $product = Product::with([
            'category',
            'orderDetails',
            'images',
            'discounts',
            'groups',
            'reviews.user',
            'favorites.user'
        ])->findOrFail($id);
        return view('admin.products.show', compact('product'));
    }
    
    public function edit($id)
    {
        $product = Product::with(['translations', 'images'])->findOrFail($id);
        $categories = Category::pluck('name', 'id')->all();
        return view('admin.products.edit', compact('product', 'categories'));
    }

    public function update(Request $request, $id)
    {
        $this->validate($request, [
            'name' => 'required|unique:products,name,' . $id,
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg,webp',
            'images.*' => 'nullable|image|mimes:jpeg,png,jpg,webp,gif,svg',
            'category_id' => 'required|exists:categories,id',
            'price' => 'required|numeric|min:0',
            'serial_number' => 'nullable|string|max:255',
            'request_number' => 'nullable|string|max:255',
            'description' => 'nullable|string',
            'active' => 'nullable|boolean',
        ]);

        $product = Product::findOrFail($id);
        
        $product->name = $request->input('name');
        $product->category_id = $request->input('category_id');
        $product->price = $request->input('price');
        $product->serial_number = $request->input('serial_number');
        $product->request_number = $request->input('request_number');
        $product->description = $request->input('description');
        $product->active = $request->input('active', 1);
        
        if ($request->hasFile('image')) {
            // Delete old image if exists
            if ($product->image && Storage::disk('public')->exists($product->image)) {
                Storage::disk('public')->delete($product->image);
            }
            $product->image = $request->file('image')->store('products', 'public');
        }
        
        DB::beginTransaction();
        try {
            $product->save();

            // Save newly uploaded multiple images (append to existing images)
            if ($request->hasFile('images')) {
                $uploadedImages = $request->file('images');
                
                // Ensure we have an array
                if (!is_array($uploadedImages)) {
                    $uploadedImages = [$uploadedImages];
                }
                
                foreach ($uploadedImages as $file) {
                    // Skip if file is null or invalid
                    if (!$file || !$file->isValid()) {
                        continue;
                    }
                    
                    try {
                        $path = $file->store("products/{$product->id}", 'public');
                        if ($path) {
                            ProductImage::create([
                                'product_id' => $product->id,
                                'path' => $path
                            ]);
                        }
                    } catch (\Exception $e) {
                        \Log::error('Error saving product image: ' . $e->getMessage());
                        continue;
                    }
                }
            }
            
            DB::commit();
        } catch (\Exception $e) {
            DB::rollBack();
            \Log::error('Error updating product: ' . $e->getMessage());
            return redirect()->back()
                ->withInput()
                ->withErrors(['error' => 'حدث خطأ أثناء تحديث المنتج. يرجى المحاولة مرة أخرى.']);
        }

        // Save translations
        if ($request->has('translations')) {
            foreach ($request->input('translations') as $locale => $translationData) {
                if (!empty($translationData['name_translated']) || !empty($translationData['description_translated'])) {
                    ProductTranslation::updateOrCreate(
                        [
                            'product_id' => $product->id,
                            'locale' => $locale
                        ],
                        [
                            'name_translated' => $translationData['name_translated'] ?? '',
                            'description_translated' => $translationData['description_translated'] ?? ''
                        ]
                    );
                }
            }
        }

        return redirect()->route('admin.products.index')
            ->with('success', 'تم تحديث المنتج بنجاح');
    }

    public function destroy($id)
    {
        $product = Product::findOrFail($id);
        
        // Delete image if exists
        if ($product->image && Storage::disk('public')->exists($product->image)) {
            Storage::disk('public')->delete($product->image);
        }

        // Delete additional images directory if exists
        Storage::disk('public')->deleteDirectory("products/{$product->id}");
        
        $product->delete();

        return redirect()->route('admin.products.index')
            ->with('success', 'تم حذف المنتج بنجاح');
    }

    public function destroyImage(Product $product, ProductImage $image)
    {
        // Verify that the image belongs to the product
        if ($image->product_id !== $product->id) {
            abort(404, 'الصورة غير مرتبطة بهذا المنتج');
        }

        if ($image->path && Storage::disk('public')->exists($image->path)) {
            Storage::disk('public')->delete($image->path);
        }

        $image->delete();

        return redirect()->back()->with('success', 'تم حذف الصورة بنجاح');
    }
}