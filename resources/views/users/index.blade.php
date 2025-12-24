@extends('layouts.app')

@section('title', 'إدارة المستخدمين')

@section('content')
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2><i class="bi bi-people-fill me-2"></i>إدارة المستخدمين</h2>
        <a href="{{ route('users.create') }}" class="btn btn-primary">
            <i class="bi bi-plus-circle me-2"></i>إضافة مستخدم جديد
        </a>
    </div>

    <div class="card">
        <div class="card-header">
            <h5 class="mb-0">قائمة المستخدمين</h5>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-hover">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>الاسم</th>
                            <th>البريد الإلكتروني</th>
                            <th>الدور</th>
                            <th>الحالة</th>
                            <th>تاريخ الإنشاء</th>
                            <th>الإجراءات</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($users as $user)
                            <tr>
                                <td>{{ $user->id }}</td>
                                <td>
                                    <i class="bi bi-person-circle me-2"></i>
                                    {{ $user->name }}
                                </td>
                                <td>{{ $user->email }}</td>
                                <td>
                                    @if ($user->role === 'admin')
                                        <span class="badge bg-danger">
                                            <i class="bi bi-shield-fill-check me-1"></i>مدير
                                        </span>
                                    @else
                                        <span class="badge bg-info">
                                            <i class="bi bi-person-badge me-1"></i>موظف
                                        </span>
                                    @endif
                                </td>
                                <td>
                                    @if ($user->is_active)
                                        <span class="badge bg-success">
                                            <i class="bi bi-check-circle me-1"></i>نشط
                                        </span>
                                    @else
                                        <span class="badge bg-secondary">
                                            <i class="bi bi-x-circle me-1"></i>معطل
                                        </span>
                                    @endif
                                </td>
                                <td>{{ $user->created_at->format('Y-m-d') }}</td>
                                <td>
                                    <div class="btn-group" role="group">
                                        <a href="{{ route('users.edit', $user) }}" class="btn btn-sm btn-warning">
                                            <i class="bi bi-pencil"></i>
                                        </a>
                                        @if ($user->id !== auth()->id())
                                            <form action="{{ route('users.destroy', $user) }}" method="POST" class="d-inline"
                                                onsubmit="return confirm('هل أنت متأكد من تعطيل هذا المستخدم؟')">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-sm btn-danger">
                                                    <i class="bi bi-trash"></i>
                                                </button>
                                            </form>
                                        @endif
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="7" class="text-center py-4">
                                    <i class="bi bi-inbox fs-1 text-muted d-block mb-2"></i>
                                    لا توجد مستخدمين
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection