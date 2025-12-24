@extends('layouts.app')

@section('title', 'المواعيد')

@section('content')
    <div class="container-fluid">
        <div class="row mb-4">
            <div class="col-md-6">
                <h2 class="fw-bold text-dark">المواعيد</h2>
                <p class="text-muted">إدارة مواعيد المرضى</p>
            </div>
            <div class="col-md-6 text-end">
                <a href="{{ route('appointments.create') }}" class="btn btn-primary">
                    <i class="bi bi-calendar-plus me-2"></i>حجز موعد جديد
                </a>
            </div>
        </div>

        <!-- Filter Form -->
        <div class="card mb-4">
            <div class="card-body">
                <form action="{{ route('appointments.index') }}" method="GET">
                    <div class="row">
                        <div class="col-md-4">
                            <input type="date" name="date" class="form-control" value="{{ request('date') }}"
                                placeholder="التاريخ">
                        </div>
                        <div class="col-md-4">
                            <select name="status" class="form-select">
                                <option value="">جميع الحالات</option>
                                <option value="pending" {{ request('status') == 'pending' ? 'selected' : '' }}>معلق</option>
                                <option value="confirmed" {{ request('status') == 'confirmed' ? 'selected' : '' }}>مؤكد
                                </option>
                                <option value="completed" {{ request('status') == 'completed' ? 'selected' : '' }}>مكتمل
                                </option>
                                <option value="cancelled" {{ request('status') == 'cancelled' ? 'selected' : '' }}>ملغي
                                </option>
                            </select>
                        </div>
                        <div class="col-md-4">
                            <button type="submit" class="btn btn-primary w-100">
                                <i class="bi bi-search me-2"></i>بحث
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>

        <!-- Appointments Table -->
        <div class="card">
            <div class="card-body">
                @if($appointments->count() > 0)
                    <div class="table-responsive">
                        <table class="table table-hover">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>المريض</th>
                                    <th>التاريخ</th>
                                    <th>الوقت</th>
                                    <th>الحالة</th>
                                    <th>السبب</th>
                                    <th>الإجراءات</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($appointments as $appointment)
                                    <tr>
                                        <td>{{ $appointment->id }}</td>
                                        <td>
                                            <a href="{{ route('patients.show', $appointment->patient_id) }}">
                                                {{ $appointment->patient->name }}
                                            </a>
                                        </td>
                                        <td>{{ $appointment->appointment_date->format('Y-m-d') }}</td>
                                        <td>{{ $appointment->appointment_time->format('h:i A') }}</td>
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
                                        <td>
                                            <a href="{{ route('appointments.show', $appointment->id) }}"
                                                class="btn btn-sm btn-info">
                                                <i class="bi bi-eye"></i>
                                            </a>
                                            <a href="{{ route('appointments.edit', $appointment->id) }}"
                                                class="btn btn-sm btn-warning">
                                                <i class="bi bi-pencil"></i>
                                            </a>
                                            <form action="{{ route('appointments.destroy', $appointment->id) }}" method="POST"
                                                class="d-inline" onsubmit="return confirm('هل أنت متأكد من حذف هذا الموعد؟')">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-sm btn-danger">
                                                    <i class="bi bi-trash"></i>
                                                </button>
                                            </form>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>

                    <div class="mt-3">
                        {{ $appointments->links() }}
                    </div>
                @else
                    <div class="text-center py-5">
                        <i class="bi bi-calendar-x" style="font-size: 4rem; color: #cbd5e0;"></i>
                        <h4 class="mt-3 text-muted">لا توجد مواعيد</h4>
                        <p class="text-muted">لم يتم العثور على أي مواعيد</p>
                        <a href="{{ route('appointments.create') }}" class="btn btn-primary mt-2">
                            <i class="bi bi-calendar-plus me-2"></i>حجز موعد جديد
                        </a>
                    </div>
                @endif
            </div>
        </div>
    </div>
@endsection