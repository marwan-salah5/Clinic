@extends('layouts.app')

@section('title', 'تفاصيل السجل المرضي')

@section('content')
    <div class="container-fluid">
        <div class="row mb-4">
            <div class="col-md-6">
                <h2 class="fw-bold text-dark">تفاصيل السجل المرضي #{{ $history->id }}</h2>
                <p class="text-muted">عرض تفاصيل الزيارة الطبية</p>
            </div>
            <div class="col-md-6 text-end">
                <a href="{{ route('medical-history.edit', $history->id) }}" class="btn btn-warning">
                    <i class="bi bi-pencil me-2"></i>تعديل
                </a>
                <a href="{{ route('medical-history.index') }}" class="btn btn-secondary">
                    <i class="bi bi-arrow-right me-2"></i>العودة
                </a>
            </div>
        </div>

        <div class="row">
            <div class="col-lg-8">
                <div class="card mb-4">
                    <div class="card-header">
                        <h5 class="mb-0"><i class="bi bi-info-circle me-2"></i>تفاصيل الزيارة</h5>
                    </div>
                    <div class="card-body">
                        <div class="row mb-3">
                            <div class="col-md-6">
                                <label class="text-muted small">المريض</label>
                                <p class="fw-bold">
                                    <a href="{{ route('patients.show', $history->patient_id) }}"
                                        class="text-decoration-none">
                                        {{ $history->patient->name }}
                                    </a>
                                </p>
                            </div>
                            <div class="col-md-6">
                                <label class="text-muted small">الطبيب</label>
                                <p class="fw-bold">{{ $history->doctor->name }}</p>
                            </div>
                        </div>

                        <div class="mb-3">
                            <label class="text-muted small">تاريخ الزيارة</label>
                            <p class="fw-bold">{{ $history->visit_date }}</p>
                        </div>

                        <hr>

                        <div class="mb-3">
                            <label class="text-muted small">الأعراض (Symptoms)</label>
                            <p class="fw-bold">{{ $history->symptoms ?? 'لا يوجد' }}</p>
                        </div>

                        <div class="mb-3">
                            <label class="text-muted small">التشخيص (Diagnosis)</label>
                            <div class="alert alert-info">
                                <p class="fw-bold mb-0">{{ $history->diagnosis }}</p>
                            </div>
                        </div>

                        <div class="mb-3">
                            <label class="text-muted small">العلاج (Treatment)</label>
                            <p class="fw-bold">{{ $history->treatment ?? 'لا يوجد' }}</p>
                        </div>

                        <div class="mb-3">
                            <label class="text-muted small">الوصفة الطبية (Prescriptions)</label>
                            <div class="p-3 bg-light rounded border">
                                <p class="fw-bold mb-0" style="white-space: pre-line;">
                                    {{ $history->prescriptions ?? 'لا يوجد' }}</p>
                            </div>
                        </div>

                        <div class="mb-0">
                            <label class="text-muted small">ملاحظات</label>
                            <p class="fw-bold">{{ $history->notes ?? 'لا توجد ملاحظات' }}</p>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-lg-4">
                <div class="card">
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <h5 class="mb-0"><i class="bi bi-arrow-repeat me-2"></i>المتابعات المرتبطة</h5>
                        <a href="{{ route('follow-ups.create') }}?medical_history_id={{ $history->id }}"
                            class="btn btn-sm btn-primary">
                            <i class="bi bi-plus"></i>
                        </a>
                    </div>
                    <div class="card-body">
                        @if($history->followUps->count() > 0)
                            <ul class="list-group list-group-flush">
                                @foreach($history->followUps as $followUp)
                                    <li class="list-group-item px-0">
                                        <div class="d-flex justify-content-between align-items-center">
                                            <div>
                                                <span class="d-block fw-bold">{{ $followUp->follow_up_date }}</span>
                                                <span class="small text-muted">
                                                    @if($followUp->status == 'pending')
                                                        معلقة
                                                    @elseif($followUp->status == 'completed')
                                                        مكتملة
                                                    @else
                                                        ملغية
                                                    @endif
                                                </span>
                                            </div>
                                            <a href="{{ route('follow-ups.show', $followUp->id) }}"
                                                class="btn btn-sm btn-outline-primary">
                                                <i class="bi bi-eye"></i>
                                            </a>
                                        </div>
                                    </li>
                                @endforeach
                            </ul>
                        @else
                            <p class="text-muted text-center py-3">لا توجد متابعات مرتبطة بهذه الزيارة</p>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection