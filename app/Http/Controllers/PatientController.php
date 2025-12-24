<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class PatientController extends Controller
{
    public function index(Request $request)
    {
        $query = \App\Models\Patient::query();

        if ($request->has('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                    ->orWhere('national_id', 'like', "%{$search}%")
                    ->orWhere('phone', 'like', "%{$search}%");
            });
        }

        $patients = $query->latest()->paginate(10);

        if ($request->wantsJson()) {
            return response()->json($patients);
        }

        return view('patients.index', compact('patients'));
    }

    public function create()
    {
        return view('patients.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'national_id' => 'nullable|string|unique:patients,national_id',
            'phone' => 'required|string',
            'email' => 'nullable|email',
            'date_of_birth' => 'nullable|date',
            'gender' => 'nullable|in:male,female',
            'address' => 'nullable|string',
            'blood_type' => 'nullable|string',
            'allergies' => 'nullable|string',
        ]);

        \App\Models\Patient::create($validated);

        return redirect()->route('patients.index')->with('success', 'تم إضافة المريض بنجاح');
    }

    public function show($id)
    {
        $patient = \App\Models\Patient::with(['medicalHistories', 'appointments', 'followUps'])->findOrFail($id);
        return view('patients.show', compact('patient'));
    }

    public function edit($id)
    {
        $patient = \App\Models\Patient::findOrFail($id);
        return view('patients.edit', compact('patient'));
    }

    public function update(Request $request, $id)
    {
        $patient = \App\Models\Patient::findOrFail($id);

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'national_id' => 'nullable|string|unique:patients,national_id,' . $id,
            'phone' => 'required|string',
            'email' => 'nullable|email',
            'date_of_birth' => 'nullable|date',
            'gender' => 'nullable|in:male,female',
            'address' => 'nullable|string',
            'blood_type' => 'nullable|string',
            'allergies' => 'nullable|string',
        ]);

        $patient->update($validated);

        return redirect()->route('patients.show', $patient->id)->with('success', 'تم تحديث بيانات المريض بنجاح');
    }

    public function destroy($id)
    {
        $patient = \App\Models\Patient::findOrFail($id);
        $patient->delete();

        return redirect()->route('patients.index')->with('success', 'تم حذف المريض بنجاح');
    }

    /**
     * Normalize phone number by converting Arabic/Persian digits to English
     */
    private function normalizePhone($phone)
    {
        if (empty($phone)) {
            return '';
        }

        $arabicDigits = ['٠', '١', '٢', '٣', '٤', '٥', '٦', '٧', '٨', '٩'];
        $persianDigits = ['۰', '۱', '۲', '۳', '۴', '۵', '۶', '۷', '۸', '۹'];
        $englishDigits = ['0', '1', '2', '3', '4', '5', '6', '7', '8', '9'];

        $phone = str_replace($arabicDigits, $englishDigits, $phone);
        $phone = str_replace($persianDigits, $englishDigits, $phone);

        // Remove any non-digit characters for comparison
        return preg_replace('/[^0-9]/', '', $phone);
    }

    /**
     * Search for a patient by phone number (AJAX)
     * Smart search that works with both Arabic and English digits
     */
    public function searchByPhone(Request $request)
    {
        $phone = $request->input('phone');

        if (empty($phone)) {
            return response()->json(['found' => false, 'patients' => [], 'patient' => null]);
        }

        // Normalize the search phone number
        $normalizedSearchPhone = $this->normalizePhone($phone);

        // Get all patients and filter by normalized phone
        $patients = \App\Models\Patient::all()->filter(function ($p) use ($normalizedSearchPhone) {
            $normalizedPatientPhone = $this->normalizePhone($p->phone);
            return str_contains($normalizedPatientPhone, $normalizedSearchPhone) ||
                str_contains($normalizedSearchPhone, $normalizedPatientPhone);
        })->values();

        if ($patients->isNotEmpty()) {
            return response()->json([
                'found' => true,
                'patients' => $patients,
                'patient' => $patients->first() // For backward compatibility
            ]);
        }

        return response()->json(['found' => false, 'patients' => [], 'patient' => null]);
    }

    /**
     * Quick create patient (AJAX) - for inline creation during appointment booking
     */
    public function quickCreate(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'phone' => 'required|string',
            'gender' => 'required|in:male,female',
            'date_of_birth' => 'nullable|date',
            'national_id' => 'nullable|string|unique:patients,national_id',
            'email' => 'nullable|email',
            'address' => 'nullable|string',
            'blood_type' => 'nullable|string',
            'allergies' => 'nullable|string',
        ]);

        $patient = \App\Models\Patient::create($validated);

        return response()->json([
            'success' => true,
            'message' => 'تم إضافة المريض بنجاح',
            'patient' => [
                'id' => $patient->id,
                'name' => $patient->name,
                'phone' => $patient->phone,
            ]
        ]);
    }
}
