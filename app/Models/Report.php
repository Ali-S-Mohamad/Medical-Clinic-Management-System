<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Report extends Model
{
    use HasFactory , SoftDeletes;
    protected $fillable = [
        'patient_id',
        'patient_name',
        'doctor_name',
        'appointment_date',
        'medications_names',
        'instructions',
        'details',
        'appointment_id', 
    ];

    public function appointment()
    {
        return $this->belongsTo(Appointment::class);
    }

    public function patient()
    {
        return $this->belongsTo(Patient::class);
    }
}
