@extends('admin.layouts.app')

@section('content')
    <div class="content-header row">
        <div class="content-header-left col-md-9 col-12 mb-2">
            <div class="row breadcrumbs-top">
                <div class="col-12">
                    <h2 class="content-header-title float-left mb-0" style="color: #B79C6D; font-weight: bold;">إدارة الفئات
                    </h2>
                    <div class="breadcrumb-wrapper col-12">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="{{ route('admin.index') }}">الرئيسية</a></li>
                            <li class="breadcrumb-item active">الفئات</li>
                        </ol>
                    </div>
                </div>
            </div>
        </div>
        <div class="content-header-right text-md-right col-md-3 col-12 d-md-block d-none">
            <div class="form-group breadcrumb-right">
                <a href="{{ route('admin.categories.create') }}" class="btn btn-primary">
                    <i class="fa-solid fa-plus"></i> إضافة فئة جديدة
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
                        <p class="card-text">إجمالي الفئات</p>
                    </div>
                    <div class="avatar bg-light-primary p-50 m-0">
                        <div class="avatar-content">
                            <i class="fa-solid fa-list text-primary font-medium-5"></i>
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
                        <p class="card-text">الفئات النشطة</p>
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
                        <p class="card-text">الفئات غير النشطة</p>
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
                        <h2 class="fw-bolder mb-0">{{ $stats['total_products'] }}</h2>
                        <p class="card-text">إجمالي المنتجات</p>
                    </div>
                    <div class="avatar bg-light-info p-50 m-0">
                        <div class="avatar-content">
                            <i class="fa-solid fa-box text-info font-medium-5"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Categories Table -->
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h4 class="card-title">قائمة الفئات</h4>
                    <div class="card-tools">
                        <!-- Search and Filters -->
                        <form method="GET" action="{{ route('admin.categories.index') }}"
                            class="d-flex align-items-center gap-2">
                            <div class="input-group input-group-sm" style="width: 200px;">
                                <input type="text" name="search" value="{{ request('search') }}" class="form-control"
                                    placeholder="البحث...">
                                <div class="input-group-append">
                                    <button type="submit" class="btn btn-outline-secondary">
                                        <i class="fa-solid fa-search"></i>
                                    </button>
                                </div>
                            </div>

                            <select name="status" class="form-control form-control-sm" style="width: 120px;">
                                <option value="">جميع الحالات</option>
                                <option value="1" {{ request('status') == '1' ? 'selected' : '' }}>نشط</option>
                                <option value="0" {{ request('status') == '0' ? 'selected' : '' }}>غير نشط</option>
                            </select>

                            <select name="sort_by" class="form-control form-control-sm" style="width: 120px;">
                                <option value="created_at" {{ request('sort_by') == 'created_at' ? 'selected' : '' }}>تاريخ
                                    الإنشاء</option>
                                <option value="name" {{ request('sort_by') == 'name' ? 'selected' : '' }}>الاسم</option>
                                <option value="updated_at" {{ request('sort_by') == 'updated_at' ? 'selected' : '' }}>آخر
                                    تحديث</option>
                            </select>

                            <select name="sort_order" class="form-control form-control-sm" style="width: 100px;">
                                <option value="desc" {{ request('sort_order') == 'desc' ? 'selected' : '' }}>تنازلي</option>
                                <option value="asc" {{ request('sort_order') == 'asc' ? 'selected' : '' }}>تصاعدي</option>
                            </select>

                            <button type="submit" class="btn btn-primary btn-sm">
                                <i class="fa-solid fa-filter"></i> تطبيق
                            </button>

                            @if(request()->hasAny(['search', 'status', 'sort_by', 'sort_order']))
                                <a href="{{ route('admin.categories.index') }}" class="btn btn-secondary btn-sm">
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
                                            class="text-decoration-none" style="color: #2a2727;">
                                            اسم الفئة
                                            @if(request('sort_by') == 'name')
                                                <i
                                                    class="fa-solid fa-sort-{{ request('sort_order') == 'asc' ? 'up' : 'down' }}"></i>
                                            @endif
                                        </a>
                                    </th>
                                    <th>عدد المنتجات</th>
                                    <th>الحالة</th>
                                    <th>الإجراءات</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($categories as $category)
                                    <tr>
                                        <td>{{ ($categories->currentPage() - 1) * $categories->perPage() + $loop->iteration }}
                                        </td>
                                        <td>
                                            @if($category->image)
                                                <img src="{{ asset('storage/' . $category->image) }}" alt="{{ $category->name }}"
                                                    class="img-thumbnail" style="width: 50px; height: 50px; object-fit: cover;">
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
                                                <h6 class="mb-0">{{ $category->name }}</h6>
                                            </div>
                                        </td>
                                        <td>
                                            <span class="badge badge-light-primary">{{ $category->products->count() }}</span>
                                        </td>
                                        <td>
                                            @if($category->active)
                                                <span class="badge badge-success" style="color: #28a745;">نشط</span>
                                            @else
                                                <span class="badge badge-danger" style="color: #ae0000;">غير نشط</span>
                                            @endif
                                        </td>
                                        <td>
                                            <div class="btn-group" role="group">
                                                <a href="{{ route('admin.categories.show', $category->id) }}"
                                                    class="btn btn-sm btn-info" title="عرض التفاصيل">
                                                    <i class="fa-solid fa-eye"></i>
                                                </a>
                                                <a href="{{ route('admin.categories.edit', $category->id) }}"
                                                    class="btn btn-sm btn-warning" title="تعديل">
                                                    <i class="fa-solid fa-edit"></i>
                                                </a>
                                                <button type="button" class="btn btn-sm btn-danger" data-toggle="modal"
                                                    data-target="#deleteModal{{ $category->id }}" title="حذف">
                                                    <i class="fa-solid fa-trash"></i>
                                                </button>
                                            </div>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="6" class="text-center">
                                            <div class="py-4">
                                                <i class="fa-solid fa-list fa-3x text-muted mb-3"></i>
                                                <h5 class="text-muted">لا توجد فئات</h5>
                                                <p class="text-muted">ابدأ بإضافة فئة جديدة</p>
                                                <a href="{{ route('admin.categories.create') }}" class="btn btn-primary">
                                                    <i class="fa-solid fa-plus"></i> إضافة فئة جديدة
                                                </a>
                                            </div>
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>

                    @if($categories->hasPages())
                        <div class="d-flex justify-content-between align-items-center mt-3">
                            <div class="pagination-info">
                                <span class="text-muted">
                                    عرض {{ ($categories->currentPage() - 1) * $categories->perPage() + 1 }} إلى
                                    {{ min($categories->currentPage() * $categories->perPage(), $categories->total()) }}
                                    من أصل {{ $categories->total() }} فئة
                                </span>
                            </div>
                            <div class="pagination-links">
                                {{ $categories->appends(request()->query())->links() }}
                            </div>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>


    @foreach ($categories as $category)
        <!-- Delete Modal -->
        <div class="modal fade" id="deleteModal{{ $category->id }}" tabindex="-1" role="dialog"
            aria-labelledby="deleteModalLabel{{ $category->id }}" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="deleteModalLabel{{ $category->id }}">تأكيد الحذف</h5>
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
                                تحذير: هذه الفئة تحتوي على {{ $category->products->count() }} منتج. لا يمكن حذفها إلا بعد نقل
                                المنتجات إلى فئة أخرى.
                            </div>
                        @endif
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">إلغاء</button>
                        <form action="{{ route('admin.categories.destroy', $category->id) }}" method="POST"
                            style="display: inline;">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger">حذف</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    @endforeach

    @push('styles')
        <style>
            .image-upload-area {
                border: 2px dashed #ddd;
                border-radius: 8px;
                padding: 1.5rem;
                text-align: center;
                cursor: pointer;
                transition: all 0.3s ease;
                background-color: #f8f9fa;
            }

            .image-upload-area:hover {
                border-color: #B79C6D;
                background-color: #f0f8f9;
            }

            .image-upload-area.dragover {
                border-color: #B79C6D;
                background-color: #e8f4f5;
            }

            .image-preview img {
                max-height: 200px;
                object-fit: cover;
            }

            .no-image-placeholder {
                padding: 2rem;
                color: #6c757d;
            }

            .category-details {
                padding: 1rem 0;
            }

            .detail-item {
                display: flex;
                align-items: center;
                padding: 0.5rem 0;
                border-bottom: 1px solid #f0f0f0;
            }

            .detail-item:last-child {
                border-bottom: none;
            }

            .detail-item strong {
                min-width: 120px;
                color: #333;
            }

            .product-mini-card {
                border: 1px solid #eee;
                border-radius: 6px;
                padding: 0.5rem;
                text-align: center;
                background: white;
            }

            .no-image-mini {
                height: 60px;
                display: flex;
                align-items: center;
                justify-content: center;
                background: #f8f9fa;
                border-radius: 4px;
            }

            .product-mini-info {
                margin-top: 0.25rem;
            }

            .product-mini-name {
                display: block;
                font-weight: 600;
                color: #333;
            }

            .product-mini-price {
                color: #28a745;
                font-weight: bold;
            }

            .current-image img {
                border: 2px solid #B79C6D;
            }

            .modal-lg {
                max-width: 800px;
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

            /* Modal fixes */
            .modal {
                z-index: 1050;
            }

            .modal-backdrop {
                z-index: 1040;
            }

            /* Ensure modals are visible */
            .modal.show {
                display: block !important;
            }

            /* Fix for Bootstrap modal issues */
            .modal-dialog {
                margin: 1.75rem auto;
            }

            @media (min-width: 576px) {
                .modal-dialog {
                    max-width: 500px;
                    margin: 1.75rem auto;
                }
            }

            @media (min-width: 992px) {
                .modal-lg {
                    max-width: 800px;
                }
            }

            /* Modal backdrop fixes */
            .modal-backdrop {
                background-color: rgba(0, 0, 0, 0.5);
            }

            .modal-backdrop.show {
                opacity: 0.5;
            }

            /* Ensure modal buttons work */
            [data-toggle="modal"] {
                cursor: pointer;
            }

            /* Fix modal z-index issues */
            .modal {
                z-index: 1050 !important;
            }

            .modal-backdrop {
                z-index: 1040 !important;
            }
        </style>
    @endpush

    @push('scripts')
        <script>
            $(document).ready(function () {
                // Auto-submit form on filter change
                $('.card-tools form select[name="status"], .card-tools form select[name="sort_by"], .card-tools form select[name="sort_order"]').on('change', function () {
                    $(this).closest('form').submit();
                });

                // Image preview on hover
                $('.img-thumbnail').hover(
                    function () {
                        $(this).css('transform', 'scale(1.1)');
                    },
                    function () {
                        $(this).css('transform', 'scale(1)');
                    }
                );
            });
        </script>
    @endpush
@endsection