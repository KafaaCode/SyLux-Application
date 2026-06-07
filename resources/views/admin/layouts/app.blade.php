<!DOCTYPE html>
<html class="loading" lang="en" data-textdirection="rtl">
<!-- BEGIN: Head-->

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width,initial-scale=1.0,user-scalable=0,minimal-ui">
    <meta name="description"
        content="Vuexy admin is super flexible, powerful, clean &amp; modern responsive bootstrap 4 admin template with unlimited possibilities.">
    <meta name="keywords"
        content="admin template, Vuexy admin template, dashboard template, flat admin template, responsive admin template, web app">
    <meta name="author" content="PIXINVENT">
    <title>SyLux</title>
    <link rel="apple-touch-icon" href="{{asset('logo.png')}}">
    <link rel="shortcut icon" type="image/x-icon" href="{{asset('logo.png')}}">
    <!-- <link href="https://fonts.googleapis.com/css2?family=Montserrat:ital,wght@0,300;0,400;0,500;0,600;1,400;1,500;1,600" rel="stylesheet"> -->

    <link href="https://fonts.googleapis.com/css2?family=Cairo:wght@300;400;600;700&display=swap" rel="stylesheet">


    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css"
        integrity="sha512-Kc323vGBEqzTmouAECnVceyQqyqdsSiqLQISBL29aUW4U/M7pSPA/gEUZQqv1cwx4OnYxTxve5UMg5GT6L4JJg=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />


    <!-- BEGIN: Vendor CSS-->
    <link rel="stylesheet" type="text/css" href="{{ asset('/app-assets/vendors/css/vendors-rtl.min.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('/app-assets/vendors/css/charts/apexcharts.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('/app-assets/vendors/css/extensions/toastr.min.css') }}">
    <!-- END: Vendor CSS-->

    <!-- BEGIN: Theme CSS-->
    <link rel="stylesheet" type="text/css" href="{{ asset('/app-assets/css-rtl/bootstrap.css')}}">
    <link rel="stylesheet" type="text/css" href="{{ asset('/app-assets/css-rtl/bootstrap-extended.css')}}">
    <link rel="stylesheet" type="text/css" href="{{ asset('/app-assets/css-rtl/colors.css')}}">
    <link rel="stylesheet" type="text/css" href="{{ asset('/app-assets/css-rtl/components.css')}}">
    <link rel="stylesheet" type="text/css" href="{{ asset('/app-assets/css-rtl/themes/dark-layout.css')}}">
    <link rel="stylesheet" type="text/css" href="{{ asset('/app-assets/css-rtl/themes/bordered-layout.css')}}">
    <link rel="stylesheet" type="text/css" href="{{ asset('/app-assets/css-rtl/themes/semi-dark-layout.css')}}">

    <!-- BEGIN: Page CSS-->
    <link rel="stylesheet" type="text/css"
        href="{{ asset('/app-assets/css-rtl/core/menu/menu-types/vertical-menu.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('/app-assets/css-rtl/pages/dashboard-ecommerce.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('/app-assets/css-rtl/plugins/charts/chart-apex.css') }}">
    <link rel="stylesheet" type="text/css"
        href="{{ asset('/app-assets/css-rtl/plugins/extensions/ext-component-toastr.css') }}">
    <!-- END: Page CSS-->

    <!-- BEGIN: Custom CSS-->
    <link rel="stylesheet" type="text/css" href="{{ asset('/app-assets/css-rtl/custom-rtl.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('/assets/css/style-rtl.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('/assets/css/admin-fixes.css') }}">
    <!-- END: Custom CSS-->
    <style>
        /* =========================
   Sidebar Modern Design
========================= */

        .navigation-main {
            padding-top: 10px;
        }

        .navigation-main .nav-item {
            margin: 6px 12px;
        }

        .navigation-main .nav-item a {
            display: flex;
            align-items: center;
            border-radius: 14px;
            padding: 13px 16px !important;
            transition: all 0.3s ease;
            font-family: 'Cairo', sans-serif !important;
            font-weight: 600;
            position: relative;
            overflow: hidden;
        }

        .navigation-main .nav-item a i {
            width: 24px;
            text-align: center;
            margin-left: 12px;
            font-size: 17px;
            transition: all .3s ease;
        }

        /* Hover Effect */
        .navigation-main .nav-item a:hover {
            background: rgba(183, 156, 109, 0.12);
            color: #B79C6D !important;
            transform: translateX(-4px);
        }

        .navigation-main .nav-item a:hover i {
            transform: scale(1.15);
            color: #B79C6D;
        }

        /* Active Menu */
        .main-menu.menu-light .navigation>li.active>a {
            background: linear-gradient(135deg,
                    #B79C6D 0%,
                    #D7BF8E 100%) !important;

            color: #fff !important;

            border-radius: 14px;

            box-shadow:
                0 10px 25px rgba(183, 156, 109, 0.35);

            transform: translateX(-3px);
        }

        .main-menu.menu-light .navigation>li.active>a i,
        .main-menu.menu-light .navigation>li.active>a span {
            color: #fff !important;
        }

        /* Active Indicator */
        .main-menu.menu-light .navigation>li.active>a::before {
            content: '';
            position: absolute;
            right: 0;
            top: 15%;
            width: 4px;
            height: 70%;
            background: #fff;
            border-radius: 20px;
        }

        /* Sidebar */
        .main-menu {
            border-left: 1px solid rgba(183, 156, 109, .15);
            box-shadow: 0 0 25px rgba(0, 0, 0, .04);
        }

        /* Logo Area */
        .navbar-header {
            padding-top: 12px;
            padding-bottom: 12px;
        }

        .brand-logo img {
            width: 42px;
            height: 42px;
            border-radius: 12px;
            object-fit: cover;
            box-shadow: 0 6px 15px rgba(183, 156, 109, .25);
        }

        .brand-text {
            font-weight: 700 !important;
            letter-spacing: .5px;
        }

        /* Dark Mode */
        body.dark-layout .navigation-main .nav-item a {
            color: #d0d2d6 !important;
        }

        body.dark-layout .navigation-main .nav-item a:hover {
            background: rgba(183, 156, 109, .15);
            color: #D7BF8E !important;
        }

        body.dark-layout .navigation-main .nav-item a:hover i {
            color: #D7BF8E !important;
        }

        body.dark-layout .main-menu.menu-light .navigation>li.active>a {
            background: linear-gradient(135deg,
                    #B79C6D,
                    #D7BF8E) !important;
        }

        /* Header */
        .header-navbar {
            backdrop-filter: blur(10px);
        }

        /* Scroll Top */
        .scroll-top {
            width: 50px;
            height: 50px;
            border-radius: 50% !important;
            box-shadow: 0 8px 20px rgba(183, 156, 109, .35);
        }

        .scroll-top:hover {
            transform: translateY(-3px);
        }

        /* Footer */
        #mainFooter {
            padding: 15px 20px;
        }

        #mainFooter strong {
            font-weight: 700;
        }

        .navigation-main .nav-item a {
            font-family: 'Cairo', sans-serif !important;
        }

        .main-menu.menu-light .navigation>li.active>a {
            background: -webkit-linear-gradient(208deg, #B79C6D, #B79C6D);
            background: linear-gradient(-118deg, #B79C6D, #B79C6D);
            box-shadow: 0 0 10px 1px #B79C6D;
            color: #FFFFFF;
            font-weight: 400;
            border-radius: 4px;
        }

        body {
            font-family: 'Cairo', sans-serif;
        }

        /* Dark Mode Styles */
        body.dark-layout {
            background-color: #283046 !important;
            color: #b4b7bd !important;
        }

        body.dark-layout .main-menu {
            background-color: #283046 !important;
        }

        body.dark-layout .main-menu .navigation>li>a {
            color: #b4b7bd !important;
        }

        body.dark-layout .main-menu .navigation>li.active>a {
            background: -webkit-linear-gradient(208deg, #B79C6D, #B79C6D);
            background: linear-gradient(-118deg, #B79C6D, #B79C6D);
            box-shadow: 0 0 10px 1px #B79C6D;
            color: #FFFFFF !important;
        }

        body.dark-layout .card {
            background-color: #283046 !important;
            border-color: #404656 !important;
        }

        body.dark-layout .card-header {
            background-color: #283046 !important;
            border-bottom-color: #404656 !important;
        }

        body.dark-layout .card-title {
            color: #b4b7bd !important;
        }

        body.dark-layout .form-control {
            background-color: #404656 !important;
            border-color: #404656 !important;
            color: #b4b7bd !important;
        }

        body.dark-layout .form-control:focus {
            background-color: #404656 !important;
            border-color: #B79C6D !important;
            color: #b4b7bd !important;
        }

        body.dark-layout .table {
            color: #b4b7bd !important;
        }

        body.dark-layout .table th {
            border-color: #404656 !important;
            background-color: #283046 !important;
        }

        body.dark-layout .table td {
            border-color: #404656 !important;
        }

        body.dark-layout .nav-tabs .nav-link {
            color: #b4b7bd !important;
            border-color: #404656 !important;
        }

        body.dark-layout .nav-tabs .nav-link.active {
            background-color: #283046 !important;
            border-color: #404656 #404656 #283046 !important;
            color: #b4b7bd !important;
        }

        body.dark-layout .modal-content {
            background-color: #283046 !important;
            border-color: #404656 !important;
        }

        body.dark-layout .modal-header {
            border-bottom-color: #404656 !important;
        }

        body.dark-layout .modal-footer {
            border-top-color: #404656 !important;
        }

        body.dark-layout .alert {
            background-color: #404656 !important;
            border-color: #404656 !important;
            color: #b4b7bd !important;
        }

        /* Footer Dark Mode */
        body.dark-layout #mainFooter {
            background-color: #283046 !important;
            border-top-color: #404656 !important;
            color: #b4b7bd !important;
        }

        body.dark-layout #mainFooter .text-muted {
            color: #8a8a8a !important;
        }

        /* Light Mode Footer */
        body:not(.dark-layout) #mainFooter {
            background-color: #ffffff !important;
            border-top: 1px solid #e0e0e0 !important;
            color: #333333 !important;
        }

        body:not(.dark-layout) #mainFooter .text-muted {
            color: #6c757d !important;
        }

        /* Dark Mode Toggle Icon */
        .nav-link-style {
            transition: all 0.3s ease;
        }

        .nav-link-style:hover {
            transform: scale(1.1);
        }

        /* Scroll to top button */
        .scroll-top {
            position: fixed;
            bottom: 20px;
            right: 20px;
            z-index: 1000;
            background-color: #B79C6D !important;
            border-color: #B79C6D !important;
        }

        .scroll-top:hover {
            background-color: #5a9ca0 !important;
            border-color: #5a9ca0 !important;
        }
    </style>
</head>
<!-- END: Head-->

<!-- BEGIN: Body-->

<body class="vertical-layout vertical-menu-modern  navbar-floating footer-static  " data-open="click"
    data-menu="vertical-menu-modern" data-col="">

    <!-- BEGIN: Header-->
    <nav
        class="header-navbar navbar navbar-expand-lg align-items-center floating-nav navbar-light navbar-shadow container-xxl">
        <div class="navbar-container d-flex content">
            <div class="bookmark-wrapper d-flex align-items-center">
                <ul class="nav navbar-nav d-xl-none">
                    <li class="nav-item"><a class="nav-link menu-toggle" href="#"><i class="ficon"
                                data-feather="menu"></i></a></li>
                </ul>
                <ul class="nav navbar-nav">
                    <li class="nav-item d-none d-lg-block"><a class="nav-link bookmark-star"></a>
                        <h2 style="font-weight: bold;font-family: 'Cairo', sans-serif;"><img
                                src="{{asset('logo.png')}}" alt="avatar" height="40" width="110"> </h2>
                    </li>
                </ul>
            </div>
            <ul class="nav navbar-nav align-items-center ms-auto">
                <!-- <li class="nav-item d-none d-lg-block">
                    <a class="nav-link nav-link-style" id="darkModeToggle" href="#" onclick="toggleDarkMode()">
                        <i class="ficon" data-feather="moon" id="darkModeIcon"></i>
                    </a>
                </li> -->
                <li class="nav-item dropdown dropdown-user"><a class="nav-link dropdown-toggle dropdown-user-link"
                        id="dropdown-user" href="#" data-bs-toggle="dropdown" aria-haspopup="true"
                        aria-expanded="false">
                        <div class="user-nav d-sm-flex d-none"><span class="user-name fw-bolder"></span><span
                                class="user-status"></span></div><span class="avatar"><img class="round"
                                src="{{asset('logo.png')}}" alt="avatar" height="40" width="40"><span
                                class="avatar-status-online"></span></span>
                    </a>
                    <div class="dropdown-menu dropdown-menu-end" aria-labelledby="dropdown-user">
                        <a class="dropdown-item" href="{{ 'profile.edit' }}"><i class="me-50" data-feather="user"></i>
                            العلومات الشخصية</a>
                        <!-- <a class="dropdown-item" href="auth-login-cover.html"><i class="me-50" data-feather="power"></i> Logout</a> -->
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf

                            <x-responsive-nav-link :href="route('logout')" onclick="event.preventDefault();
                                                this.closest('form').submit();">
                                {{ __('Log Out') }}
                            </x-responsive-nav-link>
                        </form>
                    </div>
                </li>
            </ul>
        </div>
    </nav>
    <ul class="main-search-list-defaultlist-other-list d-none">
        <li class="auto-suggestion justify-content-between"><a
                class="d-flex align-items-center justify-content-between w-100 py-50">
                <div class="d-flex justify-content-start"><span class="me-75"
                        data-feather="alert-circle"></span><span>No results found.</span></div>
            </a></li>
    </ul>
    <!-- END: Header-->


    <!-- BEGIN: Main Menu-->
    <div class="main-menu menu-fixed menu-light menu-accordion menu-shadow" data-scroll-to-active="true">
        <div class="navbar-header">
            <ul class="nav navbar-nav flex-row">
                <li class="nav-item me-auto"><a class="navbar-brand" href="/admin/dashboard">
                        <span class="brand-logo">
                            <img src="{{asset('logo.png')}}" alt="" />
                        </span>
                        <h2 class="brand-text" style="color: #B79C6D;">SyLux</h2>
                    </a></li>
                <li class="nav-item nav-toggle"><a class="nav-link modern-nav-toggle pe-0" data-bs-toggle="collapse"><i
                            class="d-block d-xl-none text-primary toggle-icon font-medium-4" data-feather="x"></i><i
                            class="d-none d-xl-block collapse-toggle-icon font-medium-4  text-primary"
                            data-feather="disc" data-ticon="disc"></i></a></li>
            </ul>
        </div>
        <div class="shadow-bottom"></div>
        <div class="main-menu-content">
            <ul class="navigation navigation-main">
                <li class="nav-item"><a class="d-flex align-items-center" href="{{ route('admin.index') }}">
                        <i class="fa-solid fa-house"></i><span class="menu-title text-truncate">الرئيسية</span></a>
                </li>
                <li class="nav-item"><a class="d-flex align-items-center" href="{{ route('admin.orders.index') }}"><i
                            class="fa-solid fa-cart-shopping"></i><span
                            class="menu-title text-truncate">الطلبات</span></a>
                </li>

                <!-- categories and products -->
                <li class="nav-item"><a class="d-flex align-items-center"
                        href="{{ route('admin.categories.index') }}"><i class="fa-solid fa-layer-group"></i><span
                            class="menu-title text-truncate">الفئات</span></a>
                </li>
                <li class="nav-item"><a class="d-flex align-items-center"
                        href="{{ route('admin.sections.index') }}"><i class="fa-solid fa-layer-group"></i><span
                            class="menu-title text-truncate">الأقسام</span></a>
                </li>
                <li class="nav-item"><a class="d-flex align-items-center" href="{{ route('admin.products.index') }}"><i
                            class="fa-solid fa-box-open"></i><span class="menu-title text-truncate">المنتجات</span></a>
                </li>
                <li class="nav-item"><a class="d-flex align-items-center" href="{{ route('admin.discounts.index') }}"><i
                            class="fa-solid fa-tags"></i><span class="menu-title text-truncate">الخصومات</span></a>
                </li>
                <li class="nav-item"><a class="d-flex align-items-center" href="{{ route('admin.groups.index') }}"><i
                            class="fa-solid fa-object-group"></i><span class="menu-title text-truncate">المجموعات</span></a>
                </li>
                <li class="nav-item"><a class="d-flex align-items-center" href="{{ route('admin.reviews.index') }}"><i
                            class="fa-solid fa-star"></i><span class="menu-title text-truncate">التقييمات</span></a>
                </li>
                <li class="nav-item"><a class="d-flex align-items-center" href="{{ route('admin.supports.index') }}"><i
                            class="fa-solid fa-headset"></i><span class="menu-title text-truncate">الدعم الفني</span></a>
                </li>
                <li class="nav-item"><a class="d-flex align-items-center" href="{{ route('admin.roles.index') }}"><i
                            class="fa-solid fa-shield-halved"></i><span
                            class="menu-title text-truncate">الصلاحيات</span></a>
                </li>
                <li class="nav-item"><a class="d-flex align-items-center"
                        href="{{ route('admin.permissions.index') }}"><i class="fa-solid fa-circle-minus"></i><span
                            class="menu-title text-truncate">الأذونات</span></a>
                </li>
                <li class="nav-item"><a class="d-flex align-items-center" href="{{ route('admin.users.index') }}"><i
                            class="fa-solid fa-users"></i><span class="menu-title text-truncate">المستخدمين</span></a>
                </li>
                <li class="nav-item"><a class="d-flex align-items-center" href="{{ route('admin.settings.edit') }}"><i
                            class="fa-solid fa-gear"></i><span class="menu-title text-truncate">الإعدادات</span></a>
                </li>
            </ul>
        </div>
    </div>
    <!-- END: Main Menu-->

    <!-- BEGIN: Content-->
    <div class="app-content content ">
        <div class="content-overlay"></div>
        <div class="header-navbar-shadow"></div>
        <div class="content-wrapper container-xxl p-0">
            <div class="content-body">
                @yield('content')
            </div>
        </div>
    </div>
    <!-- END: Content-->

    <div class="sidenav-overlay"></div>
    <div class="drag-target"></div>

    <!-- BEGIN: Footer-->
    <footer class="footer footer-static" id="mainFooter">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-6">
                    <p class="mb-0">
                        <strong style="color: #B79C6D;">Frip Trading</strong>
                        <span class="text-muted">- نظام إدارة التغليف</span>
                    </p>
                </div>
                <div class="col-md-6 text-md-end">
                    <p class="mb-0">
                        <span class="text-muted">تم التطوير بواسطة</span>
                        <strong style="color: #B79C6D;">KafaaCode</strong>
                    </p>
                </div>
            </div>
        </div>
    </footer>
    <button class="btn btn-primary btn-icon scroll-top" type="button"><i data-feather="arrow-up"></i></button>
    <!-- END: Footer-->


    <!-- BEGIN: Vendor JS-->
    <script src="{{ asset('/app-assets/vendors/js/vendors.min.js') }}"></script>
    <!-- BEGIN Vendor JS-->

    <!-- BEGIN: Page Vendor JS-->
    <script src="{{ asset('/app-assets/vendors/js/charts/apexcharts.min.js') }}"></script>
    <script src="{{ asset('/app-assets/vendors/js/extensions/toastr.min.js') }}"></script>
    <!-- END: Page Vendor JS-->

    <!-- BEGIN: Theme JS-->
    <script src="{{ asset('/app-assets/js/core/app-menu.js') }}"></script>
    <script src="{{ asset('/app-assets/js/core/app.js') }}"></script>
    <!-- END: Theme JS-->

    <!-- BEGIN: Page JS-->
    <script src="{{ asset('/app-assets/js/scripts/pages/dashboard-ecommerce.js') }}"></script>
    <!-- END: Page JS-->

    <!-- BEGIN: Page Vendor JS-->
    <script src="../../../app-assets/vendors/js/extensions/sweetalert2.all.min.js"></script>
    <script src="../../../app-assets/vendors/js/extensions/polyfill.min.js"></script>
    <!-- END: Page Vendor JS-->

    <!-- BEGIN: Page JS-->
    <script src="../../../app-assets/js/scripts/extensions/ext-component-sweet-alerts.js"></script>
    <!-- END: Page JS-->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <script>
        $(window).on('load', function () {
            if (feather) {
                feather.replace({
                    width: 14,
                    height: 14
                });
            }
        })
    </script>

    <script>
        document.addEventListener("DOMContentLoaded", function () {
            // الحصول على مسار الصفحة الحالي
            var currentPath = window.location.pathname;

            // الحصول على جميع عناصر القائمة
            var menuItems = document.querySelectorAll(".navigation-main .nav-item a");

            menuItems.forEach(function (item) {
                if (item.href.includes(currentPath)) {
                    item.parentElement.classList.add("active");
                }
            });

            // تهيئة الوضع الليلي
            initializeDarkMode();
        });

        // تهيئة الوضع الليلي
        function initializeDarkMode() {
            const isDarkMode = localStorage.getItem('darkMode') === 'true';
            const darkModeIcon = document.getElementById('darkModeIcon');

            if (isDarkMode) {
                document.body.classList.add('dark-layout');
                if (darkModeIcon) {
                    darkModeIcon.setAttribute('data-feather', 'sun');
                }
            } else {
                document.body.classList.remove('dark-layout');
                if (darkModeIcon) {
                    darkModeIcon.setAttribute('data-feather', 'moon');
                }
            }

            // إعادة تهيئة الأيقونات
            if (typeof feather !== 'undefined') {
                feather.replace();
            }
        }

        // تبديل الوضع الليلي
        function toggleDarkMode() {
            const body = document.body;
            const darkModeIcon = document.getElementById('darkModeIcon');
            const isCurrentlyDark = body.classList.contains('dark-layout');

            if (isCurrentlyDark) {
                // تحويل إلى الوضع الفاتح
                body.classList.remove('dark-layout');
                localStorage.setItem('darkMode', 'false');
                if (darkModeIcon) {
                    darkModeIcon.setAttribute('data-feather', 'moon');
                }
            } else {
                // تحويل إلى الوضع الليلي
                body.classList.add('dark-layout');
                localStorage.setItem('darkMode', 'true');
                if (darkModeIcon) {
                    darkModeIcon.setAttribute('data-feather', 'sun');
                }
            }

            // إعادة تهيئة الأيقونات
            if (typeof feather !== 'undefined') {
                feather.replace();
            }
        }

        // إضافة تأثيرات إضافية للوضع الليلي
        function enhanceDarkMode() {
            const isDarkMode = localStorage.getItem('darkMode') === 'true';

            if (isDarkMode) {
                // إضافة تأثيرات إضافية للوضع الليلي
                document.body.style.transition = 'all 0.3s ease';

                // تحديث ألوان العناصر الديناميكية
                const dynamicElements = document.querySelectorAll('.btn-primary, .badge-primary');
                dynamicElements.forEach(element => {
                    element.style.backgroundColor = '#B79C6D';
                    element.style.borderColor = '#B79C6D';
                });
            }
        }

        // تشغيل التحسينات عند تحميل الصفحة
        window.addEventListener('load', function () {
            enhanceDarkMode();
        });
    </script>

    <!-- Admin Fixes JavaScript -->
    <script src="{{ asset('/assets/js/admin-fixes.js') }}"></script>

    @stack('scripts')
</body>
<!-- END: Body-->

</html>