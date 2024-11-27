<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Patient extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'user_id',
<<<<<<< HEAD
        'dob'
=======
        'dob',
        'insurance_number'
>>>>>>> 80eabe856da1f5424eab8d38476e0782d1eb464c
    ];

    public function user(){
        return $this->belongsTo(User::class);
    }

    public function medicalFiles(){
        return $this->hasMany(MedicalFile::class);
    }

    public function appointments(){
        return $this->hasMany(Appointment::class);
    }
}
