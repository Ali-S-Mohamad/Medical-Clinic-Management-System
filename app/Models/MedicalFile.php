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

    public static function boot()
{
    parent::boot();

    static::deleting(function ($medicalFile) {
        // Check if the deletion is a permanent (force) delete
        if ($medicalFile->isForceDeleting()) {
            // Permanently delete associated prescriptions
            $medicalFile->prescriptions()->forceDelete();
        } else {
            // Soft delete associated prescriptions
            $medicalFile->prescriptions()->delete();
        }
    });

    static::restoring(function ($medicalFile) {
        // Restore associated prescriptions when the medical file is restored
        $medicalFile->prescriptions()->restore();
    });
}



    public function patient(){
        return $this->belongsTo(Patient::class);
    }

    public function prescriptions(){
        return $this->hasMany(Prescription::class);
    }

    public function scopeFilterByInsurance($query, $insurance)
    {
    if (!empty($insurance)) {
        $query->whereHas('patient', function($query) use ($insurance) {
            $query->where('insurance_number', '=', "$insurance");
        });
    }
    }

    public function scopeFilterByName($query, $name)
    {
    if (!empty($name)) {
        $query->whereHas('patient.user', function($userQuery) use ($name) {
            $userQuery->whereRaw("CONCAT(firstname, ' ', lastname) LIKE ?", ["%{$name}%"]);
        });
    }
    }

 
}