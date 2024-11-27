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
        'dob',
        'insurance_number'
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
