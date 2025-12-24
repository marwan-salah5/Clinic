<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Patient;
use App\Models\Appointment;

class Invoice extends Model
{
    protected $fillable = [
        'patient_id',
        'appointment_id',
        'invoice_number',
        'invoice_date',
        'total_amount',
        'amount_paid',
        'remaining_amount',
        'status',
        'notes',
    ];

    public function patient()
    {
        return $this->belongsTo(Patient::class);
    }

    public function appointment()
    {
        return $this->belongsTo(Appointment::class);
    }
}
