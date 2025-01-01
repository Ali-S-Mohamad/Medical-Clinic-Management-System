<?php
namespace App\Http\Controllers\Api;

use App\Models\Patient;
use App\Models\Appointment;
use Illuminate\Http\Request;
use App\Http\Traits\ApiResponse;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\AppointmentRequest;
use App\Services\AppointmentService; 

class AppointmentController extends Controller
{
    use ApiResponse;

    protected $appointmentService; 

    public function __construct(AppointmentService $appointmentService)
    {
        $this->appointmentService = $appointmentService; 
    }

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

        // use appointmentService
        $response = $this->appointmentService->bookAppointment(
            $patient->id, 
            $request->doctor_id, 
            $appointmentDateTime
        );

        if ($response['success']) {
            return $this->apiResponse([$response['appointment']], 'Appointment created successfully.', 201);
        }

        return $this->apiResponse(null, $response['message'], 409);
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
