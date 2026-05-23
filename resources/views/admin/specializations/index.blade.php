@extends('admin.layouts.app')

@section('content')
<div class="content-header row">
    <div class="content-header-left col-md-9 col-12 mb-2">
        <div class="row breadcrumbs-top">
            <div class="col-12">
                <h2 class="content-header-title float-left mb-0" style="color: #70B9BE; font-weight: bold;">إدارة التخصصات</h2>
                <div class="breadcrumb-wrapper col-12">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{ route('admin.index') }}">الرئيسية</a></li>
                        <li class="breadcrumb-item active">التخصصات</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>
    <div class="content-header-right text-md-right col-md-3 col-12 d-md-block d-none">
        <div class="form-group breadcrumb-right">
            <a href="{{ route('admin.specializations.create') }}" class="btn btn-primary">
                <i class="fa-solid fa-plus"></i> إضافة تخصص جديد
            </a>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-header">
                <h4 class="card-title">قائمة التخصصات</h4>
                <div class="card-tools">
                    <!-- Search -->
                    <form method="GET" action="{{ route('admin.specializations.index') }}" class="d-flex align-items-center gap-2">
                        <div class="input-group input-group-sm" style="width: 200px;">
                            <input type="text" name="search" value="{{ request('search') }}" class="form-control" placeholder="البحث...">
                            <div class="input-group-append">
                                <button type="submit" class="btn btn-outline-secondary">
                                    <i class="fa-solid fa-search"></i>
                                </button>
                            </div>
                        </div>
                        
                        <select name="sort_by" class="form-control form-control-sm" style="width: 120px;">
                            <option value="name" {{ request('sort_by') == 'name' ? 'selected' : '' }}>الاسم</option>
                            <option value="created_at" {{ request('sort_by') == 'created_at' ? 'selected' : '' }}>تاريخ الإنشاء</option>
                        </select>
                        
                        <select name="sort_order" class="form-control form-control-sm" style="width: 100px;">
                            <option value="asc" {{ request('sort_order') == 'asc' ? 'selected' : '' }}>تصاعدي</option>
                            <option value="desc" {{ request('sort_order') == 'desc' ? 'selected' : '' }}>تنازلي</option>
                        </select>
                        
                        <button type="submit" class="btn btn-sm btn-outline-primary">
                            <i class="fa-solid fa-filter"></i> تطبيق
                        </button>
                    </form>
                </div>
            </div>
            <div class="card-body">
                <!-- Statistics -->
                <div class="row mb-4">
                    <div class="col-md-3">
                        <div class="card bg-primary text-white">
                            <div class="card-body">
                                <div class="d-flex justify-content-between">
                                    <div>
                                        <h4 class="mb-0">{{ $stats['total'] }}</h4>
                                        <p class="mb-0">إجمالي التخصصات</p>
                                    </div>
                                    <div class="align-self-center">
                                        <i class="fa-solid fa-graduation-cap fa-2x"></i>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Specializations Table -->
                <div class="table-responsive">
                    <table class="table table-striped">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>اسم التخصص</th>
                                <th>عدد الفئات</th>
                                <th>تاريخ الإنشاء</th>
                                <th>الإجراءات</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($specializations as $specialization)
                                <tr>
                                    <td>{{ ($specializations->currentPage() - 1) * $specializations->perPage() + $loop->iteration }}</td>
                                    <td>
                                        <div class="d-flex flex-column">
                                            <h6 class="mb-0">{{ $specialization->name }}</h6>
                                        </div>
                                    </td>
                                    <td>
                                        <span class="badge badge-light-info">{{ $specialization->categories->count() }}</span>
                                    </td>
                                    <td>{{ $specialization->created_at->format('Y-m-d H:i') }}</td>
                                    <td>
                                        <div class="btn-group" role="group">
                                            <a href="{{ route('admin.specializations.edit', $specialization->id) }}" 
                                               class="btn btn-sm btn-warning" 
                                               title="تعديل">
                                                <i class="fa-solid fa-edit"></i>
                                            </a>
                                            <button type="button" 
                                                    class="btn btn-sm btn-danger" 
                                                    onclick="deleteSpecialization({{ $specialization->id }})"
                                                    title="حذف">
                                                <i class="fa-solid fa-trash"></i>
                                            </button>
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="5" class="text-center">
                                        <div class="py-4">
                                            <i class="fa-solid fa-graduation-cap fa-3x text-muted mb-3"></i>
                                            <p class="text-muted">لا توجد تخصصات متاحة</p>
                                            <a href="{{ route('admin.specializations.create') }}" class="btn btn-primary">
                                                <i class="fa-solid fa-plus"></i> إضافة تخصص جديد
                                            </a>
                                        </div>
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                <!-- Pagination -->
                @if($specializations->hasPages())
                    <div class="d-flex justify-content-center mt-4">
                        {{ $specializations->links() }}
                    </div>
                @endif
            </div>
        </div>
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
                <p>هل أنت متأكد من حذف هذا التخصص؟</p>
                <p class="text-danger"><small>هذا الإجراء لا يمكن التراجع عنه.</small></p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">إلغاء</button>
                <form id="deleteForm" method="POST" style="display: inline;">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-danger">حذف</button>
                </form>
            </div>
        </div>
    </div>
</div>

<script>
function deleteSpecialization(specializationId) {
    document.getElementById('deleteForm').action = '{{ route("admin.specializations.destroy", ":id") }}'.replace(':id', specializationId);
    $('#deleteModal').modal('show');
}
</script>
@endsection
