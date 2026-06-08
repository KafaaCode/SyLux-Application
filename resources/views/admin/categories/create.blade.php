@extends('admin.layouts.app')

@section('content')
<div class="content-header row">
    <div class="content-header-left col-md-9 col-12 mb-2">
        <div class="row breadcrumbs-top">
            <div class="col-12">
                <h2 class="content-header-title float-left mb-0" style="color: #B79C6D; font-weight: bold;">إضافة فئة جديدة</h2>
                <div class="breadcrumb-wrapper col-12">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{ route('admin.index') }}">الرئيسية</a></li>
                        <li class="breadcrumb-item"><a href="{{ route('admin.categories.index') }}">الفئات</a></li>
                        <li class="breadcrumb-item active">إضافة فئة جديدة</li>
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
                    <i class="fa-solid fa-plus-circle text-primary"></i>
                    إضافة فئة جديدة
                </h4>
            </div>
            <div class="card-body">
                <form action="{{ route('admin.categories.store') }}" method="POST" enctype="multipart/form-data" id="categoryForm">
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
                                                       value="{{ old('name') }}"
                                                       required>
                                                @error('name')
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
                                        <div class="image-upload-area" id="imageUploadArea">
                                            <div class="upload-content">
                                                <i class="fa-solid fa-cloud-upload-alt fa-2x text-muted"></i>
                                                <p class="mt-2 text-muted">اختر صورة أو اسحب وأفلت</p>
                                                <small class="text-muted">الحد الأقصى: 2MB</small>
                                            </div>
                                            <input type="file" 
                                                   id="image" 
                                                   name="image" 
                                                   class="form-control-file d-none @error('image') is-invalid @enderror"
                                                   accept="image/*">
                                        </div>
                                        
                                        <!-- Image Preview -->
                                        <div class="image-preview mt-3" id="imagePreview" style="display: none;">
                                            <label class="form-label">معاينة الصورة:</label>
                                            <img id="previewImg" src="" alt="معاينة الصورة" class="img-fluid rounded border">
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
                            
                            <!-- Form Actions -->
                            <div class="card">
                                <div class="card-body">
                                    <div class="d-flex justify-content-between">
                                        <button type="button" class="btn btn-secondary" onclick="history.back()">
                                            <i class="fa-solid fa-times"></i> إلغاء
                                        </button>
                                        <button type="submit" class="btn btn-primary">
                                            <i class="fa-solid fa-save"></i> حفظ الفئة
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