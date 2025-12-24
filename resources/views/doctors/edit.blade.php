@extends('layouts.app')

@section('title', 'تعديل بيانات الطبيب')

@section('content')
    <div class="container-fluid">
        <div class="row mb-4">
            <div class="col-12">
                <h2 class="fw-bold text-dark">تعديل بيانات الطبيب</h2>
                <p class="text-muted">تحديث معلومات الطبيب</p>
            </div>
        </div>

        <div class="row">
            <div class="col-lg-8">
                <div class="card">
                    <div class="card-header">
                        <h5 class="mb-0"><i class="bi bi-pencil-square me-2"></i>بيانات الطبيب</h5>
                    </div>
                    <div class="card-body">
                        <form action="{{ route('doctors.update', $doctor) }}" method="POST">
                            @csrf
                            @method('PUT')

                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label for="name" class="form-label">الاسم الكامل <span
                                            class="text-danger">*</span></label>
                                    <input type="text" class="form-control @error('name') is-invalid @enderror" id="name"
                                        name="name" value="{{ old('name', $doctor->name) }}" required>
                                    @error('name')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="col-md-6 mb-3">
                                    <label for="specialization" class="form-label">التخصص <span
                                            class="text-danger">*</span></label>
                                    <input type="text" class="form-control @error('specialization') is-invalid @enderror"
                                        id="specialization" name="specialization"
                                        value="{{ old('specialization', $doctor->specialization) }}" required>
                                    @error('specialization')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label for="phone" class="form-label">رقم الهاتف <span
                                            class="text-danger">*</span></label>
                                    <input type="text" class="form-control @error('phone') is-invalid @enderror" id="phone"
                                        name="phone" value="{{ old('phone', $doctor->phone) }}" required>
                                    @error('phone')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="col-md-6 mb-3">
                                    <label for="email" class="form-label">البريد الإلكتروني</label>
                                    <input type="email" class="form-control @error('email') is-invalid @enderror" id="email"
                                        name="email" value="{{ old('email', $doctor->email) }}">
                                    @error('email')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                    <small class="text-muted">اختياري</small>
                                </div>
                            </div>

                            <div class="d-flex gap-2">
                                <button type="submit" class="btn btn-primary">
                                    <i class="bi bi-check-circle me-2"></i>حفظ التعديلات
                                </button>
                                <a href="{{ route('doctors.index') }}" class="btn btn-secondary">
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