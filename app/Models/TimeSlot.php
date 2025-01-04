<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TimeSlot extends Model
{
    use HasFactory;

        protected $fillable = [
            'doctor_id',       
            'day_of_week',     
            'start_time',      
            'end_time',        
            'slot_duration',   
            'is_available',    
        ];

    /**
     * Define a relationship to the Doctor model (assuming there is a Doctor model).
     */
    public function doctor()
    {
        return $this->belongsTo(Employee::class);
    }
}
