@extends('admin.layouts.app')

@section('title', 'تفاصيل التقييم')

@section('content')
<div class="content-header row mb-2">
    <div class="col-md-8">
        <h2 class="content-header-title" style="color: #B79C6D;">تفاصيل التقييم</h2>
    </div>
    <div class="col-md-4 text-md-end">
        <a href="{{ route('admin.reviews.index') }}" class="btn btn-secondary btn-sm">العودة للقائمة</a>
    </div>
</div>

@if(session('success'))
    <div class="alert alert-success">{{ session('success') }}</div>
@endif

<div class="row">
    <div class="col-lg-8">
        <div class="card mb-3">
            <div class="card-header"><strong>معلومات التقييم</strong></div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-6 mb-2"><strong>المستخدم:</strong> {{ $review->user->name ?? '-' }}</div>
                    <div class="col-md-6 mb-2"><strong>المنتج:</strong> {{ $review->product->name ?? '-' }}</div>
                    <div class="col-md-6 mb-2">
                        <strong>التقييم:</strong>
                        <span class="text-warning">
                            @for($i = 1; $i <= 5; $i++)
                                <i class="fa-solid fa-star{{ $i <= $review->rating ? '' : '-o' }}"></i>
                            @endfor
                        </span>
                    </div>
                    <div class="col-md-6 mb-2">
                        <strong>الحالة:</strong>
                        @if($review->status === 'pending')
                            <span class="badge bg-warning">معلق</span>
                        @elseif($review->status === 'approved')
                            <span class="badge bg-success">مقبول</span>
                        @else
                            <span class="badge bg-danger">مرفوض</span>
                        @endif
                    </div>
                    <div class="col-md-6 mb-2"><strong>التاريخ:</strong> {{ $review->created_at->format('Y-m-d H:i') }}</div>
                    <div class="col-12 mb-2">
                        <strong>المراجعة:</strong>
                        <p class="mt-2">{{ $review->review ?? 'لا يوجد نص مراجعة' }}</p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="col-lg-4">
        <div class="card">
            <div class="card-header"><strong>تحديث الحالة</strong></div>
            <div class="card-body">
                <form action="{{ route('admin.reviews.updateStatus', $review->id) }}" method="POST">
                    @csrf
                    <div class="mb-3">
                        <label class="form-label">الحالة</label>
                        <select name="status" class="form-select" required>
                            <option value="pending" {{ $review->status === 'pending' ? 'selected' : '' }}>معلق</option>
                            <option value="approved" {{ $review->status === 'approved' ? 'selected' : '' }}>مقبول</option>
                            <option value="rejected" {{ $review->status === 'rejected' ? 'selected' : '' }}>مرفوض</option>
                        </select>
                    </div>
                    <button type="submit" class="btn btn-success w-100">حفظ التحديث</button>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
