@extends('layouts.app')

@section('title', 'تفاصيل الموعد')

@section('content')
    <div class="container-fluid">
        <div class="row mb-4">
            <div class="col-md-6">
                <h2 class="fw-bold text-dark">تفاصيل الموعد #{{ $appointment->id }}</h2>
                <p class="text-muted">عرض معلومات الموعد</p>
            </div>
            <div class="col-md-6 text-end">
                <a href="{{ route('appointments.edit', $appointment->id) }}" class="btn btn-warning">
                    <i class="bi bi-pencil me-2"></i>تعديل
                </a>
                <a href="{{ route('appointments.index') }}" class="btn btn-secondary">
                    <i class="bi bi-arrow-right me-2"></i>العودة
                </a>
            </div>
        </div>

        <div class="row">
            <div class="col-lg-8">
                <div class="card mb-4">
                    <div class="card-header">
                        <h5 class="mb-0"><i class="bi bi-info-circle me-2"></i>المعلومات الأساسية</h5>
                    </div>
                    <div class="card-body">
                        <div class="row mb-3">
                            <div class="col-md-6">
                                <label class="text-muted small">المريض</label>
                                <p class="fw-bold">
                                    <a href="{{ route('patients.show', $appointment->patient_id) }}"
                                        class="text-decoration-none">
                                        {{ $appointment->patient->name }}
                                    </a>
                                </p>
                            </div>
                            <div class="col-md-6">
                                <label class="text-muted small">الطبيب</label>
                                <p class="fw-bold">{{ $appointment->doctor->name }}</p>
                            </div>
                        </div>

                        <div class="row mb-3">
                            <div class="col-md-6">
                                <label class="text-muted small">التاريخ</label>
                                <p class="fw-bold">{{ $appointment->appointment_date->format('Y-m-d') }}</p>
                            </div>
                            <div class="col-md-6">
                                <label class="text-muted small">الوقت</label>
                                <p class="fw-bold">{{ $appointment->appointment_time->format('h:i A') }}</p>
                            </div>
                        </div>

                        <div class="mb-3">
                            <label class="text-muted small">الحالة</label>
                            <div>
                                @if($appointment->status == 'pending')
                                    <span class="badge bg-warning fs-6">معلق</span>
                                @elseif($appointment->status == 'confirmed')
                                    <span class="badge bg-success fs-6">مؤكد</span>
                                @elseif($appointment->status == 'completed')
                                    <span class="badge bg-info fs-6">مكتمل</span>
                                @else
                                    <span class="badge bg-danger fs-6">ملغي</span>
                                @endif
                            </div>
                        </div>

                        <div class="mb-3">
                            <label class="text-muted small">سبب الزيارة</label>
                            <p class="fw-bold">{{ $appointment->reason ?? 'لا يوجد' }}</p>
                        </div>

                        <div class="mb-0">
                            <label class="text-muted small">ملاحظات</label>
                            <p class="fw-bold">{{ $appointment->notes ?? 'لا توجد ملاحظات' }}</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection