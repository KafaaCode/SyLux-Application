@extends('admin.layouts.app')

@section('content')
<div class="content-header row">
    <div class="content-header-left col-md-9 col-12 mb-2">
        <div class="row breadcrumbs-top">
            <div class="col-12">
                <h2 class="content-header-title float-left mb-0" style="color: #B79C6D; font-weight: bold;">تعديل الفئة</h2>
                <div class="breadcrumb-wrapper col-12">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{ route('admin.index') }}">الرئيسية</a></li>
                        <li class="breadcrumb-item"><a href="{{ route('admin.categories.index') }}">الفئات</a></li>
                        <li class="breadcrumb-item active">تعديل الفئة</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>
    <div class="content-header-right text-md-right col-md-3 col-12 d-md-block d-none">
        <div class="form-group breadcrumb-right">
            <a href="{{ route('admin.categories.index') }}" class="btn btn-secondary">
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
                    تعديل بيانات الفئة: {{ $category->getTranslatedName() }}
                </h4>
            </div>
            <div class="card-body">
                <form action="{{ route('admin.categories.update', $category->id) }}" method="POST" enctype="multipart/form-data" id="categoryForm">
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
                                                    اسم الفئة <span class="text-danger">*</span>
                                                </label>
                                                <input type="text" 
                                                       id="name" 
                                                       name="name" 
                                                       class="form-control @error('name') is-invalid @enderror"
                                                       placeholder="أدخل اسم الفئة"
                                                       value="{{ old('name', $category->name) }}"
                                                       required>
                                                @error('name')
                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                            </div>
                                        </div>
                                        
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="section_id" class="form-label">القسم</label>
                                                <select id="section_id" name="section_id" class="form-control @error('section_id') is-invalid @enderror">
                                                    <option value="">اختر القسم</option>
                                                    @foreach ($sections as $id => $name)
                                                        <option value="{{ $id }}" {{ old('section_id', $category->section_id) == $id ? 'selected' : '' }}>{{ $name }}</option>
                                                    @endforeach
                                                </select>
                                                @error('section_id')<div class="invalid-feedback">{{ $message }}</div>@enderror
                                            </div>
                                        </div>

                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="country_id" class="form-label">الدولة</label>
                                                <select id="country_id" name="country_id" class="form-control @error('country_id') is-invalid @enderror">
                                                    <option value="">اختر الدولة</option>
                                                    @foreach ($countries as $id => $name)
                                                        <option value="{{ $id }}" {{ old('country_id', $category->country_id) == $id ? 'selected' : '' }}>{{ $name }}</option>
                                                    @endforeach
                                                </select>
                                                @error('country_id')<div class="invalid-feedback">{{ $message }}</div>@enderror
                                            </div>
                                        </div>

                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="specialization_id" class="form-label">التخصص</label>
                                                <select id="specialization_id" name="specialization_id" class="form-control @error('specialization_id') is-invalid @enderror">
                                                    <option value="">اختر التخصص</option>
                                                    @foreach ($specializations as $id => $name)
                                                        <option value="{{ $id }}" {{ old('specialization_id', $category->specialization_id) == $id ? 'selected' : '' }}>{{ $name }}</option>
                                                    @endforeach
                                                </select>
                                                @error('specialization_id')<div class="invalid-feedback">{{ $message }}</div>@enderror
                                            </div>
                                        </div>

                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="active" class="form-label">الحالة</label>
                                                <select id="active" 
                                                        name="active" 
                                                        class="form-control @error('active') is-invalid @enderror">
                                                    <option value="1" {{ old('active', $category->active) == 1 ? 'selected' : '' }}>نشط</option>
                                                    <option value="0" {{ old('active', $category->active) == 0 ? 'selected' : '' }}>غير نشط</option>
                                                </select>
                                                @error('active')
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
                                                    $translation = $category->translations()->where('locale', $locale)->first();
                                                @endphp
                                                <div class="tab-pane fade {{ $loop->first ? 'show active' : '' }}" 
                                                     id="{{ $locale }}" 
                                                     role="tabpanel" 
                                                     aria-labelledby="{{ $locale }}-tab"
                                                     style="display: {{ $loop->first ? 'block' : 'none' }};">
                                                    <div class="row mt-3">
                                                        <div class="col-12">
                                                            <div class="form-group">
                                                                <label for="name_translated_{{ $locale }}" class="form-label">
                                                                    اسم الفئة ({{ $name }})
                                                                </label>
                                                                <input type="text" 
                                                                       id="name_translated_{{ $locale }}" 
                                                                       name="translations[{{ $locale }}][name_translated]" 
                                                                       class="form-control"
                                                                       placeholder="أدخل اسم الفئة بـ {{ $name }}"
                                                                       value="{{ old('translations.' . $locale . '.name_translated', $translation->name_translated ?? '') }}">
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
                                        صورة الفئة
                                    </h5>
                                </div>
                                <div class="card-body">
                                    <div class="form-group">
                                        <!-- Current Image -->
                                        @if($category->image)
                                            <div class="current-image mb-3">
                                                <label class="form-label">الصورة الحالية:</label>
                                                <div class="text-center">
                                                    <img src="{{ asset('storage/' . $category->image) }}" 
                                                         alt="{{ $category->getTranslatedName() }}" 
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
                            
                            <!-- Category Info -->
                            <div class="card">
                                <div class="card-header">
                                    <h5 class="card-title">
                                        <i class="fa-solid fa-info text-primary"></i>
                                        معلومات الفئة
                                    </h5>
                                </div>
                                <div class="card-body">
                                    <div class="info-item">
                                        <strong>تاريخ الإنشاء:</strong>
                                        <span class="text-muted">{{ $category->created_at->format('Y-m-d H:i') }}</span>
                                    </div>
                                    <div class="info-item mt-2">
                                        <strong>آخر تحديث:</strong>
                                        <span class="text-muted">{{ $category->updated_at->format('Y-m-d H:i') }}</span>
                                    </div>
                                    @if($category->products->count() > 0)
                                        <div class="info-item mt-2">
                                            <strong>عدد المنتجات:</strong>
                                            <span class="badge badge-info">{{ $category->products->count() }}</span>
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
    border-color: #B79C6D;
    background-color: #f0f8f9;
}

.image-upload-area.dragover {
    border-color: #B79C6D;
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
    color: #B79C6D;
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
    border: 2px solid #B79C6D;
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

    // Form validation
    $('#categoryForm').on('submit', function(e) {
        const requiredFields = ['name'];
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
        }
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

// Tab switching function
function switchTab(locale) {
    // Remove active class from all tabs
    $('.nav-link').removeClass('active');
    $('.tab-pane').hide();
    
    // Add active class to clicked tab
    $('#' + locale + '-tab').addClass('active');
    $('#' + locale).show();
}
</script>
@endpush
@endsection