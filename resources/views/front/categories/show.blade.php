@extends('layouts.master')

@section('title', 'المنتجات')

@section('content')
    <main id="content" role="main" class="container py-5">

        <!-- Breadcrumb -->
        <nav aria-label="breadcrumb" class="mb-4">
            <ol class="breadcrumb p-3 rounded">

            </ol>
        </nav>

        <!-- Title and Back Button -->
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h3 class="mb-0">المنتجات تحت فئة: {{ $category->getTranslatedName() }}</h3>
            <a href="{{ route('categories.web.index') }}" class="btn btn-outline-primary">
                <i class="fas fa-arrow-right"></i> رجوع
            </a>
        </div>

        @if($products->isEmpty())
            <!-- No Products Message -->
            <div class="text-center py-5">
                <img src="{{ asset('logo.png') }}" alt="لا يوجد منتجات" class="mb-2" style="max-width: 300px;">
                <h4 class="text-muted">عذرًا، لا توجد منتجات متاحة حاليًا في هذه الفئة.</h4>
            </div>
        @else
            <!-- Products Grid -->
            <div class="row row-cols-1 row-cols-sm-2 row-cols-lg-3 g-4">
                @foreach($products as $index => $product)
                    <div class="col-sm-6 col-lg-4 mb-5">
                        <!-- Card -->
                        <a class="card card-flush h-100" href="{{ route('products.web.show',$product->id) }}" data-aos="fade-up" data-aos-delay="{{ $index * 100 }}">
                            <img class="card-img" src="{{ \App\Support\MediaHelper::productImage($product) }}" alt="{{ $product->getTranslatedName() }}">
                            <div class="card-body">
                                <span class="card-subtitle text-body">اكتشف المزيد</span>
                                <h4 class="card-title text-inherit">{{ $product->getTranslatedName() }}</h4>
                            </div>
                        </a>
                    </div>
                @endforeach
            </div>
        @endif

    </main>
@endsection