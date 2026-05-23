@extends('layouts.master')

@section('title', 'طلباتي')

@section('content')
<main id="content" role="main" class="container py-5">
    
    
    <div class="card p-4">
        <h5 class="mb-3">قائمة الطلبات</h5>
        @if($orders->isEmpty())
            <div class="text-center text-muted py-5">
                <i class="bi bi-bag fs-1 mb-3"></i>
                <p>لا يوجد طلبات حتى الآن.</p>
            </div>
        @else
            <div class="table-responsive">
                <table class="table align-middle">
                    <thead>
                        <tr>
                            <th>رقم الطلب</th>
                            <th>تاريخ الطلب</th>
                            <th>الحالة</th>
                            <th>الإجمالي</th>
                            <th>المنتجات</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($orders as $order)
                        <tr>
                            <td>{{ $order->serial_number ?? $order->id }}</td>
                            <td>{{ $order->created_at->format('Y-m-d H:i') }}</td>
                            <td><span class="badge bg-info">{{ $order->status ?? 'جديد' }}</span></td>
                            <td>{{ $order->total_price ?? $order->total_amount }} ل.س</td>
                            <td>
                                <ul class="list-unstyled mb-0">
                                    @foreach($order->orderDetails as $detail)
                                        <li>
                                            <span class="fw-bold">{{ $detail->product->name ?? '' }}</span>
                                            <span class="text-muted">x{{ $detail->quantity }}</span>
                                        </li>
                                    @endforeach
                                </ul>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        @endif
    </div>
</main>
@endsection
