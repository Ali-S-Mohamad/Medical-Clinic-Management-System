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
                $userQuery->where('name', 'LIKE', "%{$name}%");
        
            });
        }
    }
}
