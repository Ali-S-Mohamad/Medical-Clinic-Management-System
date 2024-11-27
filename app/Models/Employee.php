<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Employee extends Model
{
    use HasFactory, SoftDeletes;
    protected $fillable = [
        'user_id', 
        'department_id',
        'cv_path',
        'academic_qualifications',
        'previous_experience',
        'languages_spoken',
    ];
    protected static function booted() { 
        static::deleting(function ($employess) { 
            if ($employess->user) {
                 $employess->user->delete(); 
                } 
        });
        static::restoring(function ($employess) { 
            if ($employess->user()->withTrashed()->exists()) { 
                $employess->user()->withTrashed()->restore(); }
        });
        static::forceDeleting(function ($employess) { 
            if ($employess->user()->withTrashed()->exists()) { 
                $employess->user()->forceDelete(); } 
            });
    }

    public function user() { 
        return $this->belongsTo(User::class);
    }
    
    public function appointments(){
        return $this->hasMany(Appointment::class,'doctor_id');
    }

    public function department(){
        return $this->belongsTo(Department::class);
    }
}
