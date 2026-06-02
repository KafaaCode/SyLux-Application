@extends('admin.layouts.app')

@section('content')

    <div class="card">

        ```
        <div class="card-header d-flex justify-content-between align-items-center">

            <h3 class="mb-0">
                الأقسام
            </h3>

            <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#createModal">

                <i class="fa fa-plus"></i>
                إضافة قسم
            </button>

        </div>

        <div class="card-body">

            <table class="table table-bordered align-middle">

                <thead>
                    <tr>
                        <th>#</th>
                        <th>الصورة</th>
                        <th>الاسم</th>
                        <th>الحالة</th>
                        <th width="180">الإجراءات</th>
                    </tr>
                </thead>

                <tbody>

                    @foreach($sections as $section)

                        <tr>

                            <td>{{ $section->id }}</td>

                            <td>
                                @if($section->image)
                                    <img src="{{ asset('storage/' . $section->image) }}" width="60">
                                @endif
                            </td>

                            <td>{{ $section->name }}</td>

                            <td>
                                @if($section->active)
                                    <span class="badge bg-success">
                                        مفعل
                                    </span>
                                @else
                                    <span class="badge bg-danger">
                                        غير مفعل
                                    </span>
                                @endif
                            </td>

                            <td>

                                <button class="btn btn-warning btn-sm edit-btn" data-id="{{ $section->id }}"
                                    data-name="{{ $section->name }}" data-bs-toggle="modal" data-bs-target="#editModal">

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

                    @endforeach

                </tbody>

            </table>

            {{ $sections->links() }}

        </div>
        ```

    </div>

    {{-- Create Modal --}}

    <div class="modal fade" id="createModal">

        ```
        <div class="modal-dialog">

            <form action="{{ route('admin.sections.store') }}" method="POST" enctype="multipart/form-data">

                @csrf

                <div class="modal-content">

                    <div class="modal-header">
                        <h5>إضافة قسم</h5>
                    </div>

                    <div class="modal-body">

                        <div class="mb-1">
                            <label>الاسم</label>

                            <input type="text" name="name" class="form-control" required>
                        </div>

                        <div>
                            <label>الصورة</label>

                            <input type="file" name="image" class="form-control">
                        </div>

                    </div>

                    <div class="modal-footer">

                        <button class="btn btn-primary">
                            حفظ
                        </button>

                    </div>

                </div>

            </form>

        </div>
        ```

    </div>

    {{-- Edit Modal --}}

    <div class="modal fade" id="editModal">

        ```
        <div class="modal-dialog">

            <form id="editForm" method="POST" enctype="multipart/form-data">

                @csrf
                @method('PUT')

                <div class="modal-content">

                    <div class="modal-header">
                        <h5>تعديل قسم</h5>
                    </div>

                    <div class="modal-body">

                        <div class="mb-1">

                            <label>الاسم</label>

                            <input type="text" id="edit_name" name="name" class="form-control">

                        </div>

                        <div>

                            <label>الصورة</label>

                            <input type="file" name="image" class="form-control">

                        </div>

                    </div>

                    <div class="modal-footer">

                        <button class="btn btn-warning">
                            تحديث
                        </button>

                    </div>

                </div>

            </form>

        </div>
        ```

    </div>

@endsection

@push('scripts')

    <script>

        $('.edit-btn').on('click', function () {

            let id = $(this).data('id');
            let name = $(this).data('name');

            $('#edit_name').val(name);

            $('#editForm').attr(
                'action',
                '/admin/sections/' + id
            );

        });

    </script>

@endpush