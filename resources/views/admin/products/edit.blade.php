@extends('admin.layouts.app')

@section('content')
<div class="content-header row">
    <div class="content-header-left col-md-9 col-12 mb-2">
        <div class="row breadcrumbs-top">
            <div class="col-12">
                <h2 class="content-header-title float-left mb-0" style="color: #70B9BE; font-weight: bold;">تعديل المنتج</h2>
                <div class="breadcrumb-wrapper col-12">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{ route('admin.index') }}">الرئيسية</a></li>
                        <li class="breadcrumb-item"><a href="{{ route('admin.products.index') }}">المنتجات</a></li>
                        <li class="breadcrumb-item active">تعديل المنتج</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>
    <div class="content-header-right text-md-right col-md-3 col-12 d-md-block d-none">
        <div class="form-group breadcrumb-right">
            <a href="{{ route('admin.products.index') }}" class="btn btn-secondary">
                <i class="fa-solid fa-arrow-right"></i> العودة للقائمة
            </a>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-header">
                <h4 class="card-title">
                    <i class="fa-solid fa-edit text-warning"></i>
                    تعديل بيانات المنتج: {{ $product->name }}
                </h4>
            </div>
            <div class="card-body">
                <form action="{{ route('admin.products.update', $product->id) }}" method="POST" enctype="multipart/form-data" id="productForm">
                    @csrf
                    @method('PATCH')
                    
                    <!-- Validation Errors -->
                    @if ($errors->any())
                        <div class="alert alert-danger">
                            <h6 class="alert-heading">
                                <i class="fa-solid fa-exclamation-triangle"></i>
                                يرجى تصحيح الأخطاء التالية:
                            </h6>
                            <ul class="mb-0">
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <!-- Success Message -->
                    @if (session('success'))
                        <div class="alert alert-success">
                            <i class="fa-solid fa-check-circle"></i>
                            {{ session('success') }}
                        </div>
                    @endif

                    <div class="row">
                        <!-- Basic Information -->
                        <div class="col-lg-8">
                            <div class="card">
                                <div class="card-header">
                                    <h5 class="card-title">
                                        <i class="fa-solid fa-info-circle text-info"></i>
                                        المعلومات الأساسية
                                    </h5>
                                </div>
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="name" class="form-label">
                                                    اسم المنتج <span class="text-danger">*</span>
                                                </label>
                                                <input type="text" 
                                                       id="name" 
                                                       name="name" 
                                                       class="form-control @error('name') is-invalid @enderror"
                                                       placeholder="أدخل اسم المنتج"
                                                       value="{{ old('name', $product->name) }}"
                                                       required>
                                                @error('name')
                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                            </div>
                                        </div>
                                        
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="category_id" class="form-label">
                                                    الفئة <span class="text-danger">*</span>
                                                </label>
                                                <select id="category_id" 
                                                        name="category_id" 
                                                        class="form-control @error('category_id') is-invalid @enderror"
                                                        required>
                                                    <option value="">اختر الفئة</option>
                                                    @foreach ($categories as $id => $name)
                                                        <option value="{{ $id }}" {{ old('category_id', $product->category_id) == $id ? 'selected' : '' }}>
                                                            {{ $name }}
                                                        </option>
                                                    @endforeach
                                                </select>
                                                @error('category_id')
                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                            </div>
                                        </div>
                                        
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="serial_number" class="form-label">الرقم التسلسلي</label>
                                                <input type="text" 
                                                       id="serial_number" 
                                                       name="serial_number" 
                                                       class="form-control @error('serial_number') is-invalid @enderror"
                                                       placeholder="أدخل الرقم التسلسلي"
                                                       value="{{ old('serial_number', $product->serial_number) }}">
                                                @error('serial_number')
                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                            </div>
                                        </div>
                                        
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="request_number" class="form-label">رقم الطلب</label>
                                                <input type="text" 
                                                       id="request_number" 
                                                       name="request_number" 
                                                       class="form-control @error('request_number') is-invalid @enderror"
                                                       placeholder="أدخل رقم الطلب"
                                                       value="{{ old('request_number', $product->request_number) }}">
                                                @error('request_number')
                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                            </div>
                                        </div>
                                        
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="price" class="form-label">
                                                    السعر <span class="text-danger">*</span>
                                                </label>
                                                <div class="input-group">
                                                    <input type="number" 
                                                           step="0.01" 
                                                           id="price" 
                                                           name="price" 
                                                           class="form-control @error('price') is-invalid @enderror"
                                                           placeholder="0.00"
                                                           value="{{ old('price', $product->price) }}"
                                                           required>
                                                    <div class="input-group-append">
                                                        <span class="input-group-text">ريال</span>
                                                    </div>
                                                </div>
                                                @error('price')
                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                            </div>
                                        </div>
                                        
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="active" class="form-label">الحالة</label>
                                                <select id="active" 
                                                        name="active" 
                                                        class="form-control @error('active') is-invalid @enderror">
                                                    <option value="1" {{ old('active', $product->active) == 1 ? 'selected' : '' }}>نشط</option>
                                                    <option value="0" {{ old('active', $product->active) == 0 ? 'selected' : '' }}>غير نشط</option>
                                                </select>
                                                @error('active')
                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                            </div>
                                        </div>
                                        
                                        <div class="col-12">
                                            <div class="form-group">
                                                <label for="description" class="form-label">الوصف</label>
                                                <textarea id="description" 
                                                          name="description" 
                                                          class="form-control @error('description') is-invalid @enderror"
                                                          rows="4"
                                                          placeholder="أدخل وصف المنتج">{{ old('description', $product->description) }}</textarea>
                                                @error('description')
                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            
                            <!-- Translations Section -->
                            <div class="card mt-4">
                                <div class="card-header">
                                    <h5 class="card-title">
                                        <i class="fa-solid fa-language text-primary"></i>
                                        الترجمات
                                    </h5>
                                </div>
                                <div class="card-body">
                                    <div class="nav-tabs-custom">
                                        <ul class="nav nav-tabs" id="translationTabs" role="tablist">
                                            @foreach(config('app.available_locales') as $locale => $name)
                                                <li class="nav-item" role="presentation">
                                                    <a class="nav-link {{ $loop->first ? 'active' : '' }}" 
                                                       id="{{ $locale }}-tab" 
                                                       data-toggle="tab" 
                                                       href="#{{ $locale }}" 
                                                       role="tab" 
                                                       aria-controls="{{ $locale }}" 
                                                       aria-selected="{{ $loop->first ? 'true' : 'false' }}"
                                                       onclick="switchTab('{{ $locale }}')">
                                                        {{ $name }}
                                                    </a>
                                                </li>
                                            @endforeach
                                        </ul>
                                        
                                        <div class="tab-content" id="translationTabsContent">
                                            @foreach(config('app.available_locales') as $locale => $name)
                                                @php
                                                    $translation = $product->translations()->where('locale', $locale)->first();
                                                @endphp
                                                <div class="tab-pane fade {{ $loop->first ? 'show active' : '' }}" 
                                                     id="{{ $locale }}" 
                                                     role="tabpanel" 
                                                     aria-labelledby="{{ $locale }}-tab"
                                                     style="display: {{ $loop->first ? 'block' : 'none' }};">
                                                    <div class="row mt-3">
                                                        <div class="col-md-6">
                                                            <div class="form-group">
                                                                <label for="name_translated_{{ $locale }}" class="form-label">
                                                                    اسم المنتج ({{ $name }})
                                                                </label>
                                                                <input type="text" 
                                                                       id="name_translated_{{ $locale }}" 
                                                                       name="translations[{{ $locale }}][name_translated]" 
                                                                       class="form-control"
                                                                       placeholder="أدخل اسم المنتج بـ {{ $name }}"
                                                                       value="{{ old('translations.' . $locale . '.name_translated', $translation->name_translated ?? '') }}">
                                                            </div>
                                                        </div>
                                                        <div class="col-md-6">
                                                            <div class="form-group">
                                                                <label for="description_translated_{{ $locale }}" class="form-label">
                                                                    وصف المنتج ({{ $name }})
                                                                </label>
                                                                <textarea id="description_translated_{{ $locale }}" 
                                                                          name="translations[{{ $locale }}][description_translated]" 
                                                                          class="form-control"
                                                                          rows="3"
                                                                          placeholder="أدخل وصف المنتج بـ {{ $name }}">{{ old('translations.' . $locale . '.description_translated', $translation->description_translated ?? '') }}</textarea>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            @endforeach
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        
                        <!-- Image Upload -->
                        <div class="col-lg-4">
                            <div class="card">
                                <div class="card-header">
                                    <h5 class="card-title">
                                        <i class="fa-solid fa-image text-success"></i>
                                        صورة المنتج
                                    </h5>
                                </div>
                                <div class="card-body">
                                    <div class="form-group">
                                        <!-- Current Image -->
                                        @if($product->image)
                                            <div class="current-image mb-3">
                                                <label class="form-label">الصورة الحالية:</label>
                                                <div class="text-center">
                                                    <img src="{{ asset('storage/' . $product->image) }}" 
                                                         alt="{{ $product->name }}" 
                                                         class="img-fluid rounded border"
                                                         style="max-height: 200px; object-fit: cover;">
                                                </div>
                                            </div>
                                        @endif
                                        
                                        <!-- Upload New Image -->
                                        <div class="image-upload-area" id="imageUploadArea">
                                            <div class="upload-content">
                                                <i class="fa-solid fa-cloud-upload-alt fa-2x text-muted"></i>
                                                <p class="mt-2 text-muted">اختر صورة جديدة أو اسحب وأفلت</p>
                                                <small class="text-muted">الحد الأقصى: 2MB</small>
                                            </div>
                                            <input type="file" 
                                                   id="image" 
                                                   name="image" 
                                                   class="form-control-file d-none @error('image') is-invalid @enderror"
                                                   accept="image/*">
                                        </div>
                                        
                                        <!-- New Image Preview -->
                                        <div class="image-preview mt-3" id="imagePreview" style="display: none;">
                                            <label class="form-label">معاينة الصورة الجديدة:</label>
                                            <img id="previewImg" src="" alt="معاينة الصورة" class="img-fluid rounded border">
                                            <button type="button" class="btn btn-sm btn-danger mt-2" id="removeImage">
                                                <i class="fa-solid fa-trash"></i> إزالة الصورة الجديدة
                                            </button>
                                        </div>
                                        
                                        @error('image')
                                            <div class="invalid-feedback d-block">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                            </div>

                            <!-- Existing Additional Images -->
                            <div class="card mt-2">
                                <div class="card-header">
                                    <h5 class="card-title">
                                        <i class="fa-solid fa-images text-success"></i>
                                        صور المنتج الإضافية
                                    </h5>
                                </div>
                                <div class="card-body">
                                    @if($product->images && $product->images->count())
                                        <div class="row">
                                            @foreach($product->images as $image)
                                                <div class="col-md-6 mb-3">
                                                    <div class="border rounded p-2 text-center">
                                                        <img src="{{ asset('storage/' . $image->path) }}" alt="image" class="img-fluid" style="max-height:180px; object-fit:cover;">
                                                        <div class="mt-2">
                                                            <button type="button" class="btn btn-sm btn-danger" onclick="deleteProductImage('{{ $product->id }}', '{{ $image->id }}')">
                                                                <i class="fa-solid fa-trash"></i> حذف
                                                            </button>
                                                        </div>
                                                    </div>
                                                </div>
                                            @endforeach
                                        </div>
                                    @else
                                        <p class="text-muted mb-0">لا توجد صور إضافية بعد.</p>
                                    @endif
                                </div>
                            </div>

                            <!-- Upload New Additional Images -->
                            <div class="card mt-2">
                                <div class="card-header">
                                    <h5 class="card-title">
                                        <i class="fa-solid fa-file-upload text-primary"></i>
                                        إضافة صور جديدة
                                    </h5>
                                </div>
                                <div class="card-body">
                                    <div class="form-group">
                                        <input type="file" name="images[]" class="form-control" multiple accept="image/*">
                                        <small class="text-muted d-block mt-1">يمكنك اختيار عدة صور. لا يوجد حد أقصى لحجم الصورة.</small>
                                        @error('images.*')
                                            <div class="invalid-feedback d-block">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                            
                            <!-- Product Info -->
                            <div class="card">
                                <div class="card-header">
                                    <h5 class="card-title">
                                        <i class="fa-solid fa-info text-primary"></i>
                                        معلومات المنتج
                                    </h5>
                                </div>
                                <div class="card-body">
                                    <div class="info-item">
                                        <strong>تاريخ الإنشاء:</strong>
                                        <span class="text-muted">{{ $product->created_at->format('Y-m-d H:i') }}</span>
                                    </div>
                                    <div class="info-item mt-2">
                                        <strong>آخر تحديث:</strong>
                                        <span class="text-muted">{{ $product->updated_at->format('Y-m-d H:i') }}</span>
                                    </div>
                                    @if($product->orderDetails->count() > 0)
                                        <div class="info-item mt-2">
                                            <strong>عدد الطلبات:</strong>
                                            <span class="badge badge-info">{{ $product->orderDetails->count() }}</span>
                                        </div>
                                    @endif
                                </div>
                            </div>
                            
                            <!-- Form Actions -->
                            <div class="card">
                                <div class="card-body">
                                    <div class="d-flex justify-content-between">
                                        <button type="button" class="btn btn-secondary" onclick="history.back()">
                                            <i class="fa-solid fa-times"></i> إلغاء
                                        </button>
                                        <button type="submit" class="btn btn-warning">
                                            <i class="fa-solid fa-save"></i> حفظ التعديلات
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

@push('styles')
<style>
.image-upload-area {
    border: 2px dashed #ddd;
    border-radius: 8px;
    padding: 1.5rem;
    text-align: center;
    cursor: pointer;
    transition: all 0.3s ease;
    background-color: #f8f9fa;
}

.image-upload-area:hover {
    border-color: #70B9BE;
    background-color: #f0f8f9;
}

.image-upload-area.dragover {
    border-color: #70B9BE;
    background-color: #e8f4f5;
}

.image-preview img {
    max-height: 200px;
    object-fit: cover;
}

.form-label {
    font-weight: 600;
    color: #333;
}

.card-title {
    color: #70B9BE;
    font-weight: 600;
}

.alert {
    border-radius: 8px;
}

.btn {
    border-radius: 6px;
    font-weight: 500;
}

.info-item {
    padding: 0.5rem 0;
    border-bottom: 1px solid #eee;
}

.info-item:last-child {
    border-bottom: none;
}

.current-image img {
    border: 2px solid #70B9BE;
}

/* Tab fixes */
.nav-tabs .nav-link {
    border: 1px solid transparent;
    border-top-left-radius: 0.25rem;
    border-top-right-radius: 0.25rem;
    color: #495057;
    background-color: transparent;
    border-color: #dee2e6 #dee2e6 #fff;
}

.nav-tabs .nav-link:hover {
    border-color: #e9ecef #e9ecef #dee2e6;
    isolation: isolate;
}

.nav-tabs .nav-link.active {
    color: #495057;
    background-color: #fff;
    border-color: #dee2e6 #dee2e6 #fff;
}

.tab-content > .tab-pane {
    display: none;
}

.tab-content > .tab-pane.active {
    display: block;
}

.tab-content > .tab-pane.show {
    display: block;
}
</style>
@endpush

@push('scripts')
<script>
$(document).ready(function() {
    // Image upload functionality
    const imageUploadArea = document.getElementById('imageUploadArea');
    const imageInput = document.getElementById('image');
    const imagePreview = document.getElementById('imagePreview');
    const previewImg = document.getElementById('previewImg');
    const removeImageBtn = document.getElementById('removeImage');

    if (imageUploadArea && imageInput) {
        // Click to upload
        imageUploadArea.addEventListener('click', () => {
            imageInput.click();
        });

        // Drag and drop functionality
        imageUploadArea.addEventListener('dragover', (e) => {
            e.preventDefault();
            imageUploadArea.classList.add('dragover');
        });

        imageUploadArea.addEventListener('dragleave', () => {
            imageUploadArea.classList.remove('dragover');
        });

        imageUploadArea.addEventListener('drop', (e) => {
            e.preventDefault();
            imageUploadArea.classList.remove('dragover');
            
            const files = e.dataTransfer.files;
            if (files.length > 0) {
                handleFileSelect(files[0]);
            }
        });

        // File input change
        imageInput.addEventListener('change', (e) => {
            if (e.target.files.length > 0) {
                handleFileSelect(e.target.files[0]);
            }
        });

        // Remove image
        if (removeImageBtn) {
            removeImageBtn.addEventListener('click', () => {
                imageInput.value = '';
                imagePreview.style.display = 'none';
            });
        }
    }

    function handleFileSelect(file) {
        // Validate file type
        if (!file.type.startsWith('image/')) {
            alert('يرجى اختيار ملف صورة صالح');
            return;
        }

        // Validate file size (2MB)
        if (file.size > 2 * 1024 * 1024) {
            alert('حجم الملف يجب أن يكون أقل من 2MB');
            return;
        }

        // Show preview
        const reader = new FileReader();
        reader.onload = (e) => {
            if (previewImg) previewImg.src = e.target.result;
            if (imagePreview) imagePreview.style.display = 'block';
        };
        reader.readAsDataURL(file);
    }

    // Form validation and prevent double submission
    let isSubmitting = false;
    $('#productForm').on('submit', function(e) {
        // Prevent double submission
        if (isSubmitting) {
            e.preventDefault();
            return false;
        }

        const requiredFields = ['name', 'category_id', 'price'];
        let isValid = true;

        requiredFields.forEach(field => {
            const input = $(`[name="${field}"]`);
            if (!input.val()) {
                input.addClass('is-invalid');
                isValid = false;
            } else {
                input.removeClass('is-invalid');
            }
        });

        if (!isValid) {
            e.preventDefault();
            alert('يرجى ملء جميع الحقول المطلوبة');
            return false;
        }

        // Mark as submitting
        isSubmitting = true;
        $(this).find('button[type="submit"]').prop('disabled', true).html('<i class="fa-solid fa-spinner fa-spin"></i> جاري الحفظ...');
    });

    // Real-time validation
    $('input[required], select[required]').on('blur', function() {
        if (!$(this).val()) {
            $(this).addClass('is-invalid');
        } else {
            $(this).removeClass('is-invalid');
        }
    });
});

// Delete product image via AJAX to avoid nested form submission side-effects
async function deleteProductImage(productId, imageId) {
    if (!confirm('حذف هذه الصورة؟')) return;

    const tokenMeta = document.querySelector('meta[name="csrf-token"]');
    const csrfToken = tokenMeta ? tokenMeta.getAttribute('content') : '{{ csrf_token() }}';
    const url = `{{ url('admin/products') }}/${productId}/images/${imageId}`;

    try {
        const response = await fetch(url, {
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN': csrfToken,
                'X-Requested-With': 'XMLHttpRequest',
                'Accept': 'text/html,application/json'
            },
            body: new URLSearchParams({ _method: 'DELETE' })
        });

        if (!response.ok) {
            throw new Error('فشل حذف الصورة');
        }

        // Reload to reflect changes
        window.location.reload();
    } catch (e) {
        alert('حدث خطأ أثناء حذف الصورة');
        console.error(e);
    }
}
</script>
@endpush
@endsection
