<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Department;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class DoctorController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $doctors = User::with('department')
            ->whereNotNull('department_id')
            ->orderBy('name')
            ->paginate(10);
        return view('doctors.index', compact('doctors'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $departments = Department::orderBy('name')->get();
        return view('doctors.create', compact('departments'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'department_id' => 'required|exists:departments,id',
            'phone' => 'nullable|string|max:20',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|string|min:8',
        ]);

        User::create([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'password' => Hash::make($validated['password']),
            'department_id' => $validated['department_id'],
            'role' => 'staff',
            'is_active' => true,
        ]);

        return redirect()->route('doctors.index')->with('success', 'تم إضافة الطبيب بنجاح');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $doctor = User::with('department')->findOrFail($id);
        return view('doctors.show', compact('doctor'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $doctor = User::findOrFail($id);
        $departments = Department::orderBy('name')->get();
        return view('doctors.edit', compact('doctor', 'departments'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $doctor = User::findOrFail($id);
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'department_id' => 'required|exists:departments,id',
            'phone' => 'nullable|string|max:20',
            'email' => 'required|email|unique:users,email,' . $id,
        ]);

        $doctor->update([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'department_id' => $validated['department_id'],
        ]);

        return redirect()->route('doctors.index')->with('success', 'تم تعديل بيانات الطبيب');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $doctor = User::findOrFail($id);
        $doctor->delete();
        return redirect()->route('doctors.index')->with('success', 'تم حذف الطبيب');
    }
}
