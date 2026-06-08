@extends('admin.layouts.app')

@section('title', 'إدارة الأقسام')

@section('content')
<div class="content-header row">
    <div class="content-header-left col-md-9 col-12 mb-2">
        <div class="row breadcrumbs-top">
            <div class="col-12">
                <h2 class="content-header-title float-left mb-0" style="color: #B79C6D; font-weight: bold;">إدارة الأقسام</h2>
                <div class="breadcrumb-wrapper col-12">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{ route('admin.index') }}">الرئيسية</a></li>
                        <li class="breadcrumb-item active">الأقسام</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>
    <div class="content-header-right text-md-right col-md-3 col-12 d-md-block d-none">
        <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#createSectionModal">
            <i class="fa-solid fa-plus"></i> إضافة قسم
        </button>
    </div>
</div>

@if(session('success'))
    <div class="alert alert-success alert-dismissible fade show" role="alert">
        {{ session('success') }}
        <button type="button" class="close" data-dismiss="alert"><span>&times;</span></button>
    </div>
@endif

@if(session('error'))
    <div class="alert alert-danger alert-dismissible fade show" role="alert">
        {{ session('error') }}
        <button type="button" class="close" data-dismiss="alert"><span>&times;</span></button>
    </div>
@endif

@if ($errors->any())
    <div class="alert alert-danger">
        <ul class="mb-0">
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif

@include('admin.sections.partials.stats', ['stats' => $stats])

<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-header d-flex flex-wrap justify-content-between align-items-center">
                <h4 class="card-title mb-0">قائمة الأقسام</h4>
                <div class="card-tools mt-1 mt-md-0">
                    <form method="GET" action="{{ route('admin.sections.index') }}" class="d-flex flex-wrap align-items-center gap-2">
                        <div class="input-group input-group-sm" style="width: 200px;">
                            <input type="text" name="search" value="{{ request('search') }}" class="form-control" placeholder="بحث بالاسم...">
                            <div class="input-group-append">
                                <button type="submit" class="btn btn-outline-secondary">
                                    <i class="fa-solid fa-search"></i>
                                </button>
                            </div>
                        </div>
                        <select name="status" class="form-control form-control-sm" style="width: 130px;">
                            <option value="">كل الحالات</option>
                            <option value="active" {{ request('status') === 'active' ? 'selected' : '' }}>مفعل</option>
                            <option value="inactive" {{ request('status') === 'inactive' ? 'selected' : '' }}>غير مفعل</option>
                        </select>
                        <select name="sort_by" class="form-control form-control-sm" style="width: 130px;">
                            <option value="created_at" {{ request('sort_by', 'created_at') === 'created_at' ? 'selected' : '' }}>تاريخ الإنشاء</option>
                            <option value="name" {{ request('sort_by') === 'name' ? 'selected' : '' }}>الاسم</option>
                        </select>
                        <select name="sort_order" class="form-control form-control-sm" style="width: 110px;">
                            <option value="desc" {{ request('sort_order', 'desc') === 'desc' ? 'selected' : '' }}>تنازلي</option>
                            <option value="asc" {{ request('sort_order') === 'asc' ? 'selected' : '' }}>تصاعدي</option>
                        </select>
                        <button type="submit" class="btn btn-sm btn-outline-primary">
                            <i class="fa-solid fa-filter"></i> تطبيق
                        </button>
                    </form>
                </div>
            </div>

            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-striped align-middle">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>الصورة</th>
                                <th>الاسم</th>
                                <th>الحالة</th>
                                <th>تاريخ الإنشاء</th>
                                <th>الإجراءات</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($sections as $section)
                                <tr>
                                    <td>{{ ($sections->currentPage() - 1) * $sections->perPage() + $loop->iteration }}</td>
                                    <td>
                                        @if($section->image)
                                            <img src="{{ asset('storage/' . $section->image) }}"
                                                 alt="{{ $section->name }}"
                                                 class="img-thumbnail"
                                                 style="width: 52px; height: 52px; object-fit: cover;">
                                        @else
                                            <div class="avatar bg-light-secondary">
                                                <div class="avatar-content">
                                                    <i class="fa-solid fa-image text-secondary"></i>
                                                </div>
                                            </div>
                                        @endif
                                    </td>
                                    <td><h6 class="mb-0">{{ $section->name }}</h6></td>
                                    <td>
                                        @if($section->active)
                                            <span class="badge badge-success">مفعل</span>
                                        @else
                                            <span class="badge badge-danger">غير مفعل</span>
                                        @endif
                                    </td>
                                    <td>{{ $section->created_at->format('Y-m-d H:i') }}</td>
                                    <td>
                                        <div class="btn-group" role="group">
                                            <button type="button"
                                                    class="btn btn-sm btn-warning edit-section-btn"
                                                    title="تعديل"
                                                    data-id="{{ $section->id }}"
                                                    data-name="{{ $section->name }}"
                                                    data-image="{{ $section->image }}"
                                                    data-update-url="{{ route('admin.sections.update', $section) }}">
                                                <i class="fa-solid fa-edit"></i>
                                            </button>
                                            <form action="{{ route('admin.sections.toggle', $section) }}" method="POST" class="d-inline">
                                                @csrf
                                                @method('PATCH')
                                                <button type="submit"
                                                        class="btn btn-sm btn-secondary"
                                                        title="{{ $section->active ? 'إلغاء التفعيل' : 'تفعيل' }}">
                                                    <i class="fa-solid fa-{{ $section->active ? 'ban' : 'check' }}"></i>
                                                </button>
                                            </form>
                                            <button type="button"
                                                    class="btn btn-sm btn-danger"
                                                    title="حذف"
                                                    onclick="openDeleteSectionModal('{{ route('admin.sections.destroy', $section) }}')">
                                                <i class="fa-solid fa-trash"></i>
                                            </button>
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="6" class="text-center py-4">
                                        <i class="fa-solid fa-layer-group fa-3x text-muted mb-2 d-block"></i>
                                        <p class="text-muted mb-2">لا توجد أقسام</p>
                                        <button type="button" class="btn btn-primary btn-sm" data-toggle="modal" data-target="#createSectionModal">
                                            <i class="fa-solid fa-plus"></i> إضافة قسم
                                        </button>
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                @if($sections->hasPages())
                    <div class="d-flex justify-content-center mt-3">
                        {{ $sections->links() }}
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>

@include('admin.sections.partials.form-modal', [
    'modalId' => 'createSectionModal',
    'title' => 'إضافة قسم جديد',
    'action' => route('admin.sections.store'),
    'submitLabel' => 'حفظ',
    'submitClass' => 'primary',
])

@include('admin.sections.partials.form-modal', [
    'modalId' => 'editSectionModal',
    'title' => 'تعديل القسم',
    'action' => '#',
    'method' => 'PUT',
    'submitLabel' => 'تحديث',
    'submitClass' => 'warning',
])

<div class="modal fade" id="deleteSectionModal" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">تأكيد الحذف</h5>
                <button type="button" class="close" data-dismiss="modal"><span>&times;</span></button>
            </div>
            <div class="modal-body">
                <p>هل أنت متأكد من حذف هذا القسم؟</p>
                <p class="text-danger mb-0"><small>لا يمكن التراجع عن هذا الإجراء.</small></p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">إلغاء</button>
                <form id="deleteSectionForm" method="POST" class="d-inline">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-danger">حذف</button>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
    function openDeleteSectionModal(actionUrl) {
        document.getElementById('deleteSectionForm').action = actionUrl;
        $('#deleteSectionModal').modal('show');
    }

    document.querySelectorAll('.edit-section-btn').forEach(function (button) {
        button.addEventListener('click', function () {
            const form = document.querySelector('#editSectionModal form');
            form.action = this.dataset.updateUrl;
            document.getElementById('editSectionModal_name').value = this.dataset.name;

            document.querySelectorAll('#editSectionModal .section-image-preview').forEach(function (el) {
                el.remove();
            });

            if (this.dataset.image) {
                const wrapper = document.createElement('div');
                wrapper.className = 'mt-1 section-image-preview';
                wrapper.innerHTML = '<img src="{{ asset('storage') }}/' + this.dataset.image + '" class="img-thumbnail" style="max-height:80px">';
                document.querySelector('#editSectionModal .modal-body').appendChild(wrapper);
            }

            $('#editSectionModal').modal('show');
        });
    });
</script>
@endpush
