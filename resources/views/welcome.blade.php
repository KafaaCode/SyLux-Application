@extends('layouts.master')

@section('title', __('messages.home'))

@section('content')
    <!-- Hero -->
    <div class="d-lg-flex position-relative">
      <div class="container d-lg-flex align-items-lg-center content-space-t-3 content-space-lg-0 min-vh-lg-100">
        <div class="w-100">
          <div class="row">
            <div class="col-lg-5" style="direction: rtl">
              <div class="mb-5">
                <h1 class="display-4 mb-3">
                  {{ __('messages.package_products_style') }}

                  <span style="color: #B79C6D" class="text-highlight-warning">
                    <span class="js-typedjs" data-hs-typed-options='{
                    "strings": ["{{ __('messages.elegant') }}", "{{ __('messages.distinctive') }}", "{{ __('messages.professional') }}"],
                    "typeSpeed": 90,
                    "loop": true,
                    "backSpeed": 30,
                    "backDelay": 2500
                  }'></span>
                  </span>
                </h1>

                <p class="lead">{{ __('messages.packaging_solutions_description') }}</p>
              </div>

              <div class="d-grid d-sm-flex gap-3">
                <a class="btn btn-primary btn-transition px-6" href="{{ route('products.web.index') }}">{{ __('messages.browse_products') }}</a>
                <a class="btn btn-outline-primary btn-transition px-6" href="#category">{{ __('messages.categories') }}</a>
              </div>
            </div>
          </div>
        </div>

        <div class="col-lg-7 col-xl-6 d-none d-lg-block position-absolute top-0 end-0 pe-0"
          style="margin-top: 6.75rem;">
          <svg xmlns="http://www.w3.org/2000/svg" x="0px" y="0px" viewBox="0 0 1137.5 979.2">
            <path fill="#F9FBFF" d="M565.5,957.4c81.1-7.4,155.5-49.3,202.4-115.7C840,739.8,857,570,510.7,348.3C-35.5-1.5-4.2,340.3,2.7,389
              c0.7,4.7,1.2,9.5,1.7,14.2l29.3,321c14,154.2,150.6,267.8,304.9,253.8L565.5,957.4z" />
            <defs>
              <path id="mainHeroSVG1"
                d="M1137.5,0H450.4l-278,279.7C22.4,430.6,24.3,675,176.8,823.5l0,0C316.9,960,537.7,968.7,688.2,843.6l449.3-373.4V0z" />
            </defs>
            <clipPath id="mainHeroSVG2">
              <use xlink:href="#mainHeroSVG1" />
            </clipPath>
            <g transform="matrix(1 0 0 1 0 0)" clip-path="url(#mainHeroSVG2)">
              <image width="750" height="750" xlink:href="images/كيس _ ابيض مسمط.png"
                transform="matrix(1.4462 0 0 1.4448 52.8755 0)"></image>
            </g>
          </svg>
        </div>
      </div>
    </div>

    @if(isset($sections) && $sections->isNotEmpty())
    <div id="sections" class="container content-space-2">
      <div class="w-md-75 w-lg-50 text-center mx-md-auto mb-5">
        <h2>{{ __('messages.sections') }}</h2>
      </div>

      <div class="row gx-lg-7">
        @foreach($sections as $index => $section)
          <div class="col-sm-6 col-lg-3 mb-5">
            <a class="card card-flush h-100" href="{{ route('categories.web.index') }}" data-aos="fade-up" data-aos-delay="{{ $index * 100 }}">
              <img class="card-img" src="{{ \App\Support\MediaHelper::sectionImage($section) }}" alt="{{ $section->name }}">
              <div class="card-body text-center">
                <h4 class="card-title text-inherit mb-1">{{ $section->name }}</h4>
                <span class="card-subtitle text-body">{{ $section->categories_count }} {{ __('messages.categories') }}</span>
              </div>
            </a>
          </div>
        @endforeach
      </div>
    </div>
    @endif

    @if(isset($featuredProducts) && $featuredProducts->isNotEmpty())
    <div id="products" class="container content-space-2 content-space-lg-3">
      <div class="w-md-75 w-lg-50 text-center mx-md-auto mb-5">
        <h2>{{ __('messages.featured_products') }}</h2>
      </div>

      <div class="row gx-lg-7">
        @foreach($featuredProducts as $index => $product)
          <div class="col-sm-6 col-lg-3 mb-5">
            <a class="card card-flush h-100" href="{{ route('products.web.show', $product) }}" data-aos="fade-up" data-aos-delay="{{ $index * 100 }}">
              <img class="card-img" src="{{ \App\Support\MediaHelper::productImage($product) }}" alt="{{ $product->getTranslatedName() }}">
              <div class="card-body">
                <span class="card-subtitle text-body">{{ __('messages.discover_more') }}</span>
                <h4 class="card-title text-inherit">{{ $product->getTranslatedName() }}</h4>
              </div>
            </a>
          </div>
        @endforeach
      </div>

      <div class="text-center">
        <a class="btn btn-outline-primary" href="{{ route('products.web.index') }}">{{ __('messages.browse_products') }}</a>
      </div>
    </div>
    @endif

    <div id="category" class="container content-space-2 content-space-lg-3">
      <div class="w-md-75 w-lg-50 text-center mx-md-auto mb-5">
        <h2>{{ __('messages.categories') }}</h2>
      </div>

      @if($categories->isEmpty())
        <div class="text-center py-5">
          <h4 class="text-muted">{{ __('messages.no_categories') }}</h4>
        </div>
      @else
        <div class="overflow-hidden">
          <div class="row gx-lg-7">
            @foreach($categories as $index => $category)
              <div class="col-sm-6 col-lg-4 mb-5">
                <a class="card card-flush h-100" href="{{ route('categories.web.show', $category) }}" data-aos="fade-up" data-aos-delay="{{ $index * 100 }}">
                  <img class="card-img" src="{{ \App\Support\MediaHelper::categoryImage($category) }}" alt="{{ $category->getTranslatedName() }}">
                  <div class="card-body">
                    <span class="card-subtitle text-body">{{ __('messages.discover_more') }}</span>
                    <h4 class="card-title text-inherit">{{ $category->getTranslatedName() }}</h4>
                  </div>
                </a>
              </div>
            @endforeach
          </div>
        </div>

        <div class="text-center">
          <a class="btn btn-outline-primary" href="{{ route('categories.web.index') }}">{{ __('messages.view_all_categories') }}</a>
        </div>
      @endif
    </div>
@endsection
