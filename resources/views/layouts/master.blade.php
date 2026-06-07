<!DOCTYPE html>
<html lang="en" dir="">

<!-- Mirrored from htmlstream.com/preview/front-v4.2/html/landing-classic-corporate.html by HTTrack Website Copier/3.x [XR&CO'2014], Tue, 02 Aug 2022 18:14:25 GMT -->

<head>
    <!-- Required Meta Tags Always Come First -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Title -->
    <title>Frip Tradeing</title>

    <!-- Favicon -->
    <link rel="shortcut icon" href="{{ asset('images/init_page.png') }}">

    <!-- Font -->
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600&amp;display=swap" rel="stylesheet">

    <link rel="stylesheet" href="{{ asset('front/assets/css/vendor.min.css') }}">
    <link rel="stylesheet" href="{{ asset('front/assets/vendor/bootstrap-icons/font/bootstrap-icons.css') }}">
    <link rel="stylesheet" href="{{ asset('front/assets/vendor/aos/dist/aos.css') }}">
    <link rel="stylesheet" href="{{ asset('front/assets/css/theme.minc619.css?v=1.0') }}">


    <!-- إضافة الخط من Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Cairo:wght@400;700&display=swap" rel="stylesheet">

    <style>
        body {
            font-family: 'Cairo', sans-serif;
        }

        h1,
        h2,
        h3,
        h4,
        h5,
        h6 {
            font-weight: 700;
        }

        p,
        span,
        div {
            font-weight: 400;
        }

        .bg-dark {
            --bs-bg-opacity: 1;
            background-color: #347478ff !important;
        }
    </style>

</head>

<body>
    <!-- ========== HEADER ========== -->
    @include('layouts.partials.navbar') <!-- استخراج الـ navbar في ملف منفصل -->
    <!-- ========== END HEADER ========== -->

    <!-- ========== MAIN CONTENT ========== -->
    <main id="content" role="main">
        @yield('content')
    </main>
    <!-- ========== END MAIN CONTENT ========== -->

    <footer class="bg-dark text-white">
        <div class="container py-5">
            <div class="row g-4">
                <!-- Logo & Contact -->
                <div class="col-lg-3">
                    <a class="navbar-brand mb-3 d-block" href="{{ route('home') }}">
                        <img src="{{ asset('images/init_page.png') }}" alt="{{ config('app.name') }}" class="img-fluid">
                    </a>
                    @php
                        $contactAddress = \App\Models\AppSetting::get('contact.address', '153 شارع الصناعة، المدينة الصناعية، سوريا');
                        $contactPhone = \App\Models\AppSetting::get('contact.phone', '+963 11 1234567');
                        $contactEmail = \App\Models\AppSetting::get('contact.email', 'info@syluxbelgium.com');
                    @endphp
                    <p class="small mb-2">
                        <i class="bi-geo-alt-fill me-2"></i> {{ $contactAddress }}
                    </p>
                    <p class="small mb-0">
                        <i class="bi-telephone-inbound-fill me-2"></i> {{ $contactPhone }}
                    </p>
                    <p class="small">
                        <i class="bi-envelope-fill me-2"></i> {{ $contactEmail }}
                    </p>
                </div>

                <!-- Company Info -->
                <div class="col-sm-3">
                    <h5 class="mb-3">{{ __('messages.company') }}</h5>
                    <ul class="list-unstyled">
                        <li><a href="{{ route('about') }}" class="link-light text-decoration-none">{{ __('messages.about_us') }}</a></li>
                        <li><a href="{{ route('products.web.index') }}"
                                class="link-light text-decoration-none">{{ __('messages.products') }}</a></li>
                        <li><a href="{{ route('contact') }}" class="link-light text-decoration-none">{{ __('messages.contact_us') }}</a></li>
                        <li><a href="{{ route('privacy') }}"
                                class="link-light text-decoration-none">{{ __('messages.privacy_policy') }}</a></li>
                        <li><a href="#" class="link-light text-decoration-none">{{ __('messages.terms') }}</a></li>
                    </ul>
                </div>

                <!-- Categories from Database -->
                <div class="col-sm-3">
                    <h5 class="mb-3">{{ __('messages.categories') }}</h5>
                    <ul class="list-unstyled">
                        @php
                            $categories = \App\Models\Category::where('active', true)->get();
                        @endphp
                        @foreach($categories as $category)
                            <li>
                                <a href="{{ route('categories.web.show', $category->id) }}"
                                    class="link-light text-decoration-none">
                                    {{ $category->getTranslatedName() }}
                                </a>
                            </li>
                        @endforeach
                    </ul>
                </div>

                <!-- Social & Newsletter -->
                <div class="col-sm-3">
                    <h5 class="mb-3">{{ __('messages.follow_us') }}</h5>
                    @php($siteSettings = [
                        'facebook_link' => \App\Models\AppSetting::get('social.facebook_link'),
                        'instagram_link' => \App\Models\AppSetting::get('social.instagram_link'),
                        'twitter_link' => \App\Models\AppSetting::get('social.twitter_link'),
                        'linkedin_link' => \App\Models\AppSetting::get('social.linkedin_link'),
                    ])
                    <ul class="list-inline mb-3">
                        @if(!empty($siteSettings['facebook_link']))
                            <li class="list-inline-item"><a href="{{ $siteSettings['facebook_link'] }}" target="_blank"
                                    rel="noopener" class="btn btn-outline-light btn-sm"><i class="bi-facebook"></i></a></li>
                        @endif
                        @if(!empty($siteSettings['instagram_link']))
                            <li class="list-inline-item"><a href="{{ $siteSettings['instagram_link'] }}" target="_blank"
                                    rel="noopener" class="btn btn-outline-light btn-sm"><i class="bi-instagram"></i></a>
                            </li>
                        @endif
                        @if(!empty($siteSettings['twitter_link']))
                            <li class="list-inline-item"><a href="{{ $siteSettings['twitter_link'] }}" target="_blank"
                                    rel="noopener" class="btn btn-outline-light btn-sm"><i class="bi-twitter"></i></a></li>
                        @endif
                        @if(!empty($siteSettings['linkedin_link']))
                            <li class="list-inline-item"><a href="{{ $siteSettings['linkedin_link'] }}" target="_blank"
                                    rel="noopener" class="btn btn-outline-light btn-sm"><i class="bi-linkedin"></i></a></li>
                        @endif
                    </ul>
                    <h6 class="mb-2">{{ __('messages.newsletter') }}</h6>
                    <form class="d-flex" action="#" method="POST">
                        @csrf
                        <input type="email" class="form-control form-control-sm me-2" name="email"
                            placeholder="{{ __('messages.your_email') }}" required>
                        <button type="submit" class="btn btn-warning btn-sm">{{ __('messages.subscribe') }}</button>
                    </form>
                </div>
            </div>

            <hr class="border-light my-4">

            <div class="d-flex flex-column flex-md-row justify-content-between align-items-center">
                <p class="mb-2 mb-md-0 small text-white-50">
                    © {{ now()->year }} {{ config('app.name') }}. {{ __('messages.all_rights_reserved') }}.
                </p>
                <ul class="list-inline mb-0">
                    <li class="list-inline-item"><a href="{{ route('privacy') }}"
                            class="link-light small">{{ __('messages.privacy_policy') }}</a></li>
                    <li class="list-inline-item"><a href="#" class="link-light small">{{ __('messages.terms') }}</a>
                    </li>
                    <li class="list-inline-item"><a href="#"
                            class="link-light small">{{ __('messages.contact_us') }}</a></li>
                </ul>
            </div>
        </div>
    </footer>



    <!-- ========== SECONDARY CONTENTS ========== -->
    <a class="js-go-to go-to position-fixed" href="javascript:;" style="visibility: hidden;" data-hs-go-to-options='{
       "offsetTop": 700,
       "position": {
         "init": { "right": "2rem" },
         "show": { "bottom": "2rem" },
         "hide": { "bottom": "-2rem" }
       }
     }'>
        <i class="bi-chevron-up"></i>
    </a>
    <!-- ========== END SECONDARY CONTENTS ========== -->


    <script src="{{ asset('front/assets/js/vendor.min.js') }}"></script>
    <script src="{{ asset('front/assets/vendor/aos/dist/aos.js') }}"></script>
    <script src="{{ asset('front/assets/js/theme.min.js') }}"></script>


    <!-- JS Plugins Init. -->
    <script>
        (function () {
            // INITIALIZATION OF HEADER
            // =======================================================
            new HSHeader('#header').init()


            // INITIALIZATION OF MEGA MENU
            // =======================================================
            new HSMegaMenu('.js-mega-menu', {
                desktop: {
                    position: 'left'
                }
            })


            // INITIALIZATION OF SHOW ANIMATIONS
            // =======================================================
            new HSShowAnimation('.js-animation-link')


            // INITIALIZATION OF BOOTSTRAP VALIDATION
            // =======================================================
            HSBsValidation.init('.js-validate', {
                onSubmit: data => {
                    data.event.preventDefault()
                    alert('Submited')
                }
            })


            // INITIALIZATION OF BOOTSTRAP DROPDOWN
            // =======================================================
            HSBsDropdown.init()


            // INITIALIZATION OF GO TO
            // =======================================================
            new HSGoTo('.js-go-to')


            // INITIALIZATION OF AOS
            // =======================================================
            AOS.init({
                duration: 650,
                once: true
            });


            // INITIALIZATION OF TEXT ANIMATION (TYPING)
            // =======================================================
            HSCore.components.HSTyped.init('.js-typedjs')


            // INITIALIZATION OF SWIPER
            // =======================================================
            var sliderThumbs = new Swiper('.js-swiper-thumbs', {
                watchSlidesVisibility: true,
                watchSlidesProgress: true,
                history: false,
                breakpoints: {
                    480: {
                        slidesPerView: 2,
                        spaceBetween: 15,
                    },
                    768: {
                        slidesPerView: 3,
                        spaceBetween: 15,
                    },
                    1024: {
                        slidesPerView: 3,
                        spaceBetween: 15,
                    },
                },
                on: {
                    'afterInit': function (swiper) {
                        swiper.el.querySelectorAll('.js-swiper-pagination-progress-body-helper')
                            .forEach($progress => $progress.style.transitionDuration = `${swiper.params.autoplay.delay}ms`)
                    }
                }
            });

            var sliderMain = new Swiper('.js-swiper-main', {
                effect: 'fade',
                autoplay: true,
                loop: true,
                thumbs: {
                    swiper: sliderThumbs
                }
            })
        })()
    </script>
</body>

</html>