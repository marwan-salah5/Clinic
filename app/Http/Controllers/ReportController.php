<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Patient;
use App\Models\Appointment;
use App\Models\Invoice;
use App\Models\MedicalHistory;
use Carbon\Carbon;

class ReportController extends Controller
{
    /**
     * Show reports page
     */
    public function index()
    {
        return view('reports.index');
    }

    /**
     * Generate patient individual report
     */
    public function patientReport($id)
    {
        $patient = Patient::with([
            'appointments.doctor.department',
            'medicalHistories.doctor.department',
            'invoices',
            'followUps'
        ])->findOrFail($id);

        return view('reports.patient', compact('patient'));
    }

    /**
     * Generate comprehensive reports (daily, monthly, yearly)
     */
    public function comprehensive(Request $request)
    {
        $type = $request->input('type', 'daily'); // daily, monthly, yearly
        $date = $request->input('date', now());

        $startDate = null;
        $endDate = null;

        switch ($type) {
            case 'daily':
                $startDate = Carbon::parse($date)->startOfDay();
                $endDate = Carbon::parse($date)->endOfDay();
                break;
            case 'monthly':
                $startDate = Carbon::parse($date)->startOfMonth();
                $endDate = Carbon::parse($date)->endOfMonth();
                break;
            case 'yearly':
                $startDate = Carbon::parse($date)->startOfYear();
                $endDate = Carbon::parse($date)->endOfYear();
                break;
        }

        // Get data for the period
        $appointments = Appointment::with(['patient', 'doctor.department'])
            ->whereBetween('appointment_date', [$startDate, $endDate])
            ->get();

        $invoices = Invoice::with(['patient', 'appointment'])
            ->whereBetween('created_at', [$startDate, $endDate])
            ->get();

        $medicalHistories = MedicalHistory::with(['patient', 'doctor.department'])
            ->whereBetween('visit_date', [$startDate, $endDate])
            ->get();

        $patients = Patient::whereBetween('created_at', [$startDate, $endDate])->get();

        // Statistics
        $stats = [
            'total_patients' => $patients->count(),
            'total_appointments' => $appointments->count(),
            'completed_appointments' => $appointments->where('status', 'completed')->count(),
            'cancelled_appointments' => $appointments->where('status', 'cancelled')->count(),
            'total_revenue' => $invoices->sum('total_amount'),
            'paid_amount' => $invoices->sum('amount_paid'),
            'remaining_amount' => $invoices->sum('remaining_amount'),
            'total_medical_records' => $medicalHistories->count(),
        ];

        return view('reports.comprehensive', compact(
            'type',
            'startDate',
            'endDate',
            'appointments',
            'invoices',
            'medicalHistories',
            'patients',
            'stats'
        ));
    }
}
