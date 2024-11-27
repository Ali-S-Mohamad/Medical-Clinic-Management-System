<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Prescription extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'medical_file_id',
        'doctor_id',
        'appointment_id',
        'medications_names',
        'instructions',
        'details',
    ];

    protected static function boot()
    {
        parent::boot();
        static::deleted(function ($prescription) {
            //check if the prescription is the last one in the medical file
            $medicalFile = $prescription->medicalFile; 
            if ($medicalFile && $medicalFile->prescriptions()->count() == 0) {
                $medicalFile->delete(); 
            }
        });
    }

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
