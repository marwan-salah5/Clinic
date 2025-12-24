<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        $isDoctor = auth()->user()->department_id;

        if ($isDoctor) {
            // Doctor's dashboard - show only their data
            $totalPatients = \App\Models\Appointment::where('user_id', auth()->id())
                ->distinct('patient_id')
                ->count('patient_id');
            $todayAppointments = \App\Models\Appointment::where('user_id', auth()->id())
                ->whereDate('appointment_date', today())
                ->count();
            $totalMedicalRecords = \App\Models\MedicalHistory::where('user_id', auth()->id())->count();
            $pendingFollowUps = 0; // Doctors don't see follow-ups
            $upcomingAppointments = \App\Models\Appointment::with('patient')
                ->where('user_id', auth()->id())
                ->where('appointment_date', '>=', today())
                ->orderBy('appointment_date')
                ->orderBy('appointment_time')
                ->limit(5)
                ->get();
        } else {
            // Admin/Staff dashboard - show all data
            $totalPatients = \App\Models\Patient::count();
            $todayAppointments = \App\Models\Appointment::whereDate('appointment_date', today())->count();
            $totalMedicalRecords = \App\Models\MedicalHistory::count();
            $pendingFollowUps = \App\Models\FollowUp::where('status', 'pending')->count();
            $upcomingAppointments = \App\Models\Appointment::with('patient')
                ->where('appointment_date', '>=', today())
                ->orderBy('appointment_date')
                ->orderBy('appointment_time')
                ->limit(5)
                ->get();
        }

        return view('dashboard', compact(
            'totalPatients',
            'todayAppointments',
            'totalMedicalRecords',
            'pendingFollowUps',
            'upcomingAppointments'
        ));
    }
}
