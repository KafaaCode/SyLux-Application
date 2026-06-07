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
                        <span class="badge badge-light-success badge-lg">نشط</span>
                    @else
                        <span class="badge badge-light-danger badge-lg">غير نشط</span>
                    @endif
                </div>
            </div>
            <div class="card-body">
                <!-- Profile Header -->
                <div class="profile-header d-flex align-items-center gap-4 mb-4">
                    <div class="profile-avatar">
                        <div class="avatar-circle">
                            <i class="fa-solid fa-user fa-3x"></i>
                        </div>
                    </div>
                    <div class="profile-meta flex-grow-1">
                        <h3 class="profile-name mb-1">{{ $user->name }}</h3>
                        <p class="profile-email mb-2">
                            <i class="fa-solid fa-envelope text-info mr-1"></i> {{ $user->email }}
                            @if($user->email_verified_at)
                                <span class="badge badge-light-success mr-1"><i class="fa-solid fa-check-circle"></i> محقق</span>
                            @else
                                <span class="badge badge-light-warning mr-1"><i class="fa-solid fa-clock"></i> غير محقق</span>
                            @endif
                        </p>
                        <div class="profile-badges">
                            @if($user->active ?? true)
                                <span class="badge badge-light-success"><i class="fa-solid fa-circle text-success" style="font-size:8px;vertical-align:middle;"></i> نشط</span>
                            @else
                                <span class="badge badge-light-danger"><i class="fa-solid fa-circle text-danger" style="font-size:8px;vertical-align:middle;"></i> غير نشط</span>
                            @endif
                            <span class="badge badge-light-primary">#{{ $user->id }}</span>
                        </div>
                    </div>
                </div>

                <hr class="my-4" style="border-color: rgba(0,0,0,0.08);">

                <!-- Info Grid -->
                <div class="row info-grid">
                    <div class="col-md-4 col-sm-6 mb-3">
                        <div class="info-tile">
                            <div class="tile-icon">
                                <i class="fa-solid fa-venus-mars text-primary"></i>
                            </div>
                            <div class="tile-content">
                                <span class="tile-label">الجنس</span>
                                <span class="tile-value">
                                    @if($user->gender === 'male')
                                        <span class="badge badge-light-primary">ذكر</span>
                                    @elseif($user->gender === 'female')
                                        <span class="badge badge-light-danger">أنثى</span>
                                    @else
                                        <span class="text-muted">غير محدد</span>
                                    @endif
                                </span>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-4 col-sm-6 mb-3">
                        <div class="info-tile">
                            <div class="tile-icon">
                                <i class="fa-solid fa-calendar text-primary"></i>
                            </div>
                            <div class="tile-content">
                                <span class="tile-label">تاريخ الميلاد</span>
                                <span class="tile-value">{{ $user->birthdate ? $user->birthdate->format('Y-m-d') : '-' }}</span>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-4 col-sm-6 mb-3">
                        <div class="info-tile">
                            <div class="tile-icon">
                                <i class="fa-solid fa-coins text-warning"></i>
                            </div>
                            <div class="tile-content">
                                <span class="tile-label">النقاط</span>
                                <span class="tile-value">
                                    <span class="badge badge-light-warning">{{ $user->points ?? 0 }}</span>
                                </span>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-4 col-sm-6 mb-3">
                        <div class="info-tile">
                            <div class="tile-icon">
                                <i class="fa-solid fa-user-shield text-info"></i>
                            </div>
                            <div class="tile-content">
                                <span class="tile-label">الصلاحيات</span>
                                <span class="tile-value">
                                    @if($user->roles->count() > 0)
                                        @foreach($user->roles as $role)
                                            <span class="badge badge-light-info">{{ $role->name }}</span>
                                        @endforeach
                                    @else
                                        <span class="badge badge-light-secondary">بدون</span>
                                    @endif
                                </span>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-4 col-sm-6 mb-3">
                        <div class="info-tile">
                            <div class="tile-icon">
                                <i class="fa-solid fa-calendar-check text-success"></i>
                            </div>
                            <div class="tile-content">
                                <span class="tile-label">تاريخ الإنشاء</span>
                                <span class="tile-value">{{ $user->created_at->format('Y-m-d') }}</span>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-4 col-sm-6 mb-3">
                        <div class="info-tile">
                            <div class="tile-icon">
                                <i class="fa-solid fa-clock text-secondary"></i>
                            </div>
                            <div class="tile-content">
                                <span class="tile-label">آخر تحديث</span>
                                <span class="tile-value">{{ $user->updated_at->format('Y-m-d') }}</span>
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
                            <span class="badge badge-light-success">نشط</span>
                        @else
                            <span class="badge badge-light-danger">غير نشط</span>
                        @endif
                    </div>
                    <div class="info-item mt-2">
                        <strong>البريد الإلكتروني:</strong>
                        @if($user->email_verified_at)
                            <span class="badge badge-light-success">محقق</span>
                        @else
                            <span class="badge badge-light-warning">غير محقق</span>
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
/* Profile Header */
.profile-header {
    padding: 1rem 0.5rem;
}

.profile-avatar .avatar-circle {
    width: 90px;
    height: 90px;
    border-radius: 50%;
    background: linear-gradient(135deg, #B79C6D, #5a9ca0);
    display: flex;
    align-items: center;
    justify-content: center;
    color: #fff;
    box-shadow: 0 4px 12px rgba(183,156,109,0.35);
}

.profile-name {
    font-weight: 700;
    color: inherit;
    font-size: 1.5rem;
}

.profile-email {
    color: inherit;
    opacity: 0.8;
    font-size: 0.95rem;
}

.profile-badges .badge {
    font-size: 0.75rem;
    padding: 0.4rem 0.6rem;
    margin-left: 0.25rem;
}

/* Info Tiles */
.info-tile {
    display: flex;
    align-items: center;
    gap: 0.875rem;
    padding: 1rem;
    border: 1px solid rgba(0,0,0,0.06);
    border-radius: 10px;
    background: rgba(0,0,0,0.015);
    transition: all 0.25s ease;
    height: 100%;
}

.info-tile:hover {
    background: rgba(0,0,0,0.04);
    transform: translateY(-2px);
    box-shadow: 0 6px 16px rgba(0,0,0,0.06);
}

.tile-icon {
    width: 44px;
    height: 44px;
    border-radius: 10px;
    display: flex;
    align-items: center;
    justify-content: center;
    flex-shrink: 0;
}

.tile-icon i {
    font-size: 1.1rem;
}

.tile-content {
    display: flex;
    flex-direction: column;
    min-width: 0;
}

.tile-label {
    font-size: 0.78rem;
    color: inherit;
    opacity: 0.6;
    margin-bottom: 0.15rem;
    font-weight: 500;
}

.tile-value {
    font-size: 0.92rem;
    font-weight: 600;
    color: inherit;
    opacity: 0.95;
}

/* Legacy role card styles */
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

