@extends('admin.layouts.app')

@section('title', 'تفاصيل رسالة الدعم')

@section('content')
<div class="content-header row mb-2">
    <div class="col-md-8">
        <h2 class="content-header-title" style="color: #B79C6D;">تفاصيل رسالة الدعم</h2>
    </div>
    <div class="col-md-4 text-md-end">
        <a href="{{ route('admin.supports.index') }}" class="btn btn-secondary btn-sm">العودة للقائمة</a>
    </div>
</div>

@if(session('success'))
    <div class="alert alert-success">{{ session('success') }}</div>
@endif

<div class="row">
    <div class="col-lg-8">
        <div class="card mb-3">
            <div class="card-header"><strong>محتوى الرسالة</strong></div>
            <div class="card-body">
                <div class="row">
                    <div class="col-12 mb-3">
                        <strong>العنوان:</strong>
                        <p class="mt-1">{{ $support->title ?? '-' }}</p>
                    </div>
                    <div class="col-12 mb-2">
                        <strong>الرسالة:</strong>
                        <p class="mt-2">{{ $support->message ?? 'لا يوجد محتوى' }}</p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="col-lg-4">
        <div class="card mb-3">
            <div class="card-header"><strong>بيانات المرسل</strong></div>
            <div class="card-body">
                <div class="mb-3">
                    <strong>اسم المرسل:</strong>
                    <div class="mt-1">{{ $support->sender_name ?? '-' }}</div>
                </div>
                <div class="mb-3">
                    <strong>بريد المرسل:</strong>
                    <div class="mt-1">
                        @if($support->sender_email)
                            <a href="mailto:{{ $support->sender_email }}">{{ $support->sender_email }}</a>
                        @else
                            -
                        @endif
                    </div>
                </div>
                <div class="mb-3">
                    <strong>تاريخ الإرسال:</strong>
                    <div class="mt-1">{{ $support->created_at->format('Y-m-d H:i') }}</div>
                </div>
            </div>
        </div>

        <div class="card">
            <div class="card-header"><strong>إجراءات</strong></div>
            <div class="card-body">
                @if($support->sender_email)
                    <a href="mailto:{{ $support->sender_email }}" class="btn btn-primary w-100 mb-2">
                        <i class="fa-solid fa-reply"></i> الرد عبر البريد
                    </a>
                @endif
                <form action="{{ route('admin.supports.destroy', $support->id) }}" method="POST" onsubmit="return confirm('هل أنت متأكد من الحذف؟');">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-danger w-100">
                        <i class="fa-solid fa-trash"></i> حذف الرسالة
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
