<?php

namespace App\Models;


use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Rating extends Model
{
    use HasFactory;
    protected $fillable = [
        'patient_id',
        'doctor_id',
        'doctor_rate',
        'details'
    ];
    public function doctor() { 
        return $this->belongsTo(Employee::class); 
    }

    public function patient() { 
        return $this->belongsTo(Patient::class); 
    }
}
