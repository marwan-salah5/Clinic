<?php

namespace App\Http\Controllers;

use App\Models\Invoice;
use App\Models\Patient;
use Illuminate\Http\Request;

class InvoiceController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $invoices = Invoice::with('patient')->latest()->paginate(10);
        return view('invoices.index', compact('invoices'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(Request $request)
    {
        $patient = null;
        if ($request->has('patient_id')) {
            $patient = Patient::find($request->patient_id);
        }
        $patients = Patient::all(); // For selection if not pre-filled
        return view('invoices.create', compact('patient', 'patients'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'patient_id' => 'required|exists:patients,id',
            'invoice_date' => 'required|date',
            'total_amount' => 'required|numeric|min:0',
            'amount_paid' => 'nullable|numeric|min:0|lte:total_amount',
            'status' => 'required|in:unpaid,paid,cancelled',
            'notes' => 'nullable|string',
        ]);

        // Generate a simple invoice number
        $validated['invoice_number'] = 'INV-' . time() . '-' . rand(100, 999);

        // Calculate paid and remaining amounts
        if (!isset($validated['amount_paid'])) {
            $validated['amount_paid'] = ($validated['status'] === 'paid') ? $validated['total_amount'] : 0;
        }

        $validated['remaining_amount'] = $validated['total_amount'] - $validated['amount_paid'];

        $invoice = Invoice::create($validated);

        return redirect()->route('invoices.show', $invoice)->with('success', 'تم إنشاء الفاتورة بنجاح.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Invoice $invoice)
    {
        $invoice->load('patient');
        return view('invoices.show', compact('invoice'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Invoice $invoice)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Invoice $invoice)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Invoice $invoice)
    {
        $invoice->delete();
        return redirect()->back()->with('success', 'Invoice deleted successfully.');
    }
}
