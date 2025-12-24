@extends('layouts.app')

@section('title', 'قائمة المرضى')

@section('content')
    <div class="container-fluid">
        <div class="row mb-4">
            <div class="col-md-6">
                <h2 class="fw-bold text-dark">قائمة المرضى</h2>
                <p class="text-muted">إدارة بيانات المرضى</p>
            </div>
            <div class="col-md-6 text-end">
                <a href="{{ route('patients.create') }}" class="btn btn-primary">
                    <i class="bi bi-person-plus me-2"></i>إضافة مريض جديد
                </a>
            </div>
        </div>

        <!-- Search Form -->
        <div class="card mb-4">
            <div class="card-body">
                <form action="{{ route('patients.index') }}" method="GET">
                    <div class="row">
                        <div class="col-md-10">
                            <input type="text" name="search" class="form-control"
                                placeholder="البحث بالاسم، الرقم القومي، أو رقم الهاتف..." value="{{ request('search') }}">
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

        <!-- Patients Table -->
        <div class="card">
            <div class="card-body">
                @if($patients->count() > 0)
                    <div class="table-responsive">
                        <table class="table table-hover">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>الاسم</th>
                                    <th>الرقم القومي</th>
                                    <th>رقم الهاتف</th>
                                    <th>العمر</th>
                                    <th>الجنس</th>
                                    <th>الإجراءات</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($patients as $patient)
                                    <tr>
                                        <td>{{ $patient->id }}</td>
                                        <td>{{ $patient->name }}</td>
                                        <td>{{ $patient->national_id ?? '-' }}</td>
                                        <td>{{ $patient->phone }}</td>
                                        <td>{{ $patient->age }} سنة</td>
                                        <td>{{ $patient->gender == 'male' ? 'ذكر' : 'أنثى' }}</td>
                                        <td>
                                            <a href="{{ route('patients.show', $patient->id) }}" class="btn btn-sm btn-info"
                                                title="عرض">
                                                <i class="bi bi-eye"></i>
                                            </a>
                                            <a href="{{ route('patients.edit', $patient->id) }}" class="btn btn-sm btn-warning"
                                                title="تعديل">
                                                <i class="bi bi-pencil"></i>
                                            </a>
                                            <form action="{{ route('patients.destroy', $patient->id) }}" method="POST"
                                                class="d-inline" onsubmit="return confirm('هل أنت متأكد من حذف هذا المريض؟')">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-sm btn-danger" title="حذف">
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
                        {{ $patients->links() }}
                    </div>
                @else
                    <div class="text-center py-5">
                        <i class="bi bi-people" style="font-size: 4rem; color: #cbd5e0;"></i>
                        <h4 class="mt-3 text-muted">لا توجد بيانات</h4>
                        <p class="text-muted">لم يتم العثور على أي مرضى</p>
                        <a href="{{ route('patients.create') }}" class="btn btn-primary mt-2">
                            <i class="bi bi-person-plus me-2"></i>إضافة مريض جديد
                        </a>
                    </div>
                @endif
            </div>
        </div>
    </div>
@endsection