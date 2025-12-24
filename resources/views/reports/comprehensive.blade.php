<!DOCTYPE html>
<html lang="ar" dir="rtl">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>التقرير الشامل -
        @if($type == 'daily') يومي
        @elseif($type == 'monthly') شهري
        @else سنوي
        @endif
    </title>
    <link href="https://fonts.googleapis.com/css2?family=Cairo:wght@300;400;600;700&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.rtl.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css">
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

        .stats-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
            gap: 20px;
            margin-bottom: 30px;
        }

        .stat-card {
            background: white;
            padding: 20px;
            border-radius: 10px;
            border-left: 4px solid #667eea;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
        }

        .stat-card h3 {
            font-size: 2rem;
            font-weight: 700;
            color: #667eea;
            margin: 10px 0;
        }

        .stat-card p {
            color: #718096;
            margin: 0;
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
                    <h1 class="mb-0">التقرير الشامل -
                        @if($type == 'daily') يومي
                        @elseif($type == 'monthly') شهري
                        @else سنوي
                        @endif
                    </h1>
                    <p class="mb-0 mt-2">
                        من: {{ $startDate->format('Y-m-d') }} إلى: {{ $endDate->format('Y-m-d') }}
                    </p>
                </div>
                <div class="col-md-4 text-end">
                    <h3>عيادات القافلة الطبية</h3>
                    <p class="mb-0">تاريخ الإنشاء: {{ now()->format('Y-m-d H:i') }}</p>
                </div>
            </div>
        </div>

        <!-- Statistics -->
        <div class="stats-grid">
            <div class="stat-card">
                <i class="bi bi-people text-primary" style="font-size: 2rem;"></i>
                <h3>{{ $stats['total_patients'] }}</h3>
                <p>مرضى جدد</p>
            </div>

            <div class="stat-card">
                <i class="bi bi-calendar-check text-success" style="font-size: 2rem;"></i>
                <h3>{{ $stats['total_appointments'] }}</h3>
                <p>إجمالي المواعيد</p>
            </div>

            <div class="stat-card">
                <i class="bi bi-check-circle text-info" style="font-size: 2rem;"></i>
                <h3>{{ $stats['completed_appointments'] }}</h3>
                <p>مواعيد مكتملة</p>
            </div>

            <div class="stat-card">
                <i class="bi bi-x-circle text-danger" style="font-size: 2rem;"></i>
                <h3>{{ $stats['cancelled_appointments'] }}</h3>
                <p>مواعيد ملغاة</p>
            </div>

            <div class="stat-card">
                <i class="bi bi-file-medical text-warning" style="font-size: 2rem;"></i>
                <h3>{{ $stats['total_medical_records'] }}</h3>
                <p>سجلات طبية</p>
            </div>

            <div class="stat-card">
                <i class="bi bi-cash-stack text-success" style="font-size: 2rem;"></i>
                <h3>{{ number_format($stats['total_revenue'], 0) }}</h3>
                <p>إجمالي الإيرادات (جنيه)</p>
            </div>
        </div>

        <!-- Financial Summary -->
        <div class="bg-white p-4 rounded shadow-sm mb-4">
            <h3 class="text-primary mb-4">الملخص المالي</h3>

            <div class="table-responsive">
                <table class="table table-bordered">
                    <thead class="table-light">
                        <tr>
                            <th>البيان</th>
                            <th>المبلغ (جنيه)</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>إجمالي الإيرادات</td>
                            <td class="fw-bold text-success">{{ number_format($stats['total_revenue'], 2) }}</td>
                        </tr>
                        <tr>
                            <td>المبالغ المدفوعة</td>
                            <td class="fw-bold text-info">{{ number_format($stats['paid_amount'], 2) }}</td>
                        </tr>
                        <tr>
                            <td>المبالغ المتبقية</td>
                            <td class="fw-bold text-warning">{{ number_format($stats['remaining_amount'], 2) }}</td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>

        <!-- Appointments Details -->
        <div class="section-title">
            <h4 class="mb-0">تفاصيل المواعيد ({{ $appointments->count() }})</h4>
        </div>

        @if($appointments->count() > 0)
            <div class="bg-white p-4 rounded shadow-sm mb-4">
                <div class="table-responsive">
                    <table class="table table-striped table-hover">
                        <thead class="table-light">
                            <tr>
                                <th>#</th>
                                <th>المريض</th>
                                <th>الطبيب</th>
                                <th>القسم</th>
                                <th>التاريخ</th>
                                <th>الوقت</th>
                                <th>الحالة</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($appointments as $index => $appointment)
                                <tr>
                                    <td>{{ $index + 1 }}</td>
                                    <td>{{ $appointment->patient->name }}</td>
                                    <td>{{ $appointment->doctor->name ?? 'غير محدد' }}</td>
                                    <td>{{ $appointment->doctor->department->name ?? 'غير محدد' }}</td>
                                    <td>{{ $appointment->appointment_date }}</td>
                                    <td>{{ $appointment->appointment_time }}</td>
                                    <td>
                                        @if($appointment->status == 'completed')
                                            <span class="badge bg-success">مكتمل</span>
                                        @elseif($appointment->status == 'cancelled')
                                            <span class="badge bg-danger">ملغي</span>
                                        @else
                                            <span class="badge bg-warning">معلق</span>
                                        @endif
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        @else
            <p class="text-muted">لا توجد مواعيد في هذه الفترة</p>
        @endif

        <!-- New Patients -->
        <div class="section-title">
            <h4 class="mb-0">المرضى الجدد ({{ $patients->count() }})</h4>
        </div>

        @if($patients->count() > 0)
            <div class="bg-white p-4 rounded shadow-sm mb-4">
                <div class="table-responsive">
                    <table class="table table-striped table-hover">
                        <thead class="table-light">
                            <tr>
                                <th>#</th>
                                <th>الاسم</th>
                                <th>الهاتف</th>
                                <th>العمر</th>
                                <th>الجنس</th>
                                <th>تاريخ التسجيل</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($patients as $index => $patient)
                                <tr>
                                    <td>{{ $index + 1 }}</td>
                                    <td>{{ $patient->name }}</td>
                                    <td>{{ $patient->phone }}</td>
                                    <td>{{ $patient->age ?? 'غير محدد' }}</td>
                                    <td>{{ $patient->gender == 'male' ? 'ذكر' : 'أنثى' }}</td>
                                    <td>{{ $patient->created_at->format('Y-m-d') }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        @else
            <p class="text-muted">لا يوجد مرضى جدد في هذه الفترة</p>
        @endif

        <!-- Medical Records -->
        <div class="section-title">
            <h4 class="mb-0">السجلات الطبية ({{ $medicalHistories->count() }})</h4>
        </div>

        @if($medicalHistories->count() > 0)
            <div class="bg-white p-4 rounded shadow-sm mb-4">
                <div class="table-responsive">
                    <table class="table table-striped table-hover">
                        <thead class="table-light">
                            <tr>
                                <th>#</th>
                                <th>المريض</th>
                                <th>الطبيب</th>
                                <th>القسم</th>
                                <th>التشخيص</th>
                                <th>تاريخ الزيارة</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($medicalHistories as $index => $history)
                                <tr>
                                    <td>{{ $index + 1 }}</td>
                                    <td>{{ $history->patient->name }}</td>
                                    <td>{{ $history->doctor->name ?? 'غير محدد' }}</td>
                                    <td>{{ $history->doctor->department->name ?? 'غير محدد' }}</td>
                                    <td>{{ Str::limit($history->diagnosis, 50) }}</td>
                                    <td>{{ $history->visit_date }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        @else
            <p class="text-muted">لا توجد سجلات طبية في هذه الفترة</p>
        @endif

        <!-- Footer -->
        <div class="text-center mt-5 text-muted">
            <p>تم إنشاء هذا التقرير بواسطة عيادات القافلة الطبية</p>
            <p class="small">{{ now()->format('Y-m-d H:i:s') }}</p>
        </div>
    </div>
</body>

</html>