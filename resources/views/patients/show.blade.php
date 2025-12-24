@extends('layouts.app')

@section('title', 'تفاصيل المريض')

@section('content')
    <div class="container-fluid">
        <div class="row mb-4">
            <div class="col-md-6">
                <h2 class="fw-bold text-dark">{{ $patient->name }}</h2>
                <p class="text-muted">معلومات المريض الكاملة</p>
            </div>
            <div class="col-md-6 text-end">
                <a href="{{ route('patients.edit', $patient->id) }}" class="btn btn-warning">
                    <i class="bi bi-pencil me-2"></i>تعديل
                </a>
                <a href="{{ route('patients.index') }}" class="btn btn-secondary">
                    <i class="bi bi-arrow-right me-2"></i>العودة
                </a>
            </div>
        </div>

        <div class="row">
            <!-- Patient Information -->
            <div class="col-lg-4">
                <div class="card mb-4">
                    <div class="card-header">
                        <h5 class="mb-0"><i class="bi bi-person me-2"></i>المعلومات الشخصية</h5>
                    </div>
                    <div class="card-body">
                        <div class="mb-3">
                            <label class="text-muted small">الاسم الكامل</label>
                            <p class="fw-bold">{{ $patient->name }}</p>
                        </div>
                        <div class="mb-3">
                            <label class="text-muted small">الرقم القومي</label>
                            <p class="fw-bold">{{ $patient->national_id ?? '-' }}</p>
                        </div>
                        <div class="mb-3">
                            <label class="text-muted small">رقم الهاتف</label>
                            <p class="fw-bold">{{ $patient->phone }}</p>
                        </div>
                        <div class="mb-3">
                            <label class="text-muted small">البريد الإلكتروني</label>
                            <p class="fw-bold">{{ $patient->email ?? '-' }}</p>
                        </div>
                        <div class="mb-3">
                            <label class="text-muted small">تاريخ الميلاد</label>
                            <p class="fw-bold">{{ $patient->date_of_birth }}</p>
                        </div>
                        <div class="mb-3">
                            <label class="text-muted small">الجنس</label>
                            <p class="fw-bold">{{ $patient->gender == 'male' ? 'ذكر' : 'أنثى' }}</p>
                        </div>
                        <div class="mb-3">
                            <label class="text-muted small">فصيلة الدم</label>
                            <p class="fw-bold">{{ $patient->blood_type ?? '-' }}</p>
                        </div>
                        <div class="mb-3">
                            <label class="text-muted small">العنوان</label>
                            <p class="fw-bold">{{ $patient->address ?? '-' }}</p>
                        </div>
                        <div class="mb-0">
                            <label class="text-muted small">الحساسية</label>
                            <p class="fw-bold">{{ $patient->allergies ?? '-' }}</p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Medical History, Appointments, Follow-ups -->
            <div class="col-lg-8">
                <!-- Medical History -->
                <div class="card mb-4">
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <h5 class="mb-0"><i class="bi bi-file-medical me-2"></i>التاريخ المرضي</h5>
                        <span class="badge bg-primary">{{ $patient->medicalHistories->count() }}</span>
                    </div>
                    <div class="card-body">
                        @if($patient->medicalHistories->count() > 0)
                            <div class="table-responsive">
                                <table class="table table-sm">
                                    <thead>
                                        <tr>
                                            <th>التاريخ</th>
                                            <th>التشخيص</th>
                                            <th>العلاج</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($patient->medicalHistories as $history)
                                            <tr>
                                                <td>{{ $history->visit_date }}</td>
                                                <td>{{ Str::limit($history->diagnosis, 50) }}</td>
                                                <td>{{ Str::limit($history->treatment, 50) }}</td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        @else
                            <p class="text-muted text-center py-3">لا يوجد تاريخ مرضي</p>
                        @endif
                    </div>
                </div>

                <!-- Appointments -->
                <div class="card mb-4">
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <h5 class="mb-0"><i class="bi bi-calendar-check me-2"></i>المواعيد</h5>
                        <span class="badge bg-primary">{{ $patient->appointments->count() }}</span>
                    </div>
                    <div class="card-body">
                        @if($patient->appointments->count() > 0)
                            <div class="table-responsive">
                                <table class="table table-sm">
                                    <thead>
                                        <tr>
                                            <th>التاريخ</th>
                                            <th>الوقت</th>
                                            <th>الحالة</th>
                                            <th>السبب</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($patient->appointments as $appointment)
                                            <tr>
                                                <td>{{ $appointment->appointment_date }}</td>
                                                <td>{{ $appointment->appointment_time }}</td>
                                                <td>
                                                    @if($appointment->status == 'pending')
                                                        <span class="badge bg-warning">معلق</span>
                                                    @elseif($appointment->status == 'confirmed')
                                                        <span class="badge bg-success">مؤكد</span>
                                                    @elseif($appointment->status == 'completed')
                                                        <span class="badge bg-info">مكتمل</span>
                                                    @else
                                                        <span class="badge bg-danger">ملغي</span>
                                                    @endif
                                                </td>
                                                <td>{{ Str::limit($appointment->reason, 30) }}</td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        @else
                            <p class="text-muted text-center py-3">لا توجد مواعيد</p>
                        @endif
                    </div>
                </div>

            </div>
        </div>

        <!-- Invoices -->
        <div class="card mb-4">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h5 class="mb-0"><i class="bi bi-receipt me-2"></i>الفواتير</h5>
                <div>
                    <span class="badge bg-primary me-2">{{ $patient->invoices->count() }}</span>
                    <a href="{{ route('invoices.create', ['patient_id' => $patient->id]) }}" class="btn btn-sm btn-success">
                        <i class="bi bi-plus-lg"></i> إضافة
                    </a>
                </div>
            </div>
            <div class="card-body">
                @if($patient->invoices->count() > 0)
                    <div class="table-responsive">
                        <table class="table table-sm">
                            <thead>
                                <tr>
                                    <th>رقم الفاتورة</th>
                                    <th>التاريخ</th>
                                    <th>المبلغ</th>
                                    <th>الحالة</th>
                                    <th>إجراءات</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($patient->invoices as $invoice)
                                    <tr>
                                        <td>{{ $invoice->invoice_number }}</td>
                                        <td>{{ $invoice->invoice_date }}</td>
                                        <td>{{ number_format($invoice->total_amount, 2) }}</td>
                                        <td>
                                            @if($invoice->status == 'paid')
                                                <span class="badge bg-success">مدفوع</span>
                                            @elseif($invoice->status == 'unpaid')
                                                <span class="badge bg-warning text-dark">غير مدفوع</span>
                                            @else
                                                <span class="badge bg-danger">ملغي</span>
                                            @endif
                                        </td>
                                        <td>
                                            <a href="{{ route('invoices.show', $invoice->id) }}"
                                                class="btn btn-sm btn-outline-primary" title="طباعة">
                                                <i class="bi bi-printer"></i>
                                            </a>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                @else
                    <p class="text-muted text-center py-3">لا توجد فواتير لهذا المريض</p>
                @endif
            </div>
        </div>
    </div>
    </div>
    </div>
    </div>
@endsection