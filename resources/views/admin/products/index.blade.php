@extends('admin.layouts.app')

@section('content')
<div class="content-header row">
    <div class="content-header-left col-md-9 col-12 mb-2">
        <div class="row breadcrumbs-top">
            <div class="col-12">
                <h2 class="content-header-title float-left mb-0" style="color: #B79C6D; font-weight: bold;">إدارة المنتجات</h2>
                <div class="breadcrumb-wrapper col-12">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{ route('admin.index') }}">الرئيسية</a></li>
                        <li class="breadcrumb-item active">المنتجات</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>
    <div class="content-header-right text-md-right col-md-3 col-12 d-md-block d-none">
        <div class="form-group breadcrumb-right">
            <a href="{{ route('admin.products.create') }}" class="btn btn-primary">
                <i class="fa-solid fa-plus"></i> إضافة منتج جديد
            </a>
        </div>
    </div>
</div>

<!-- Statistics Cards -->
<div class="row">
    <div class="col-lg-3 col-sm-6 col-12">
        <div class="card">
            <div class="card-header d-flex align-items-start pb-0">
                <div>
                    <h2 class="fw-bolder mb-0">{{ $stats['total'] }}</h2>
                    <p class="card-text">إجمالي المنتجات</p>
                </div>
                <div class="avatar bg-light-primary p-50 m-0">
                    <div class="avatar-content">
                        <i class="fa-solid fa-box text-primary font-medium-5"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-lg-3 col-sm-6 col-12">
        <div class="card">
            <div class="card-header d-flex align-items-start pb-0">
                <div>
                    <h2 class="fw-bolder mb-0">{{ $stats['active'] }}</h2>
                    <p class="card-text">المنتجات النشطة</p>
                </div>
                <div class="avatar bg-light-success p-50 m-0">
                    <div class="avatar-content">
                        <i class="fa-solid fa-check-circle text-success font-medium-5"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-lg-3 col-sm-6 col-12">
        <div class="card">
            <div class="card-header d-flex align-items-start pb-0">
                <div>
                    <h2 class="fw-bolder mb-0">{{ $stats['inactive'] }}</h2>
                    <p class="card-text">المنتجات غير النشطة</p>
                </div>
                <div class="avatar bg-light-warning p-50 m-0">
                    <div class="avatar-content">
                        <i class="fa-solid fa-pause-circle text-warning font-medium-5"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-lg-3 col-sm-6 col-12">
        <div class="card">
            <div class="card-header d-flex align-items-start pb-0">
                <div>
                    <h2 class="fw-bolder mb-0">{{ number_format($stats['avg_price'], 2) }}</h2>
                    <p class="card-text">متوسط السعر</p>
                </div>
                <div class="avatar bg-light-info p-50 m-0">
                    <div class="avatar-content">
                        <i class="fa-solid fa-dollar-sign text-info font-medium-5"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Products Table -->
<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-header">
                <h4 class="card-title">قائمة المنتجات</h4>
                <div class="card-tools">
                    <!-- Search and Filters -->
                    <form method="GET" action="{{ route('admin.products.index') }}" class="d-flex align-items-center gap-2">
                        <div class="input-group input-group-sm" style="width: 200px;">
                            <input type="text" name="search" value="{{ request('search') }}" class="form-control" placeholder="البحث...">
                            <div class="input-group-append">
                                <button type="submit" class="btn btn-outline-secondary">
                                    <i class="fa-solid fa-search"></i>
                                </button>
                            </div>
                        </div>
                        
                        <select name="category_id" class="form-control form-control-sm" style="width: 150px;">
                            <option value="">جميع الفئات</option>
                            @foreach($categories as $id => $name)
                                <option value="{{ $id }}" {{ request('category_id') == $id ? 'selected' : '' }}>
                                    {{ $name }}
                                </option>
                            @endforeach
                        </select>
                        
                        <select name="status" class="form-control form-control-sm" style="width: 120px;">
                            <option value="">جميع الحالات</option>
                            <option value="1" {{ request('status') == '1' ? 'selected' : '' }}>نشط</option>
                            <option value="0" {{ request('status') == '0' ? 'selected' : '' }}>غير نشط</option>
                        </select>
                        
                        <select name="sort_by" class="form-control form-control-sm" style="width: 120px;">
                            <option value="created_at" {{ request('sort_by') == 'created_at' ? 'selected' : '' }}>تاريخ الإنشاء</option>
                            <option value="name" {{ request('sort_by') == 'name' ? 'selected' : '' }}>الاسم</option>
                            <option value="price" {{ request('sort_by') == 'price' ? 'selected' : '' }}>السعر</option>
                            <option value="updated_at" {{ request('sort_by') == 'updated_at' ? 'selected' : '' }}>آخر تحديث</option>
                        </select>
                        
                        <select name="sort_order" class="form-control form-control-sm" style="width: 100px;">
                            <option value="desc" {{ request('sort_order') == 'desc' ? 'selected' : '' }}>تنازلي</option>
                            <option value="asc" {{ request('sort_order') == 'asc' ? 'selected' : '' }}>تصاعدي</option>
                        </select>
                        
                        <button type="submit" class="btn btn-primary btn-sm">
                            <i class="fa-solid fa-filter"></i> تطبيق
                        </button>
                        
                        @if(request()->hasAny(['search', 'category_id', 'status', 'sort_by', 'sort_order']))
                            <a href="{{ route('admin.products.index') }}" class="btn btn-secondary btn-sm">
                                <i class="fa-solid fa-times"></i> مسح
                            </a>
                        @endif
                    </form>
                </div>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-striped table-hover">
                        <thead class="thead-dark">
                            <tr>
                                <th>#</th>
                                <th>الصورة</th>
                                <th>
                                    <a href="{{ request()->fullUrlWithQuery(['sort_by' => 'name', 'sort_order' => request('sort_by') == 'name' && request('sort_order') == 'asc' ? 'desc' : 'asc']) }}"
                                       class="text-decoration-none" style="color: inherit;">
                                        اسم المنتج
                                        @if(request('sort_by') == 'name')
                                            <i class="fa-solid fa-sort-{{ request('sort_order') == 'asc' ? 'up' : 'down' }}"></i>
                                        @endif
                                    </a>
                                </th>
                                <th>الفئة</th>
                                <th>الرقم التسلسلي</th>
                                <th>
                                    <a href="{{ request()->fullUrlWithQuery(['sort_by' => 'price', 'sort_order' => request('sort_by') == 'price' && request('sort_order') == 'asc' ? 'desc' : 'asc']) }}"
                                       class="text-decoration-none" style="color: inherit;">
                                        السعر
                                        @if(request('sort_by') == 'price')
                                            <i class="fa-solid fa-sort-{{ request('sort_order') == 'asc' ? 'up' : 'down' }}"></i>
                                        @endif
                                    </a>
                                </th>
                                <th>الحالة</th>
                                <th>
                                    <a href="{{ request()->fullUrlWithQuery(['sort_by' => 'created_at', 'sort_order' => request('sort_by') == 'created_at' && request('sort_order') == 'asc' ? 'desc' : 'asc']) }}"
                                       class="text-decoration-none" style="color: inherit;">
                                        تاريخ الإنشاء
                                        @if(request('sort_by') == 'created_at' || !request('sort_by'))
                                            <i class="fa-solid fa-sort-{{ request('sort_order') == 'asc' ? 'up' : 'down' }}"></i>
                                        @endif
                                    </a>
                                </th>
                                <th>الإجراءات</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($products as $product)
                                <tr>
                                    <td>{{ ($products->currentPage() - 1) * $products->perPage() + $loop->iteration }}</td>
                                    <td>
                                        @if($product->image)
                                            <img src="{{ asset('storage/' . $product->image) }}" 
                                                 alt="{{ $product->name }}" 
                                                 class="img-thumbnail" 
                                                 style="width: 50px; height: 50px; object-fit: cover;">
                                        @else
                                            <div class="avatar bg-light-secondary">
                                                <div class="avatar-content">
                                                    <i class="fa-solid fa-image text-secondary"></i>
                                                </div>
                                            </div>
                                        @endif
                                    </td>
                                    <td>
                                        <div class="d-flex flex-column">
                                            <h6 class="mb-0">{{ $product->getTranslatedName() }}</h6>
                                            @if($product->description)
                                                <small class="text-muted">{{ Str::limit($product->getTranslatedDescription(), 50) }}</small>
                                            @endif
                                        </div>
                                    </td>
                                    <td>
                                        <span class="badge badge-light-primary">{{ $product->category?->getTranslatedName() ?? 'غير محدد' }}</span>
                                    </td>
                                    <td>
                                        <span class="text-muted">{{ $product->serial_number ?? 'غير محدد' }}</span>
                                    </td>
                                    <td>
                                        <span class="font-weight-bold text-success">{{ number_format($product->price, 2) }} ريال</span>
                                    </td>
                                    <td>
                                        @if($product->active)
                                            <span class="badge badge-light-success">نشط</span>
                                        @else
                                            <span class="badge badge-light-danger">غير نشط</span>
                                        @endif
                                    </td>
                                    <td>
                                        <small class="text-muted">{{ $product->created_at->format('Y-m-d') }}</small>
                                    </td>
                                    <td>
                                        <div class="btn-group" role="group">
                                            <a href="{{ route('admin.products.show', $product->id) }}" 
                                               class="btn btn-sm btn-info" 
                                               data-toggle="tooltip" 
                                               title="عرض التفاصيل">
                                                <i class="fa-solid fa-eye"></i>
                                            </a>
                                            <a href="{{ route('admin.products.edit', $product->id) }}" 
                                               class="btn btn-sm btn-warning" 
                                               data-toggle="tooltip" 
                                               title="تعديل">
                                                <i class="fa-solid fa-edit"></i>
                                            </a>
                                            <button type="button" 
                                                    class="btn btn-sm btn-danger" 
                                                    data-toggle="modal" 
                                                    data-target="#deleteModal{{ $product->id }}"
                                                    title="حذف">
                                                <i class="fa-solid fa-trash"></i>
                                            </button>
                                        </div>
                                    </td>
                                </tr>

                                <!-- Delete Modal -->
                                <div class="modal fade" id="deleteModal{{ $product->id }}" tabindex="-1" role="dialog">
                                    <div class="modal-dialog" role="document">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title">تأكيد الحذف</h5>
                                                <button type="button" class="close" data-dismiss="modal">
                                                    <span>&times;</span>
                                                </button>
                                            </div>
                                            <div class="modal-body">
                                                <p>هل أنت متأكد من حذف المنتج "<strong>{{ $product->name }}</strong>"؟</p>
                                                <p class="text-danger">هذا الإجراء لا يمكن التراجع عنه.</p>
                                            </div>
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-secondary" data-dismiss="modal">إلغاء</button>
                                                <form action="{{ route('admin.products.destroy', $product->id) }}" method="POST" style="display: inline;">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="btn btn-danger">حذف</button>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @empty
                                <tr>
                                    <td colspan="9" class="text-center">
                                        <div class="py-4">
                                            <i class="fa-solid fa-box-open fa-3x text-muted mb-3"></i>
                                            <h5 class="text-muted">لا توجد منتجات</h5>
                                            <p class="text-muted">ابدأ بإضافة منتج جديد</p>
                                            <a href="{{ route('admin.products.create') }}" class="btn btn-primary">
                                                <i class="fa-solid fa-plus"></i> إضافة منتج جديد
                                            </a>
                                        </div>
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
                
                @if($products->hasPages())
                    <div class="d-flex justify-content-between align-items-center mt-3">
                        <div class="pagination-info">
                            <span class="text-muted">
                                عرض {{ ($products->currentPage() - 1) * $products->perPage() + 1 }} إلى 
                                {{ min($products->currentPage() * $products->perPage(), $products->total()) }} 
                                من أصل {{ $products->total() }} منتج
                            </span>
                        </div>
                        <div class="pagination-links">
                            {{ $products->appends(request()->query())->links() }}
                        </div>
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script>
    $(document).ready(function() {
        // Initialize tooltips
        $('[data-toggle="tooltip"]').tooltip();
        
        // Auto-submit form on filter change
        $('select[name="category_id"], select[name="status"], select[name="sort_by"], select[name="sort_order"]').on('change', function() {
            $(this).closest('form').submit();
        });
        
        // Image preview on hover
        $('.img-thumbnail').hover(
            function() {
                $(this).css('transform', 'scale(1.1)');
            },
            function() {
                $(this).css('transform', 'scale(1)');
            }
        );
    });
</script>
@endpush
@endsection
