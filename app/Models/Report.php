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

    //filter by patient name
    public function scopeFilterByName($query, $name)
    {
        if ($name) {
            return $query->where('patient_name', 'like', '%' . $name . '%');
        }
        return $query;
    }
    //filter by doctor name
    public function scopeFilterByDoctor($query, $doctor)
    {
        if ($doctor) {
            return $query->where('doctor_name', 'like', '%' . $doctor . '%');
        }
        return $query;
    }
    //filter by date
    public function scopeFilterByDate($query, $date)
    {
        if ($date) {
            return $query->whereDate('appointment_date', $date);
        }
        return $query;
    }
}
