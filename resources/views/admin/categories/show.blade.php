@extends('admin.layouts.app')

@section('content')
<div class="content-header row">
    <div class="content-header-left col-md-9 col-12 mb-2">
        <div class="row breadcrumbs-top">
            <div class="col-12">
                <h2 class="content-header-title float-left mb-0" style="color: #70B9BE; font-weight: bold;">تفاصيل الفئة</h2>
                <div class="breadcrumb-wrapper col-12">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{ route('admin.index') }}">الرئيسية</a></li>
                        <li class="breadcrumb-item"><a href="{{ route('admin.categories.index') }}">الفئات</a></li>
                        <li class="breadcrumb-item active">تفاصيل الفئة</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>
    <div class="content-header-right text-md-right col-md-3 col-12 d-md-block d-none">
        <div class="form-group breadcrumb-right">
            <a href="{{ route('admin.categories.index') }}" class="btn btn-secondary">
                <i class="fa-solid fa-arrow-right"></i> العودة للقائمة
            </a>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-header">
                <h4 class="card-title">
                    <i class="fa-solid fa-eye text-info"></i>
                    تفاصيل الفئة: {{ $category->getTranslatedName() }}
                </h4>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-4">
                        <div class="text-center">
                            @if($category->image)
                                <img src="{{ asset('storage/' . $category->image) }}" 
                                     alt="{{ $category->getTranslatedName() }}" 
                                     class="img-fluid rounded shadow"
                                     style="max-height: 300px; object-fit: cover;">
                            @else
                                <div class="no-image-placeholder">
                                    <i class="fa-solid fa-image fa-5x text-muted"></i>
                                    <p class="text-muted mt-2">لا توجد صورة</p>
                                </div>
                            @endif
                        </div>
                    </div>
                    <div class="col-md-8">
                        <div class="category-details">
                            <div class="detail-item">
                                <strong>اسم الفئة:</strong>
                                <span>{{ $category->getTranslatedName() }}</span>
                            </div>
                            <div class="detail-item">
                                <strong>الدولة:</strong>
                                <span class="badge badge-light-info">{{ $category->country->getTranslatedName() ?? 'غير محدد' }}</span>
                            </div>
                            <div class="detail-item">
                                <strong>التخصص:</strong>
                                <span class="badge badge-light-warning">{{ $category->specialization->getTranslatedName() ?? 'غير محدد' }}</span>
                            </div>
                            <div class="detail-item">
                                <strong>عدد المنتجات:</strong>
                                <span class="badge badge-light-primary">{{ $category->products->count() }}</span>
                            </div>
                            <div class="detail-item">
                                <strong>الحالة:</strong>
                                @if($category->active)
                                    <span class="badge badge-success">نشط</span>
                                @else
                                    <span class="badge badge-danger">غير نشط</span>
                                @endif
                            </div>
                            <div class="detail-item">
                                <strong>تاريخ الإنشاء:</strong>
                                <span>{{ $category->created_at->format('Y-m-d H:i') }}</span>
                            </div>
                            <div class="detail-item">
                                <strong>آخر تحديث:</strong>
                                <span>{{ $category->updated_at->format('Y-m-d H:i') }}</span>
                            </div>
                        </div>
                    </div>
                </div>
                
                @if($category->products->count() > 0)
                    <div class="mt-4">
                        <h6><i class="fa-solid fa-box text-success"></i> المنتجات في هذه الفئة</h6>
                        <div class="row">
                            @foreach($category->products as $product)
                                <div class="col-md-3 col-sm-6 mb-3">
                                    <div class="product-mini-card">
                                        @if($product->image)
                                            <img src="{{ asset('storage/' . $product->image) }}" 
                                                 alt="{{ $product->getTranslatedName() }}" 
                                                 class="img-fluid rounded"
                                                 style="height: 80px; object-fit: cover;">
                                        @else
                                            <div class="no-image-mini">
                                                <i class="fa-solid fa-image text-muted"></i>
                                            </div>
                                        @endif
                                        <div class="product-mini-info">
                                            <small class="product-mini-name">{{ $product->getTranslatedName() }}</small>
                                            <small class="product-mini-price">{{ number_format($product->price, 2) }} ريال</small>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                @endif
            </div>
            <div class="card-footer">
                <div class="d-flex justify-content-between">
                    <a href="{{ route('admin.categories.index') }}" class="btn btn-secondary">
                        <i class="fa-solid fa-arrow-right"></i> العودة للقائمة
                    </a>
                    <div>
                        <a href="{{ route('admin.categories.edit', $category->id) }}" class="btn btn-warning">
                            <i class="fa-solid fa-edit"></i> تعديل الفئة
                        </a>
                        <button type="button" class="btn btn-danger" data-toggle="modal" data-target="#deleteModal">
                            <i class="fa-solid fa-trash"></i> حذف الفئة
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Delete Modal -->
<div class="modal fade" id="deleteModal" tabindex="-1" role="dialog" aria-labelledby="deleteModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="deleteModalLabel">تأكيد الحذف</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="text-center mb-3">
                    <i class="fa-solid fa-exclamation-triangle fa-3x text-warning"></i>
                </div>
                <p>هل أنت متأكد من حذف الفئة "<strong>{{ $category->getTranslatedName() }}</strong>"؟</p>
                <p class="text-danger">هذا الإجراء لا يمكن التراجع عنه.</p>
                @if($category->products->count() > 0)
                    <div class="alert alert-warning">
                        <i class="fa-solid fa-warning"></i>
                        تحذير: هذه الفئة تحتوي على {{ $category->products->count() }} منتج. لا يمكن حذفها إلا بعد نقل المنتجات إلى فئة أخرى.
                    </div>
                @endif
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">إلغاء</button>
                <form action="{{ route('admin.categories.destroy', $category->id) }}" method="POST" style="display: inline;">
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
.no-image-placeholder {
    padding: 3rem;
    color: #6c757d;
    background-color: #f8f9fa;
    border-radius: 8px;
}

.category-details {
    padding: 1rem 0;
}

.detail-item {
    display: flex;
    align-items: center;
    padding: 0.75rem 0;
    border-bottom: 1px solid #f0f0f0;
}

.detail-item:last-child {
    border-bottom: none;
}

.detail-item strong {
    min-width: 150px;
    color: #333;
    font-weight: 600;
}

.product-mini-card {
    border: 1px solid #eee;
    border-radius: 8px;
    padding: 1rem;
    text-align: center;
    background: white;
    transition: all 0.3s ease;
}

.product-mini-card:hover {
    box-shadow: 0 4px 8px rgba(0,0,0,0.1);
    transform: translateY(-2px);
}

.no-image-mini {
    height: 80px;
    display: flex;
    align-items: center;
    justify-content: center;
    background: #f8f9fa;
    border-radius: 6px;
}

.product-mini-info {
    margin-top: 0.5rem;
}

.product-mini-name {
    display: block;
    font-weight: 600;
    color: #333;
    margin-bottom: 0.25rem;
}

.product-mini-price {
    color: #28a745;
    font-weight: bold;
}

.card-footer {
    background-color: #f8f9fa;
    border-top: 1px solid #dee2e6;
}

.btn {
    border-radius: 6px;
    font-weight: 500;
}

.badge {
    font-size: 0.8rem;
    padding: 0.5rem 0.75rem;
}
</style>
@endpush
@endsection
