<?php
namespace App\Http\Controllers\Api;

use App\Models\Patient;
use App\Models\Appointment;
use Illuminate\Http\Request;
use App\Http\Traits\ApiResponse;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\AppointmentRequest;
use App\Http\Requests\CancelAppointmentRequest;
use App\Services\AppointmentService;

class AppointmentController extends Controller
{
    use ApiResponse;

    protected $appointmentService;

    public function __construct(AppointmentService $appointmentService)
    {
        $this->middleware(['auth:sanctum','permission:store-AppointmentforPatient'])->only(['store']);
        $this->middleware(['auth:sanctum','permission:get-AppointmentforPatient'])->only(['myAppointments']);
        $this->middleware(['auth:sanctum','permission:get-AvailableSlot'])->only('getAvailableSlots');

        $this->appointmentService = $appointmentService;
    }

    /**
     * Summary of store
     * @param \App\Http\Requests\AppointmentRequest $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(AppointmentRequest $request)
    {
        $user = $request->user();
        // Verify that the current user is a patient
        $patient = $user->patient;
        if (!$patient) {
            // Use errorResponse from ApiResponse trait
            return $this->errorResponse('User is not associated with a patient.', 403);
        }

        // Combine appointment date and time
        $appointmentDateTime = $request->appointment_date . ' ' . $request->appointment_time;

        // Use appointmentService
        $response = $this->appointmentService->bookAppointment(
            $patient->id,
            $request->doctor_id,
            $appointmentDateTime
        );

        if ($response['success']) {
            // Use successResponse from ApiResponse trait
            return $this->successResponse([$response['appointment']], 'Appointment created successfully.', 201);
        }

        // Use errorResponse for failure
        return $this->errorResponse($response['message'], 409);
    }

    // Display appointments belonging to the patient
    public function myAppointments(Request $request)
    {
        $user = $request->user();

        // Verify that the current user is a patient
        $patient = $user->patient;
        if (!$patient) {
            // Use errorResponse from ApiResponse trait
            return $this->errorResponse('User is not associated with a patient.', 403);
        }

        // Retrieve appointments associated with the patient
        $appointments = $patient->appointments()->orderBy('appointment_date', 'desc')->get();

        // Use successResponse from ApiResponse trait
        return $this->successResponse($appointments, 'Appointments retrieved successfully.', 200);
    }

    public function getAvailableSlots(Request $request, $doctorId, $dayOfWeek)
    {
        // Receipt date of customer order
        $date = $request->query('date');

        if (!$date) {
            // Return an error response using the errorResponse method from ApiResponse trait
            return $this->errorResponse('Date is required.', 400);
        }

        $availableSlots = $this->appointmentService->getAvailableSlots($doctorId, $dayOfWeek, $date);

        // Return a success response with the available slots data using successResponse
        return $this->successResponse($availableSlots, 'Available slots fetched successfully.');
    }


}
