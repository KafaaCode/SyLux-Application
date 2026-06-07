@extends('admin.layouts.app')

@section('content')
<div class="content-header row">
    <div class="content-header-left col-md-9 col-12 mb-2">
        <div class="row breadcrumbs-top">
            <div class="col-12">
                <h2 class="content-header-title float-left mb-0" style="color: #B79C6D; font-weight: bold;">تفاصيل المستخدم</h2>
                <div class="breadcrumb-wrapper col-12">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{ route('admin.index') }}">الرئيسية</a></li>
                        <li class="breadcrumb-item"><a href="{{ route('admin.users.index') }}">المستخدمين</a></li>
                        <li class="breadcrumb-item active">تفاصيل المستخدم</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>
    <div class="content-header-right text-md-right col-md-3 col-12 d-md-block d-none">
        <div class="form-group breadcrumb-right">
            <div class="btn-group" role="group">
                <a href="{{ route('admin.users.edit', $user->id) }}" class="btn btn-warning">
                    <i class="fa-solid fa-edit"></i> تعديل
                </a>
                <a href="{{ route('admin.users.index') }}" class="btn btn-secondary">
                    <i class="fa-solid fa-arrow-right"></i> العودة
                </a>
            </div>
        </div>
    </div>
</div>

<div class="row">
    <!-- User Details -->
    <div class="col-lg-8">
        <div class="card">
            <div class="card-header">
                <h4 class="card-title">
                    <i class="fa-solid fa-user text-primary"></i>
                    {{ $user->name }}
                </h4>
                <div class="card-tools">
                    @if($user->active ?? true)
                        <span class="badge badge-success badge-lg">نشط</span>
                    @else
                        <span class="badge badge-danger badge-lg">غير نشط</span>
                    @endif
                </div>
            </div>
            <div class="card-body">
                <div class="row">
                    <!-- User Avatar -->
                    <div class="col-md-4">
                        <div class="user-avatar-container">
                            <div class="avatar bg-light-primary">
                                <div class="avatar-content">
                                    <i class="fa-solid fa-user fa-3x text-primary"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <!-- User Information -->
                    <div class="col-md-8">
                        <div class="user-info">
                            <div class="info-row">
                                <div class="info-label">
                                    <i class="fa-solid fa-user text-primary"></i>
                                    اسم المستخدم:
                                </div>
                                <div class="info-value">{{ $user->name }}</div>
                            </div>
                            
                            <div class="info-row">
                                <div class="info-label">
                                    <i class="fa-solid fa-envelope text-info"></i>
                                    البريد الإلكتروني:
                                </div>
                                <div class="info-value">
                                    {{ $user->email }}
                                    @if($user->email_verified_at)
                                        <span class="badge badge-success ml-2">محقق</span>
                                    @else
                                        <span class="badge badge-warning ml-2">غير محقق</span>
                                    @endif
                                </div>
                            </div>
                            
                            <div class="info-row">
                                <div class="info-label">
                                    <i class="fa-solid fa-id-card text-warning"></i>
                                    معرف المستخدم:
                                </div>
                                <div class="info-value">
                                    <span class="badge badge-light-primary">#{{ $user->id }}</span>
                                </div>
                            </div>
                            
                            <div class="info-row">
                                <div class="info-label">
                                    <i class="fa-solid fa-venus-mars text-success"></i>
                                    الجنس:
                                </div>
                                <div class="info-value">
                                    @if($user->gender === 'male')
                                        <span class="badge badge-light-primary">ذكر</span>
                                    @elseif($user->gender === 'female')
                                        <span class="badge badge-light-danger">أنثى</span>
                                    @else
                                        <span class="text-muted">غير محدد</span>
                                    @endif
                                </div>
                            </div>

                            <div class="info-row">
                                <div class="info-label">
                                    <i class="fa-solid fa-calendar text-primary"></i>
                                    تاريخ الميلاد:
                                </div>
                                <div class="info-value">
                                    {{ $user->birthdate ? $user->birthdate->format('Y-m-d') : '-' }}
                                </div>
                            </div>

                            <div class="info-row">
                                <div class="info-label">
                                    <i class="fa-solid fa-coins text-warning"></i>
                                    النقاط:
                                </div>
                                <div class="info-value">
                                    <span class="badge badge-light-warning">{{ $user->points ?? 0 }}</span>
                                </div>
                            </div>

                            <div class="info-row">
                                <div class="info-label">
                                    <i class="fa-solid fa-user-shield text-success"></i>
                                    الصلاحيات:
                                </div>
                                <div class="info-value">
                                    @if($user->roles->count() > 0)
                                        @foreach($user->roles as $role)
                                            <span class="badge badge-light-info">{{ $role->name }}</span>
                                        @endforeach
                                    @else
                                        <span class="badge badge-light-secondary">بدون صلاحيات</span>
                                    @endif
                                </div>
                            </div>

                            <div class="info-row">
                                <div class="info-label">
                                    <i class="fa-solid fa-calendar text-primary"></i>
                                    تاريخ الإنشاء:
                                </div>
                                <div class="info-value">{{ $user->created_at->format('Y-m-d H:i') }}</div>
                            </div>
                            
                            <div class="info-row">
                                <div class="info-label">
                                    <i class="fa-solid fa-clock text-info"></i>
                                    آخر تحديث:
                                </div>
                                <div class="info-value">{{ $user->updated_at->format('Y-m-d H:i') }}</div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
        <!-- User Roles Details -->
        @if($user->roles->count() > 0)
            <div class="card mt-4">
                <div class="card-header">
                    <h5 class="card-title">
                        <i class="fa-solid fa-user-shield text-success"></i>
                        تفاصيل الصلاحيات ({{ $user->roles->count() }})
                    </h5>
                </div>
                <div class="card-body">
                    <div class="row">
                        @foreach($user->roles as $role)
                            <div class="col-md-6 col-sm-12 mb-3">
                                <div class="role-card">
                                    <div class="role-icon">
                                        <i class="fa-solid fa-shield-alt text-primary"></i>
                                    </div>
                                    <div class="role-info">
                                        <h6 class="role-name">{{ $role->name }}</h6>
                                        <small class="role-description text-muted">
                                            تم إنشاؤه: {{ $role->created_at->format('Y-m-d') }}
                                        </small>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        @endif
    </div>
    
    <!-- Sidebar -->
    <div class="col-lg-4">
        <!-- Quick Actions -->
        <div class="card">
            <div class="card-header">
                <h5 class="card-title">
                    <i class="fa-solid fa-bolt text-warning"></i>
                    إجراءات سريعة
                </h5>
            </div>
            <div class="card-body">
                <div class="d-grid gap-2">
                    <a href="{{ route('admin.users.edit', $user->id) }}" class="btn btn-warning">
                        <i class="fa-solid fa-edit"></i> تعديل المستخدم
                    </a>
                    @if($user->id !== Auth::id())
                        <button type="button" class="btn btn-danger" data-toggle="modal" data-target="#deleteModal">
                            <i class="fa-solid fa-trash"></i> حذف المستخدم
                        </button>
                    @else
                        <button type="button" class="btn btn-secondary" disabled>
                            <i class="fa-solid fa-lock"></i> لا يمكن حذف المستخدم الحالي
                        </button>
                    @endif
                    <a href="{{ route('admin.users.create') }}" class="btn btn-primary">
                        <i class="fa-solid fa-plus"></i> إضافة مستخدم جديد
                    </a>
                </div>
            </div>
        </div>
        
        <!-- User Statistics -->
        <div class="card">
            <div class="card-header">
                <h5 class="card-title">
                    <i class="fa-solid fa-chart-bar text-success"></i>
                    إحصائيات المستخدم
                </h5>
            </div>
            <div class="card-body">
                <div class="stat-item">
                    <div class="stat-icon">
                        <i class="fa-solid fa-user-shield text-primary"></i>
                    </div>
                    <div class="stat-content">
                        <div class="stat-number">{{ $user->roles->count() }}</div>
                        <div class="stat-label">عدد الصلاحيات</div>
                    </div>
                </div>
                
                <div class="stat-item">
                    <div class="stat-icon">
                        <i class="fa-solid fa-calendar text-info"></i>
                    </div>
                    <div class="stat-content">
                        <div class="stat-number">{{ $user->created_at->diffInDays(now()) }}</div>
                        <div class="stat-label">أيام منذ الإنشاء</div>
                    </div>
                </div>
                
                <div class="stat-item">
                    <div class="stat-icon">
                        <i class="fa-solid fa-clock text-warning"></i>
                    </div>
                    <div class="stat-content">
                        <div class="stat-number">{{ $user->updated_at->diffInDays(now()) }}</div>
                        <div class="stat-label">أيام منذ آخر تحديث</div>
                    </div>
                </div>
            </div>
        </div>
        
        <!-- Related Information -->
        <div class="card">
            <div class="card-header">
                <h5 class="card-title">
                    <i class="fa-solid fa-info text-info"></i>
                    معلومات إضافية
                </h5>
            </div>
            <div class="card-body">
                <div class="related-info">
                    <div class="info-item">
                        <strong>الحالة:</strong>
                        @if($user->active ?? true)
                            <span class="badge badge-success">نشط</span>
                        @else
                            <span class="badge badge-danger">غير نشط</span>
                        @endif
                    </div>
                    <div class="info-item mt-2">
                        <strong>البريد الإلكتروني:</strong>
                        @if($user->email_verified_at)
                            <span class="badge badge-success">محقق</span>
                        @else
                            <span class="badge badge-warning">غير محقق</span>
                        @endif
                    </div>
                    <div class="info-item mt-2">
                        <strong>آخر نشاط:</strong>
                        <span class="text-muted">{{ $user->updated_at->format('Y-m-d H:i') }}</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Delete Modal -->
@if($user->id !== Auth::id())
    <div class="modal fade" id="deleteModal" tabindex="-1" role="dialog">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">تأكيد الحذف</h5>
                    <button type="button" class="close" data-dismiss="modal">
                        <span>&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="text-center mb-3">
                        <i class="fa-solid fa-exclamation-triangle fa-3x text-warning"></i>
                    </div>
                    <p>هل أنت متأكد من حذف المستخدم "<strong>{{ $user->name }}</strong>"؟</p>
                    <p class="text-danger">هذا الإجراء لا يمكن التراجع عنه.</p>
                    <div class="alert alert-warning">
                        <i class="fa-solid fa-warning"></i>
                        تحذير: سيتم حذف جميع البيانات المرتبطة بهذا المستخدم.
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">إلغاء</button>
                    <form action="{{ route('admin.users.destroy', $user->id) }}" method="POST" style="display: inline;">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger">حذف</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endif

@push('styles')
<style>
.user-avatar-container {
    text-align: center;
    padding: 1rem;
}

.avatar {
    width: 120px;
    height: 120px;
    margin: 0 auto;
    display: flex;
    align-items: center;
    justify-content: center;
    border-radius: 50%;
    background: linear-gradient(135deg, #B79C6D, #5a9ca0);
}

.user-info {
    padding: 1rem 0;
}

.info-row {
    display: flex;
    align-items: center;
    padding: 0.75rem 0;
    border-bottom: 1px solid #f0f0f0;
}

.info-row:last-child {
    border-bottom: none;
}

.info-label {
    font-weight: 600;
    color: inherit;
    min-width: 150px;
    display: flex;
    align-items: center;
    gap: 0.5rem;
}

.info-value {
    color: inherit;
    flex: 1;
    opacity: 0.85;
}

.role-card {
    border: 1px solid #eee;
    border-radius: 8px;
    padding: 1rem;
    transition: all 0.3s ease;
    background: white;
    display: flex;
    align-items: center;
    gap: 1rem;
}

.role-card:hover {
    box-shadow: 0 4px 8px rgba(0,0,0,0.1);
    transform: translateY(-2px);
}

.role-icon {
    width: 50px;
    height: 50px;
    background: #f8f9fa;
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
}

.role-name {
    font-weight: 600;
    margin-bottom: 0.25rem;
    color: inherit;
}

.role-description {
    font-size: 0.9rem;
}

.stat-item {
    display: flex;
    align-items: center;
    padding: 1rem 0;
    border-bottom: 1px solid #f0f0f0;
}

.stat-item:last-child {
    border-bottom: none;
}

.stat-icon {
    width: 50px;
    height: 50px;
    background: #f8f9fa;
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    margin-left: 1rem;
}

.stat-content {
    flex: 1;
}

.stat-number {
    font-size: 1.5rem;
    font-weight: bold;
    color: inherit;
}

.stat-label {
    color: inherit;
    opacity: 0.75;
    font-size: 0.9rem;
}

.related-info {
    text-align: center;
}

.info-item {
    padding: 0.5rem 0;
    border-bottom: 1px solid #eee;
}

.info-item:last-child {
    border-bottom: none;
}

.card-title {
    color: #B79C6D;
    font-weight: 600;
}

.btn {
    border-radius: 6px;
    font-weight: 500;
}

.badge {
    font-size: 0.8rem;
    padding: 0.5rem 0.75rem;
}

.alert {
    border-radius: 8px;
}
</style>
@endpush

@push('scripts')
<script>
$(document).ready(function() {
    // Initialize tooltips
    $('[data-toggle="tooltip"]').tooltip();
});
</script>
@endpush
@endsection

