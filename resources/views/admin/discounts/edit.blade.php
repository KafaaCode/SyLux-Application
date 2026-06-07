@extends('admin.layouts.app')

@section('title', 'تعديل الخصم')

@section('content')
<div class="content-header row mb-2">
    <div class="col-12">
        <h2 class="content-header-title" style="color: #B79C6D;">تعديل الخصم</h2>
    </div>
</div>

<div class="card">
    <div class="card-body">
        <form action="{{ route('admin.discounts.update', $discount->id) }}" method="POST">
            @csrf
            @method('PUT')
            <div class="row">
                <div class="col-md-6 mb-3">
                    <label class="form-label">نسبة الخصم (%)</label>
                    <input type="number" step="0.01" min="0" max="100" name="discount_percentage" class="form-control" value="{{ $discount->discount_percentage }}" required>
                </div>
                <div class="col-md-6 mb-3">
                    <label class="form-label">الحالة</label>
                    <select name="active" class="form-select">
                        <option value="1" {{ $discount->active ? 'selected' : '' }}>نشط</option>
                        <option value="0" {{ !$discount->active ? 'selected' : '' }}>غير نشط</option>
                    </select>
                </div>
                <div class="col-md-6 mb-3">
                    <label class="form-label">تاريخ البدء</label>
                    <input type="datetime-local" name="start_time" class="form-control" value="{{ $discount->start_time ? $discount->start_time->format('Y-m-d\TH:i') : '' }}">
                </div>
                <div class="col-md-6 mb-3">
                    <label class="form-label">تاريخ الانتهاء</label>
                    <input type="datetime-local" name="end_time" class="form-control" value="{{ $discount->end_time ? $discount->end_time->format('Y-m-d\TH:i') : '' }}">
                </div>
                <div class="col-md-12 mb-3">
                    <div class="form-check">
                        <input class="form-check-input" type="checkbox" name="apply_to_all" id="apply_to_all" value="1" {{ $discount->apply_to_all ? 'checked' : '' }}>
                        <label class="form-check-label" for="apply_to_all">تطبيق على جميع المنتجات</label>
                    </div>
                </div>
                <div class="col-md-12 mb-3" id="products_container" style="{{ $discount->apply_to_all ? 'display:none' : '' }}">
                    <label class="form-label">المنتجات المشمولة</label>
                    <select name="products[]" class="form-select" multiple size="8">
                        @foreach($products as $id => $name)
                            <option value="{{ $id }}" {{ in_array($id, $selectedProducts) ? 'selected' : '' }}>{{ $name }}</option>
                        @endforeach
                    </select>
                    <small class="text-muted">يمكن اختيار عدة منتجات (Ctrl+Click)</small>
                </div>
            </div>
            <div class="text-end">
                <a href="{{ route('admin.discounts.index') }}" class="btn btn-secondary">إلغاء</a>
                <button type="submit" class="btn btn-primary">تحديث</button>
            </div>
        </form>
    </div>
</div>

@push('scripts')
<script>
    document.getElementById('apply_to_all').addEventListener('change', function() {
        document.getElementById('products_container').style.display = this.checked ? 'none' : 'block';
    });
</script>
@endpush
@endsection
