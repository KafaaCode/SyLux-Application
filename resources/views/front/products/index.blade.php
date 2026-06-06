@extends('layouts.master')

@section('title', 'المنتجات')

@section('content')
<main id="content" role="main">
    <div class="container content-space-2 content-space-lg-3">
        <!-- Heading -->
        <div class="w-md-75 w-lg-50 text-center mx-md-auto mb-5">
            <h2>{{ __('messages.products') }}</h2>
        </div>
        <!-- End Heading -->

        <div class="row gx-lg-7">
            @foreach($products as $index => $product)
                <div class="col-sm-6 col-lg-4 mb-5">
                    <!-- Card -->
                    <a class="card card-flush h-100" href="{{ route('products.web.show', $product->id) }}" data-aos="fade-up" data-aos-delay="{{ $index * 100 }}">
                        <img class="card-img" src="{{ \App\Support\MediaHelper::productImage($product) }}" alt="{{ $product->getTranslatedName() }}">
                        <div class="card-body">
                            <span class="card-subtitle text-body">اكتشف المزيد</span>
                            <h4 class="card-title text-inherit">{{ $product->getTranslatedName() }}</h4>
                        </div>
                    </a>
                </div>
            @endforeach
        </div>

        @if($products->isEmpty())
            <div class="text-center py-5">
                <h4 class="text-muted">لا توجد منتجات متاحة</h4>
            </div>
        @endif
    </div>
</main>
@endsection
