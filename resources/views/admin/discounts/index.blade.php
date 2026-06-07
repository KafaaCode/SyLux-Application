@extends('admin.layouts.app')

@section('title', 'إدارة الخصومات')

@section('content')
<div class="content-header row mb-2">
    <div class="col-12">
        <h2 class="content-header-title" style="color: #B79C6D;">إدارة الخصومات</h2>
    </div>
</div>

@if(session('success'))
    <div class="alert alert-success">{{ session('success') }}</div>
@endif

<div class="card mb-3">
    <div class="card-body">
        <div class="d-flex justify-content-between align-items-center">
            <form method="GET" class="row g-2 align-items-end flex-fill">
                <div class="col-md-4">
                    <input type="text" name="search" class="form-control" placeholder="بحث..."
                        value="{{ request('search') }}">
                </div>
                <div class="col-md-3">
                    <select name="status" class="form-select">
                        <option value="">الكل</option>
                        <option value="1" {{ request('status') === '1' ? 'selected' : '' }}>نشط</option>
                        <option value="0" {{ request('status') === '0' ? 'selected' : '' }}>غير نشط</option>
                    </select>
                </div>
                <div class="col-md-2">
                    <button type="submit" class="btn btn-primary w-100">تصفية</button>
                </div>
            </form>
            <a href="{{ route('admin.discounts.create') }}" class="btn btn-success ms-2">
                <i class="fa-solid fa-plus"></i> إضافة خصم
            </a>
        </div>
    </div>
</div>

<div class="card">
    <div class="card-body table-responsive">
        <table class="table align-middle">
            <thead>
                <tr>
                    <th>#</th>
                    <th>نسبة الخصم</th>
                    <th>الحالة</th>
                    <th>عام / منتجات محددة</th>
                    <th>تاريخ البدء</th>
                    <th>تاريخ الانتهاء</th>
                    <th>الإجراءات</th>
                </tr>
            </thead>
            <tbody>
                @forelse($discounts as $discount)
                    <tr>
                        <td>{{ ($discounts->currentPage() - 1) * $discounts->perPage() + $loop->iteration }}</td>
                        <td><strong>{{ $discount->discount_percentage }}%</strong></td>
                        <td>
                            @if($discount->active)
                                <span class="badge bg-success">نشط</span>
                            @else
                                <span class="badge bg-danger">غير نشط</span>
                            @endif
                        </td>
                        <td>
                            @if($discount->apply_to_all)
                                <span class="badge bg-info">عام</span>
                            @else
                                <span class="badge bg-warning">{{ $discount->products->count() }} منتج</span>
                            @endif
                        </td>
                        <td>{{ $discount->start_time ? $discount->start_time->format('Y-m-d H:i') : '-' }}</td>
                        <td>{{ $discount->end_time ? $discount->end_time->format('Y-m-d H:i') : '-' }}</td>
                        <td>
                            <a href="{{ route('admin.discounts.edit', $discount->id) }}" class="btn btn-sm btn-warning">
                                <i class="fa-solid fa-edit"></i>
                            </a>
                            <form action="{{ route('admin.discounts.destroy', $discount->id) }}" method="POST" class="d-inline" onsubmit="return confirm('هل أنت متأكد من الحذف؟');">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-sm btn-danger">
                                    <i class="fa-solid fa-trash"></i>
                                </button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="7" class="text-center py-4 text-muted">لا توجد خصومات</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
        {{ $discounts->links() }}
    </div>
</div>
@endsection
