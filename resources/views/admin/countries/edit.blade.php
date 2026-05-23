@extends('admin.layouts.app')

@section('content')
<div class="content-header row">
    <div class="content-header-left col-md-9 col-12 mb-2">
        <div class="row breadcrumbs-top">
            <div class="col-12">
                <h2 class="content-header-title float-left mb-0" style="color: #70B9BE; font-weight: bold;">تعديل الدولة</h2>
                <div class="breadcrumb-wrapper col-12">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{ route('admin.index') }}">الرئيسية</a></li>
                        <li class="breadcrumb-item"><a href="{{ route('admin.countries.index') }}">الدول</a></li>
                        <li class="breadcrumb-item active">تعديل الدولة</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>
    <div class="content-header-right text-md-right col-md-3 col-12 d-md-block d-none">
        <div class="form-group breadcrumb-right">
            <a href="{{ route('admin.countries.index') }}" class="btn btn-secondary">
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
                    تعديل بيانات الدولة: {{ $country->name }}
                </h4>
            </div>
            <div class="card-body">
                <form action="{{ route('admin.countries.update', $country->id) }}" method="POST" id="countryForm">
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
                                        <div class="col-md-12">
                                            <div class="form-group">
                                                <label for="name" class="form-label">
                                                    اسم الدولة <span class="text-danger">*</span>
                                                </label>
                                                <input type="text" 
                                                       id="name" 
                                                       name="name" 
                                                       class="form-control @error('name') is-invalid @enderror"
                                                       placeholder="أدخل اسم الدولة"
                                                       value="{{ old('name', $country->name) }}"
                                                       required>
                                                @error('name')
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
                                                       aria-selected="{{ $loop->first ? 'true' : 'false' }}">
                                                        {{ $name }}
                                                    </a>
                                                </li>
                                            @endforeach
                                        </ul>
                                        
                                        <div class="tab-content" id="translationTabsContent">
                                            @foreach(config('app.available_locales') as $locale => $name)
                                                @php
                                                    $translation = $country->translations()->where('locale', $locale)->first();
                                                @endphp
                                                <div class="tab-pane fade {{ $loop->first ? 'show active' : '' }}" 
                                                     id="{{ $locale }}" 
                                                     role="tabpanel" 
                                                     aria-labelledby="{{ $locale }}-tab">
                                                    <div class="row mt-3">
                                                        <div class="col-md-12">
                                                            <div class="form-group">
                                                                <label for="name_translated_{{ $locale }}" class="form-label">
                                                                    اسم الدولة ({{ $name }})
                                                                </label>
                                                                <input type="text" 
                                                                       id="name_translated_{{ $locale }}" 
                                                                       name="translations[{{ $locale }}][name_translated]" 
                                                                       class="form-control"
                                                                       placeholder="أدخل اسم الدولة بـ {{ $name }}"
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
                        
                        <!-- Country Info -->
                        <div class="col-lg-4">
                            <div class="card">
                                <div class="card-header">
                                    <h5 class="card-title">
                                        <i class="fa-solid fa-info text-primary"></i>
                                        معلومات الدولة
                                    </h5>
                                </div>
                                <div class="card-body">
                                    <div class="info-item">
                                        <strong>تاريخ الإنشاء:</strong>
                                        <span class="text-muted">{{ $country->created_at->format('Y-m-d H:i') }}</span>
                                    </div>
                                    <div class="info-item mt-2">
                                        <strong>آخر تحديث:</strong>
                                        <span class="text-muted">{{ $country->updated_at->format('Y-m-d H:i') }}</span>
                                    </div>
                                    @if($country->categories->count() > 0)
                                        <div class="info-item mt-2">
                                            <strong>عدد الفئات:</strong>
                                            <span class="badge badge-info">{{ $country->categories->count() }}</span>
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

<style>
.info-item {
    display: flex;
    justify-content: space-between;
    align-items: center;
    padding: 0.5rem 0;
    border-bottom: 1px solid #eee;
}

.info-item:last-child {
    border-bottom: none;
}

.nav-tabs .nav-link {
    color: #6c757d;
    border: 1px solid transparent;
    border-top-left-radius: 0.25rem;
    border-top-right-radius: 0.25rem;
}

.nav-tabs .nav-link:hover {
    border-color: #e9ecef #e9ecef #dee2e6;
}

.nav-tabs .nav-link.active {
    color: #495057;
    background-color: #fff;
    border-color: #dee2e6 #dee2e6 #fff;
}
</style>
@endsection
