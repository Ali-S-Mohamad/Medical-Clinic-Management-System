<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class MedicalFile extends Model
{
    use HasFactory, SoftDeletes;
    protected $fillable = [
    'patient_id',
    'diagnoses',
    ];


    public function patient(){
        return $this->belongsTo(Patient::class);
    }

    public function prescriptions(){
        return $this->hasMany(Prescription::class);
    }
}
