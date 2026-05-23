@extends('admin.layouts.app')

@section('title', 'إدارة الطلبات')

@section('content')
<div class="container py-4">
    <h4 class="mb-4">جميع الطلبات</h4>
    <div class="card">
        <div class="card-body table-responsive">
            <table class="table align-middle">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>المستخدم</th>
                        <th>تاريخ الطلب</th>
                        <th>الحالة</th>
                        <th>الإجمالي</th>
                        <th>تفاصيل</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($orders as $order)
                    <tr>
                        <td>{{ $order->serial_number ?? $order->id }}</td>
                        <td>{{ $order->user->name ?? '-' }}</td>
                        <td>{{ $order->created_at->format('Y-m-d H:i') }}</td>
                        <td><span class="badge bg-info">{{ $order->status ?? 'جديد' }}</span></td>
                        <td>{{ $order->total_price ?? $order->total_amount }} ل.س</td>
                        <td>
                            <a href="{{ route('admin.orders.show', $order->id) }}" class="btn btn-sm btn-primary">عرض</a>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
            {{ $orders->links() }}
        </div>
    </div>
</div>
@endsection
