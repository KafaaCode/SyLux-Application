@extends('admin.layouts.app')

@section('title', 'تفاصيل الطلب')

@section('content')
<div class="content-header row mb-2">
    <div class="col-md-8">
        <h2 class="content-header-title" style="color: #B79C6D;">
            طلب {{ $order->serial_number ?? $order->id }}
        </h2>
    </div>
    <div class="col-md-4 text-md-end">
        <a href="{{ route('admin.orders.index') }}" class="btn btn-secondary btn-sm">العودة للقائمة</a>
    </div>
</div>

@if(session('success'))
    <div class="alert alert-success">{{ session('success') }}</div>
@endif

<div class="row">
    <div class="col-lg-8">
        <div class="card mb-3">
            <div class="card-header"><strong>معلومات الطلب</strong></div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-6 mb-2"><strong>العميل:</strong> {{ $order->user->name ?? '-' }}</div>
                    <div class="col-md-6 mb-2"><strong>البريد:</strong> {{ $order->user->email ?? '-' }}</div>
                    <div class="col-md-6 mb-2"><strong>الشركة:</strong> {{ $order->user->companyName ?? '-' }}</div>
                    <div class="col-md-6 mb-2"><strong>تاريخ الطلب:</strong> {{ $order->created_at->format('Y-m-d H:i') }}</div>
                    <div class="col-md-6 mb-2">
                        <strong>الحالة:</strong>
                        <span class="badge {{ \App\Support\OrderStatus::badgeClass($order->status) }}">
                            {{ \App\Support\OrderStatus::label($order->status) }}
                        </span>
                    </div>
                    <div class="col-md-6 mb-2"><strong>الإجمالي:</strong> {{ number_format($order->total_price ?? $order->total_amount, 0) }} ل.س</div>
                    @if($order->delivery_time)
                        <div class="col-md-6 mb-2"><strong>موعد التسليم:</strong> {{ $order->delivery_time }}</div>
                    @endif
                </div>
            </div>
        </div>

        <div class="card mb-3">
            <div class="card-header"><strong>المنتجات</strong></div>
            <div class="card-body table-responsive">
                <table class="table">
                    <thead>
                        <tr>
                            <th>المنتج</th>
                            <th>السعر</th>
                            <th>الكمية</th>
                            <th>المجموع</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($order->orderDetails as $detail)
                            @php $lineTotal = ($detail->product->price ?? 0) * $detail->quantity; @endphp
                            <tr>
                                <td>{{ $detail->product->name ?? 'منتج محذوف' }}</td>
                                <td>{{ number_format($detail->product->price ?? 0, 0) }} ل.س</td>
                                <td>{{ $detail->quantity }}</td>
                                <td>{{ number_format($lineTotal, 0) }} ل.س</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <div class="col-lg-4">
        <div class="card">
            <div class="card-header"><strong>تحديث الطلب</strong></div>
            <div class="card-body">
                <form action="{{ route('admin.orders.updateStatus', $order->id) }}" method="POST">
                    @csrf
                    <div class="mb-3">
                        <label class="form-label">الحالة</label>
                        <select name="status" class="form-select" required>
                            @foreach($statuses as $value => $label)
                                <option value="{{ $value }}" {{ \App\Support\OrderStatus::normalize($order->status) === $value ? 'selected' : '' }}>
                                    {{ $label }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">ملاحظة / رد للعميل</label>
                        <textarea name="reply_message" class="form-control" rows="4">{{ old('reply_message', $order->reply_message) }}</textarea>
                    </div>
                    <button type="submit" class="btn btn-success w-100">حفظ التحديث</button>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
