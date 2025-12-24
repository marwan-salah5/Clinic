@extends('layouts.app')

@section('title', 'إضافة سجل مرضي')

@section('content')
    <div class="container-fluid">
        <div class="row mb-4">
            <div class="col-12">
                <h2 class="fw-bold text-dark">إضافة سجل مرضي</h2>
                <p class="text-muted">تسجيل زيارة طبية جديدة</p>
            </div>
        </div>

        <div class="row">
            <div class="col-lg-10">
                <div class="card">
                    <div class="card-header">
                        <h5 class="mb-0"><i class="bi bi-file-medical-fill me-2"></i>تفاصيل الزيارة</h5>
                    </div>
                    <div class="card-body">
                        <form action="{{ route('medical-history.store') }}" method="POST">
                            @csrf

                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label for="patient_id" class="form-label">المريض <span
                                            class="text-danger">*</span></label>
                                    <select class="form-select @error('patient_id') is-invalid @enderror" id="patient_id"
                                        name="patient_id" required>
                                        <option value="">اختر المريض</option>
                                        @foreach($patients as $patient)
                                            <option value="{{ $patient->id }}" {{ old('patient_id') == $patient->id ? 'selected' : '' }}>
                                                {{ $patient->name }}
                                            </option>
                                        @endforeach
                                    </select>
                                    @error('patient_id')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="col-md-6 mb-3">
                                    <label for="user_id" class="form-label">الطبيب <span
                                            class="text-danger">*</span></label>
                                    <select class="form-select @error('user_id') is-invalid @enderror" id="user_id"
                                        name="user_id" required>
                                        <option value="">اختر الطبيب</option>
                                        @foreach($doctors as $doctor)
                                            <option value="{{ $doctor->id }}" {{ old('user_id') == $doctor->id ? 'selected' : '' }}>
                                                {{ $doctor->name }}
                                            </option>
                                        @endforeach
                                    </select>
                                    @error('user_id')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <div class="mb-3">
                                <label for="visit_date" class="form-label">تاريخ الزيارة <span
                                        class="text-danger">*</span></label>
                                <input type="date" class="form-control @error('visit_date') is-invalid @enderror"
                                    id="visit_date" name="visit_date" value="{{ old('visit_date', date('Y-m-d')) }}"
                                    required>
                                @error('visit_date')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="mb-3">
                                <label for="symptoms" class="form-label">الأعراض (Symptoms)</label>
                                <textarea class="form-control @error('symptoms') is-invalid @enderror" id="symptoms"
                                    name="symptoms" rows="3">{{ old('symptoms') }}</textarea>
                                @error('symptoms')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="mb-3">
                                <label for="diagnosis" class="form-label">التشخيص (Diagnosis) <span
                                        class="text-danger">*</span></label>
                                <textarea class="form-control @error('diagnosis') is-invalid @enderror" id="diagnosis"
                                    name="diagnosis" rows="3" required>{{ old('diagnosis') }}</textarea>
                                @error('diagnosis')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="mb-3">
                                <label for="treatment" class="form-label">العلاج (Treatment)</label>
                                <textarea class="form-control @error('treatment') is-invalid @enderror" id="treatment"
                                    name="treatment" rows="3">{{ old('treatment') }}</textarea>
                                @error('treatment')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="mb-3">
                                <label for="prescriptions" class="form-label">الوصفة الطبية (Prescriptions)</label>
                                <textarea class="form-control @error('prescriptions') is-invalid @enderror"
                                    id="prescriptions" name="prescriptions" rows="3">{{ old('prescriptions') }}</textarea>
                                @error('prescriptions')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="mb-3">
                                <label for="notes" class="form-label">ملاحظات إضافية</label>
                                <textarea class="form-control @error('notes') is-invalid @enderror" id="notes" name="notes"
                                    rows="2">{{ old('notes') }}</textarea>
                                @error('notes')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="d-flex gap-2">
                                <button type="submit" class="btn btn-primary">
                                    <i class="bi bi-check-circle me-2"></i>حفظ السجل
                                </button>
                                <a href="{{ route('medical-history.index') }}" class="btn btn-secondary">
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