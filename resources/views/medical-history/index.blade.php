@extends('layouts.app')

@section('title', 'التاريخ المرضي')

@section('content')
    <div class="container-fluid">
        <div class="row mb-4">
            <div class="col-md-6">
                <h2 class="fw-bold text-dark">التاريخ المرضي</h2>
                <p class="text-muted">السجلات الطبية للمرضى</p>
            </div>
            <div class="col-md-6 text-end">
                <a href="{{ route('medical-history.create') }}" class="btn btn-primary">
                    <i class="bi bi-file-medical-fill me-2"></i>إضافة سجل جديد
                </a>
            </div>
        </div>

        <!-- Filter Form -->
        <div class="card mb-4">
            <div class="card-body">
                <form action="{{ route('medical-history.index') }}" method="GET">
                    <div class="row">
                        <div class="col-md-10">
                            <select name="patient_id" class="form-select">
                                <option value="">جميع المرضى</option>
                                @foreach($patients as $patient)
                                    <option value="{{ $patient->id }}" {{ request('patient_id') == $patient->id ? 'selected' : '' }}>
                                        {{ $patient->name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-2">
                            <button type="submit" class="btn btn-primary w-100">
                                <i class="bi bi-search me-2"></i>بحث
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>

        <!-- Medical History Table -->
        <div class="card">
            <div class="card-body">
                @if($histories->count() > 0)
                    <div class="table-responsive">
                        <table class="table table-hover">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>المريض</th>
                                    <th>تاريخ الزيارة</th>
                                    <th>التشخيص</th>
                                    <th>العلاج</th>
                                    <th>الإجراءات</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($histories as $history)
                                    <tr>
                                        <td>{{ $history->id }}</td>
                                        <td>
                                            <a href="{{ route('patients.show', $history->patient_id) }}">
                                                {{ $history->patient->name }}
                                            </a>
                                        </td>
                                        <td>{{ $history->visit_date }}</td>
                                        <td>{{ Str::limit($history->diagnosis, 40) }}</td>
                                        <td>{{ Str::limit($history->treatment, 40) }}</td>
                                        <td>
                                            <a href="{{ route('medical-history.show', $history->id) }}" class="btn btn-sm btn-info">
                                                <i class="bi bi-eye"></i>
                                            </a>
                                            <a href="{{ route('medical-history.edit', $history->id) }}"
                                                class="btn btn-sm btn-warning">
                                                <i class="bi bi-pencil"></i>
                                            </a>
                                            <form action="{{ route('medical-history.destroy', $history->id) }}" method="POST"
                                                class="d-inline" onsubmit="return confirm('هل أنت متأكد من حذف هذا السجل؟')">
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
                        {{ $histories->links() }}
                    </div>
                @else
                    <div class="text-center py-5">
                        <i class="bi bi-file-medical" style="font-size: 4rem; color: #cbd5e0;"></i>
                        <h4 class="mt-3 text-muted">لا توجد سجلات طبية</h4>
                        <p class="text-muted">لم يتم العثور على أي سجلات</p>
                        <a href="{{ route('medical-history.create') }}" class="btn btn-primary mt-2">
                            <i class="bi bi-file-medical-fill me-2"></i>إضافة سجل جديد
                        </a>
                    </div>
                @endif
            </div>
        </div>
    </div>
@endsection