@extends('layouts.app')

@section('title', 'قائمة الفواتير')

@section('content')
    <div class="container-fluid">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h2 class="fw-bold text-dark">الفواتير</h2>
            <a href="{{ route('invoices.create') }}" class="btn btn-primary">
                <i class="bi bi-plus-lg me-2"></i>إنشاء فاتورة جديدة
            </a>
        </div>

        <div class="card shadow-sm">
            <div class="card-body">
                @if($invoices->count() > 0)
                    <div class="table-responsive">
                        <table class="table table-hover align-middle">
                            <thead class="table-light">
                                <tr>
                                    <th>رقم الفاتورة</th>
                                    <th>المريض</th>
                                    <th>التاريخ</th>
                                    <th>المبلغ</th>
                                    <th>الحالة</th>
                                    <th>الإجراءات</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($invoices as $invoice)
                                    <tr>
                                        <td class="fw-bold">{{ $invoice->invoice_number }}</td>
                                        <td>
                                            <a href="{{ route('patients.show', $invoice->patient_id) }}"
                                                class="text-decoration-none">
                                                {{ $invoice->patient->name }}
                                            </a>
                                        </td>
                                        <td>{{ $invoice->invoice_date }}</td>
                                        <td>{{ number_format($invoice->total_amount, 2) }} ج.م</td>
                                        <td>
                                            @if($invoice->status == 'paid')
                                                <span class="badge bg-success">مدفوع</span>
                                            @elseif($invoice->status == 'unpaid')
                                                <span class="badge bg-warning text-dark">غير مدفوع</span>
                                            @else
                                                <span class="badge bg-danger">ملغي</span>
                                            @endif
                                        </td>
                                        <td>
                                            <div class="btn-group btn-group-sm">
                                                <a href="{{ route('invoices.show', $invoice->id) }}" class="btn btn-outline-primary"
                                                    title="عرض / طباعة">
                                                    <i class="bi bi-printer"></i>
                                                </a>
                                                <form action="{{ route('invoices.destroy', $invoice->id) }}" method="POST"
                                                    class="d-inline"
                                                    onsubmit="return confirm('هل أنت متأكد من حذف هذه الفاتورة؟');">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="btn btn-outline-danger" title="حذف">
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
                    <div class="d-flex justify-content-center mt-4">
                        {{ $invoices->links() }}
                    </div>
                @else
                    <div class="text-center py-5">
                        <i class="bi bi-receipt text-muted display-1"></i>
                        <p class="mt-3 text-muted">لا توجد فواتير حالياً.</p>
                        <a href="{{ route('invoices.create') }}" class="btn btn-primary mt-2">إنشاء أول فاتورة</a>
                    </div>
                @endif
            </div>
        </div>
    </div>
@endsection