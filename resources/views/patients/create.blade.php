@extends('layouts.app')

@section('title', 'إضافة مريض جديد')

@section('content')
    <div class="container-fluid">
        <div class="row mb-4">
            <div class="col-12">
                <h2 class="fw-bold text-dark">إضافة مريض جديد</h2>
                <p class="text-muted">الحقول المطلوبة فقط: الاسم ورقم الهاتف</p>
            </div>
        </div>

        <div class="row">
            <div class="col-lg-8">
                <div class="card">
                    <div class="card-header">
                        <h5 class="mb-0"><i class="bi bi-person-plus me-2"></i>بيانات المريض</h5>
                    </div>
                    <div class="card-body">
                        <form action="{{ route('patients.store') }}" method="POST">
                            @csrf

                            <!-- Required Fields Section -->
                            <div class="alert alert-info">
                                <i class="bi bi-info-circle me-2"></i>
                                <strong>الحقول الأساسية (مطلوبة)</strong>
                            </div>

                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label for="name" class="form-label">الاسم الكامل <span
                                            class="text-danger">*</span></label>
                                    <input type="text" class="form-control @error('name') is-invalid @enderror" id="name"
                                        name="name" value="{{ old('name') }}" required autofocus>
                                    @error('name')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="col-md-6 mb-3">
                                    <label for="phone" class="form-label">رقم الهاتف <span
                                            class="text-danger">*</span></label>
                                    <input type="text" class="form-control @error('phone') is-invalid @enderror" id="phone"
                                        name="phone" value="{{ old('phone') }}" required>
                                    @error('phone')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <!-- Optional Fields Section (Collapsible) -->
                            <div class="mt-4">
                                <button class="btn btn-outline-secondary btn-sm" type="button" data-bs-toggle="collapse"
                                    data-bs-target="#optionalFields" aria-expanded="false">
                                    <i class="bi bi-plus-circle me-1"></i>
                                    إضافة معلومات إضافية (اختياري)
                                </button>
                            </div>

                            <div class="collapse mt-3" id="optionalFields">
                                <div class="alert alert-secondary">
                                    <i class="bi bi-info-circle me-2"></i>
                                    هذه الحقول اختيارية ويمكن إضافتها لاحقاً
                                </div>

                                <div class="row">
                                    <div class="col-md-6 mb-3">
                                        <label for="national_id" class="form-label">الرقم القومي</label>
                                        <input type="text" class="form-control @error('national_id') is-invalid @enderror"
                                            id="national_id" name="national_id" value="{{ old('national_id') }}">
                                        @error('national_id')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <div class="col-md-6 mb-3">
                                        <label for="email" class="form-label">البريد الإلكتروني</label>
                                        <input type="email" class="form-control @error('email') is-invalid @enderror"
                                            id="email" name="email" value="{{ old('email') }}">
                                        @error('email')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-md-6 mb-3">
                                        <label for="date_of_birth" class="form-label">تاريخ الميلاد</label>
                                        <input type="date" class="form-control @error('date_of_birth') is-invalid @enderror"
                                            id="date_of_birth" name="date_of_birth" value="{{ old('date_of_birth') }}">
                                        @error('date_of_birth')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <div class="col-md-6 mb-3">
                                        <label for="gender" class="form-label">الجنس</label>
                                        <select class="form-select @error('gender') is-invalid @enderror" id="gender"
                                            name="gender">
                                            <option value="">اختر الجنس</option>
                                            <option value="male" {{ old('gender') == 'male' ? 'selected' : '' }}>ذكر</option>
                                            <option value="female" {{ old('gender') == 'female' ? 'selected' : '' }}>أنثى
                                            </option>
                                        </select>
                                        @error('gender')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-md-6 mb-3">
                                        <label for="blood_type" class="form-label">فصيلة الدم</label>
                                        <select class="form-select @error('blood_type') is-invalid @enderror"
                                            id="blood_type" name="blood_type">
                                            <option value="">اختر فصيلة الدم</option>
                                            <option value="A+" {{ old('blood_type') == 'A+' ? 'selected' : '' }}>A+</option>
                                            <option value="A-" {{ old('blood_type') == 'A-' ? 'selected' : '' }}>A-</option>
                                            <option value="B+" {{ old('blood_type') == 'B+' ? 'selected' : '' }}>B+</option>
                                            <option value="B-" {{ old('blood_type') == 'B-' ? 'selected' : '' }}>B-</option>
                                            <option value="AB+" {{ old('blood_type') == 'AB+' ? 'selected' : '' }}>AB+
                                            </option>
                                            <option value="AB-" {{ old('blood_type') == 'AB-' ? 'selected' : '' }}>AB-
                                            </option>
                                            <option value="O+" {{ old('blood_type') == 'O+' ? 'selected' : '' }}>O+</option>
                                            <option value="O-" {{ old('blood_type') == 'O-' ? 'selected' : '' }}>O-</option>
                                        </select>
                                        @error('blood_type')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <div class="col-md-6 mb-3">
                                        <label for="address" class="form-label">العنوان</label>
                                        <input type="text" class="form-control @error('address') is-invalid @enderror"
                                            id="address" name="address" value="{{ old('address') }}">
                                        @error('address')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>

                                <div class="mb-3">
                                    <label for="allergies" class="form-label">الحساسية</label>
                                    <textarea class="form-control @error('allergies') is-invalid @enderror" id="allergies"
                                        name="allergies" rows="3">{{ old('allergies') }}</textarea>
                                    @error('allergies')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                    <small class="text-muted">اذكر أي حساسية للأدوية أو الأطعمة</small>
                                </div>
                            </div>

                            <div class="d-flex gap-2 mt-4">
                                <button type="submit" class="btn btn-primary">
                                    <i class="bi bi-check-circle me-2"></i>حفظ
                                </button>
                                <a href="{{ route('patients.index') }}" class="btn btn-secondary">
                                    <i class="bi bi-x-circle me-2"></i>إلغاء
                                </a>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection