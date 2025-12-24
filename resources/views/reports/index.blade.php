@extends('layouts.app')

@section('title', 'التقارير')

@section('content')
    <div class="container-fluid">
        <div class="row mb-4">
            <div class="col-12">
                <h2 class="fw-bold text-dark">التقارير</h2>
                <p class="text-muted">إنشاء وعرض التقارير المختلفة</p>
            </div>
        </div>

        <div class="row">
            <!-- Comprehensive Reports -->
            <div class="col-md-6 mb-4">
                <div class="card h-100">
                    <div class="card-header">
                        <h5 class="mb-0"><i class="bi bi-file-earmark-bar-graph me-2"></i>التقارير الشاملة</h5>
                    </div>
                    <div class="card-body">
                        <p class="text-muted">تقارير يومية، شهرية، وسنوية شاملة لجميع المعاملات</p>
                        
                        <form action="{{ route('reports.comprehensive') }}" method="GET" target="_blank">
                            <div class="mb-3">
                                <label for="type" class="form-label">نوع التقرير</label>
                                <select class="form-select" id="type" name="type" required>
                                    <option value="daily">يومي</option>
                                    <option value="monthly">شهري</option>
                                    <option value="yearly">سنوي</option>
                                </select>
                            </div>

                            <div class="mb-3">
                                <label for="date" class="form-label">التاريخ</label>
                                <input type="date" class="form-control" id="date" name="date" 
                                    value="{{ date('Y-m-d') }}" required>
                            </div>

                            <button type="submit" class="btn btn-primary w-100">
                                <i class="bi bi-file-earmark-pdf me-2"></i>إنشاء التقرير
                            </button>
                        </form>
                    </div>
                </div>
            </div>

            <!-- Patient Individual Report -->
            <div class="col-md-6 mb-4">
                <div class="card h-100">
                    <div class="card-header">
                        <h5 class="mb-0"><i class="bi bi-person-lines-fill me-2"></i>تقرير مريض فردي</h5>
                    </div>
                    <div class="card-body">
                        <p class="text-muted">تقرير مفصل لسجل معاملات مريض معين</p>
                        
                        <div class="mb-3">
                            <label for="patient_search" class="form-label">بحث عن المريض</label>
                            <input type="text" class="form-control" id="patient_search" 
                                placeholder="ابحث برقم الهاتف...">
                            <div id="patient_results" class="mt-2"></div>
                        </div>

                        <div id="selected_patient" class="alert alert-info d-none">
                            <strong>المريض المختار:</strong> <span id="patient_name"></span>
                            <button type="button" class="btn btn-sm btn-primary float-end" id="generate_patient_report">
                                <i class="bi bi-file-earmark-pdf me-1"></i>إنشاء التقرير
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    @push('scripts')
        <script>
            $(document).ready(function() {
                let selectedPatientId = null;

                // Patient search
                $('#patient_search').on('input', function() {
                    const phone = $(this).val();
                    
                    if (phone.length >= 3) {
                        $.ajax({
                            url: '{{ route('patients.search-by-phone') }}',
                            method: 'POST',
                            data: {
                                _token: '{{ csrf_token() }}',
                                phone: phone
                            },
                            success: function(response) {
                                if (response.patients && response.patients.length > 0) {
                                    let html = '<div class="list-group">';
                                    response.patients.forEach(patient => {
                                        html += `
                                            <a href="#" class="list-group-item list-group-item-action patient-item" 
                                                data-id="${patient.id}" data-name="${patient.name}">
                                                <strong>${patient.name}</strong> - ${patient.phone}
                                            </a>
                                        `;
                                    });
                                    html += '</div>';
                                    $('#patient_results').html(html);
                                } else {
                                    $('#patient_results').html('<p class="text-muted">لا توجد نتائج</p>');
                                }
                            }
                        });
                    } else {
                        $('#patient_results').html('');
                    }
                });

                // Select patient
                $(document).on('click', '.patient-item', function(e) {
                    e.preventDefault();
                    selectedPatientId = $(this).data('id');
                    const patientName = $(this).data('name');
                    
                    $('#patient_name').text(patientName);
                    $('#selected_patient').removeClass('d-none');
                    $('#patient_results').html('');
                    $('#patient_search').val('');
                });

                // Generate patient report
                $('#generate_patient_report').on('click', function() {
                    if (selectedPatientId) {
                        window.open(`{{ url('reports/patient') }}/${selectedPatientId}`, '_blank');
                    }
                });
            });
        </script>
    @endpush
@endsection
