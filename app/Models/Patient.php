<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Notifications\Notifiable;

class Patient extends Model
{
    use HasFactory, SoftDeletes, Notifiable;

    protected $fillable = [
        'user_id',
        'dob',
        'insurance_number'
    ];

    public function user(){
        return $this->belongsTo(User::class);
    }

    public function medicalFile(){
        return $this->hasOne(MedicalFile::class);
    }

    // public function prescriptions(){
    //     return $this->hasMany(Prescription::class);
    // }

    public function appointments(){
        return $this->hasMany(Appointment::class);
    }


    public function ratings() {
        return $this->hasMany(Rating::class);
    }

}
