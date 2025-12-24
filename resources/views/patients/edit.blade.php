@extends('layouts.app')

@section('title', 'تعديل بيانات المريض')

@section('content')
    <div class="container-fluid">
        <div class="row mb-4">
            <div class="col-12">
                <h2 class="fw-bold text-dark">تعديل بيانات المريض</h2>
                <p class="text-muted">تحديث معلومات المريض: {{ $patient->name }}</p>
            </div>
        </div>

        <div class="row">
            <div class="col-lg-8">
                <div class="card">
                    <div class="card-header">
                        <h5 class="mb-0"><i class="bi bi-pencil me-2"></i>تعديل البيانات</h5>
                    </div>
                    <div class="card-body">
                        <form action="{{ route('patients.update', $patient->id) }}" method="POST">
                            @csrf
                            @method('PUT')

                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label for="name" class="form-label">الاسم الكامل <span
                                            class="text-danger">*</span></label>
                                    <input type="text" class="form-control @error('name') is-invalid @enderror" id="name"
                                        name="name" value="{{ old('name', $patient->name) }}" required>
                                    @error('name')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="col-md-6 mb-3">
                                    <label for="national_id" class="form-label">الرقم القومي</label>
                                    <input type="text" class="form-control @error('national_id') is-invalid @enderror"
                                        id="national_id" name="national_id"
                                        value="{{ old('national_id', $patient->national_id) }}">
                                    @error('national_id')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label for="phone" class="form-label">رقم الهاتف <span
                                            class="text-danger">*</span></label>
                                    <input type="text" class="form-control @error('phone') is-invalid @enderror" id="phone"
                                        name="phone" value="{{ old('phone', $patient->phone) }}" required>
                                    @error('phone')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="col-md-6 mb-3">
                                    <label for="email" class="form-label">البريد الإلكتروني</label>
                                    <input type="email" class="form-control @error('email') is-invalid @enderror" id="email"
                                        name="email" value="{{ old('email', $patient->email) }}">
                                    @error('email')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label for="date_of_birth" class="form-label">تاريخ الميلاد <span
                                            class="text-danger">*</span></label>
                                    <input type="date" class="form-control @error('date_of_birth') is-invalid @enderror"
                                        id="date_of_birth" name="date_of_birth"
                                        value="{{ old('date_of_birth', $patient->date_of_birth) }}" required>
                                    @error('date_of_birth')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="col-md-6 mb-3">
                                    <label for="gender" class="form-label">الجنس <span class="text-danger">*</span></label>
                                    <select class="form-select @error('gender') is-invalid @enderror" id="gender"
                                        name="gender" required>
                                        <option value="">اختر الجنس</option>
                                        <option value="male" {{ old('gender', $patient->gender) == 'male' ? 'selected' : '' }}>ذكر</option>
                                        <option value="female" {{ old('gender', $patient->gender) == 'female' ? 'selected' : '' }}>أنثى</option>
                                    </select>
                                    @error('gender')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label for="blood_type" class="form-label">فصيلة الدم</label>
                                    <select class="form-select @error('blood_type') is-invalid @enderror" id="blood_type"
                                        name="blood_type">
                                        <option value="">اختر فصيلة الدم</option>
                                        <option value="A+" {{ old('blood_type', $patient->blood_type) == 'A+' ? 'selected' : '' }}>A+</option>
                                        <option value="A-" {{ old('blood_type', $patient->blood_type) == 'A-' ? 'selected' : '' }}>A-</option>
                                        <option value="B+" {{ old('blood_type', $patient->blood_type) == 'B+' ? 'selected' : '' }}>B+</option>
                                        <option value="B-" {{ old('blood_type', $patient->blood_type) == 'B-' ? 'selected' : '' }}>B-</option>
                                        <option value="AB+" {{ old('blood_type', $patient->blood_type) == 'AB+' ? 'selected' : '' }}>AB+</option>
                                        <option value="AB-" {{ old('blood_type', $patient->blood_type) == 'AB-' ? 'selected' : '' }}>AB-</option>
                                        <option value="O+" {{ old('blood_type', $patient->blood_type) == 'O+' ? 'selected' : '' }}>O+</option>
                                        <option value="O-" {{ old('blood_type', $patient->blood_type) == 'O-' ? 'selected' : '' }}>O-</option>
                                    </select>
                                    @error('blood_type')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="col-md-6 mb-3">
                                    <label for="address" class="form-label">العنوان</label>
                                    <input type="text" class="form-control @error('address') is-invalid @enderror"
                                        id="address" name="address" value="{{ old('address', $patient->address) }}">
                                    @error('address')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <div class="mb-3">
                                <label for="allergies" class="form-label">الحساسية</label>
                                <textarea class="form-control @error('allergies') is-invalid @enderror" id="allergies"
                                    name="allergies" rows="3">{{ old('allergies', $patient->allergies) }}</textarea>
                                @error('allergies')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="d-flex gap-2">
                                <button type="submit" class="btn btn-primary">
                                    <i class="bi bi-check-circle me-2"></i>تحديث
                                </button>
                                <a href="{{ route('patients.show', $patient->id) }}" class="btn btn-secondary">
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