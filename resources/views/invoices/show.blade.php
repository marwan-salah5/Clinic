@extends('layouts.app')

@section('title', 'فاتورة #' . $invoice->invoice_number)

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card shadow-sm" id="invoice-card">
                    <div class="card-body p-5">
                        <!-- Header -->
                        <div class="row mb-4 border-bottom pb-4">
                            <div class="col-6">
                                <h2 class="fw-bold text-primary">عيادات القافلة الطبية</h2>
                                <p class="text-muted mb-0">نظام إدارة العيادات</p>
                            </div>
                            <div class="col-6 text-end">
                                <h4 class="fw-bold">فاتورة</h4>
                                <p class="text-muted mb-0">#{{ $invoice->invoice_number }}</p>
                                <p class="text-muted mb-0">{{ $invoice->invoice_date }}</p>
                            </div>
                        </div>

                        <!-- Patient & Doctor Info -->
                        <div class="row mb-4">
                            <div class="col-6">
                                <h6 class="fw-bold text-uppercase text-muted mb-2">بيانات المريض</h6>
                                <h5 class="fw-bold">{{ $invoice->patient->name }}</h5>
                                <p class="mb-0">{{ $invoice->patient->phone }}</p>
                            </div>
                            <div class="col-6 text-end">
                                <h6 class="fw-bold text-uppercase text-muted mb-2">الطبيب المعالج</h6>
                                @if($invoice->appointment && $invoice->appointment->doctor)
                                    <h5 class="fw-bold">{{ $invoice->appointment->doctor->name }}</h5>
                                    <p class="mb-0">{{ $invoice->appointment->doctor->specialization ?? 'عام' }}</p>
                                @else
                                    <p class="text-muted">-</p>
                                @endif
                            </div>
                        </div>

                        <!-- Invoice Details -->
                        <div class="table-responsive mb-4">
                            <table class="table table-bordered">
                                <thead class="table-light">
                                    <tr>
                                        <th>الوصف</th>
                                        <th class="text-end" style="width: 150px;">المبلغ</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td>
                                            كشف طبي
                                            @if($invoice->appointment)
                                                - موعد بتاريخ {{ $invoice->appointment->appointment_date->format('Y-m-d') }}
                                                <br>
                                                - الساعة
                                                {{ \Carbon\Carbon::parse($invoice->appointment->appointment_time)->format('h:i A') }}
                                            @endif
                                            <br>
                                            <small class="text-muted">{{ $invoice->notes }}</small>
                                        </td>
                                        <td class="text-end fw-bold">{{ number_format($invoice->total_amount, 2) }} ج.م</td>
                                    </tr>
                                </tbody>
                                <tfoot class="table-light">
                                    <tr>
                                        <td class="text-end fw-bold">الإجمالي</td>
                                        <td class="text-end fw-bold text-primary">
                                            {{ number_format($invoice->total_amount, 2) }}
                                            ج.م</td>
                                    </tr>
                                </tfoot>
                            </table>
                        </div>

                        <!-- Footer -->
                        <div class="text-center mt-5 pt-4 border-top">
                            <p class="text-muted mb-0">شكراً لثقتكم بنا</p>
                        </div>
                    </div>
                </div>

                <!-- Actions -->
                <div class="text-center mt-4 no-print">
                    <button onclick="window.print()" class="btn btn-primary btn-lg">
                        <i class="bi bi-printer me-2"></i>طباعة الفاتورة
                    </button>
                    <a href="{{ route('appointments.index') }}" class="btn btn-secondary btn-lg ms-2">
                        <i class="bi bi-arrow-right me-2"></i>عودة للمواعيد
                    </a>
                </div>
            </div>
        </div>
    </div>

    <style>
        @media print {
            @page {
                size: auto;
                margin: 0;
            }

            html,
            body {
                height: 100%;
                margin: 0 !important;
                padding: 0 !important;
                overflow: hidden;
            }

            body * {
                visibility: hidden;
            }

            #invoice-card,
            #invoice-card * {
                visibility: visible;
            }

            #invoice-card {
                position: absolute;
                left: 0;
                top: 0;
                width: 100%;
                margin: 0 !important;
                padding: 15px !important;
                box-shadow: none !important;
                border: none !important;
            }

            .no-print {
                display: none !important;
            }
        }
    </style>
@endsection