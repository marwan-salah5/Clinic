@extends('layouts.app')

@section('title', 'إنشاء فاتورة جديدة')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card shadow-sm">
                    <div class="card-header bg-primary text-white">
                        <h5 class="mb-0">إنشاء فاتورة جديدة</h5>
                    </div>
                    <div class="card-body">
                        <form action="{{ route('invoices.store') }}" method="POST">
                            @csrf

                            <div class="mb-3">
                                <label for="patient_id" class="form-label">المريض</label>
                                <select name="patient_id" id="patient_id"
                                    class="form-select @error('patient_id') is-invalid @enderror" required>
                                    <option value="">اختر المريض...</option>
                                    @foreach($patients as $p)
                                        <option value="{{ $p->id }}" {{ (old('patient_id') == $p->id || (isset($patient) && $patient->id == $p->id)) ? 'selected' : '' }}>
                                            {{ $p->name }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('patient_id')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="mb-3">
                                <label for="invoice_date" class="form-label">تاريخ الفاتورة</label>
                                <input type="date" name="invoice_date" id="invoice_date"
                                    class="form-control @error('invoice_date') is-invalid @enderror"
                                    value="{{ old('invoice_date', date('Y-m-d')) }}" required>
                                @error('invoice_date')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="mb-3">
                                <label for="amount" class="form-label">المبلغ الإجمالي</label>
                                <div class="input-group">
                                    <input type="number" step="0.01" name="amount" id="amount"
                                        class="form-control @error('amount') is-invalid @enderror"
                                        value="{{ old('amount') }}" required>
                                    <span class="input-group-text">ج.م</span>
                                </div>
                                @error('amount')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="mb-3">
                                <label for="status" class="form-label">الحالة</label>
                                <select name="status" id="status" class="form-select @error('status') is-invalid @enderror"
                                    required>
                                    <option value="unpaid" {{ old('status') == 'unpaid' ? 'selected' : '' }}>غير مدفوع
                                    </option>
                                    <option value="paid" {{ old('status') == 'paid' ? 'selected' : '' }}>مدفوع</option>
                                    <option value="cancelled" {{ old('status') == 'cancelled' ? 'selected' : '' }}>ملغي
                                    </option>
                                </select>
                                @error('status')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="mb-3">
                                <label for="notes" class="form-label">ملاحظات / تفاصيل الخدمة</label>
                                <textarea name="notes" id="notes" rows="4"
                                    class="form-control @error('notes') is-invalid @enderror">{{ old('notes') }}</textarea>
                                <div class="form-text">يمكنك كتابة تفاصيل الخدمات المقدمة هنا.</div>
                                @error('notes')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="d-flex justify-content-end">
                                <a href="{{ url()->previous() }}" class="btn btn-secondary me-2">إلغاء</a>
                                <button type="submit" class="btn btn-primary">حفظ الفاتورة</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection