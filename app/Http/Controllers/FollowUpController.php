<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class FollowUpController extends Controller
{
    public function index(Request $request)
    {
        $query = \App\Models\FollowUp::with(['patient', 'medicalHistory']);

        if ($request->has('status')) {
            $query->where('status', $request->status);
        }

        $followUps = $query->latest('follow_up_date')->paginate(15);
        return view('follow-ups.index', compact('followUps'));
    }

    public function create()
    {
        $patients = \App\Models\Patient::orderBy('name')->get();
        $histories = \App\Models\MedicalHistory::with('patient')->latest()->get();
        return view('follow-ups.create', compact('patients', 'histories'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'patient_id' => 'required|exists:patients,id',
            'medical_history_id' => 'required|exists:medical_histories,id',
            'follow_up_date' => 'required|date',
            'status' => 'required|in:pending,completed,cancelled',
            'notes' => 'nullable|string',
            'completed' => 'boolean',
        ]);

        \App\Models\FollowUp::create($validated);

        return redirect()->route('follow-ups.index')->with('success', 'تم إضافة المتابعة بنجاح');
    }

    public function show($id)
    {
        $followUp = \App\Models\FollowUp::with(['patient', 'medicalHistory'])->findOrFail($id);
        return view('follow-ups.show', compact('followUp'));
    }

    public function edit($id)
    {
        $followUp = \App\Models\FollowUp::findOrFail($id);
        $patients = \App\Models\Patient::orderBy('name')->get();
        $histories = \App\Models\MedicalHistory::with('patient')->latest()->get();
        return view('follow-ups.edit', compact('followUp', 'patients', 'histories'));
    }

    public function update(Request $request, $id)
    {
        $followUp = \App\Models\FollowUp::findOrFail($id);

        $validated = $request->validate([
            'patient_id' => 'required|exists:patients,id',
            'medical_history_id' => 'required|exists:medical_histories,id',
            'follow_up_date' => 'required|date',
            'status' => 'required|in:pending,completed,cancelled',
            'notes' => 'nullable|string',
            'completed' => 'boolean',
        ]);

        $followUp->update($validated);

        return redirect()->route('follow-ups.show', $followUp->id)->with('success', 'تم تحديث المتابعة بنجاح');
    }

    public function destroy($id)
    {
        $followUp = \App\Models\FollowUp::findOrFail($id);
        $followUp->delete();

        return redirect()->route('follow-ups.index')->with('success', 'تم حذف المتابعة بنجاح');
    }
}
