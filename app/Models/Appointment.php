<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Appointment extends Model
{
    use HasFactory, SoftDeletes;


    public function patient(){
        return $this->belongsTo(Patient::class);
    }

    public function employee(){
        return $this->belongsTo(Employee::class,'doctor_id');
    }

    public function prescription(){
        return $this->hasOne(Prescription::class);
    }
}
