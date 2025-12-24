<!DOCTYPE html>
<html lang="ar" dir="rtl">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>تقرير المريض - {{ $patient->name }}</title>
    <link href="https://fonts.googleapis.com/css2?family=Cairo:wght@300;400;600;700&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.rtl.min.css" rel="stylesheet">
    <style>
        * {
            font-family: 'Cairo', sans-serif;
        }

        @media print {
            .no-print {
                display: none !important;
            }

            body {
                background: white !important;
            }
        }

        .report-header {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            padding: 30px;
            border-radius: 10px;
            margin-bottom: 30px;
        }

        .info-card {
            border: 2px solid #e2e8f0;
            border-radius: 10px;
            padding: 20px;
            margin-bottom: 20px;
        }

        .section-title {
            background: #f7fafc;
            padding: 15px;
            border-left: 4px solid #667eea;
            margin: 30px 0 20px 0;
            font-weight: 600;
        }
    </style>
</head>

<body class="bg-light">
    <div class="container my-5">
        <!-- Print Button -->
        <div class="text-end mb-3 no-print">
            <button onclick="window.print()" class="btn btn-primary">
                <i class="bi bi-printer"></i> طباعة التقرير
            </button>
        </div>

        <!-- Report Header -->
        <div class="report-header">
            <div class="row align-items-center">
                <div class="col-md-8">
                    <h1 class="mb-0">تقرير المريض</h1>
                    <p class="mb-0 mt-2">تاريخ التقرير: {{ now()->format('Y-m-d') }}</p>
                </div>
                <div class="col-md-4 text-end">
                    <h3>عيادات القافلة الطبية</h3>
                </div>
            </div>
        </div>

        <!-- Patient Information -->
        <div class="bg-white p-4 rounded shadow-sm">
            <h3 class="text-primary mb-4">المعلومات الشخصية</h3>

            <div class="row">
                <div class="col-md-6">
                    <div class="info-card">
                        <strong>الاسم الكامل:</strong> {{ $patient->name }}
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="info-card">
                        <strong>رقم الهاتف:</strong> {{ $patient->phone }}
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="info-card">
                        <strong>العمر:</strong> {{ $patient->age ?? 'غير محدد' }} سنة
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="info-card">
                        <strong>الجنس:</strong> {{ $patient->gender == 'male' ? 'ذكر' : 'أنثى' }}
                    </div>
                </div>
                @if($patient->blood_type)
                    <div class="col-md-6">
                        <div class="info-card">
                            <strong>فصيلة الدم:</strong> {{ $patient->blood_type }}
                        </div>
                    </div>
                @endif
                @if($patient->allergies)
                    <div class="col-md-6">
                        <div class="info-card">
                            <strong>الحساسية:</strong> {{ $patient->allergies }}
                        </div>
                    </div>
                @endif
            </div>

            <!-- Appointments History -->
            <div class="section-title">
                <h4 class="mb-0">سجل المواعيد ({{ $patient->appointments->count() }})</h4>
            </div>

            @if($patient->appointments->count() > 0)
                <div class="table-responsive">
                    <table class="table table-bordered">
                        <thead class="table-light">
                            <tr>
                                <th>التاريخ</th>
                                <th>الوقت</th>
                                <th>الطبيب</th>
                                <th>القسم</th>
                                <th>الحالة</th>
                                <th>السبب</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($patient->appointments->sortByDesc('appointment_date') as $appointment)
                                <tr>
                                    <td>{{ $appointment->appointment_date }}</td>
                                    <td>{{ $appointment->appointment_time }}</td>
                                    <td>{{ $appointment->doctor->name ?? 'غير محدد' }}</td>
                                    <td>{{ $appointment->doctor->department->name ?? 'غير محدد' }}</td>
                                    <td>
                                        @if($appointment->status == 'completed')
                                            <span class="badge bg-success">مكتمل</span>
                                        @elseif($appointment->status == 'cancelled')
                                            <span class="badge bg-danger">ملغي</span>
                                        @else
                                            <span class="badge bg-warning">معلق</span>
                                        @endif
                                    </td>
                                    <td>{{ $appointment->reason ?? '-' }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @else
                <p class="text-muted">لا توجد مواعيد مسجلة</p>
            @endif

            <!-- Medical History -->
            <div class="section-title">
                <h4 class="mb-0">التاريخ المرضي ({{ $patient->medicalHistories->count() }})</h4>
            </div>

            @if($patient->medicalHistories->count() > 0)
                @foreach($patient->medicalHistories->sortByDesc('visit_date') as $history)
                    <div class="info-card">
                        <div class="row">
                            <div class="col-md-12 mb-2">
                                <strong>تاريخ الزيارة:</strong> {{ $history->visit_date }}
                                <span class="float-end"><strong>الطبيب:</strong>
                                    {{ $history->doctor->name ?? 'غير محدد' }}</span>
                            </div>
                            <div class="col-md-12">
                                <strong>التشخيص:</strong> {{ $history->diagnosis }}
                            </div>
                            @if($history->symptoms)
                                <div class="col-md-12 mt-2">
                                    <strong>الأعراض:</strong> {{ $history->symptoms }}
                                </div>
                            @endif
                            @if($history->treatment)
                                <div class="col-md-12 mt-2">
                                    <strong>العلاج:</strong> {{ $history->treatment }}
                                </div>
                            @endif
                            @if($history->prescriptions)
                                <div class="col-md-12 mt-2">
                                    <strong>الوصفات الطبية:</strong> {{ $history->prescriptions }}
                                </div>
                            @endif
                        </div>
                    </div>
                @endforeach
            @else
                <p class="text-muted">لا يوجد تاريخ مرضي مسجل</p>
            @endif

            <!-- Invoices -->
            <div class="section-title">
                <h4 class="mb-0">الفواتير ({{ $patient->invoices->count() }})</h4>
            </div>

            @if($patient->invoices->count() > 0)
                <div class="table-responsive">
                    <table class="table table-bordered">
                        <thead class="table-light">
                            <tr>
                                <th>رقم الفاتورة</th>
                                <th>التاريخ</th>
                                <th>المبلغ الإجمالي</th>
                                <th>المدفوع</th>
                                <th>المتبقي</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($patient->invoices->sortByDesc('created_at') as $invoice)
                                <tr>
                                    <td>#{{ $invoice->id }}</td>
                                    <td>{{ $invoice->created_at->format('Y-m-d') }}</td>
                                    <td>{{ number_format($invoice->total_amount, 2) }} جنيه</td>
                                    <td>{{ number_format($invoice->amount_paid, 2) }} جنيه</td>
                                    <td>{{ number_format($invoice->remaining_amount, 2) }} جنيه</td>
                                </tr>
                            @endforeach
                        </tbody>
                        <tfoot class="table-light">
                            <tr>
                                <th colspan="2">الإجمالي</th>
                                <th>{{ number_format($patient->invoices->sum('total_amount'), 2) }} جنيه</th>
                                <th>{{ number_format($patient->invoices->sum('amount_paid'), 2) }} جنيه</th>
                                <th>{{ number_format($patient->invoices->sum('remaining_amount'), 2) }} جنيه</th>
                            </tr>
                        </tfoot>
                    </table>
                </div>
            @else
                <p class="text-muted">لا توجد فواتير مسجلة</p>
            @endif
        </div>

        <!-- Footer -->
        <div class="text-center mt-4 text-muted">
            <p>تم إنشاء هذا التقرير بواسطة عيادات القافلة الطبية</p>
        </div>
    </div>
</body>

</html>