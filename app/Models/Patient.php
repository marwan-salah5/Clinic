<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Patient extends Model
{
    protected $casts = [
        'date_of_birth' => 'datetime',
    ];

    protected $fillable = [
        'name',
        'national_id',
        'phone',
        'email',
        'date_of_birth',
        'gender',
        'address',
        'blood_type',
        'allergies',
        'referral_source',
        'age',
    ];

    public function medicalHistories()
    {
        return $this->hasMany(MedicalHistory::class);
    }

    public function appointments()
    {
        return $this->hasMany(Appointment::class);
    }

    public function followUps()
    {
        return $this->hasMany(FollowUp::class);
    }

    public function invoices()
    {
        return $this->hasMany(Invoice::class);
    }

    public function getAgeAttribute()
    {
        if ($this->attributes['age']) {
            return $this->attributes['age'];
        }
        return $this->date_of_birth ? $this->date_of_birth->age : 'غير محدد';
    }
}
