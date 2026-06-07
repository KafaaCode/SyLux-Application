@extends('admin.layouts.app')

@section('title', 'إضافة مجموعة جديدة')

@section('content')
<div class="content-header row mb-2">
    <div class="col-12">
        <h2 class="content-header-title" style="color: #B79C6D;">إضافة مجموعة جديدة</h2>
    </div>
</div>

<div class="card">
    <div class="card-body">
        <form action="{{ route('admin.groups.store') }}" method="POST">
            @csrf
            <div class="row">
                <div class="col-md-6 mb-3">
                    <label class="form-label">اسم المجموعة</label>
                    <input type="text" name="name" class="form-control" required>
                </div>
                <div class="col-md-6 mb-3">
                    <label class="form-label">الحالة</label>
                    <select name="active" class="form-select">
                        <option value="1">نشط</option>
                        <option value="0">غير نشط</option>
                    </select>
                </div>
                <div class="col-md-12 mb-3">
                    <label class="form-label">المنتجات</label>
                    <select name="products[]" class="form-select" multiple size="8">
                        @foreach($products as $id => $name)
                            <option value="{{ $id }}">{{ $name }}</option>
                        @endforeach
                    </select>
                    <small class="text-muted">يمكن اختيار عدة منتجات (Ctrl+Click)</small>
                </div>
            </div>
            <div class="text-end">
                <a href="{{ route('admin.groups.index') }}" class="btn btn-secondary">إلغاء</a>
                <button type="submit" class="btn btn-primary">حفظ</button>
            </div>
        </form>
    </div>
</div>
@endsection
