@extends('layouts.app')

@section('title', 'تعديل الموعد')

@section('content')
    <div class="container-fluid">
        <div class="row mb-4">
            <div class="col-12">
                <h2 class="fw-bold text-dark">تعديل الموعد</h2>
                <p class="text-muted">تحديث بيانات الموعد رقم #{{ $appointment->id }}</p>
            </div>
        </div>

        <div class="row">
            <div class="col-lg-8">
                <div class="card">
                    <div class="card-header">
                        <h5 class="mb-0"><i class="bi bi-pencil me-2"></i>تعديل البيانات</h5>
                    </div>
                    <div class="card-body">
                        <form action="{{ route('appointments.update', $appointment->id) }}" method="POST">
                            @csrf
                            @method('PUT')

                            <div class="row">
                                <!-- Patient Name (Read-only) -->
                                <div class="col-md-6 mb-3">
                                    <label for="patient_name" class="form-label">المريض</label>
                                    <input type="text" class="form-control" id="patient_name" 
                                        value="{{ $appointment->patient->name }} - {{ $appointment->patient->phone }}" readonly>
                                    <input type="hidden" name="patient_id" value="{{ $appointment->patient_id }}">
                                </div>

                                <!-- Age Field -->
                                <div class="col-md-6 mb-3">
                                    <label for="age" class="form-label">العمر <span class="text-danger">*</span></label>
                                    <div class="input-group">
                                        <input type="text" class="form-control @error('age') is-invalid @enderror" 
                                            id="age" name="age" value="{{ old('age', $appointment->age) }}" 
                                            placeholder="أدخل العمر" required>
                                        <span class="input-group-text">سنة</span>
                                    </div>
                                    @error('age')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <!-- Department Selection -->
                                <div class="col-md-6 mb-3">
                                    <label for="department_id" class="form-label">القسم <span class="text-danger">*</span></label>
                                    <select class="form-select" id="department_id" required>
                                        <option value="">اختر القسم</option>
                                        @foreach($departments as $department)
                                            <option value="{{ $department->id }}" 
                                                {{ old('department_id', $appointment->doctor->department_id ?? '') == $department->id ? 'selected' : '' }}>
                                                {{ $department->name }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>

                                <!-- Doctor Selection -->
                                <div class="col-md-6 mb-3">
                                    <label for="user_id" class="form-label">الطبيب <span class="text-danger">*</span></label>
                                    <select class="form-select @error('user_id') is-invalid @enderror" id="user_id"
                                        name="user_id" required>
                                        <option value="">اختر القسم أولاً</option>
                                        @foreach($departments as $department)
                                            @foreach($department->doctors as $doctor)
                                                <option value="{{ $doctor->id }}" 
                                                    data-department="{{ $department->id }}"
                                                    {{ old('user_id', $appointment->user_id) == $doctor->id ? 'selected' : '' }}>
                                                    {{ $doctor->name }}
                                                </option>
                                            @endforeach
                                        @endforeach
                                    </select>
                                    @error('user_id')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label for="appointment_date" class="form-label">تاريخ الموعد <span
                                            class="text-danger">*</span></label>
                                    <input type="date" class="form-control @error('appointment_date') is-invalid @enderror"
                                        id="appointment_date" name="appointment_date"
                                        value="{{ old('appointment_date', $appointment->appointment_date->format('Y-m-d')) }}" required>
                                    @error('appointment_date')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="col-md-6 mb-3">
                                    <label for="appointment_time" class="form-label">وقت الموعد <span
                                            class="text-danger">*</span></label>
                                    <input type="text" class="form-control @error('appointment_time') is-invalid @enderror"
                                        id="appointment_time" name="appointment_time"
                                        value="{{ old('appointment_time', $appointment->appointment_time->format('H:i')) }}"
                                        placeholder="00:00" required>
                                    @error('appointment_time')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <div class="mb-3">
                                <label for="status" class="form-label">الحالة <span class="text-danger">*</span></label>
                                <select class="form-select @error('status') is-invalid @enderror" id="status" name="status"
                                    required>
                                    <option value="">اختر الحالة</option>
                                    <option value="pending" {{ old('status', $appointment->status) == 'pending' ? 'selected' : '' }}>معلق</option>
                                    <option value="confirmed" {{ old('status', $appointment->status) == 'confirmed' ? 'selected' : '' }}>مؤكد</option>
                                    <option value="completed" {{ old('status', $appointment->status) == 'completed' ? 'selected' : '' }}>مكتمل</option>
                                    <option value="cancelled" {{ old('status', $appointment->status) == 'cancelled' ? 'selected' : '' }}>ملغي</option>
                                </select>
                                @error('status')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="mb-3">
                                <label for="reason" class="form-label">سبب الزيارة</label>
                                <textarea class="form-control @error('reason') is-invalid @enderror" id="reason"
                                    name="reason" rows="3">{{ old('reason', $appointment->reason) }}</textarea>
                                @error('reason')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="mb-3">
                                <label for="notes" class="form-label">ملاحظات</label>
                                <textarea class="form-control @error('notes') is-invalid @enderror" id="notes" name="notes"
                                    rows="3">{{ old('notes', $appointment->notes) }}</textarea>
                                @error('notes')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="d-flex gap-2">
                                <button type="submit" class="btn btn-primary">
                                    <i class="bi bi-check-circle me-2"></i>تحديث
                                </button>
                                <a href="{{ route('appointments.index') }}" class="btn btn-secondary">
                                    <i class="bi bi-x-circle me-2"></i>إلغاء
                                </a>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    @push('scripts')
        <script>
            $(document).ready(function() {
                const departmentsData = @json($departments);
                
                // Convert Arabic numerals to English
                function convertArabicToEnglish(str) {
                    const arabicNumbers = ['٠', '١', '٢', '٣', '٤', '٥', '٦', '٧', '٨', '٩'];
                    const englishNumbers = ['0', '1', '2', '3', '4', '5', '6', '7', '8', '9'];
                    
                    for (let i = 0; i < arabicNumbers.length; i++) {
                        str = str.replace(new RegExp(arabicNumbers[i], 'g'), englishNumbers[i]);
                    }
                    return str;
                }

                // Age input - accept Arabic and English numbers
                $('#age').on('input', function() {
                    let value = $(this).val();
                    value = convertArabicToEnglish(value);
                    // Remove non-numeric characters
                    value = value.replace(/[^0-9]/g, '');
                    $(this).val(value);
                });
                
                // Department change handler
                $('#department_id').on('change', function() {
                    const departmentId = $(this).val();
                    const doctorSelect = $('#user_id');
                    
                    doctorSelect.html('<option value="">اختر الطبيب</option>');
                    
                    if (departmentId) {
                        const department = departmentsData.find(d => d.id == departmentId);
                        if (department && department.doctors) {
                            department.doctors.forEach(doctor => {
                                doctorSelect.append(
                                    `<option value="${doctor.id}">${doctor.name}</option>`
                                );
                            });
                        }
                    }
                });

                // Filter doctors on page load based on selected department
                const selectedDepartmentId = $('#department_id').val();
                if (selectedDepartmentId) {
                    $('#department_id').trigger('change');
                    // Re-select the doctor
                    const selectedDoctorId = {{ $appointment->user_id }};
                    $('#user_id').val(selectedDoctorId);
                }
            });
        </script>
    @endpush
@endsection