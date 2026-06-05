@extends('admin.layouts.app')

@section('title', 'الأقسام')

@section('content')
<div class="content-header row">
    <div class="content-header-left col-md-9 col-12 mb-2">
        <h2 class="content-header-title mb-0" style="color: #B79C6D;">الأقسام</h2>
    </div>
</div>

@if(session('success'))
    <div class="alert alert-success">{{ session('success') }}</div>
@endif

<div class="card">
    <div class="card-header d-flex justify-content-between align-items-center">
        <h4 class="mb-0">قائمة الأقسام</h4>
        <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#createModal">
            <i class="fa fa-plus"></i> إضافة قسم
        </button>
    </div>

    <div class="card-body table-responsive">
        <table class="table table-bordered align-middle">
            <thead>
                <tr>
                    <th>#</th>
                    <th>الصورة</th>
                    <th>الاسم</th>
                    <th>عدد الفئات</th>
                    <th>الحالة</th>
                    <th width="200">الإجراءات</th>
                </tr>
            </thead>
            <tbody>
                @forelse($sections as $section)
                    <tr>
                        <td>{{ $section->id }}</td>
                        <td>
                            @if($section->image)
                                <img src="{{ asset('storage/' . $section->image) }}" width="60" class="rounded">
                            @else
                                <span class="text-muted">—</span>
                            @endif
                        </td>
                        <td>{{ $section->name }}</td>
                        <td><span class="badge bg-primary">{{ $section->categories_count }}</span></td>
                        <td>
                            @if($section->active)
                                <span class="badge bg-success">مفعل</span>
                            @else
                                <span class="badge bg-danger">غير مفعل</span>
                            @endif
                        </td>
                        <td>
                            <button class="btn btn-warning btn-sm edit-btn"
                                data-id="{{ $section->id }}"
                                data-name="{{ $section->name }}"
                                data-bs-toggle="modal"
                                data-bs-target="#editModal">
                                تعديل
                            </button>
                            <form action="{{ route('admin.sections.toggle', $section) }}" method="POST" class="d-inline">
                                @csrf
                                @method('PATCH')
                                <button class="btn btn-secondary btn-sm">
                                    {{ $section->active ? 'إلغاء التفعيل' : 'تفعيل' }}
                                </button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="6" class="text-center py-4 text-muted">لا توجد أقسام بعد</td>
                    </tr>
                @endforelse
            </tbody>
        </table>

        {{ $sections->links() }}
    </div>
</div>

<div class="modal fade" id="createModal" tabindex="-1">
    <div class="modal-dialog">
        <form action="{{ route('admin.sections.store') }}" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">إضافة قسم</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <div class="mb-2">
                        <label class="form-label">الاسم</label>
                        <input type="text" name="name" class="form-control" required>
                    </div>
                    <div>
                        <label class="form-label">الصورة</label>
                        <input type="file" name="image" class="form-control">
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">إلغاء</button>
                    <button class="btn btn-primary">حفظ</button>
                </div>
            </div>
        </form>
    </div>
</div>

<div class="modal fade" id="editModal" tabindex="-1">
    <div class="modal-dialog">
        <form id="editForm" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">تعديل قسم</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <div class="mb-2">
                        <label class="form-label">الاسم</label>
                        <input type="text" id="edit_name" name="name" class="form-control" required>
                    </div>
                    <div>
                        <label class="form-label">الصورة</label>
                        <input type="file" name="image" class="form-control">
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">إلغاء</button>
                    <button class="btn btn-warning">تحديث</button>
                </div>
            </div>
        </form>
    </div>
</div>
@endsection

@push('scripts')
<script>
    $('.edit-btn').on('click', function () {
        $('#edit_name').val($(this).data('name'));
        $('#editForm').attr('action', '/admin/sections/' + $(this).data('id'));
    });
</script>
@endpush
