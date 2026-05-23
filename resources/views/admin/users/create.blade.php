@extends('admin.layouts.app')

@section('content')
<div class="content-header row">
    <div class="content-header-left col-md-9 col-12 mb-2">
        <div class="row breadcrumbs-top">
            <div class="col-12">
                <h2 class="content-header-title float-left mb-0" style="color: #70B9BE; font-weight: bold;">إضافة مستخدم جديد</h2>
                <div class="breadcrumb-wrapper col-12">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{ route('admin.index') }}">الرئيسية</a></li>
                        <li class="breadcrumb-item"><a href="{{ route('admin.users.index') }}">المستخدمين</a></li>
                        <li class="breadcrumb-item active">إضافة مستخدم جديد</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>
    <div class="content-header-right text-md-right col-md-3 col-12 d-md-block d-none">
        <div class="form-group breadcrumb-right">
            <a href="{{ route('admin.users.index') }}" class="btn btn-secondary">
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
                    بيانات المستخدم الجديد
                </h4>
            </div>
            <div class="card-body">
                <form action="{{ route('admin.users.store') }}" method="POST" id="createUserForm">
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
                                                    اسم المستخدم <span class="text-danger">*</span>
                                                </label>
                                                <input type="text" 
                                                       id="name" 
                                                       name="name" 
                                                       class="form-control @error('name') is-invalid @enderror"
                                                       placeholder="أدخل اسم المستخدم"
                                                       value="{{ old('name') }}"
                                                       required>
                                                @error('name')
                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                            </div>
                                        </div>
                                        
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="email" class="form-label">
                                                    البريد الإلكتروني <span class="text-danger">*</span>
                                                </label>
                                                <input type="email" 
                                                       id="email" 
                                                       name="email" 
                                                       class="form-control @error('email') is-invalid @enderror"
                                                       placeholder="أدخل البريد الإلكتروني"
                                                       value="{{ old('email') }}"
                                                       required>
                                                @error('email')
                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                            </div>
                                        </div>
                                        
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="password" class="form-label">
                                                    كلمة المرور <span class="text-danger">*</span>
                                                </label>
                                                <div class="input-group">
                                                    <input type="password" 
                                                           id="password" 
                                                           name="password" 
                                                           class="form-control @error('password') is-invalid @enderror"
                                                           placeholder="أدخل كلمة المرور"
                                                           required>
                                                    <div class="input-group-append">
                                                        <button type="button" class="btn btn-outline-secondary" onclick="togglePassword('password')">
                                                            <i class="fa-solid fa-eye" id="password-icon"></i>
                                                        </button>
                                                    </div>
                                                </div>
                                                @error('password')
                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                                <small class="form-text text-muted">يجب أن تكون كلمة المرور 8 أحرف على الأقل</small>
                                            </div>
                                        </div>
                                        
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="password_confirmation" class="form-label">
                                                    تأكيد كلمة المرور <span class="text-danger">*</span>
                                                </label>
                                                <div class="input-group">
                                                    <input type="password" 
                                                           id="password_confirmation" 
                                                           name="password_confirmation" 
                                                           class="form-control @error('password_confirmation') is-invalid @enderror"
                                                           placeholder="أعد إدخال كلمة المرور"
                                                           required>
                                                    <div class="input-group-append">
                                                        <button type="button" class="btn btn-outline-secondary" onclick="togglePassword('password_confirmation')">
                                                            <i class="fa-solid fa-eye" id="password_confirmation-icon"></i>
                                                        </button>
                                                    </div>
                                                </div>
                                                @error('password_confirmation')
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
                        
                        <!-- Roles and Permissions -->
                        <div class="col-lg-4">
                            <div class="card">
                                <div class="card-header">
                                    <h5 class="card-title">
                                        <i class="fa-solid fa-user-shield text-warning"></i>
                                        الصلاحيات
                                    </h5>
                                </div>
                                <div class="card-body">
                                    <div class="form-group">
                                        <label class="form-label">
                                            أدوار المستخدم <span class="text-danger">*</span>
                                        </label>
                                        @if($roles)
                                            @foreach($roles as $roleName => $roleDisplay)
                                                <div class="form-check">
                                                    <input type="checkbox" 
                                                           id="role_{{ $loop->index }}" 
                                                           name="roles[]" 
                                                           value="{{ $roleName }}"
                                                           class="form-check-input @error('roles') is-invalid @enderror"
                                                           {{ in_array($roleName, old('roles', [])) ? 'checked' : '' }}>
                                                    <label class="form-check-label" for="role_{{ $loop->index }}">
                                                        {{ $roleDisplay }}
                                                    </label>
                                                </div>
                                            @endforeach
                                        @else
                                            <p class="text-muted">لا توجد أدوار متاحة</p>
                                        @endif
                                        @error('roles')
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
                                            <i class="fa-solid fa-save"></i> حفظ المستخدم
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

.form-check {
    margin-bottom: 0.5rem;
}

.form-check-input {
    margin-top: 0.25rem;
}

.form-check-label {
    margin-left: 0.5rem;
    font-weight: 500;
}

.input-group-append .btn {
    border-top-left-radius: 0;
    border-bottom-left-radius: 0;
}
</style>
@endpush

@push('scripts')
<script>
$(document).ready(function() {
    // Form validation
    $('#createUserForm').on('submit', function(e) {
        const requiredFields = ['name', 'email', 'password', 'password_confirmation'];
        let isValid = true;
        let missingFields = [];

        requiredFields.forEach(field => {
            const input = $(`[name="${field}"]`);
            const value = input.val();
            
            if (!value || value.trim() === '') {
                input.addClass('is-invalid');
                isValid = false;
                missingFields.push(field);
            } else {
                input.removeClass('is-invalid');
            }
        });

        // Check if at least one role is selected
        const selectedRoles = $('input[name="roles[]"]:checked').length;
        if (selectedRoles === 0) {
            isValid = false;
            $('input[name="roles[]"]').addClass('is-invalid');
            missingFields.push('roles');
        } else {
            $('input[name="roles[]"]').removeClass('is-invalid');
        }

        // Check password confirmation
        const password = $('input[name="password"]').val();
        const passwordConfirmation = $('input[name="password_confirmation"]').val();
        
        if (password !== passwordConfirmation) {
            $('input[name="password_confirmation"]').addClass('is-invalid');
            isValid = false;
            missingFields.push('password_confirmation');
        }

        if (!isValid) {
            e.preventDefault();
            alert(`يرجى ملء جميع الحقول المطلوبة: ${missingFields.join(', ')}`);
            return false;
        }
        
        return true;
    });

    // Real-time validation
    $('input[required]').on('blur', function() {
        if (!$(this).val()) {
            $(this).addClass('is-invalid');
        } else {
            $(this).removeClass('is-invalid');
        }
    });

    // Password confirmation validation
    $('input[name="password_confirmation"]').on('input', function() {
        const password = $('input[name="password"]').val();
        const passwordConfirmation = $(this).val();
        
        if (passwordConfirmation && password !== passwordConfirmation) {
            $(this).addClass('is-invalid');
        } else {
            $(this).removeClass('is-invalid');
        }
    });
});

function togglePassword(fieldId) {
    const field = document.getElementById(fieldId);
    const icon = document.getElementById(fieldId + '-icon');
    
    if (field.type === 'password') {
        field.type = 'text';
        icon.classList.remove('fa-eye');
        icon.classList.add('fa-eye-slash');
    } else {
        field.type = 'password';
        icon.classList.remove('fa-eye-slash');
        icon.classList.add('fa-eye');
    }
}
</script>
@endpush
@endsection