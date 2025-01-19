<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Notifications\Notifiable;

class Appointment extends Model
{
    use HasFactory, Notifiable;
    protected $fillable = [
        'patient_id',
        'doctor_id',
        'appointment_date',
        'status',
        'notes',
    ];

    /**
     * The relation between appointment and patient
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function patient()
    {
        return $this->belongsTo(Patient::class);
    }

    /**
     * The relation between appointment and employee
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function employee()
    {
        return $this->belongsTo(Employee::class, 'doctor_id');
    }

    /**
     * The relation between appointment and prescription
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function prescription()
    {
        return $this->hasOne(Prescription::class);
    }

    /**
     * The relation between appointment and timeSlot
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function timeSlot()
    {
        return $this->belongsTo(TimeSlot::class);
    }
}
