@extends('layouts.app')

@section('title', 'لوحة التحكم - عيادات القافلة الطبية')

@section('content')
    <div class="container-fluid">
        <div class="row mb-4">
            <div class="col-12">
                <h2 class="fw-bold text-dark">مرحباً بك في عيادات القافلة الطبية</h2>
                <p class="text-muted">نظرة سريعة على إحصائيات اليوم</p>
            </div>
        </div>

        <!-- Statistics Cards -->
        <div class="row">
            <div class="col-md-6 col-lg-3">
                <div class="stats-card patients">
                    <div class="icon">
                        <i class="bi bi-people"></i>
                    </div>
                    <h3>{{ $totalPatients ?? 0 }}</h3>
                    <p>إجمالي المرضى</p>
                </div>
            </div>
            <div class="col-md-6 col-lg-3">
                <div class="stats-card appointments">
                    <div class="icon">
                        <i class="bi bi-calendar-check"></i>
                    </div>
                    <h3>{{ $todayAppointments ?? 0 }}</h3>
                    <p>مواعيد اليوم</p>
                </div>
            </div>
            <div class="col-md-6 col-lg-3">
                <div class="stats-card medical">
                    <div class="icon">
                        <i class="bi bi-file-medical"></i>
                    </div>
                    <h3>{{ $totalMedicalRecords ?? 0 }}</h3>
                    <p>السجلات المرضية</p>
                </div>
            </div>
            <div class="col-md-6 col-lg-3">
                <div class="stats-card followups">
                    <div class="icon">
                        <i class="bi bi-arrow-repeat"></i>
                    </div>
                    <h3>{{ $pendingFollowUps ?? 0 }}</h3>
                    <p>متابعات معلقة</p>
                </div>
            </div>
            <div class="col-md-6 col-lg-3">
                <div class="stats-card doctors">
                    <div class="icon">
                        <i class="bi bi-stethoscope"></i>
                    </div>
                    <h3>{{ $totalDoctors ?? 0 }}</h3>
                    <p>الأطباء</p>
                </div>
            </div>
        </div>

        <!-- Recent Appointments -->
        <div class="row mt-4">
            <div class="col-lg-8">
                <div class="card">
                    <div class="card-header">
                        <h5 class="mb-0"><i class="bi bi-calendar-event me-2"></i>المواعيد القادمة</h5>
                    </div>
                    <div class="card-body">
                        @if(isset($upcomingAppointments) && $upcomingAppointments->count() > 0)
                            <div class="table-responsive">
                                <table class="table table-hover">
                                    <thead>
                                        <tr>
                                            <th>المريض</th>
                                            <th>التاريخ</th>
                                            <th>الوقت</th>
                                            <th>الحالة</th>
                                            <th>الإجراءات</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($upcomingAppointments as $appointment)
                                            <tr>
                                                <td>{{ $appointment->patient->name }}</td>
                                                <td>{{ \Carbon\Carbon::parse($appointment->appointment_date)->format('Y-m-d') }}</td>
                                                <td>{{ \Carbon\Carbon::parse($appointment->appointment_time)->format('h:i A') }}</td>
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
                                                <td>
                                                    <a href="{{ route('appointments.show', $appointment->id) }}"
                                                        class="btn btn-sm btn-primary">
                                                        <i class="bi bi-eye"></i>
                                                    </a>
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        @else
                            <div class="text-center py-5">
                                <i class="bi bi-calendar-x" style="font-size: 3rem; color: #cbd5e0;"></i>
                                <p class="text-muted mt-3">لا توجد مواعيد قادمة</p>
                                <a href="{{ route('appointments.create') }}" class="btn btn-primary mt-2">
                                    <i class="bi bi-plus-circle me-2"></i>إضافة موعد جديد
                                </a>
                            </div>
                        @endif
                    </div>
                </div>
            </div>

            <div class="col-lg-4">
                <div class="card">
                    <div class="card-header">
                        <h5 class="mb-0"><i class="bi bi-bell me-2"></i>إشعارات</h5>
                    </div>
                    <div class="card-body">
                        <div class="list-group list-group-flush">
                            @if(isset($pendingFollowUps) && $pendingFollowUps > 0)
                                <div class="list-group-item border-0 px-0">
                                    <div class="d-flex align-items-center">
                                        <div class="flex-shrink-0">
                                            <div class="rounded-circle bg-warning bg-opacity-10 p-3">
                                                <i class="bi bi-arrow-repeat text-warning"></i>
                                            </div>
                                        </div>
                                        <div class="flex-grow-1 ms-3">
                                            <h6 class="mb-1">متابعات معلقة</h6>
                                            <p class="text-muted small mb-0">لديك {{ $pendingFollowUps }} متابعة معلقة</p>
                                        </div>
                                    </div>
                                </div>
                            @endif

                            @if(isset($todayAppointments) && $todayAppointments > 0)
                                <div class="list-group-item border-0 px-0">
                                    <div class="d-flex align-items-center">
                                        <div class="flex-shrink-0">
                                            <div class="rounded-circle bg-info bg-opacity-10 p-3">
                                                <i class="bi bi-calendar-check text-info"></i>
                                            </div>
                                        </div>
                                        <div class="flex-grow-1 ms-3">
                                            <h6 class="mb-1">مواعيد اليوم</h6>
                                            <p class="text-muted small mb-0">لديك {{ $todayAppointments }} موعد اليوم</p>
                                        </div>
                                    </div>
                                </div>
                            @endif

                            @if((!isset($pendingFollowUps) || $pendingFollowUps == 0) && (!isset($todayAppointments) || $todayAppointments == 0))
                                <div class="text-center py-4">
                                    <i class="bi bi-check-circle" style="font-size: 2.5rem; color: #48bb78;"></i>
                                    <p class="text-muted mt-3 mb-0">لا توجد إشعارات جديدة</p>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>

                <div class="card mt-3">
                    <div class="card-header">
                        <h5 class="mb-0"><i class="bi bi-lightning me-2"></i>إجراءات سريعة</h5>
                    </div>
                    <div class="card-body">
                        <div class="d-grid gap-2">
                            <a href="{{ route('patients.create') }}" class="btn btn-outline-primary">
                                <i class="bi bi-person-plus me-2"></i>إضافة مريض جديد
                            </a>
                            <a href="{{ route('appointments.create') }}" class="btn btn-outline-primary">
                                <i class="bi bi-calendar-plus me-2"></i>حجز موعد
                            </a>
                            <a href="{{ route('patients.index') }}" class="btn btn-outline-primary">
                                <i class="bi bi-search me-2"></i>البحث عن مريض
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection