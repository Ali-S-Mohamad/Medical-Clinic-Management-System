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

    protected static function booted()
    {
        static::deleting(function ($patients) {
            if ($patients->user) {
                if(!$patients->user->hasAnyRole(['doctor','employee'])){
                    $patients->user->delete();
                } else{
                    $patients->user->removeRole('patient');
                }
            }

            if ($patients->medicalFile) {
                $patients->medicalFile->delete();
            }

            if ($patients->appointments) {
                foreach ($patients->appointments as $appointment) {
                    $appointment->delete();
                }
            }
        });

        static::restoring(function ($patients) {
            if ($patients->user()->withTrashed()->exists()) {
                $patients->user()->withTrashed()->restore();
                if($patients->user->hasAnyRole(['doctor','employee'])){
                    $patients->user->assignRole('patient');
                }
            }

            if ($patients->medicalFile()->withTrashed()->exists()) {
                $patients->medicalFile()->withTrashed()->restore();
            }

        });

    static::forceDeleting(function ($patients) {
        if ($patients->user()->withTrashed()->exists()) {
            $patients->user()->forceDelete();
        }

        if ($patients->medicalFile()->withTrashed()->exists()) {
            $patients->medicalFile()->forceDelete();
        }

    });
}


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
