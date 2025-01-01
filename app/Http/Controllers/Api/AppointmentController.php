<?php

namespace App\Http\Controllers\Api;

use App\Models\Patient;
use App\Models\Appointment;
use Illuminate\Http\Request;
use App\Http\Traits\ApiResponse;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\AppointmentRequest;

class AppointmentController extends Controller
{
    use ApiResponse;

    public function store(AppointmentRequest $request)
    {
        $user = $request->user();
        // Verify that the current user is a patient
        $patient = $user->patient;
        if (!$patient) {
            return $this->apiResponse(null, 'User is not associated with a patient.', 403);
        }
        // Combine appointment date and time
        $appointmentDateTime = $request->appointment_date . ' ' . $request->appointment_time;

        // Check appointment availability
        $existingAppointment = Appointment::where('doctor_id', $request->doctor_id)
            ->where('appointment_date', $appointmentDateTime)
            ->first();
        if ($existingAppointment) {
            return $this->apiResponse(null, 'The appointment slot is already booked.', 409);
        }
        //create appointment
        $appointment = Appointment::create([
            'patient_id' => $patient->id,
            'doctor_id' => $request->doctor_id,
            'appointment_date' => $appointmentDateTime,
            'status' => $request->status,
            'notes' => $request->notes,
        ]);
        return $this->apiResponse([$appointment], 'Appointment created successfully.', 201);
    }

    // Display appointments belonging to the patient
    public function myAppointments(Request $request)
    {
        $user = $request->user();

        // Verify that the current user is a patient
        $patient = $user->patient;
        if (!$patient) {
            return $this->apiResponse(null, 'User is not associated with a patient.', 403);
        }

        // Retrieve appointments associated with the patient
        $appointments = $patient->appointments()->orderBy('appointment_date', 'desc')->get();
        return $this->apiResponse($appointments, 'Appointments retrieved successfully.', 200);
    }
}
