<?php

namespace App\Models;


use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Support\Facades\Log; // استيراد الفئة Log

class Rating extends Model
{
    use HasFactory;
    protected $fillable = [
        'patient_id',
        'employee_id',
        'doctor_rate',
        'details'
    ];
    protected static function boot() {
        parent::boot();
        Log::info('Boot method called');
        static::saved(function ($rating) {
            $employee = Employee::find($rating->employee_id);
            if ($employee) {
                $average = $employee->ratings()->avg('doctor_rate');
              //  Log::info('Average calculated: ' . $average);
                $employee->avg_ratings = $average;
                $employee->save(); }
            });
            }

    public function doctor() {
        return $this->belongsTo(Employee::class , 'employee_id');
    }

    public function patient() {
        return $this->belongsTo(Patient::class);
    }
}
