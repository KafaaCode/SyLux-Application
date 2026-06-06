<header id="header" class="navbar navbar-expand-lg navbar-end navbar-light navbar-show-hide sticky-top"
  data-hs-header-options='{
            "fixMoment": 1000,
            "fixEffect": "slide"
          }'
  style="position: fixed !important; top: 0; left: 0; right: 0; z-index: 1030; background-color: white; box-shadow: 0 2px 4px rgba(0,0,0,0.1);">

  <style>
    /* Language Switcher Styles for Frontend */
    .nav-item.dropdown .dropdown-toggle {
      display: flex;
      align-items: center;
      gap: 0.5rem;
    }

    .nav-item.dropdown .dropdown-menu {
      min-width: 140px;
      border: 1px solid #e9ecef;
      box-shadow: 0 0.5rem 1rem rgba(0, 0, 0, 0.15);
    }

    .nav-item.dropdown .dropdown-item {
      padding: 0.5rem 1rem;
      font-size: 0.875rem;
      transition: all 0.2s ease;
    }

    .nav-item.dropdown .dropdown-item:hover {
      background-color: #f8f9fa;
      color: #0d6efd;
    }

    .nav-item.dropdown .dropdown-item.active {
      background-color: #0d6efd;
      color: white;
    }

    .nav-item.dropdown .dropdown-item.active:hover {
      background-color: #0b5ed7;
    }

    /* Sticky Header Styles */
    body {
      padding-top: 80px !important;
    }

    #header {
      transition: all 0.3s ease;
    }

    #header.navbar-show-hide {
      transform: translateY(0);
    }

    /* Ensure header stays on top */
    .navbar {
      position: fixed !important;
      top: 0 !important;
      left: 0 !important;
      right: 0 !important;
      z-index: 1030 !important;
    }

    /* Smooth scrolling for anchor links */
    html {
      scroll-behavior: smooth;
    }
  </style>

  <script>
    // Sticky header functionality
    document.addEventListener('DOMContentLoaded', function () {
      const header = document.getElementById('header');
      let lastScrollTop = 0;

      window.addEventListener('scroll', function () {
        const scrollTop = window.pageYOffset || document.documentElement.scrollTop;

        // Always show header when scrolling up or at top
        if (scrollTop <= 0 || scrollTop < lastScrollTop) {
          header.style.transform = 'translateY(0)';
        } else {
          // Hide header when scrolling down (optional)
          // header.style.transform = 'translateY(-100%)';
        }

        lastScrollTop = scrollTop;
      });
    });
  </script>
  <!-- Topbar -->
  <div class="container navbar-topbar">
    <nav class="js-mega-menu navbar-nav-wrap">
      <div id="topbarNavDropdown" class="navbar-nav-wrap-collapse collapse navbar-collapse navbar-topbar-collapse">
        <div class="navbar-toggler-wrapper">
          <div class="navbar-topbar-toggler d-flex justify-content-between align-items-center">
            <span class="navbar-toggler-text small">Topbar</span>

            <!-- Toggler -->
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#topbarNavDropdown"
              aria-controls="topbarNavDropdown" aria-expanded="false" aria-label="Toggle navigation">
              <i class="bi-x"></i>
            </button>
            <!-- End Toggler -->
          </div>
        </div>
      </div>
    </nav>
  </div>
  <!-- End Topbar -->

  <div class="container">
    <nav class="js-mega-menu navbar-nav-wrap">
      <!-- Default Logo -->
      <a class="navbar-brand" href="{{ route('home') }}" aria-label="Front">
        <img class="navbar-brand-logo" src="{{ asset('images/init_page.png') }}" alt="Logo">
      </a>
      <!-- End Default Logo -->

      <!-- Toggler -->
      <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNavDropdown"
        aria-controls="navbarNavDropdown" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-default">
          <i class="bi-list"></i>
        </span>
        <span class="navbar-toggler-toggled">
          <i class="bi-x"></i>
        </span>
      </button>
      <!-- End Toggler -->

      <!-- Collapse -->
      <div class="collapse navbar-collapse" id="navbarNavDropdown">
        <div class="navbar-absolute-top-scroller">
          <ul class="navbar-nav">
            <!-- الصفحة الرئيسية -->
            <li class="nav-item">
              <a class="nav-link {{ request()->is('/') ? 'active' : '' }}"
                href="{{ route('home') }}">{{ __('messages.home') }}</a>
            </li>

            <!-- المنتجات -->
            <li class="nav-item">
              <a class="nav-link {{ request()->is('products*') ? 'active' : '' }}"
                href="{{ route('products.web.index') }}">{{ __('messages.products') }}</a>
            </li>

            <!-- الفئات -->
            <li class="nav-item">
              <a class="nav-link {{ request()->is('categories*') ? 'active' : '' }}"
                href="{{ route('categories.web.index') }}">{{ __('messages.categories') }}</a>
            </li>

            <!-- تواصل معنا -->
            <li class="nav-item">
              <a class="nav-link {{ request()->is('contact') ? 'active' : '' }}"
                href="{{ url('/contact') }}">{{ __('messages.contact') }}</a>
            </li>

            <!-- سياسة الخصوصية -->
            <li class="nav-item">
              <a class="nav-link {{ request()->is('privacy') ? 'active' : '' }}"
                href="{{ url('/privacy') }}">{{ __('messages.privacy_policy') }}</a>
            </li>

            <!-- من نحن -->
            <li class="nav-item">
              <a class="nav-link {{ request()->is('about') ? 'active' : '' }}"
                href="{{ url('/about') }}">{{ __('messages.about') }}</a>
            </li>

            <!-- Language Switcher -->
            <li class="nav-item dropdown">
              <a class="nav-link dropdown-toggle" href="#" id="languageDropdown" role="button" data-bs-toggle="dropdown"
                aria-expanded="false" title="{{ __('messages.language') }}">
                <i class="bi bi-translate"></i>
              </a>
              <ul class="dropdown-menu" aria-labelledby="languageDropdown">
                @foreach(config('app.available_locales') as $locale => $name)
                  <li>
                    <a class="dropdown-item {{ $locale === app()->getLocale() ? 'active' : '' }}"
                      href="{{ route('language.switch', $locale) }}">
                      {{ $name }}
                    </a>
                  </li>
                @endforeach
              </ul>
            </li>

            <!-- زر CTA -->

            <!-- زر سلة التسوق -->
            <li class="nav-item">
              <a class="btn btn-outline-primary position-relative" href="{{ route('cart.index') }}"
                title="{{ __('messages.shopping_cart') }}">
                <i class="bi bi-cart"></i>
                @if(session('cart') && count(session('cart')) > 0)
                  <span class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger">
                    {{ count(session('cart')) }}
                  </span>
                @endif
              </a>
            </li>
            <!-- login or dashboard -->
            @if (Auth::check())
              @if (Auth::user()->is_admin)
                <li class="nav-item">
                  <a class="btn btn-primary btn-transition" href="{{ route('admin.index') }}"
                    title="{{ __('messages.dashboard') }}">
                    <i class="bi bi-speedometer2"></i>
                  </a>
                </li>
              @else
                <li class="nav-item">
                  <a class="btn btn-primary btn-transition" href="{{ route('orders.index') }}"
                    title="{{ __('messages.my_orders') }}">
                    <i class="bi bi-clipboard-check"></i>
                  </a>
                </li>
                <li class="nav-item dropdown">
                  <a class="btn btn-primary btn-transition dropdown-toggle" href="#" id="userDropdown" role="button"
                    data-bs-toggle="dropdown" aria-expanded="false">
                    <i class="bi bi-person-circle"></i>
                  </a>
                  <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="userDropdown">
                    @if (auth()->user()->hasRole('Admin'))
                      <li>
                        <a class="dropdown-item" href="{{ route('admin.index') }}">
                          <i class="bi bi-speedometer2 me-2"></i> {{ __('messages.dashboard') }}
                        </a>
                      </li>
                    @endif
                    <li>
                      <a class="dropdown-item" href="#">
                        <i class="bi bi-person me-2"></i> {{ __('messages.profile') }}
                      </a>
                    </li>
                    <li>
                      <hr class="dropdown-divider">
                    </li>
                    <li>
                      <form action="{{ route('logout') }}" method="POST">
                        @csrf
                        <button type="submit" class="dropdown-item">
                          <i class="bi bi-box-arrow-right me-2"></i> {{ __('messages.logout') }}
                        </button>
                      </form>
                    </li>
                  </ul>
                </li>
              @endif
            @else
              <li class="nav-item">
                <a class="btn btn-primary btn-transition" href="{{ route('login') }}" title="{{ __('messages.login') }}">
                  <i class="bi bi-box-arrow-in-right"></i>
                </a>
              </li>
              <li class="nav-item">
                <a class="btn btn-primary btn-transition" href="{{ route('register') }}"
                  title="{{ __('messages.register') }}">
                  <i class="bi bi-person-plus"></i>
                </a>
              </li>
            @endif
          </ul>
        </div>
      </div>
      <!-- End Collapse -->
    </nav>
  </div>
</header>