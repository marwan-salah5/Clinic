@extends('layouts.app')

@section('title', 'المتابعات')

@section('content')
    <div class="container-fluid">
        <div class="row mb-4">
            <div class="col-md-6">
                <h2 class="fw-bold text-dark">المتابعات</h2>
                <p class="text-muted">متابعة حالات المرضى</p>
            </div>
            <div class="col-md-6 text-end">
                <a href="{{ route('follow-ups.create') }}" class="btn btn-primary">
                    <i class="bi bi-plus-circle me-2"></i>إضافة متابعة جديدة
                </a>
            </div>
        </div>

        <!-- Filter Form -->
        <div class="card mb-4">
            <div class="card-body">
                <form action="{{ route('follow-ups.index') }}" method="GET">
                    <div class="row">
                        <div class="col-md-10">
                            <select name="status" class="form-select">
                                <option value="">جميع الحالات</option>
                                <option value="pending" {{ request('status') == 'pending' ? 'selected' : '' }}>معلقة</option>
                                <option value="completed" {{ request('status') == 'completed' ? 'selected' : '' }}>مكتملة
                                </option>
                                <option value="cancelled" {{ request('status') == 'cancelled' ? 'selected' : '' }}>ملغية
                                </option>
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

        <!-- Follow-ups Table -->
        <div class="card">
            <div class="card-body">
                @if($followUps->count() > 0)
                    <div class="table-responsive">
                        <table class="table table-hover">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>المريض</th>
                                    <th>تاريخ المتابعة</th>
                                    <th>الحالة</th>
                                    <th>مكتملة</th>
                                    <th>الإجراءات</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($followUps as $followUp)
                                    <tr>
                                        <td>{{ $followUp->id }}</td>
                                        <td>
                                            <a href="{{ route('patients.show', $followUp->patient_id) }}">
                                                {{ $followUp->patient->name }}
                                            </a>
                                        </td>
                                        <td>{{ $followUp->follow_up_date }}</td>
                                        <td>
                                            @if($followUp->status == 'pending')
                                                <span class="badge bg-warning">معلقة</span>
                                            @elseif($followUp->status == 'completed')
                                                <span class="badge bg-success">مكتملة</span>
                                            @else
                                                <span class="badge bg-danger">ملغية</span>
                                            @endif
                                        </td>
                                        <td>
                                            @if($followUp->completed)
                                                <i class="bi bi-check-circle-fill text-success" style="font-size: 1.2rem;"></i>
                                            @else
                                                <i class="bi bi-x-circle-fill text-danger" style="font-size: 1.2rem;"></i>
                                            @endif
                                        </td>
                                        <td>
                                            <a href="{{ route('follow-ups.show', $followUp->id) }}" class="btn btn-sm btn-info">
                                                <i class="bi bi-eye"></i>
                                            </a>
                                            <a href="{{ route('follow-ups.edit', $followUp->id) }}" class="btn btn-sm btn-warning">
                                                <i class="bi bi-pencil"></i>
                                            </a>
                                            <form action="{{ route('follow-ups.destroy', $followUp->id) }}" method="POST"
                                                class="d-inline" onsubmit="return confirm('هل أنت متأكد من حذف هذه المتابعة؟')">
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
                        {{ $followUps->links() }}
                    </div>
                @else
                    <div class="text-center py-5">
                        <i class="bi bi-arrow-repeat" style="font-size: 4rem; color: #cbd5e0;"></i>
                        <h4 class="mt-3 text-muted">لا توجد متابعات</h4>
                        <p class="text-muted">لم يتم العثور على أي متابعات</p>
                        <a href="{{ route('follow-ups.create') }}" class="btn btn-primary mt-2">
                            <i class="bi bi-plus-circle me-2"></i>إضافة متابعة جديدة
                        </a>
                    </div>
                @endif
            </div>
        </div>
    </div>
@endsection