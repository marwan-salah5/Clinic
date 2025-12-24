<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class FollowUp extends Model
{
    protected $fillable = [
        'patient_id',
        'medical_history_id',
        'follow_up_date',
        'status',
        'notes',
        'completed',
    ];

    protected $casts = [
        'completed' => 'boolean',
    ];

    public function patient()
    {
        return $this->belongsTo(Patient::class);
    }

    public function medicalHistory()
    {
        return $this->belongsTo(MedicalHistory::class);
    }
}
