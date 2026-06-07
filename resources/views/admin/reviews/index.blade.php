@extends('admin.layouts.app')

@section('title', 'إدارة التقييمات')

@section('content')
<div class="content-header row mb-2">
    <div class="col-12">
        <h2 class="content-header-title" style="color: #B79C6D;">إدارة التقييمات</h2>
    </div>
</div>

@if(session('success'))
    <div class="alert alert-success">{{ session('success') }}</div>
@endif

<div class="card mb-3">
    <div class="card-body">
        <form method="GET" class="row g-2 align-items-end">
            <div class="col-md-3">
                <input type="text" name="search" class="form-control" placeholder="بحث..."
                    value="{{ request('search') }}">
            </div>
            <div class="col-md-2">
                <select name="status" class="form-select">
                    <option value="">الحالة</option>
                    <option value="pending" {{ request('status') === 'pending' ? 'selected' : '' }}>معلق</option>
                    <option value="approved" {{ request('status') === 'approved' ? 'selected' : '' }}>مقبول</option>
                    <option value="rejected" {{ request('status') === 'rejected' ? 'selected' : '' }}>مرفوض</option>
                </select>
            </div>
            <div class="col-md-2">
                <select name="rating" class="form-select">
                    <option value="">التقييم</option>
                    @for($i = 1; $i <= 5; $i++)
                        <option value="{{ $i }}" {{ request('rating') == $i ? 'selected' : '' }}>{{ $i }} نجوم</option>
                    @endfor
                </select>
            </div>
            <div class="col-md-2">
                <button type="submit" class="btn btn-primary w-100">تصفية</button>
            </div>
        </form>
    </div>
</div>

<div class="card">
    <div class="card-body table-responsive">
        <table class="table align-middle">
            <thead>
                <tr>
                    <th>#</th>
                    <th>المستخدم</th>
                    <th>المنتج</th>
                    <th>التقييم</th>
                    <th>المراجعة</th>
                    <th>الحالة</th>
                    <th>التاريخ</th>
                    <th>إجراء</th>
                </tr>
            </thead>
            <tbody>
                @forelse($reviews as $review)
                    <tr>
                        <td>{{ ($reviews->currentPage() - 1) * $reviews->perPage() + $loop->iteration }}</td>
                        <td>{{ $review->user->name ?? '-' }}</td>
                        <td>{{ $review->product->name ?? '-' }}</td>
                        <td>
                            <span class="text-warning">
                                @for($i = 1; $i <= 5; $i++)
                                    <i class="fa-solid fa-star{{ $i <= $review->rating ? '' : '-o' }}"></i>
                                @endfor
                            </span>
                        </td>
                        <td>{{ Str::limit($review->review, 50) }}</td>
                        <td>
                            @if($review->status === 'pending')
                                <span class="badge bg-warning">معلق</span>
                            @elseif($review->status === 'approved')
                                <span class="badge bg-success">مقبول</span>
                            @else
                                <span class="badge bg-danger">مرفوض</span>
                            @endif
                        </td>
                        <td>{{ $review->created_at->format('Y-m-d') }}</td>
                        <td>
                            <a href="{{ route('admin.reviews.show', $review->id) }}" class="btn btn-sm btn-info">
                                <i class="fa-solid fa-eye"></i>
                            </a>
                            <form action="{{ route('admin.reviews.destroy', $review->id) }}" method="POST" class="d-inline" onsubmit="return confirm('هل أنت متأكد من الحذف؟');">
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
                        <td colspan="8" class="text-center py-4 text-muted">لا توجد تقييمات</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
        {{ $reviews->links() }}
    </div>
</div>
@endsection
