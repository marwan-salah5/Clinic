<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class MedicalHistoryController extends Controller
{
    public function index(Request $request)
    {
        $query = \App\Models\MedicalHistory::with(['patient', 'doctor']);

        // If user is a doctor, show only their records
        if (auth()->user()->department_id) {
            $query->where('user_id', auth()->id());
        }

        if ($request->has('patient_id')) {
            $query->where('patient_id', $request->patient_id);
        }

        $histories = $query->latest('visit_date')->paginate(15);
        $patients = \App\Models\Patient::orderBy('name')->get();
        return view('medical-history.index', compact('histories', 'patients'));
    }

    public function create()
    {
        $patients = \App\Models\Patient::orderBy('name')->get();
        $doctors = \App\Models\Doctor::orderBy('name')->get();
        return view('medical-history.create', compact('patients', 'doctors'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'patient_id' => 'required|exists:patients,id',
            'user_id' => 'required|exists:users,id',
            'visit_date' => 'required|date',
            'diagnosis' => 'required|string',
            'symptoms' => 'nullable|string',
            'treatment' => 'nullable|string',
            'prescriptions' => 'nullable|string',
            'notes' => 'nullable|string',
        ]);

        \App\Models\MedicalHistory::create($validated);

        return redirect()->route('medical-history.index')->with('success', 'تم إضافة السجل المرضي بنجاح');
    }

    public function show($id)
    {
        $history = \App\Models\MedicalHistory::with(['patient', 'doctor', 'followUps'])->findOrFail($id);
        return view('medical-history.show', compact('history'));
    }

    public function edit($id)
    {
        $history = \App\Models\MedicalHistory::findOrFail($id);
        $patients = \App\Models\Patient::orderBy('name')->get();
        $doctors = \App\Models\Doctor::orderBy('name')->get();
        return view('medical-history.edit', compact('history', 'patients', 'doctors'));
    }

    public function update(Request $request, $id)
    {
        $history = \App\Models\MedicalHistory::findOrFail($id);

        $validated = $request->validate([
            'patient_id' => 'required|exists:patients,id',
            'user_id' => 'required|exists:users,id',
            'visit_date' => 'required|date',
            'diagnosis' => 'required|string',
            'symptoms' => 'nullable|string',
            'treatment' => 'nullable|string',
            'prescriptions' => 'nullable|string',
            'notes' => 'nullable|string',
        ]);

        $history->update($validated);

        return redirect()->route('medical-history.show', $history->id)->with('success', 'تم تحديث السجل المرضي بنجاح');
    }

    public function destroy($id)
    {
        $history = \App\Models\MedicalHistory::findOrFail($id);
        $history->delete();

        return redirect()->route('medical-history.index')->with('success', 'تم حذف السجل المرضي بنجاح');
    }
}
