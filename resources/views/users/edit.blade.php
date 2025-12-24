@extends('layouts.app')

@section('title', 'تعديل مستخدم')

@section('content')
    <div class="mb-4">
        <h2><i class="bi bi-pencil-square me-2"></i>تعديل مستخدم</h2>
    </div>

    <div class="card">
        <div class="card-header">
            <h5 class="mb-0">بيانات المستخدم</h5>
        </div>
        <div class="card-body">
            <form action="{{ route('users.update', $user) }}" method="POST">
                @csrf
                @method('PUT')

                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label for="name" class="form-label">الاسم <span class="text-danger">*</span></label>
                        <input type="text" class="form-control @error('name') is-invalid @enderror" id="name"
                            name="name" value="{{ old('name', $user->name) }}" required>
                        @error('name')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="col-md-6 mb-3">
                        <label for="email" class="form-label">البريد الإلكتروني <span
                                class="text-danger">*</span></label>
                        <input type="email" class="form-control @error('email') is-invalid @enderror" id="email"
                            name="email" value="{{ old('email', $user->email) }}" required>
                        @error('email')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label for="password" class="form-label">كلمة المرور الجديدة</label>
                        <input type="password" class="form-control @error('password') is-invalid @enderror" id="password"
                            name="password">
                        @error('password')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                        <small class="text-muted">اتركها فارغة إذا كنت لا تريد تغييرها</small>
                    </div>

                    <div class="col-md-6 mb-3">
                        <label for="password_confirmation" class="form-label">تأكيد كلمة المرور</label>
                        <input type="password" class="form-control" id="password_confirmation"
                            name="password_confirmation">
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label for="role" class="form-label">الدور <span class="text-danger">*</span></label>
                        <select class="form-select @error('role') is-invalid @enderror" id="role" name="role"
                            required>
                            <option value="">اختر الدور...</option>
                            <option value="admin" {{ old('role', $user->role) === 'admin' ? 'selected' : '' }}>مدير
                            </option>
                            <option value="staff" {{ old('role', $user->role) === 'staff' ? 'selected' : '' }}>موظف
                            </option>
                        </select>
                        @error('role')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="col-md-6 mb-3">
                        <label class="form-label">الحالة</label>
                        <div class="form-check form-switch">
                            <input class="form-check-input" type="checkbox" id="is_active" name="is_active"
                                {{ old('is_active', $user->is_active) ? 'checked' : '' }}>
                            <label class="form-check-label" for="is_active">
                                المستخدم نشط
                            </label>
                        </div>
                    </div>
                </div>

                <div class="d-flex gap-2">
                    <button type="submit" class="btn btn-primary">
                        <i class="bi bi-check-circle me-2"></i>حفظ التغييرات
                    </button>
                    <a href="{{ route('users.index') }}" class="btn btn-secondary">
                        <i class="bi bi-x-circle me-2"></i>إلغاء
                    </a>
                </div>
            </form>
        </div>
    </div>
@endsection
