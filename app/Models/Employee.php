<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\Permission\Traits\HasRoles;

class Employee extends Model
{
    use HasFactory, SoftDeletes, HasRoles;
    protected $fillable = [
        'user_id',
        'department_id',
        'cv_path',
        'academic_qualifications',
        'previous_experience',
        'languages_spoken',
        'avg_ratings',
    ];
    protected static function booted()
    {
        static::deleting(function ($employees) {
            if ($employees->user) {
                $employees->user->delete();
            }
        });
        static::restoring(function ($employees) {
            if ($employees->user()->withTrashed()->exists()) {
                $employees->user()->withTrashed()->restore();
            }
        });
        static::forceDeleting(function ($employees) {
            if ($employees->user()->withTrashed()->exists()) {
                $employees->user()->forceDelete();
            }
        });
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function appointments()
    {
        return $this->hasMany(Appointment::class, 'doctor_id');
    }

    public function department()
    {
        return $this->belongsTo(Department::class);
    }

    public function ratings() { 
        return $this->hasMany(Rating::class);
    }

    public function languages(){
        return $this->belongsToMany(Language::class,'employee_language','employee_id','language_id');
    }

}
