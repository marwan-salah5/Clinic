<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\PatientController;
use App\Http\Controllers\AppointmentController;
use App\Http\Controllers\MedicalHistoryController;
use App\Http\Controllers\SearchController;
use App\Http\Controllers\FollowUpController;
use App\Http\Controllers\DoctorController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\UserController;

// Authentication Routes (Public)
Route::get('login', [LoginController::class, 'showLoginForm'])->name('login');
Route::post('login', [LoginController::class, 'login']);

// Protected Routes (Require Authentication)
Route::middleware(['auth'])->group(function () {
    // Logout
    Route::post('logout', [LoginController::class, 'logout'])->name('logout');

    // Dashboard
    Route::get('/', [DashboardController::class, 'index'])->name('dashboard');

    // Patients
    Route::resource('patients', PatientController::class);
    Route::post('api/patients/search-by-phone', [PatientController::class, 'searchByPhone'])->name('patients.search-by-phone');
    Route::post('api/patients/quick-create', [PatientController::class, 'quickCreate'])->name('patients.quick-create');

    // Appointments
    Route::resource('appointments', AppointmentController::class);

    // Medical History
    Route::resource('medical-history', MedicalHistoryController::class);

    // Doctors
    Route::resource('doctors', DoctorController::class);

    // Invoices
    Route::resource('invoices', \App\Http\Controllers\InvoiceController::class);

    // Follow-ups
    Route::resource('follow-ups', FollowUpController::class);

    // Search
    Route::get('search', [SearchController::class, 'search'])->name('search');

    // Reports
    Route::get('reports', [\App\Http\Controllers\ReportController::class, 'index'])->name('reports.index');
    Route::get('reports/patient/{id}', [\App\Http\Controllers\ReportController::class, 'patientReport'])->name('reports.patient');
    Route::get('reports/comprehensive', [\App\Http\Controllers\ReportController::class, 'comprehensive'])->name('reports.comprehensive');

    // Admin-only Routes
    Route::middleware(['role:admin'])->group(function () {
        Route::resource('users', UserController::class)->except(['show']);

        // Fix Invoices Data (Temporary)
        Route::get('fix-invoices', function () {
            $invoices = \App\Models\Invoice::where('amount_paid', 0)->where('total_amount', '>', 0)->get();
            foreach ($invoices as $invoice) {
                if ($invoice->status == 'paid') {
                    $invoice->update([
                        'amount_paid' => $invoice->total_amount,
                        'remaining_amount' => 0
                    ]);
                } else {
                    $invoice->update([
                        'remaining_amount' => $invoice->total_amount
                    ]);
                }
            }
            return "تم تصحيح بيانات " . $invoices->count() . " فاتورة بنجاح.";
        });
    });
});
