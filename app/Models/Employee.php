<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Employee extends Model
{
    use HasFactory, SoftDeletes;

    public function user(){
        return $this->belongsTo(User::class);
    }

    public function appointments(){
        return $this->hasMany(Appointment::class,'doctor_id');
    }

    public function department(){
        return $this->belongsTo(Department::class);
    }

    public function prescriptions(){
        return $this->hasMany(Prescription::class,'doctor_id');
    }

}
