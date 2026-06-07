@extends('admin.layouts.app')

@section('title', 'إدارة الدعم الفني')

@section('content')
<div class="content-header row mb-2">
    <div class="col-12">
        <h2 class="content-header-title" style="color: #B79C6D;">رسائل الدعم الفني</h2>
    </div>
</div>

@if(session('success'))
    <div class="alert alert-success">{{ session('success') }}</div>
@endif

<div class="card mb-3">
    <div class="card-body">
        <form method="GET" class="row g-2 align-items-end">
            <div class="col-md-4">
                <input type="text" name="search" class="form-control" placeholder="بحث بالعنوان أو الاسم أو البريد..."
                    value="{{ request('search') }}">
            </div>
            <div class="col-md-2">
                <button type="submit" class="btn btn-primary w-100">تصفية</button>
            </div>
        </form>
    </div>
</div>

<div class="card">
    <div class="card-body table-responsive">
        <table class="table align-middle">
            <thead>
                <tr>
                    <th>#</th>
                    <th>العنوان</th>
                    <th>الرسالة</th>
                    <th>اسم المرسل</th>
                    <th>بريد المرسل</th>
                    <th>التاريخ</th>
                    <th>إجراء</th>
                </tr>
            </thead>
            <tbody>
                @forelse($supports as $support)
                    <tr>
                        <td>{{ ($supports->currentPage() - 1) * $supports->perPage() + $loop->iteration }}</td>
                        <td>{{ $support->title ?? '-' }}</td>
                        <td>{{ Str::limit($support->message, 50) }}</td>
                        <td>{{ $support->sender_name ?? '-' }}</td>
                        <td>{{ $support->sender_email ?? '-' }}</td>
                        <td>{{ $support->created_at->format('Y-m-d') }}</td>
                        <td>
                            <a href="{{ route('admin.supports.show', $support->id) }}" class="btn btn-sm btn-info">
                                <i class="fa-solid fa-eye"></i>
                            </a>
                            <form action="{{ route('admin.supports.destroy', $support->id) }}" method="POST" class="d-inline" onsubmit="return confirm('هل أنت متأكد من الحذف؟');">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-sm btn-danger">
                                    <i class="fa-solid fa-trash"></i>
                                </button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="7" class="text-center py-4 text-muted">لا توجد رسائل دعم</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
        {{ $supports->links() }}
    </div>
</div>
@endsection
