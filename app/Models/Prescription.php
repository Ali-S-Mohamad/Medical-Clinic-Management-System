<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Prescription extends Model
{
    use HasFactory, SoftDeletes;


    public function employee(){
        return $this->belongsTo(Employee::class,'doctor_id');
    }

    public function medicalFile(){
        return $this->belongsTo(MedicalFile::class);
    }

    public function appointment(){
        return $this->belongsTo(Appointment::class);
    }

    public function department(){
        return $this->belongsTo(Department::class);
    }
}
