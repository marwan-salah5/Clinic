@extends('layouts.app')

@section('title', 'قائمة الأطباء')

@section('content')
    <div class="container-fluid">
        <div class="row mb-4">
            <div class="col-12">
                <h2 class="fw-bold text-dark">قائمة الأطباء</h2>
                <p class="text-muted">إدارة بيانات الأطباء في عيادات القافلة الطبية</p>
            </div>
        </div>

        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <h5 class="mb-0"><i class="bi bi-stethoscope me-2"></i>الأطباء المسجلين</h5>
                        <a href="{{ route('doctors.create') }}" class="btn btn-light">
                            <i class="bi bi-plus-circle me-2"></i>إضافة طبيب جديد
                        </a>
                    </div>
                    <div class="card-body">
                        @if($doctors->count() > 0)
                            <div class="table-responsive">
                                <table class="table table-hover align-middle">
                                    <thead class="table-light">
                                        <tr>
                                            <th>#</th>
                                            <th>الاسم</th>
                                            <th>القسم</th>
                                            <th>الهاتف</th>
                                            <th>البريد الإلكتروني</th>
                                            <th class="text-center">الإجراءات</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($doctors as $doctor)
                                            <tr>
                                                <td>{{ $doctor->id }}</td>
                                                <td>
                                                    <div class="d-flex align-items-center">
                                                        <div class="avatar-circle me-2">
                                                            <i class="bi bi-person-fill"></i>
                                                        </div>
                                                        <strong>{{ $doctor->name }}</strong>
                                                    </div>
                                                </td>
                                                <td>
                                                    <span class="badge bg-info">{{ $doctor->department->name ?? 'غير محدد' }}</span>
                                                </td>
                                                <td>
                                                    @if($doctor->phone)
                                                        <i class="bi bi-telephone me-1"></i>{{ $doctor->phone }}
                                                    @else
                                                        <span class="text-muted">-</span>
                                                    @endif
                                                </td>
                                                <td>
                                                    @if($doctor->email)
                                                        <i class="bi bi-envelope me-1"></i>{{ $doctor->email }}
                                                    @else
                                                        <span class="text-muted">-</span>
                                                    @endif
                                                </td>
                                                <td class="text-center">
                                                    <div class="btn-group" role="group">
                                                        <a href="{{ route('doctors.show', $doctor) }}"
                                                            class="btn btn-sm btn-outline-info" title="عرض">
                                                            <i class="bi bi-eye"></i>
                                                        </a>
                                                        <a href="{{ route('doctors.edit', $doctor) }}"
                                                            class="btn btn-sm btn-outline-warning" title="تعديل">
                                                            <i class="bi bi-pencil"></i>
                                                        </a>
                                                        <form action="{{ route('doctors.destroy', $doctor) }}" method="POST"
                                                            class="d-inline"
                                                            onsubmit="return confirm('هل أنت متأكد من حذف هذا الطبيب؟');">
                                                            @csrf
                                                            @method('DELETE')
                                                            <button type="submit" class="btn btn-sm btn-outline-danger" title="حذف">
                                                                <i class="bi bi-trash"></i>
                                                            </button>
                                                        </form>
                                                    </div>
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>

                            <div class="mt-3">
                                {{ $doctors->links() }}
                            </div>
                        @else
                            <div class="text-center py-5">
                                <i class="bi bi-inbox display-1 text-muted"></i>
                                <p class="text-muted mt-3">لا توجد أطباء مسجلين حالياً</p>
                                <a href="{{ route('doctors.create') }}" class="btn btn-primary">
                                    <i class="bi bi-plus-circle me-2"></i>إضافة أول طبيب
                                </a>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>

    @push('styles')
        <style>
            .avatar-circle {
                width: 40px;
                height: 40px;
                border-radius: 50%;
                background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
                display: flex;
                align-items: center;
                justify-content: center;
                color: white;
                font-size: 1.2rem;
            }

            .btn-group .btn {
                border-radius: 0;
            }

            .btn-group .btn:first-child {
                border-radius: 0.25rem 0 0 0.25rem;
            }

            .btn-group .btn:last-child {
                border-radius: 0 0.25rem 0.25rem 0;
            }
        </style>
    @endpush
@endsection