@extends('admin.layouts.app')

@section('content')
<div class="content-header row">
    <div class="content-header-left col-md-9 col-12 mb-2">
        <div class="row breadcrumbs-top">
            <div class="col-12">
                <h2 class="content-header-title float-left mb-0" style="color: #70B9BE; font-weight: bold;">إدارة المستخدمين</h2>
                <div class="breadcrumb-wrapper col-12">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{ route('admin.index') }}">الرئيسية</a></li>
                        <li class="breadcrumb-item active">المستخدمين</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>
    <div class="content-header-right text-md-right col-md-3 col-12 d-md-block d-none">
        <div class="form-group breadcrumb-right">
            <a href="{{ route('admin.users.create') }}" class="btn btn-primary">
                <i class="fa-solid fa-plus"></i> إضافة مستخدم جديد
            </a>
        </div>
    </div>
</div>

<!-- Statistics Cards -->
<div class="row">
    <div class="col-lg-3 col-sm-6 col-12">
        <div class="card">
            <div class="card-header d-flex align-items-start pb-0">
                <div>
                    <h2 class="fw-bolder mb-0">{{ $stats['total'] }}</h2>
                    <p class="card-text">إجمالي المستخدمين</p>
                </div>
                <div class="avatar bg-light-primary p-50 m-0">
                    <div class="avatar-content">
                        <i class="fa-solid fa-users text-primary font-medium-5"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-lg-3 col-sm-6 col-12">
        <div class="card">
            <div class="card-header d-flex align-items-start pb-0">
                <div>
                    <h2 class="fw-bolder mb-0">{{ $stats['active'] }}</h2>
                    <p class="card-text">المستخدمين النشطين</p>
                </div>
                <div class="avatar bg-light-success p-50 m-0">
                    <div class="avatar-content">
                        <i class="fa-solid fa-user-check text-success font-medium-5"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-lg-3 col-sm-6 col-12">
        <div class="card">
            <div class="card-header d-flex align-items-start pb-0">
                <div>
                    <h2 class="fw-bolder mb-0">{{ $stats['inactive'] }}</h2>
                    <p class="card-text">المستخدمين غير النشطين</p>
                </div>
                <div class="avatar bg-light-warning p-50 m-0">
                    <div class="avatar-content">
                        <i class="fa-solid fa-user-times text-warning font-medium-5"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-lg-3 col-sm-6 col-12">
        <div class="card">
            <div class="card-header d-flex align-items-start pb-0">
                <div>
                    <h2 class="fw-bolder mb-0">{{ $stats['with_roles'] }}</h2>
                    <p class="card-text">المستخدمين ذوي الصلاحيات</p>
                </div>
                <div class="avatar bg-light-info p-50 m-0">
                    <div class="avatar-content">
                        <i class="fa-solid fa-user-shield text-info font-medium-5"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Users Table -->
<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-header">
                <h4 class="card-title">قائمة المستخدمين</h4>
                <div class="card-tools">
                    <!-- Search and Filters -->
                    <form method="GET" action="{{ route('admin.users.index') }}" class="d-flex align-items-center gap-2">
                        <div class="input-group input-group-sm" style="width: 200px;">
                            <input type="text" name="search" value="{{ request('search') }}" class="form-control" placeholder="البحث...">
                            <div class="input-group-append">
                                <button type="submit" class="btn btn-outline-secondary">
                                    <i class="fa-solid fa-search"></i>
                                </button>
                            </div>
                        </div>
                        
                        <select name="role" class="form-control form-control-sm" style="width: 150px;">
                            <option value="">جميع الصلاحيات</option>
                            @foreach($roles as $roleName => $roleDisplay)
                                <option value="{{ $roleName }}" {{ request('role') == $roleName ? 'selected' : '' }}>
                                    {{ $roleDisplay }}
                                </option>
                            @endforeach
                        </select>
                        
                        <select name="status" class="form-control form-control-sm" style="width: 120px;">
                            <option value="">جميع الحالات</option>
                            <option value="1" {{ request('status') == '1' ? 'selected' : '' }}>نشط</option>
                            <option value="0" {{ request('status') == '0' ? 'selected' : '' }}>غير نشط</option>
                        </select>
                        
                        <select name="sort_by" class="form-control form-control-sm" style="width: 120px;">
                            <option value="created_at" {{ request('sort_by') == 'created_at' ? 'selected' : '' }}>تاريخ الإنشاء</option>
                            <option value="name" {{ request('sort_by') == 'name' ? 'selected' : '' }}>الاسم</option>
                            <option value="email" {{ request('sort_by') == 'email' ? 'selected' : '' }}>البريد الإلكتروني</option>
                            <option value="updated_at" {{ request('sort_by') == 'updated_at' ? 'selected' : '' }}>آخر تحديث</option>
                        </select>
                        
                        <select name="sort_order" class="form-control form-control-sm" style="width: 100px;">
                            <option value="desc" {{ request('sort_order') == 'desc' ? 'selected' : '' }}>تنازلي</option>
                            <option value="asc" {{ request('sort_order') == 'asc' ? 'selected' : '' }}>تصاعدي</option>
                        </select>
                        
                        <button type="submit" class="btn btn-primary btn-sm">
                            <i class="fa-solid fa-filter"></i> تطبيق
                        </button>
                        
                        @if(request()->hasAny(['search', 'role', 'status', 'sort_by', 'sort_order']))
                            <a href="{{ route('admin.users.index') }}" class="btn btn-secondary btn-sm">
                                <i class="fa-solid fa-times"></i> مسح
                            </a>
                        @endif
                    </form>
                </div>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-striped table-hover">
                        <thead class="thead-dark">
                            <tr>
                                <th>#</th>
                                <th>الصورة</th>
                                <th>
                                    <a href="{{ request()->fullUrlWithQuery(['sort_by' => 'name', 'sort_order' => request('sort_by') == 'name' && request('sort_order') == 'asc' ? 'desc' : 'asc']) }}" 
                                       class="text-white text-decoration-none">
                                        اسم المستخدم
                                        @if(request('sort_by') == 'name')
                                            <i class="fa-solid fa-sort-{{ request('sort_order') == 'asc' ? 'up' : 'down' }}"></i>
                                        @endif
                                    </a>
                                </th>
                                <th>
                                    <a href="{{ request()->fullUrlWithQuery(['sort_by' => 'email', 'sort_order' => request('sort_by') == 'email' && request('sort_order') == 'asc' ? 'desc' : 'asc']) }}" 
                                       class="text-white text-decoration-none">
                                        البريد الإلكتروني
                                        @if(request('sort_by') == 'email')
                                            <i class="fa-solid fa-sort-{{ request('sort_order') == 'asc' ? 'up' : 'down' }}"></i>
                                        @endif
                                    </a>
                                </th>
                                <th>الصلاحيات</th>
                                <th>الحالة</th>
                                <th>
                                    <a href="{{ request()->fullUrlWithQuery(['sort_by' => 'created_at', 'sort_order' => request('sort_by') == 'created_at' && request('sort_order') == 'asc' ? 'desc' : 'asc']) }}" 
                                       class="text-white text-decoration-none">
                                        تاريخ الإنشاء
                                        @if(request('sort_by') == 'created_at' || !request('sort_by'))
                                            <i class="fa-solid fa-sort-{{ request('sort_order') == 'asc' ? 'up' : 'down' }}"></i>
                                        @endif
                                    </a>
                                </th>
                                <th>الإجراءات</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($users as $user)
                                <tr>
                                    <td>{{ ($users->currentPage() - 1) * $users->perPage() + $loop->iteration }}</td>
                                    <td>
                                        <div class="avatar bg-light-primary">
                                            <div class="avatar-content">
                                                <i class="fa-solid fa-user text-primary"></i>
                                            </div>
                                        </div>
                                    </td>
                                    <td>
                                        <div class="d-flex flex-column">
                                            <h6 class="mb-0">{{ $user->name }}</h6>
                                            <small class="text-muted">ID: {{ $user->id }}</small>
                                        </div>
                                    </td>
                                    <td>
                                        <div class="d-flex flex-column">
                                            <span>{{ $user->email }}</span>
                                            @if($user->email_verified_at)
                                                <small class="text-success">
                                                    <i class="fa-solid fa-check-circle"></i> محقق
                                                </small>
                                            @else
                                                <small class="text-warning">
                                                    <i class="fa-solid fa-exclamation-circle"></i> غير محقق
                                                </small>
                                            @endif
                                        </div>
                                    </td>
                                    <td>
                                        @if($user->roles->count() > 0)
                                            @foreach($user->roles as $role)
                                                <span class="badge badge-light-info">{{ $role->name }}</span>
                                            @endforeach
                                        @else
                                            <span class="badge badge-light-secondary">بدون صلاحيات</span>
                                        @endif
                                    </td>
                                    <td>
                                        @if($user->active ?? true)
                                            <span class="badge badge-success">نشط</span>
                                        @else
                                            <span class="badge badge-danger">غير نشط</span>
                                        @endif
                                    </td>
                                    <td>
                                        <small class="text-muted">{{ $user->created_at->format('Y-m-d') }}</small>
                                    </td>
                                    <td>
                                        <div class="btn-group" role="group">
                                            <a href="{{ route('admin.users.show', $user->id) }}" 
                                               class="btn btn-sm btn-info" 
                                               data-toggle="tooltip" 
                                               title="عرض التفاصيل">
                                                <i class="fa-solid fa-eye"></i>
                                            </a>
                                            <a href="{{ route('admin.users.edit', $user->id) }}" 
                                               class="btn btn-sm btn-warning" 
                                               data-toggle="tooltip" 
                                               title="تعديل">
                                                <i class="fa-solid fa-edit"></i>
                                            </a>
                                            @if($user->id !== Auth::id())
                                                <button type="button" 
                                                        class="btn btn-sm btn-danger" 
                                                        data-toggle="modal" 
                                                        data-target="#deleteModal{{ $user->id }}"
                                                        title="حذف">
                                                    <i class="fa-solid fa-trash"></i>
                                                </button>
                                            @else
                                                <button type="button" 
                                                        class="btn btn-sm btn-secondary" 
                                                        disabled
                                                        title="لا يمكن حذف المستخدم الحالي">
                                                    <i class="fa-solid fa-lock"></i>
                                                </button>
                                            @endif
                                        </div>
                                    </td>
                                </tr>

                                <!-- Delete Modal -->
                                <div class="modal fade" id="deleteModal{{ $user->id }}" tabindex="-1" role="dialog">
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
                            @empty
                                <tr>
                                    <td colspan="8" class="text-center">
                                        <div class="py-4">
                                            <i class="fa-solid fa-users fa-3x text-muted mb-3"></i>
                                            <h5 class="text-muted">لا توجد مستخدمين</h5>
                                            <p class="text-muted">ابدأ بإضافة مستخدم جديد</p>
                                            <a href="{{ route('admin.users.create') }}" class="btn btn-primary">
                                                <i class="fa-solid fa-plus"></i> إضافة مستخدم جديد
                                            </a>
                                        </div>
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
                
                @if($users->hasPages())
                    <div class="d-flex justify-content-between align-items-center mt-3">
                        <div class="pagination-info">
                            <span class="text-muted">
                                عرض {{ ($users->currentPage() - 1) * $users->perPage() + 1 }} إلى 
                                {{ min($users->currentPage() * $users->perPage(), $users->total()) }} 
                                من أصل {{ $users->total() }} مستخدم
                            </span>
                        </div>
                        <div class="pagination-links">
                            {{ $users->appends(request()->query())->links() }}
                        </div>
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script>
    $(document).ready(function() {
        // Initialize tooltips
        $('[data-toggle="tooltip"]').tooltip();
        
        // Auto-submit form on filter change (only for main filter form, not modal forms)
        $('.card-tools form select[name="role"], .card-tools form select[name="status"], .card-tools form select[name="sort_by"], .card-tools form select[name="sort_order"]').on('change', function() {
            // Only submit if it's not inside a modal
            if (!$(this).closest('.modal').length) {
                console.log('Filter changed, submitting main form...');
                $(this).closest('form').submit();
            }
        });
        
        // Image preview on hover
        $('.img-thumbnail').hover(
            function() {
                $(this).css('transform', 'scale(1.1)');
            },
            function() {
                $(this).css('transform', 'scale(1)');
            }
        );
    });
</script>
@endpush
@endsection