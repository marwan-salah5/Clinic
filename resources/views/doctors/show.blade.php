@extends('layouts.app')

@section('title', 'تفاصيل الطبيب')

@section('content')
    <div class="container-fluid">
        <div class="row mb-4">
            <div class="col-12">
                <h2 class="fw-bold text-dark">تفاصيل الطبيب</h2>
                <p class="text-muted">معلومات الطبيب الكاملة</p>
            </div>
        </div>

        <div class="row">
            <div class="col-lg-8">
                <div class="card">
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <h5 class="mb-0"><i class="bi bi-person-badge me-2"></i>{{ $doctor->name }}</h5>
                        <div class="btn-group">
                            <a href="{{ route('doctors.edit', $doctor) }}" class="btn btn-sm btn-warning">
                                <i class="bi bi-pencil me-1"></i>تعديل
                            </a>
                            <form action="{{ route('doctors.destroy', $doctor) }}" method="POST" class="d-inline"
                                onsubmit="return confirm('هل أنت متأكد من حذف هذا الطبيب؟');">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-sm btn-danger">
                                    <i class="bi bi-trash me-1"></i>حذف
                                </button>
                            </form>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="row mb-4">
                            <div class="col-12 text-center">
                                <div class="doctor-avatar mx-auto mb-3">
                                    <i class="bi bi-person-fill"></i>
                                </div>
                                <h4 class="mb-1">{{ $doctor->name }}</h4>
                                <p class="text-muted">
                                    <span class="badge bg-info fs-6">{{ $doctor->specialization }}</span>
                                </p>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <div class="info-box">
                                    <div class="info-icon">
                                        <i class="bi bi-telephone-fill"></i>
                                    </div>
                                    <div class="info-content">
                                        <small class="text-muted">رقم الهاتف</small>
                                        <p class="mb-0 fw-bold">{{ $doctor->phone }}</p>
                                    </div>
                                </div>
                            </div>

                            <div class="col-md-6 mb-3">
                                <div class="info-box">
                                    <div class="info-icon">
                                        <i class="bi bi-envelope-fill"></i>
                                    </div>
                                    <div class="info-content">
                                        <small class="text-muted">البريد الإلكتروني</small>
                                        <p class="mb-0 fw-bold">{{ $doctor->email ?? 'غير متوفر' }}</p>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="row mt-3">
                            <div class="col-md-6 mb-3">
                                <div class="info-box">
                                    <div class="info-icon">
                                        <i class="bi bi-hash"></i>
                                    </div>
                                    <div class="info-content">
                                        <small class="text-muted">رقم التعريف</small>
                                        <p class="mb-0 fw-bold">#{{ $doctor->id }}</p>
                                    </div>
                                </div>
                            </div>

                            <div class="col-md-6 mb-3">
                                <div class="info-box">
                                    <div class="info-icon">
                                        <i class="bi bi-calendar-plus"></i>
                                    </div>
                                    <div class="info-content">
                                        <small class="text-muted">تاريخ الإضافة</small>
                                        <p class="mb-0 fw-bold">{{ $doctor->created_at->format('Y-m-d') }}</p>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="mt-4">
                            <a href="{{ route('doctors.index') }}" class="btn btn-secondary">
                                <i class="bi bi-arrow-right me-2"></i>العودة للقائمة
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    @push('styles')
        <style>
            .doctor-avatar {
                width: 120px;
                height: 120px;
                border-radius: 50%;
                background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
                display: flex;
                align-items: center;
                justify-content: center;
                color: white;
                font-size: 3rem;
                box-shadow: 0 5px 20px rgba(102, 126, 234, 0.3);
            }

            .info-box {
                display: flex;
                align-items: center;
                padding: 15px;
                background: #f8f9fa;
                border-radius: 10px;
                transition: all 0.3s ease;
            }

            .info-box:hover {
                background: #e9ecef;
                transform: translateY(-2px);
            }

            .info-icon {
                width: 50px;
                height: 50px;
                border-radius: 10px;
                background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
                display: flex;
                align-items: center;
                justify-content: center;
                color: white;
                font-size: 1.5rem;
                margin-left: 15px;
            }

            .info-content {
                flex: 1;
            }

            .info-content small {
                display: block;
                font-size: 0.75rem;
            }
        </style>
    @endpush
@endsection