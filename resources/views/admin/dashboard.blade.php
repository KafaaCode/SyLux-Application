@extends('admin.layouts.app')

@section('content')
    <div class="row">
        <!-- المستخدمين -->
        <div class="col-xl-3 col-md-6 col-12">
            <div class="card text-white" style=" background-color: #70B9BE;">
                <div class="card-body d-flex justify-content-between align-items-center">
                    <div>
                        <h3>{{ $usersCount }}</h3>
                        <p>المستخدمين</p>
                    </div>
                    <i class="fa-solid fa-users fa-2x"></i>
                </div>
            </div>
        </div>
        <!-- الفئات -->
        <div class="col-xl-3 col-md-6 col-12">
            <div class="card bg-success text-white">
                <div class="card-body d-flex justify-content-between align-items-center">
                    <div>
                        <h3>{{ $categoriesCount }}</h3>
                        <p>الفئات</p>
                    </div>
                    <i class="fa-solid fa-list fa-2x"></i>
                </div>
            </div>
        </div>
        <!-- المنتجات -->
        <div class="col-xl-3 col-md-6 col-12">
            <div class="card bg-warning text-white">
                <div class="card-body d-flex justify-content-between align-items-center">
                    <div>
                        <h3>{{ $productsCount }}</h3>
                        <p>المنتجات</p>
                    </div>
                    <i class="fa-solid fa-box fa-2x"></i>
                </div>
            </div>
        </div>
        <!-- الطلبات -->
        <div class="col-xl-3 col-md-6 col-12">
            <div class="card bg-danger text-white">
                <div class="card-body d-flex justify-content-between align-items-center">
                    <div>
                        <h3>{{ $ordersCount }}</h3>
                        <p>الطلبات</p>
                    </div>
                    <i class="fa-solid fa-bag-shopping fa-2x"></i>
                </div>
            </div>
        </div>
    </div>

    <!-- دعم العملاء -->
    <div class="row mt-1">
        <div class="col-xl-3 col-md-6 col-12">
            <div class="card bg-info text-white">
                <div class="card-body d-flex justify-content-between align-items-center">
                    <div>
                        <h3>{{ $supportsCount }}</h3>
                        <p>طلبات الدعم</p>
                    </div>
                    <i class="fa-solid fa-headset fa-2x"></i>
                </div>
            </div>
        </div>
    </div>

    <!-- الرسوم البيانية -->
    <div class="row mt-1">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h4>الطلبات الشهرية</h4>
                </div>
                <div class="card-body">
                    <div id="ordersChart"></div>
                </div>
            </div>
        </div>
    </div>

    <!-- أحدث الطلبات والدعم -->
    <div class="row mt-1">
        <div class="col-md-6">
            <div class="card">
                <div class="card-header">
                    <h4>أحدث الطلبات</h4>
                </div>
                <div class="card-body">
                    <table class="table table-striped">
                        <thead>
                            <tr>
                                <th>رقم الطلب</th>
                                <th>المستخدم</th>
                                <th>المبلغ</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($latestOrders as $order)
                                <tr>
                                    <td>{{ $order->serial_number }}</td>
                                    <td>{{ $order->user->name ?? '-' }}</td>
                                    <td>{{ $order->total_amount }} $</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <div class="col-md-6">
            <div class="card">
                <div class="card-header">
                    <h4>أحدث طلبات الدعم</h4>
                </div>
                <div class="card-body">
                    <table class="table table-striped">
                        <thead>
                            <tr>
                                <th>المرسل</th>
                                <th>العنوان</th>
                                <th>البريد الإلكتروني</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($latestSupports as $support)
                                <tr>
                                    <td>{{ $support->sender_name }}</td>
                                    <td>{{ $support->title }}</td>
                                    <td>{{ $support->sender_email }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

@endsection

@push('scripts')
    <script src="https://cdn.jsdelivr.net/npm/apexcharts"></script>
    <script>
        document.addEventListener("DOMContentLoaded", function () {
            var options = {
                chart: {
                    type: 'bar',
                    height: 350
                },
                series: [{
                    name: 'عدد الطلبات',
                    data: @json($monthlyOrders->values())
                }],
                xaxis: {
                    categories: @json($monthlyOrders->keys()->map(fn($m) => 'شهر ' . $m))
                },
                colors: ['#70B9BE']
            };

            var chart = new ApexCharts(document.querySelector("#ordersChart"), options);
            chart.render();
        });
    </script>

@endpush