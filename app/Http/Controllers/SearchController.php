<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Doctor;
use App\Models\Patient;

class SearchController extends Controller
{
    public function search(Request $request)
    {
        $query = $request->input('q');
        $doctors = Doctor::where('name', 'like', "%{$query}%")
            ->orWhere('specialization', 'like', "%{$query}%")
            ->get();
        $patients = Patient::where('name', 'like', "%{$query}%")
            ->orWhere('phone', 'like', "%{$query}%")
            ->orWhere('email', 'like', "%{$query}%")
            ->get();
        return view('search.results', compact('query', 'doctors', 'patients'));
    }
}
