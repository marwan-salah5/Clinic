<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Appointment extends Model
{
    protected $fillable = [
        'patient_id',
        'user_id',
        'appointment_date',
        'appointment_time',
        'status',
        'reason',
        'notes',
        'age',
    ];

    protected $casts = [
        'appointment_date' => 'date',
        'appointment_time' => 'datetime',
    ];

    public function patient()
    {
        return $this->belongsTo(Patient::class);
    }

    public function doctor()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function invoice()
    {
        return $this->hasOne(Invoice::class);
    }
}
