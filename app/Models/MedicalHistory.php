<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class MedicalHistory extends Model
{
    protected $fillable = [
        'patient_id',
        'user_id',
        'visit_date',
        'diagnosis',
        'symptoms',
        'treatment',
        'prescriptions',
        'notes',
    ];

    public function patient()
    {
        return $this->belongsTo(Patient::class);
    }

    public function doctor()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function followUps()
    {
        return $this->hasMany(FollowUp::class);
    }
}
