<?php

namespace App\Models;

use App\Models\MedicalFile;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

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
        static::deleting(function ($prescription) {
            $medicalFile = $prescription->medicalFile;
            //Delete the medical file soft if it is the last prescription to be deleted soft
            $prescriptionsCount = Prescription::where('medical_file_id', $medicalFile->id)->count();
            if ($prescriptionsCount === 1) {
                $medicalFile->delete();
            }
        });
        static::forceDeleting(function ($prescription) {
            $medicalFile = $prescription->medicalFile;
            $remainingPrescriptions = Prescription::withTrashed()->where('medical_file_id', $medicalFile->id)->count();
            //Delete the medical file hard if it is the last prescription to be deleted hard
            if ($remainingPrescriptions === 1) {
                $medicalFile->forceDelete();
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
        return $this->belongsTo(Appointment::class, 'appointment_id');
    }

    public function department(){
        return $this->belongsTo(Department::class);
    }
}
