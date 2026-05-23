@extends('admin.layouts.app')

@section('content')
<div class="content-header row">
    <div class="content-header-left col-md-9 col-12 mb-2">
        <div class="row breadcrumbs-top">
            <div class="col-12">
                <h2 class="content-header-title float-left mb-0" style="color: #70B9BE; font-weight: bold;">إضافة منتج جديد</h2>
                <div class="breadcrumb-wrapper col-12">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{ route('admin.index') }}">الرئيسية</a></li>
                        <li class="breadcrumb-item"><a href="{{ route('admin.products.index') }}">المنتجات</a></li>
                        <li class="breadcrumb-item active">إضافة منتج جديد</li>
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
                    <i class="fa-solid fa-plus-circle text-primary"></i>
                    بيانات المنتج الجديد
                </h4>
            </div>
            <div class="card-body">
                <form action="{{ route('admin.products.store') }}" method="POST" enctype="multipart/form-data" id="productForm">
                    @csrf
                    
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
                                                       value="{{ old('name') }}"
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
                                                        <option value="{{ $id }}" {{ old('category_id') == $id ? 'selected' : '' }}>
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
                                                       value="{{ old('serial_number') }}">
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
                                                       value="{{ old('request_number') }}">
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
                                                           value="{{ old('price') }}"
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
                                                    <option value="1" {{ old('active', 1) == 1 ? 'selected' : '' }}>نشط</option>
                                                    <option value="0" {{ old('active') == 0 ? 'selected' : '' }}>غير نشط</option>
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
                                                          placeholder="أدخل وصف المنتج">{{ old('description') }}</textarea>
                                                @error('description')
                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                            </div>
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
                                        <div class="image-upload-area" id="imageUploadArea">
                                            <div class="upload-content">
                                                <i class="fa-solid fa-cloud-upload-alt fa-3x text-muted"></i>
                                                <p class="mt-2 text-muted">اسحب وأفلت الصورة هنا أو انقر للاختيار</p>
                                                <small class="text-muted">الحد الأقصى: 2MB</small>
                                            </div>
                                            <input type="file" 
                                                   id="image" 
                                                   name="image" 
                                                   class="form-control-file d-none @error('image') is-invalid @enderror"
                                                   accept="image/*">
                                        </div>
                                        <div class="image-preview mt-3" id="imagePreview" style="display: none;">
                                            <img id="previewImg" src="" alt="معاينة الصورة" class="img-fluid rounded">
                                            <button type="button" class="btn btn-sm btn-danger mt-2" id="removeImage">
                                                <i class="fa-solid fa-trash"></i> إزالة الصورة
                                            </button>
                                        </div>
                                        @error('image')
                                            <div class="invalid-feedback d-block">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                            </div>

                            <!-- Multiple Images Upload -->
                            <div class="card mt-2">
                                <div class="card-header">
                                    <h5 class="card-title">
                                        <i class="fa-solid fa-images text-success"></i>
                                        صور إضافية (اختياري)
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
                            
                            <!-- Form Actions -->
                            <div class="card">
                                <div class="card-body">
                                    <div class="d-flex justify-content-between">
                                        <button type="button" class="btn btn-secondary" onclick="history.back()">
                                            <i class="fa-solid fa-times"></i> إلغاء
                                        </button>
                                        <button type="submit" class="btn btn-primary">
                                            <i class="fa-solid fa-save"></i> حفظ المنتج
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
    padding: 2rem;
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
    removeImageBtn.addEventListener('click', () => {
        imageInput.value = '';
        imagePreview.style.display = 'none';
        imageUploadArea.style.display = 'block';
    });

    function handleFileSelect(file) {
        // Validate file type
        if (!file.type.startsWith('image/')) {
            alert('يرجى اختيار ملف صورة صالح');
            return;
        }

        // File size validation removed - no limit

        // Show preview
        const reader = new FileReader();
        reader.onload = (e) => {
            previewImg.src = e.target.result;
            imagePreview.style.display = 'block';
            imageUploadArea.style.display = 'none';
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
</script>
@endpush
@endsection
