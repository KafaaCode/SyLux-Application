{{-- resources/views/about.blade.php --}}
@extends('layouts.master')

@section('title', 'من نحن')

@section('content')
    <main id="content" role="main">


        <!-- Card Grid -->
        <div id="category" class="container content-space-2 content-space-lg-3">
            <!-- Heading -->
            <div class="w-md-75 w-lg-50 text-center mx-md-auto mb-5">
                <h2>الفئات</h2>
            </div>
            <!-- End Heading -->

            <div class="overflow-hidden">
                <div class="row gx-lg-7">
                    @foreach($categories as $index => $category)
                        <div class="col-sm-6 col-lg-4 mb-5">
                            <!-- Card -->
                            <a class="card card-flush h-100" href="{{ route('categories.web.show', $category->id) }}"
                                data-aos="fade-up" data-aos-delay="{{ $index * 100 }}">

                                <img class="card-img" src="{{ asset('storage/' . $category->image) }}"
                                    alt="{{ $category->getTranslatedName() }}">

                                <div class="card-body">
                                    <span class="card-subtitle text-body">اكتشف المزيد</span>
                                    <h4 class="card-title text-inherit">{{ $category->getTranslatedName() }}</h4>
                                </div>
                            </a>
                        </div>
                    @endforeach
                </div>
            </div>


        </div>
        <!-- End Card Grid -->
    </main>
@endsection