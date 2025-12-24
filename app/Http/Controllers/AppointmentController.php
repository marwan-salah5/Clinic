<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class AppointmentController extends Controller
{
    public function index(Request $request)
    {
        $query = \App\Models\Appointment::with(['patient', 'doctor']);

        // If user is a doctor, show only their appointments
        if (auth()->user()->department_id) {
            $query->where('user_id', auth()->id());
        }

        if ($request->has('status')) {
            $query->where('status', $request->status);
        }

        if ($request->has('date')) {
            $query->whereDate('appointment_date', $request->date);
        }

        $appointments = $query->latest('appointment_date')->paginate(15);
        return view('appointments.index', compact('appointments'));
    }

    public function create()
    {
        $patients = \App\Models\Patient::orderBy('name')->get();
        $departments = \App\Models\Department::with('doctors')->get();
        return view('appointments.create', compact('patients', 'departments'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'patient_id' => 'required|exists:patients,id',
            'user_id' => 'required|exists:users,id',
            'appointment_date' => 'required|date',
            'appointment_time' => 'required',
            'status' => 'required|in:pending,confirmed,completed,cancelled',
            'reason' => 'nullable|string',
            'notes' => 'nullable|string',
            'referral_source' => 'nullable|string',
            'age' => 'nullable|integer|min:0|max:150',
            'amount_paid' => 'nullable', // Remove numeric validation here, validate after conversion
        ]);

        if ($request->filled('amount_paid')) {
            $validated['amount_paid'] = $this->convertDigits($request->amount_paid);
        }

        $validated['appointment_time'] = $this->formatTime($validated['appointment_time']);

        // Update patient with referral source and age
        $patient = \App\Models\Patient::find($validated['patient_id']);
        if ($patient) {
            $updateData = [];

            if ($request->filled('referral_source')) {
                $updateData['referral_source'] = $validated['referral_source'];
            }

            if ($request->filled('age')) {
                $updateData['age'] = $validated['age'];
            }

            if (!empty($updateData)) {
                $patient->update($updateData);
            }
        }

        unset($validated['referral_source']);

        $appointment = \App\Models\Appointment::create($validated);

        // Create Invoice if amount is paid
        if (!empty($validated['amount_paid']) && $validated['amount_paid'] > 0) {
            $invoice = \App\Models\Invoice::create([
                'patient_id' => $appointment->patient_id,
                'appointment_id' => $appointment->id,
                'invoice_number' => 'INV-' . date('Ymd') . '-' . rand(1000, 9999),
                'invoice_date' => now(),
                'total_amount' => $validated['amount_paid'],
                'amount_paid' => $validated['amount_paid'],
                'remaining_amount' => 0,
                'status' => 'paid',
                'notes' => 'دفعة مقدمة عند حجز الموعد',
            ]);

            return redirect()->route('invoices.show', $invoice->id)->with('success', 'تم حجز الموعد وإنشاء الفاتورة بنجاح');
        }

        return redirect()->route('appointments.index')->with('success', 'تم إضافة الموعد بنجاح');
    }

    public function show($id)
    {
        $appointment = \App\Models\Appointment::with(['patient', 'doctor'])->findOrFail($id);
        return view('appointments.show', compact('appointment'));
    }

    public function edit($id)
    {
        $appointment = \App\Models\Appointment::findOrFail($id);
        $patients = \App\Models\Patient::orderBy('name')->get();
        $departments = \App\Models\Department::with('doctors')->get();
        return view('appointments.edit', compact('appointment', 'patients', 'departments'));
    }

    public function update(Request $request, $id)
    {
        $appointment = \App\Models\Appointment::findOrFail($id);

        $validated = $request->validate([
            'patient_id' => 'required|exists:patients,id',
            'user_id' => 'required|exists:users,id',
            'appointment_date' => 'required|date',
            'appointment_time' => 'required',
            'status' => 'required|in:pending,confirmed,completed,cancelled',
            'reason' => 'nullable|string',
            'notes' => 'nullable|string',
            'age' => 'nullable|integer|min:0|max:150',
        ]);

        $validated['appointment_time'] = $this->formatTime($validated['appointment_time']);

        // Update patient age if provided
        if ($request->filled('age')) {
            $patient = \App\Models\Patient::find($validated['patient_id']);
            if ($patient) {
                $patient->update(['age' => $validated['age']]);
            }
        }

        $appointment->update($validated);

        return redirect()->route('appointments.show', $appointment->id)->with('success', 'تم تحديث الموعد بنجاح');
    }

    public function destroy($id)
    {
        $appointment = \App\Models\Appointment::findOrFail($id);
        $appointment->delete();

        return redirect()->route('appointments.index')->with('success', 'تم حذف الموعد بنجاح');
    }

    private function formatTime($time)
    {
        if (empty($time)) {
            return $time;
        }

        $time = $this->convertDigits($time);

        $time = str_replace(['صباحا', 'صباحاً', 'ص'], 'AM', $time);
        $time = str_replace(['مساء', 'مساءً', 'م'], 'PM', $time);

        try {
            return \Carbon\Carbon::parse($time)->format('H:i:s');
        } catch (\Exception $e) {
            return $time;
        }
    }

    private function convertDigits($string)
    {
        if (empty($string)) {
            return $string;
        }

        $arabicDigits = ['٠', '١', '٢', '٣', '٤', '٥', '٦', '٧', '٨', '٩'];
        $englishDigits = ['0', '1', '2', '3', '4', '5', '6', '7', '8', '9'];
        return str_replace($arabicDigits, $englishDigits, $string);
    }
}
