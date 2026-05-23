@extends('layouts.master')

@section('title', 'تفاصيل المنتج')

@section('content')
    <main id="content" role="main" class="container py-5">

        <!-- Breadcrumb -->
        <nav aria-label="breadcrumb" class="mb-4">
            <ol class="breadcrumb p-3 rounded">

            </ol>
        </nav>

        <!-- Title and Back Button -->
        <div class="d-flex justify-content-between align-items-center mb-4">
            <a href="{{ route('categories.web.index') }}" class="btn btn-outline-primary">
                <i class="fas fa-arrow-right"></i> رجوع
            </a>
        </div>

        <!-- Product Detail -->
        <div class="row g-5 align-items-start">
            <!-- Product Images Gallery -->
            <div class="col-md-6">
                @php
                    $allImages = collect();
                    if ($product->image) {
                        $allImages->push((object)['path' => $product->image, 'full_path' => asset('storage/' . $product->image)]);
                    }
                    if ($product->images && $product->images->count() > 0) {
                        foreach ($product->images as $img) {
                            if (!$product->image || $img->path !== $product->image) {
                                $allImages->push((object)['path' => $img->path, 'full_path' => asset('storage/' . $img->path)]);
                            }
                        }
                    }
                    // If no images at all, add placeholder
                    if ($allImages->count() == 0) {
                        $allImages->push((object)['path' => 'image.png', 'full_path' => asset('image.png')]);
                    }
                @endphp

                <!-- Product Image Gallery -->
                <div class="product-gallery-wrapper">
                    <!-- Main Image -->
                    <div class="product-main-image-box">
                        <img id="mainProductImage" 
                             src="{{ $allImages->first()->full_path }}" 
                             alt="{{ $product->getTranslatedName() }}"
                             class="product-main-image"
                             onclick="openLightbox(0)"
                             loading="lazy"
                            style="width : 90%">
                        <!--<button type="button" class="product-zoom-button" onclick="openLightbox(0)" title="تكبير">-->
                        <!--    <i class="bi bi-zoom-in"></i>-->
                        <!--</button>-->
                    </div>

                    <!-- Thumbnails Gallery -->
                    @if($allImages->count() > 1)
                        <div class="product-thumbnails-box">
                            @foreach($allImages as $index => $img)
                                <img src="{{ $img->full_path }}" 
                                         alt="صورة {{ $index + 1 }}" 
                                         loading="lazy"
                                         style="width : 40%">
                            @endforeach
                        </div>
                    @endif
                </div>
            </div>

            <!-- Product Info -->
            <div class="col-md-6">
                <div class="bg-white p-4 rounded shadow-sm">
                    <h2 class="mb-3">{{ $product->getTranslatedName() }}</h2>

                    <div class="mb-3 text-muted">
                        <i class="fas fa-barcode me-2"></i>
                        <strong>الرقم التسلسلي:</strong> {{ $product->serial_number }}
                    </div>

                    <div class="mb-3">
                        <span class="badge bg-success fs-5">
                            {{ number_format($product->price, 2) }} <small>ل.س</small>
                        </span>
                    </div>

                    <p class="text-secondary lh-lg">
                        {{ $product->getTranslatedDescription() }}
                    </p>

                    <!-- Actions -->
                    <div class="d-flex flex-wrap gap-3 mt-4">
                        <form method="POST" action="{{ route('cart.add', $product->id) }}" class="w-100">
                            @csrf
                            <button type="submit" class="btn btn-primary btn-lg w-100">
                                <i class="fas fa-shopping-cart me-1"></i> أضف إلى السلة
                            </button>
                        </form>
                    </div>

                    <!-- Back Button -->
                    <div class="mt-4">
                        <a href="{{ route('categories.web.index') }}" class="btn btn-link text-decoration-none">
                            <i class="fas fa-arrow-right"></i> رجوع إلى الفئات
                        </a>
                    </div>
                </div>
            </div>
        </div>

    </main>

    <!-- Lightbox Modal -->
    <!--<div id="lightboxModal" class="lightbox-modal">-->
    <!--    <div class="lightbox-content">-->
    <!--        <button class="lightbox-close" onclick="closeLightbox()" aria-label="إغلاق">&times;</button>-->
    <!--        <button class="lightbox-nav lightbox-prev" onclick="lightboxPrev()" aria-label="السابق">-->
    <!--            <i class="bi bi-chevron-left"></i>-->
    <!--        </button>-->
    <!--        <img id="lightboxImage" class="lightbox-image" src="" alt="">-->
    <!--        <button class="lightbox-nav lightbox-next" onclick="lightboxNext()" aria-label="التالي">-->
    <!--            <i class="bi bi-chevron-right"></i>-->
    <!--        </button>-->
    <!--        <div id="lightboxCounter" class="lightbox-counter">1 / {{ $allImages->count() }}</div>-->
    <!--    </div>-->
    <!--</div>-->

@push('styles')
<style>
    /* Product Gallery - Clean Design */
    .product-gallery-wrapper {
        background: #ffffff;
        border: 1px solid #e0e0e0;
        border-radius: 8px;
        overflow: hidden;
    }

    /* Main Image Box - Fixed Size */
    .product-main-image-box {
        position: relative;
        width: 100%;
        height: 450px;
        max-width: 450px;
        margin: 0 auto;
        background: #ffffff;
        display: flex;
        align-items: center;
        justify-content: center;
        padding: 20px;
        cursor: zoom-in;
        box-sizing: border-box;
    }

    .product-main-image {
        width: 100%;
        height: 100%;
        max-width: 410px;
        max-height: 410px;
        object-fit: contain;
        display: block;
        transition: opacity 0.3s ease;
    }

    /* Zoom Button */
    .product-zoom-button {
        position: absolute;
        bottom: 20px;
        right: 20px;
        width: 40px;
        height: 40px;
        background: rgba(0, 0, 0, 0.65);
        border: none;
        border-radius: 50%;
        color: #ffffff;
        font-size: 18px;
        cursor: pointer;
        display: flex;
        align-items: center;
        justify-content: center;
        opacity: 0;
        transition: all 0.2s ease;
        z-index: 5;
        padding: 0;
    }

    .product-main-image-box:hover .product-zoom-button {
        opacity: 1;
    }

    .product-zoom-button:hover {
        background: rgba(0, 0, 0, 0.85);
        transform: scale(1.1);
    }

    /* Thumbnails Box - Horizontal Scroll */
    .product-thumbnails-box {
        display: flex;
        gap: 10px;
        padding: 15px 20px;
        background: #f8f9fa;
        border-top: 1px solid #e0e0e0;
        overflow-x: auto;
        overflow-y: hidden;
        flex-wrap: nowrap;
        -webkit-overflow-scrolling: touch;
    }

    .product-thumbnails-box::-webkit-scrollbar {
        height: 5px;
    }

    .product-thumbnails-box::-webkit-scrollbar-track {
        background: #f1f1f1;
        border-radius: 3px;
    }

    .product-thumbnails-box::-webkit-scrollbar-thumb {
        background: #c1c1c1;
        border-radius: 3px;
    }

    .product-thumbnails-box::-webkit-scrollbar-thumb:hover {
        background: #a1a1a1;
    }

    /* Thumbnail Button - Fixed Size */
    .product-thumbnail {
        flex: 0 0 70px;
        width: 70px;
        height: 70px;
        min-width: 70px;
        max-width: 70px;
        padding: 0;
        border: 2px solid #e0e0e0;
        border-radius: 6px;
        overflow: hidden;
        cursor: pointer;
        background: #ffffff;
        transition: all 0.2s ease;
        position: relative;
        box-sizing: border-box;
    }

    .product-thumbnail img {
        width: 100%;
        height: 100%;
        object-fit: cover;
        display: block;
        transition: transform 0.2s ease;
    }

    .product-thumbnail:hover {
        border-color: #007bff;
        transform: translateY(-3px);
        box-shadow: 0 4px 10px rgba(0, 123, 255, 0.2);
    }

    .product-thumbnail:hover img {
        transform: scale(1.05);
    }

    .product-thumbnail-active {
        border-color: #007bff !important;
        border-width: 3px !important;
        box-shadow: 0 0 0 2px rgba(0, 123, 255, 0.15) !important;
    }

    .product-thumbnail-active::after {
        content: '';
        position: absolute;
        bottom: 0;
        left: 0;
        right: 0;
        height: 3px;
        background: #007bff;
    }

    /* Lightbox Modal */
    .lightbox-modal {
        display: none;
        position: fixed;
        z-index: 9999;
        left: 0;
        top: 0;
        width: 100%;
        height: 100%;
        background: rgba(0, 0, 0, 0.95);
        animation: fadeIn 0.3s ease;
    }

    .lightbox-modal.active {
        display: flex;
        align-items: center;
        justify-content: center;
    }

    .lightbox-content {
        position: relative;
        max-width: 90%;
        max-height: 90vh;
        text-align: center;
    }

    .lightbox-image {
        max-width: 100%;
        max-height: 90vh;
        object-fit: contain;
    }

    .lightbox-close {
        position: absolute;
        top: 20px;
        right: 20px;
        color: #fff;
        font-size: 32px;
        font-weight: 300;
        cursor: pointer;
        background: rgba(255, 255, 255, 0.1);
        border: none;
        border-radius: 50%;
        width: 40px;
        height: 40px;
        display: flex;
        align-items: center;
        justify-content: center;
        transition: all 0.2s ease;
    }

    .lightbox-close:hover {
        background: rgba(255, 255, 255, 0.2);
    }

    .lightbox-nav {
        position: absolute;
        top: 50%;
        transform: translateY(-50%);
        background: rgba(255, 255, 255, 0.1);
        color: #fff;
        border: none;
        width: 50px;
        height: 50px;
        border-radius: 50%;
        font-size: 20px;
        cursor: pointer;
        transition: all 0.2s ease;
        display: flex;
        align-items: center;
        justify-content: center;
    }

    .lightbox-nav:hover {
        background: rgba(255, 255, 255, 0.2);
    }

    .lightbox-prev {
        left: 20px;
    }

    .lightbox-next {
        right: 20px;
    }

    .lightbox-counter {
        position: absolute;
        bottom: 20px;
        left: 50%;
        transform: translateX(-50%);
        color: #fff;
        font-size: 14px;
        background: rgba(0, 0, 0, 0.5);
        padding: 8px 16px;
        border-radius: 20px;
    }

    @keyframes fadeIn {
        from { opacity: 0; }
        to { opacity: 1; }
    }

    /* Responsive Design */
    @media (max-width: 768px) {
        .product-main-image-box {
            width: 100%;
            max-width: 100%;
            height: 350px;
            padding: 15px;
        }

        .product-main-image {
            max-width: 100%;
            max-height: 320px;
        }

        .product-thumbnail {
            flex: 0 0 60px;
            width: 60px;
            height: 60px;
            min-width: 60px;
            max-width: 60px;
        }

        .product-thumbnails-box {
            padding: 12px 15px;
            gap: 8px;
        }

        .product-zoom-button {
            width: 36px;
            height: 36px;
            font-size: 16px;
            bottom: 15px;
            right: 15px;
        }
    }

    @media (max-width: 576px) {
        .product-main-image-box {
            width: 100%;
            max-width: 100%;
            height: 300px;
            padding: 10px;
        }

        .product-main-image {
            max-width: 100%;
            max-height: 280px;
        }

        .product-thumbnail {
            flex: 0 0 55px;
            width: 55px;
            height: 55px;
            min-width: 55px;
            max-width: 55px;
        }

        .product-thumbnails-box {
            padding: 10px 12px;
            gap: 6px;
        }
    }
</style>
@endpush

@push('scripts')
<script>
    const productImages = @json($allImages->map(function($img) { return $img->full_path; })->values());
    let currentLightboxIndex = 0;

    function changeMainImage(imageSrc, index) {
        const mainImage = document.getElementById('mainProductImage');
        if (mainImage) {
            mainImage.style.opacity = '0';
            setTimeout(() => {
                mainImage.src = imageSrc;
                mainImage.style.opacity = '1';
            }, 150);
        }
        
        // Update active thumbnail
        document.querySelectorAll('.product-thumbnail').forEach((item, i) => {
            if (i === index) {
                item.classList.add('product-thumbnail-active');
            } else {
                item.classList.remove('product-thumbnail-active');
            }
        });
        
        // Scroll thumbnail into view if needed
        const activeThumb = document.querySelector(`[data-image-index="${index}"]`);
        if (activeThumb) {
            activeThumb.scrollIntoView({ behavior: 'smooth', block: 'nearest', inline: 'center' });
        }
        
        // Update lightbox index
        currentLightboxIndex = index;
    }

    document.addEventListener('DOMContentLoaded', function() {
        // Initialize first image
        const mainImage = document.getElementById('mainProductImage');
        if (mainImage) {
            mainImage.style.opacity = '1';
        }
    });

    function openLightbox(index) {
        currentLightboxIndex = index;
        const modal = document.getElementById('lightboxModal');
        if (modal) {
            modal.classList.add('active');
            updateLightboxImage();
            document.body.style.overflow = 'hidden';
        }
    }

    function closeLightbox() {
        const modal = document.getElementById('lightboxModal');
        if (modal) {
            modal.classList.remove('active');
            document.body.style.overflow = '';
        }
    }

    function updateLightboxImage() {
        const img = document.getElementById('lightboxImage');
        const counter = document.getElementById('lightboxCounter');
        if (img && productImages[currentLightboxIndex]) {
            img.src = productImages[currentLightboxIndex];
            img.alt = `صورة ${currentLightboxIndex + 1} من ${productImages.length}`;
        }
        if (counter) {
            counter.textContent = `${currentLightboxIndex + 1} / ${productImages.length}`;
        }
    }

    function lightboxPrev() {
        if (currentLightboxIndex > 0) {
            currentLightboxIndex--;
        } else {
            currentLightboxIndex = productImages.length - 1;
        }
        updateLightboxImage();
    }

    function lightboxNext() {
        if (currentLightboxIndex < productImages.length - 1) {
            currentLightboxIndex++;
        } else {
            currentLightboxIndex = 0;
        }
        updateLightboxImage();
    }

    document.addEventListener('DOMContentLoaded', function() {
        // Update thumbnails when carousel slides
        const carousel = document.getElementById('mainImageCarousel');
        if (carousel) {
            carousel.addEventListener('slid.bs.carousel', function(e) {
                const index = e.to;
                updateActiveThumbnail(index);
            });
        }

        // Keyboard navigation for lightbox
        document.addEventListener('keydown', function(e) {
            const modal = document.getElementById('lightboxModal');
            if (modal && modal.classList.contains('active')) {
                if (e.key === 'Escape') {
                    closeLightbox();
                } else if (e.key === 'ArrowLeft') {
                    lightboxPrev();
                } else if (e.key === 'ArrowRight') {
                    lightboxNext();
                }
            }
        });

        // Close lightbox when clicking outside image
        const modal = document.getElementById('lightboxModal');
        if (modal) {
            modal.addEventListener('click', function(e) {
                if (e.target === modal) {
                    closeLightbox();
                }
            });
        }
    });
</script>
@endpush

@endsection