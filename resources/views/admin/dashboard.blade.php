@extends('admin.layouts.app')

@section('content')
    <div class="dashboard-header">
        <h2 class="mb-1">مرحباً بك في لوحة التحكم</h2>
        <p class="mb-0">
            نظرة سريعة على أداء متجر Sylux Belgium
        </p>
    </div>

    <div class="row g-2">

        <div class="col-xl-3 col-md-6">
            <div class="card stat-card">
                <div class="card-body d-flex justify-content-between align-items-center">
                    <div>
                        <span class="text-muted">المستخدمين</span>
                        <h2 class="fw-bold mt-1">{{ $usersCount }}</h2>
                    </div>

                    <div class="stat-icon bg-gold">
                        <i class="fa-solid fa-users"></i>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-xl-3 col-md-6">
            <div class="card stat-card">
                <div class="card-body d-flex justify-content-between align-items-center">
                    <div>
                        <span class="text-muted">الفئات</span>
                        <h2 class="fw-bold mt-1">{{ $categoriesCount }}</h2>
                    </div>

                    <div class="stat-icon bg-green">
                        <i class="fa-solid fa-layer-group"></i>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-xl-3 col-md-6">
            <div class="card stat-card">
                <div class="card-body d-flex justify-content-between align-items-center">
                    <div>
                        <span class="text-muted">المنتجات</span>
                        <h2 class="fw-bold mt-1">{{ $productsCount }}</h2>
                    </div>

                    <div class="stat-icon bg-orange">
                        <i class="fa-solid fa-box-open"></i>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-xl-3 col-md-6">
            <div class="card stat-card">
                <div class="card-body d-flex justify-content-between align-items-center">
                    <div>
                        <span class="text-muted">الطلبات</span>
                        <h2 class="fw-bold mt-1">{{ $ordersCount }}</h2>
                    </div>

                    <div class="stat-icon bg-red">
                        <i class="fa-solid fa-cart-shopping"></i>
                    </div>
                </div>
            </div>
        </div>

    </div>

    <div class="card card-modern mt-3">
        <div class="card-header">
            <h4 class="mb-0">
                الطلبات الشهرية
            </h4>
        </div>

        <div class="card-body">
            <div id="ordersChart"></div>
        </div>
    </div>

    <!-- دعم العملاء -->
    <!-- <div class="row mt-1">
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
    </div> -->

    <!-- الرسوم البيانية -->
    <!-- <div class="row mt-1">
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
    </div> -->

    <!-- أحدث الطلبات والدعم -->
    <!-- <div class="row mt-1">
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
        </div> -->

    <style>
        .dashboard-header {
            background: linear-gradient(135deg, #B79C6D, #d4bc8d);
            border-radius: 20px;
            padding: 30px;
            color: white;
            margin-bottom: 25px;
            box-shadow: 0 15px 35px rgba(183, 156, 109, .25);
        }

        .stat-card {
            border: 0;
            border-radius: 20px;
            overflow: hidden;
            transition: .3s;
            height: 100%;
            box-shadow: 0 10px 30px rgba(0, 0, 0, .06);
        }

        .stat-card:hover {
            transform: translateY(-5px);
        }

        .stat-card .card-body {
            padding: 24px;
        }

        .stat-icon {
            width: 65px;
            height: 65px;
            border-radius: 18px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 24px;
            color: white;
        }

        .bg-gold {
            background: linear-gradient(135deg, #B79C6D, #d4bc8d);
        }

        .bg-green {
            background: linear-gradient(135deg, #28c76f, #48da89);
        }

        .bg-orange {
            background: linear-gradient(135deg, #ff9f43, #ffb976);
        }

        .bg-red {
            background: linear-gradient(135deg, #ea5455, #f08182);
        }

        .bg-blue {
            background: linear-gradient(135deg, #00cfe8, #50dff1);
        }

        .card-modern {
            border: none;
            border-radius: 20px;
            box-shadow: 0 10px 30px rgba(0, 0, 0, .05);
        }

        .card-modern .card-header {
            background: transparent;
            border-bottom: 1px solid #f2f2f2;
            padding: 20px;
        }

        .card-modern .card-body {
            padding: 20px;
        }

        .table-modern thead th {
            border: none;
            background: #f8f8f8;
            font-weight: 700;
        }

        .table-modern td {
            vertical-align: middle;
        }

        .badge-soft {
            background: rgba(183, 156, 109, .15);
            color: #B79C6D;
            padding: 6px 12px;
            border-radius: 50px;
        }
    </style>

@endsection

@push('scripts')
    <script src="https://cdn.jsdelivr.net/npm/apexcharts"></script>
    <script>
        document.addEventListener("DOMContentLoaded", function () {
            var options = {
                chart: {
                    type: 'area',
                    height: 380,
                    toolbar: {
                        show: false
                    }
                },
                stroke: {
                    curve: 'smooth',
                    width: 4
                },
                fill: {
                    type: 'gradient'
                },
                colors: ['#B79C6D'],
                dataLabels: {
                    enabled: false
                }
            };

            var chart = new ApexCharts(document.querySelector("#ordersChart"), options);
            chart.render();
        });
    </script>

@endpush