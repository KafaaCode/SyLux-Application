@extends('admin.layouts.app')

@section('title', 'تفاصيل الطلب')

@section('content')
<div class="container py-4">
    <h4 class="mb-4">تفاصيل الطلب رقم {{ $order->serial_number ?? $order->id }}</h4>
    <div class="card mb-3">
        <div class="card-body">
            <p><strong>المستخدم:</strong> {{ $order->user->name ?? '-' }}</p>
            <p><strong>تاريخ الطلب:</strong> {{ $order->created_at->format('Y-m-d H:i') }}</p>
            <p><strong>الحالة الحالية:</strong> <span class="badge bg-info">{{ $order->status ?? 'جديد' }}</span></p>
            <p><strong>الإجمالي:</strong> {{ $order->total_price ?? $order->total_amount }} ل.س</p>
        </div>
    </div>
    <div class="card mb-3">
        <div class="card-header">المنتجات</div>
        <div class="card-body">
            <ul>
                @foreach($order->orderDetails as $detail)
                    <li>
                        {{ $detail->product->name ?? '' }} - الكمية: {{ $detail->quantity }}
                    </li>
                @endforeach
            </ul>
        </div>
    </div>
    <form action="{{ route('admin.orders.updateStatus', $order->id) }}" method="POST" class="d-flex gap-2">
        @csrf
        <select name="status" class="form-select w-auto">
            <option value="جديد" {{ $order->status == 'جديد' ? 'selected' : '' }}>جديد</option>
            <option value="مقبول" {{ $order->status == 'مقبول' ? 'selected' : '' }}>مقبول</option>
            <option value="مرفوض" {{ $order->status == 'مرفوض' ? 'selected' : '' }}>مرفوض</option>
        </select>
        <button type="submit" class="btn btn-success">تحديث الحالة</button>
    </form>
</div>
@endsection
