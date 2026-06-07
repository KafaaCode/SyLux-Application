@extends('admin.layouts.app')

@section('content')
<div class="content-header row">
    <div class="content-header-left col-md-9 col-12 mb-2">
        <div class="row breadcrumbs-top">
            <div class="col-12">
                <h2 class="content-header-title float-left mb-0" style="color: #B79C6D; font-weight: bold;">تفاصيل المنتج</h2>
                <div class="breadcrumb-wrapper col-12">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{ route('admin.index') }}">الرئيسية</a></li>
                        <li class="breadcrumb-item"><a href="{{ route('admin.products.index') }}">المنتجات</a></li>
                        <li class="breadcrumb-item active">تفاصيل المنتج</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>
    <div class="content-header-right text-md-right col-md-3 col-12 d-md-block d-none">
        <div class="form-group breadcrumb-right">
            <div class="btn-group" role="group">
                <a href="{{ route('admin.products.edit', $product->id) }}" class="btn btn-warning">
                    <i class="fa-solid fa-edit"></i> تعديل
                </a>
                <a href="{{ route('admin.products.index') }}" class="btn btn-secondary">
                    <i class="fa-solid fa-arrow-right"></i> العودة
                </a>
            </div>
        </div>
    </div>
</div>

<div class="row">
    <!-- Product Details -->
    <div class="col-lg-8">
        <div class="card">
            <div class="card-header">
                <h4 class="card-title">
                    <i class="fa-solid fa-box text-primary"></i>
                    {{ $product->name }}
                </h4>
                <div class="card-tools">
                    @if($product->active)
                        <span class="badge badge-light-success badge-lg">نشط</span>
                    @else
                        <span class="badge badge-light-danger badge-lg">غير نشط</span>
                    @endif
                </div>
            </div>
            <div class="card-body">
                <div class="row">
                    <!-- Product Image -->
                    <div class="col-md-4">
                        <div class="product-image-container">
                            @if($product->image)
                                <img src="{{ asset('storage/' . $product->image) }}" 
                                     alt="{{ $product->name }}" 
                                     class="img-fluid rounded shadow"
                                     style="max-height: 300px; object-fit: cover;">
                            @else
                                <div class="no-image-placeholder">
                                    <i class="fa-solid fa-image fa-4x text-muted"></i>
                                    <p class="text-muted mt-2">لا توجد صورة</p>
                                </div>
                            @endif
                        </div>
                        
                        <!-- Additional Images Gallery -->
                        @if($product->images && $product->images->count() > 0)
                            <div class="additional-images mt-3">
                                <h6 class="mb-2">
                                    <i class="fa-solid fa-images text-primary"></i>
                                    صور إضافية ({{ $product->images->count() }})
                                </h6>
                                <div class="row g-2">
                                    @foreach($product->images as $image)
                                        <div class="col-6 col-md-4">
                                            <img src="{{ asset('storage/' . $image->path) }}" 
                                                 alt="صورة إضافية" 
                                                 class="img-fluid rounded border"
                                                 style="max-height: 100px; object-fit: cover; cursor: pointer;"
                                                 onclick="showImageModal('{{ asset('storage/' . $image->path) }}')">
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                        @endif
                    </div>
                    
                    <!-- Product Information -->
                    <div class="col-md-8">
                        <div class="product-info">
                            <div class="info-row">
                                <div class="info-label">
                                    <i class="fa-solid fa-tag text-primary"></i>
                                    اسم المنتج:
                                </div>
                                <div class="info-value">{{ $product->name }}</div>
                            </div>
                            
                            <div class="info-row">
                                <div class="info-label">
                                    <i class="fa-solid fa-list text-info"></i>
                                    الفئة:
                                </div>
                                <div class="info-value">
                                    <span class="badge badge-light-primary">{{ $product->category->name ?? 'غير محدد' }}</span>
                                </div>
                            </div>
                            
                            @if($product->serial_number)
                                <div class="info-row">
                                    <div class="info-label">
                                        <i class="fa-solid fa-barcode text-warning"></i>
                                        الرقم التسلسلي:
                                    </div>
                                    <div class="info-value">{{ $product->serial_number }}</div>
                                </div>
                            @endif
                            
                            @if($product->request_number)
                                <div class="info-row">
                                    <div class="info-label">
                                        <i class="fa-solid fa-file-alt text-secondary"></i>
                                        رقم الطلب:
                                    </div>
                                    <div class="info-value">{{ $product->request_number }}</div>
                                </div>
                            @endif
                            
                            <div class="info-row">
                                <div class="info-label">
                                    <i class="fa-solid fa-dollar-sign text-success"></i>
                                    السعر:
                                </div>
                                <div class="info-value">
                                    <span class="price-display">{{ number_format($product->price, 2) }} ريال</span>
                                </div>
                            </div>
                            
                            <div class="info-row">
                                <div class="info-label">
                                    <i class="fa-solid fa-calendar text-primary"></i>
                                    تاريخ الإنشاء:
                                </div>
                                <div class="info-value">{{ $product->created_at->format('Y-m-d H:i') }}</div>
                            </div>
                            
                            <div class="info-row">
                                <div class="info-label">
                                    <i class="fa-solid fa-clock text-info"></i>
                                    آخر تحديث:
                                </div>
                                <div class="info-value">{{ $product->updated_at->format('Y-m-d H:i') }}</div>
                            </div>

                            @if($product->color)
                            <div class="info-row">
                                <div class="info-label">
                                    <i class="fa-solid fa-palette text-primary"></i>
                                    اللون:
                                </div>
                                <div class="info-value">{{ $product->color }}</div>
                            </div>
                            @endif

                            @if($product->material)
                            <div class="info-row">
                                <div class="info-label">
                                    <i class="fa-solid fa-layer-group text-secondary"></i>
                                    المادة:
                                </div>
                                <div class="info-value">{{ $product->material }}</div>
                            </div>
                            @endif

                            @if($product->available_sizes)
                            <div class="info-row">
                                <div class="info-label">
                                    <i class="fa-solid fa-ruler text-warning"></i>
                                    المقاسات:
                                </div>
                                <div class="info-value">{{ $product->available_sizes }}</div>
                            </div>
                            @endif

                            @if($product->delivery_duration)
                            <div class="info-row">
                                <div class="info-label">
                                    <i class="fa-solid fa-truck text-info"></i>
                                    مدة التوصيل:
                                </div>
                                <div class="info-value">{{ $product->delivery_duration }}</div>
                            </div>
                            @endif

                            @if($product->fasil_method)
                            <div class="info-row">
                                <div class="info-label">
                                    <i class="fa-solid fa-cogs text-dark"></i>
                                    طريقة الفصل:
                                </div>
                                <div class="info-value">{{ $product->fasil_method }}</div>
                            </div>
                            @endif
                        </div>
                    </div>
                </div>

                @if($product->description)
                    <div class="row mt-4">
                        <div class="col-12">
                            <div class="description-section">
                                <h5 class="section-title">
                                    <i class="fa-solid fa-align-right text-primary"></i>
                                    وصف المنتج
                                </h5>
                                <div class="description-content">
                                    {{ $product->description }}
                                </div>
                            </div>
                        </div>
                    </div>
                @endif
            </div>
        </div>

        <!-- Related Relations -->
        @if($product->discounts->count() > 0 || $product->groups->count() > 0 || $product->reviews->count() > 0 || $product->favorites->count() > 0)
        <div class="card mt-4">
            <div class="card-header">
                <h5 class="card-title">
                    <i class="fa-solid fa-link text-primary"></i>
                    العلاقات المرتبطة
                </h5>
            </div>
            <div class="card-body">
                <!-- Discounts -->
                @if($product->discounts->count() > 0)
                <div class="relation-section mb-4">
                    <h6 class="relation-title">
                        <i class="fa-solid fa-tags text-success"></i>
                        الخصومات ({{ $product->discounts->count() }})
                    </h6>
                    <div class="table-responsive">
                        <table class="table table-sm table-bordered">
                            <thead class="thead-light">
                                <tr>
                                    <th>نسبة الخصم</th>
                                    <th>عام</th>
                                    <th>الحالة</th>
                                    <th>تاريخ البدء</th>
                                    <th>تاريخ الانتهاء</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($product->discounts as $discount)
                                <tr>
                                    <td><span class="badge badge-light-success">{{ $discount->discount_percentage }}%</span></td>
                                    <td>{{ $discount->apply_to_all ? 'نعم' : 'لا' }}</td>
                                    <td>
                                        @if($discount->active)
                                            <span class="badge badge-light-success">نشط</span>
                                        @else
                                            <span class="badge badge-light-danger">غير نشط</span>
                                        @endif
                                    </td>
                                    <td>{{ $discount->start_time ? $discount->start_time->format('Y-m-d H:i') : '-' }}</td>
                                    <td>{{ $discount->end_time ? $discount->end_time->format('Y-m-d H:i') : '-' }}</td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
                @endif

                <!-- Groups -->
                @if($product->groups->count() > 0)
                <div class="relation-section mb-4">
                    <h6 class="relation-title">
                        <i class="fa-solid fa-object-group text-info"></i>
                        المجموعات ({{ $product->groups->count() }})
                    </h6>
                    <div class="row">
                        @foreach($product->groups as $group)
                        <div class="col-md-6 mb-2">
                            <div class="group-card border rounded p-2">
                                <strong>{{ $group->name }}</strong>
                                <span class="badge {{ $group->active ? 'badge-light-success' : 'badge-light-danger' }} float-right">
                                    {{ $group->active ? 'نشط' : 'غير نشط' }}
                                </span>
                            </div>
                        </div>
                        @endforeach
                    </div>
                </div>
                @endif

                <!-- Reviews -->
                @if($product->reviews->count() > 0)
                <div class="relation-section mb-4">
                    <h6 class="relation-title">
                        <i class="fa-solid fa-star text-warning"></i>
                        التقييمات ({{ $product->reviews->count() }})
                    </h6>
                    <div class="table-responsive">
                        <table class="table table-sm table-bordered">
                            <thead class="thead-light">
                                <tr>
                                    <th>المستخدم</th>
                                    <th>التقييم</th>
                                    <th>المراجعة</th>
                                    <th>الحالة</th>
                                    <th>التاريخ</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($product->reviews as $review)
                                <tr>
                                    <td>{{ $review->user->name ?? '-' }}</td>
                                    <td>
                                        <span class="text-warning">
                                            @for($i = 1; $i <= 5; $i++)
                                                <i class="fa-solid fa-star{{ $i <= $review->rating ? '' : '-o' }}"></i>
                                            @endfor
                                        </span>
                                    </td>
                                    <td>{{ Str::limit($review->review, 40) }}</td>
                                    <td>
                                        @if($review->status === 'pending')
                                            <span class="badge badge-light-warning">معلق</span>
                                        @elseif($review->status === 'approved')
                                            <span class="badge badge-light-success">مقبول</span>
                                        @else
                                            <span class="badge badge-light-danger">مرفوض</span>
                                        @endif
                                    </td>
                                    <td>{{ $review->created_at->format('Y-m-d') }}</td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
                @endif

                <!-- Favorites -->
                @if($product->favorites->count() > 0)
                <div class="relation-section">
                    <h6 class="relation-title">
                        <i class="fa-solid fa-heart text-danger"></i>
                        المفضلة ({{ $product->favorites->count() }})
                    </h6>
                    <div class="row">
                        @foreach($product->favorites->take(10) as $favorite)
                        <div class="col-md-4 mb-2">
                            <span class="badge badge-light-secondary">
                                <i class="fa-solid fa-user text-muted"></i>
                                {{ $favorite->user->name ?? '-' }}
                            </span>
                        </div>
                        @endforeach
                    </div>
                    @if($product->favorites->count() > 10)
                        <small class="text-muted">و {{ $product->favorites->count() - 10 }} آخرون...</small>
                    @endif
                </div>
                @endif
            </div>
        </div>
        @endif
    </div>

    <!-- Sidebar -->
    <div class="col-lg-4">
        <!-- Quick Actions -->
        <div class="card">
            <div class="card-header">
                <h5 class="card-title">
                    <i class="fa-solid fa-bolt text-warning"></i>
                    إجراءات سريعة
                </h5>
            </div>
            <div class="card-body">
                <div class="d-grid gap-2">
                    <a href="{{ route('admin.products.edit', $product->id) }}" class="btn btn-warning">
                        <i class="fa-solid fa-edit"></i> تعديل المنتج
                    </a>
                    <button type="button" class="btn btn-danger" data-toggle="modal" data-target="#deleteModal">
                        <i class="fa-solid fa-trash"></i> حذف المنتج
                    </button>
                    <a href="{{ route('admin.products.create') }}" class="btn btn-primary">
                        <i class="fa-solid fa-plus"></i> إضافة منتج جديد
                    </a>
                </div>
            </div>
        </div>
        
        <!-- Product Statistics -->
        <div class="card">
            <div class="card-header">
                <h5 class="card-title">
                    <i class="fa-solid fa-chart-bar text-success"></i>
                    إحصائيات المنتج
                </h5>
            </div>
            <div class="card-body">
                <div class="stat-item">
                    <div class="stat-icon">
                        <i class="fa-solid fa-shopping-cart text-primary"></i>
                    </div>
                    <div class="stat-content">
                        <div class="stat-number">{{ $product->orderDetails->count() }}</div>
                        <div class="stat-label">عدد الطلبات</div>
                    </div>
                </div>
                
                @if($product->orderDetails->count() > 0)
                    <div class="stat-item">
                        <div class="stat-icon">
                            <i class="fa-solid fa-boxes text-info"></i>
                        </div>
                        <div class="stat-content">
                            <div class="stat-number">{{ $product->orderDetails->sum('quantity') }}</div>
                            <div class="stat-label">إجمالي الكمية المباعة</div>
                        </div>
                    </div>
                    
                    <div class="stat-item">
                        <div class="stat-icon">
                            <i class="fa-solid fa-coins text-success"></i>
                        </div>
                        <div class="stat-content">
                            <div class="stat-number">{{ number_format($product->orderDetails->sum('total_price'), 2) }}</div>
                            <div class="stat-label">إجمالي المبيعات (ريال)</div>
                        </div>
                    </div>
                @else
                    <div class="text-center text-muted py-3">
                        <i class="fa-solid fa-chart-line fa-2x mb-2"></i>
                        <p>لا توجد طلبات لهذا المنتج</p>
                    </div>
                @endif
            </div>
        </div>
        
        <!-- Category Information -->
        @if($product->category)
            <div class="card">
                <div class="card-header">
                    <h5 class="card-title">
                        <i class="fa-solid fa-folder text-info"></i>
                        معلومات الفئة
                    </h5>
                </div>
                <div class="card-body">
                    <div class="category-info">
                        <div class="category-name">
                            <strong>{{ $product->category->name }}</strong>
                        </div>
                        @if($product->category->description)
                            <div class="category-description mt-2">
                                <small class="text-muted">{{ $product->category->description }}</small>
                            </div>
                        @endif
                        <div class="category-stats mt-3">
                            <span class="badge badge-light-info">
                                {{ $product->category->products->count() }} منتج
                            </span>
                        </div>
                    </div>
                </div>
            </div>
        @endif
    </div>
</div>

<!-- Delete Modal -->
<div class="modal fade" id="deleteModal" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">تأكيد الحذف</h5>
                <button type="button" class="close" data-dismiss="modal">
                    <span>&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="text-center mb-3">
                    <i class="fa-solid fa-exclamation-triangle fa-3x text-warning"></i>
                </div>
                <p>هل أنت متأكد من حذف المنتج "<strong>{{ $product->name }}</strong>"؟</p>
                <p class="text-danger">هذا الإجراء لا يمكن التراجع عنه.</p>
                @if($product->orderDetails->count() > 0)
                    <div class="alert alert-warning">
                        <i class="fa-solid fa-warning"></i>
                        تحذير: هذا المنتج مرتبط بـ {{ $product->orderDetails->count() }} طلب. قد يؤثر الحذف على البيانات المرتبطة.
                    </div>
                @endif
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

@push('styles')
<style>
.product-image-container {
    text-align: center;
    padding: 1rem;
    background: #f8f9fa;
    border-radius: 8px;
    border: 2px dashed #ddd;
}

.no-image-placeholder {
    padding: 2rem;
    color: #6c757d;
}

.product-info {
    padding: 1rem 0;
}

.info-row {
    display: flex;
    align-items: center;
    padding: 0.75rem 0;
    border-bottom: 1px solid #f0f0f0;
}

.info-row:last-child {
    border-bottom: none;
}

.info-label {
    font-weight: 600;
    color: inherit;
    min-width: 150px;
    display: flex;
    align-items: center;
    gap: 0.5rem;
}

.info-value {
    color: inherit;
    flex: 1;
    opacity: 0.9;
}

.price-display {
    font-size: 1.2rem;
    font-weight: bold;
    color: #28a745;
}

.description-section {
    background: #f8f9fa;
    padding: 1.5rem;
    border-radius: 8px;
    border-left: 4px solid #B79C6D;
}

.section-title {
    color: #B79C6D;
    font-weight: 600;
    margin-bottom: 1rem;
    display: flex;
    align-items: center;
    gap: 0.5rem;
}

.description-content {
    line-height: 1.6;
    color: inherit;
    opacity: 0.9;
}

.stat-item {
    display: flex;
    align-items: center;
    padding: 1rem 0;
    border-bottom: 1px solid #f0f0f0;
}

.stat-item:last-child {
    border-bottom: none;
}

.stat-icon {
    width: 50px;
    height: 50px;
    background: #f8f9fa;
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    margin-left: 1rem;
}

.stat-content {
    flex: 1;
}

.stat-number {
    font-size: 1.5rem;
    font-weight: bold;
    color: inherit;
}

.stat-label {
    color: inherit;
    opacity: 0.75;
    font-size: 0.9rem;
}

.category-info {
    text-align: center;
}

.category-name {
    font-size: 1.1rem;
    color: #B79C6D;
}

.category-description {
    font-style: italic;
}

.card-title {
    color: #B79C6D;
    font-weight: 600;
}

.btn {
    border-radius: 6px;
    font-weight: 500;
}

.badge {
    font-size: 0.8rem;
    padding: 0.5rem 0.75rem;
}

.alert {
    border-radius: 8px;
}
</style>
@endpush

@push('scripts')
<script>
function showImageModal(src) {
    const modal = `
        <div class="modal fade" id="imageModal" tabindex="-1">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">صورة المنتج</h5>
                        <button type="button" class="close" data-dismiss="modal">
                            <span>&times;</span>
                        </button>
                    </div>
                    <div class="modal-body text-center">
                        <img src="${src}" class="img-fluid" alt="صورة المنتج">
                    </div>
                </div>
            </div>
        </div>
    `;
    $('body').append(modal);
    $('#imageModal').modal('show');
    
    $('#imageModal').on('hidden.bs.modal', function() {
        $(this).remove();
    });
}

$(document).ready(function() {
    // Initialize tooltips
    $('[data-toggle="tooltip"]').tooltip();
    
    // Image zoom functionality
    $('.product-image-container img').on('click', function() {
        const src = $(this).attr('src');
        showImageModal(src);
    });
});
</script>
@endpush
@endsection
