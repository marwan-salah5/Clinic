@extends('layouts.app')

@section('title', 'حجز موعد جديد')

@section('content')
    <div class="container-fluid">
        <div class="row mb-4">
            <div class="col-12">
                <h2 class="fw-bold text-dark">حجز موعد جديد</h2>
                <p class="text-muted">إضافة موعد جديد لمريض</p>
            </div>
        </div>

        <div class="row">
            <div class="col-lg-8">
                <div class="card">
                    <div class="card-header">
                        <h5 class="mb-0"><i class="bi bi-calendar-plus me-2"></i>بيانات الموعد</h5>
                    </div>
                    <div class="card-body">
                        <form action="{{ route('appointments.store') }}" method="POST" id="appointmentForm">
                            @csrf

                            <div class="row">
                                <!-- Patient Selection -->
                                <div class="col-md-12 mb-3">
                                    <label for="patient_id" class="form-label">المريض <span
                                            class="text-danger">*</span></label>
                                    <div class="input-group">
                                        <select class="form-select" id="patient_id" name="patient_id" required>
                                            <option value="">ابحث عن المريض...</option>
                                        </select>
                                        <button type="button" class="btn btn-success" id="addNewPatientBtn">
                                            <i class="bi bi-person-plus"></i>
                                        </button>
                                    </div>
                                    @error('patient_id')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <!-- Age Field -->
                                <div class="col-md-6 mb-3">
                                    <label for="age" class="form-label">العمر <span class="text-danger">*</span></label>
                                    <div class="input-group">
                                        <input type="text" class="form-control @error('age') is-invalid @enderror" id="age"
                                            name="age" value="{{ old('age') }}" placeholder="أدخل العمر" required>
                                        <span class="input-group-text">سنة</span>
                                    </div>
                                    @error('age')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <!-- Referral Source -->
                                <div class="col-md-6 mb-3">
                                    <label for="referral_source" class="form-label">كيف علم عنا</label>
                                    <select class="form-select @error('referral_source') is-invalid @enderror"
                                        id="referral_source" name="referral_source">
                                        <option value="">اختر المصدر</option>
                                        <option value="social_media" {{ old('referral_source') == 'social_media' ? 'selected' : '' }}>وسائل التواصل الاجتماعي</option>
                                        <option value="friend" {{ old('referral_source') == 'friend' ? 'selected' : '' }}>
                                            ترشيح من صديق</option>
                                        <option value="website" {{ old('referral_source') == 'website' ? 'selected' : '' }}>
                                            الموقع الإلكتروني</option>
                                        <option value="other" {{ old('referral_source') == 'other' ? 'selected' : '' }}>أخرى
                                        </option>
                                    </select>
                                    @error('referral_source')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <!-- Department Selection -->
                                <div class="col-md-6 mb-3">
                                    <label for="department_id" class="form-label">القسم <span
                                            class="text-danger">*</span></label>
                                    <select class="form-select" id="department_id" required>
                                        <option value="">اختر القسم</option>
                                        @foreach($departments as $department)
                                            <option value="{{ $department->id }}" {{ old('department_id') == $department->id ? 'selected' : '' }}>
                                                {{ $department->name }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>

                                <!-- Doctor Selection -->
                                <div class="col-md-6 mb-3">
                                    <label for="user_id" class="form-label">الطبيب <span
                                            class="text-danger">*</span></label>
                                    <select class="form-select @error('user_id') is-invalid @enderror" id="user_id"
                                        name="user_id" required>
                                        <option value="">اختر القسم أولاً</option>
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
                                        id="appointment_date" name="appointment_date" value="{{ old('appointment_date') }}"
                                        required>
                                    @error('appointment_date')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="col-md-6 mb-3">
                                    <label for="appointment_time" class="form-label">وقت الموعد <span
                                            class="text-danger">*</span></label>
                                    <input type="time" class="form-control @error('appointment_time') is-invalid @enderror"
                                        id="appointment_time" name="appointment_time" value="{{ old('appointment_time') }}"
                                        required>
                                    @error('appointment_time')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label for="amount_paid" class="form-label">المبلغ المدفوع</label>
                                    <div class="input-group">
                                        <input type="text" class="form-control @error('amount_paid') is-invalid @enderror"
                                            id="amount_paid" name="amount_paid" value="{{ old('amount_paid') }}"
                                            placeholder="0.00">
                                        <span class="input-group-text">ج.م</span>
                                    </div>
                                    @error('amount_paid')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>


                                <div class="mb-3">
                                    <label for="status" class="form-label">الحالة <span class="text-danger">*</span></label>
                                    <select class="form-select @error('status') is-invalid @enderror" id="status"
                                        name="status" required>
                                        <option value="">اختر الحالة</option>
                                        <option value="completed" {{ old('status') == 'completed' ? 'selected' : '' }}>مكتمل
                                        </option>
                                        <option value="cancelled" {{ old('status') == 'cancelled' ? 'selected' : '' }}>ملغي
                                        </option>
                                    </select>
                                    @error('status')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="mb-3">
                                    <label for="reason" class="form-label">سبب الزيارة</label>
                                    <textarea class="form-control @error('reason') is-invalid @enderror" id="reason"
                                        name="reason" rows="3">{{ old('reason') }}</textarea>
                                    @error('reason')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="mb-3">
                                    <label for="notes" class="form-label">ملاحظات</label>
                                    <textarea class="form-control @error('notes') is-invalid @enderror" id="notes"
                                        name="notes" rows="3">{{ old('notes') }}</textarea>
                                    @error('notes')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="d-flex gap-2">
                                    <button type="submit" class="btn btn-primary">
                                        <i class="bi bi-check-circle me-2"></i>حجز الموعد
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

    <!-- Modal for Adding New Patient -->
    <div class="modal fade" id="addPatientModal" tabindex="-1" aria-labelledby="addPatientModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header"
                    style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); color: white;">
                    <h5 class="modal-title" id="addPatientModalLabel">
                        <i class="bi bi-person-plus me-2"></i>إضافة مريض جديد
                    </h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"
                        aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <p class="text-muted mb-3">
                        <i class="bi bi-info-circle me-1"></i>
                        فقط الاسم ورقم الهاتف مطلوبين. يمكن إضافة باقي المعلومات لاحقاً.
                    </p>
                    <form id="quickPatientForm">
                        @csrf
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="modal_name" class="form-label">الاسم الكامل <span
                                        class="text-danger">*</span></label>
                                <input type="text" class="form-control" id="modal_name" name="name" required autofocus>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="modal_phone" class="form-label">رقم الهاتف <span
                                        class="text-danger">*</span></label>
                                <input type="text" class="form-control" id="modal_phone" name="phone" required>
                            </div>
                            <div class="col-md-12 mb-3">
                                <label class="form-label">النوع <span class="text-danger">*</span></label>
                                <div class="d-flex gap-4">
                                    <div class="form-check">
                                        <input class="form-check-input" type="radio" name="gender" id="gender_male"
                                            value="male" checked>
                                        <label class="form-check-label" for="gender_male">
                                            <i class="bi bi-gender-male text-primary me-1"></i>ذكر
                                        </label>
                                    </div>
                                    <div class="form-check">
                                        <input class="form-check-input" type="radio" name="gender" id="gender_female"
                                            value="female">
                                        <label class="form-check-label" for="gender_female">
                                            <i class="bi bi-gender-female text-danger me-1"></i>أنثى
                                        </label>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                        <i class="bi bi-x-circle me-1"></i>إلغاء
                    </button>
                    <button type="button" class="btn btn-primary" id="savePatientBtn">
                        <i class="bi bi-check-circle me-1"></i>حفظ المريض
                    </button>
                </div>
            </div>
        </div>
    </div>

    @push('scripts')
        <script>
            $(document).ready(function () {
                const addPatientModal = new bootstrap.Modal(document.getElementById('addPatientModal'));

                // Initialize Select2
                $('#patient_id').select2({
                    theme: 'bootstrap-5',
                    placeholder: 'ابحث عن المريض بالاسم أو رقم الهاتف',
                    allowClear: true,
                    tags: true, // Enable smart creation
                    ajax: {
                        url: '{{ route("patients.index") }}',
                        dataType: 'json',
                        delay: 250,
                        data: function (params) {
                            return {
                                search: params.term, // search term
                                page: params.page || 1
                            };
                        },
                        processResults: function (data) {
                            return {
                                results: data.data.map(function (patient) {
                                    return {
                                        id: patient.id,
                                        text: patient.name + ' - ' + patient.phone,
                                        patient: patient // pass full object
                                    };
                                }),
                                pagination: {
                                    more: data.next_page_url ? true : false
                                }
                            };
                        },
                        cache: true
                    },
                    createTag: function (params) {
                        const term = $.trim(params.term);
                        if (term === '') {
                            return null;
                        }
                        
                        // Return a "new" tag object
                        return {
                            id: 'new:' + term,
                            text: 'إضافة مريض جديد: ' + term,
                            isNew: true,
                            term: term
                        };
                    },
                    minimumInputLength: 0,
                    language: {
                        inputTooShort: function () {
                            return "الرجاء إدخال حرف واحد على الأقل للبحث";
                        },
                        searching: function () {
                            return "جاري البحث...";
                        },
                        noResults: function () {
                            return "لا توجد نتائج - اضغط Enter للإضافة";
                        }
                    }
                });

                // Handle selection (existing or new)
                $('#patient_id').on('select2:select', function (e) {
                    const data = e.params.data;
                    
                    if (data.isNew) {
                        // It's a new patient request
                        // Clear the selection first so we don't submit "new:..."
                        $(this).val(null).trigger('change');
                        
                        // Open the modal with the term
                        openAddPatientModal(data.term);
                    }
                });

                window.openAddPatientModal = function (input) {
                    // Check if input is phone (digits, including Arabic ones) or name (text)
                    // Regex allows English digits, Arabic-Indic digits (٠-٩), +, -, and spaces
                    const isPhone = /^[0-9+\-\s\u0660-\u0669\u06F0-\u06F9]+$/.test(input);

                    if (isPhone) {
                        $('#modal_phone').val(input);
                        $('#modal_name').val('');
                        setTimeout(() => $('#modal_name').focus(), 500);
                    } else {
                        $('#modal_name').val(input);
                        $('#modal_phone').val('');
                        setTimeout(() => $('#modal_phone').focus(), 500);
                    }

                    addPatientModal.show();
                };

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
                $('#age').on('input', function () {
                    let value = $(this).val();
                    value = convertArabicToEnglish(value);
                    // Remove non-numeric characters
                    value = value.replace(/[^0-9]/g, '');
                    $(this).val(value);
                });

                // Open add patient modal
                $('#addNewPatientBtn').on('click', function () {
                    $('#quickPatientForm')[0].reset();
                    addPatientModal.show();
                    setTimeout(() => $('#modal_name').focus(), 500);
                });

                // Save new patient
                $('#savePatientBtn').on('click', function () {
                    const formData = $('#quickPatientForm').serialize();
                    const btn = $(this);

                    btn.prop('disabled', true).html('<span class="spinner-border spinner-border-sm me-1"></span>جاري الحفظ...');

                    $.ajax({
                        url: '{{ route("patients.quick-create") }}',
                        method: 'POST',
                        data: formData,
                        success: function (response) {
                            if (response.success) {
                                // Add new patient to Select2 and select it
                                const newOption = new Option(
                                    response.patient.name + ' - ' + response.patient.phone,
                                    response.patient.id,
                                    true,
                                    true
                                );
                                $('#patient_id').append(newOption).trigger('change');

                                // Close modal and reset form
                                addPatientModal.hide();
                                $('#quickPatientForm')[0].reset();
                            }
                        },
                        error: function (xhr) {
                            let errorMsg = 'حدث خطأ أثناء إضافة المريض';
                            if (xhr.responseJSON && xhr.responseJSON.errors) {
                                const errors = Object.values(xhr.responseJSON.errors).flat();
                                errorMsg = errors.join('<br>');
                            }
                            alert(errorMsg);
                        },
                        complete: function () {
                            btn.prop('disabled', false).html('<i class="bi bi-check-circle me-1"></i>حفظ المريض');
                        }
                    });
                });

                // Department change handler
                const departmentsData = @json($departments);
                $('#department_id').on('change', function () {
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
            });
        </script>
    @endpush
@endsection