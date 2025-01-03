<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Patient;
use App\Models\Employee;
use App\Models\Appointment;
use Illuminate\Http\Request;
use App\Events\AppointmentCreated;
use App\Http\Requests\AppointmentRequest;
use App\Services\AppointmentService;

class AppointmentController extends Controller
{
    protected $appointmentService; // Declare variable to hold the service

    // Constructor to inject AppointmentService
    public function __construct(AppointmentService $appointmentService)
    {
        $this->appointmentService = $appointmentService; // Inject the service into the controller
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {


        $employee = Employee::where('user_id', auth()->user()->id)->first();

        // if (!$employee) {
        //     return redirect()->back()->withErrors(['error' => 'The employee associated with this user was not found.']);
        // }

        $isDoctor = auth()->user()->hasRole('doctor');

        $appointments = Appointment::paginate(5);

        $appointments = Appointment::with(['patient.user', 'employee.user'])
            ->when($isDoctor, function ($query) use ($employee) {
                $query->where('doctor_id', $employee->id);
            }, function ($query) use ($employee) {

                $query->whereHas('employee', function ($subQuery) use ($employee) {
                    $subQuery->where('department_id', $employee->department_id);
                });
            })
            ->whereHas('patient')
            ->paginate(5);

        return view('appointments.index', compact('appointments'));
    }


    /* Show the form for creating a new resource.
     */
    public function create()
    {
        $patients = Patient::with('user')->get();
        $doctors = User::role('doctor')->get();
        return view('appointments.create', compact('patients', 'doctors'));
    }

    // Store method to create an appointment
    public function store(AppointmentRequest $request)
    {
        $appointmentDateTime = $request->appointment_date . ' ' . $request->appointment_time;

        // Use AppointmentService to book the appointment
        $response = $this->appointmentService->bookAppointment(
            $request->patient_id,
            $request->doctor_id,
            $appointmentDateTime
        );

        // If the booking was successful
        if ($response['success']) {
            return redirect()->route('appointments.index')->with('success', 'Appointment created successfully.');
        }

        // If there was an error during booking
        return redirect()->route('appointments.index')->with('error', $response['message']);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $appointment = Appointment::with(['patient', 'employee'])->findOrFail($id);

        return view('appointments.show', compact('appointment'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $appointment = Appointment::findOrFail($id);

        $patients = Patient::with('user')->get();
        $doctors = User::role('doctor')->get();


        return view('appointments.edit', compact('appointment', 'patients', 'doctors'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(AppointmentRequest $request, string $id)
    {
        // Combine the date and time into one datetime string
        $appointmentDateTime = $request->appointment_date . ' ' . $request->appointment_time;

        // Use AppointmentService to check if the new details are valid and update the appointment
        $response = $this->appointmentService->updateAppointment(
            $id,                       // Pass the appointment ID
            $request->patient_id,      // Pass the patient ID from the request
            $request->doctor_id,       // Pass the doctor ID from the request
            $appointmentDateTime,      // Pass the updated appointment datetime
            $request->status,          // Pass the updated status (e.g., 'scheduled', 'completed', etc.)
            $request->notes            // Pass the notes (optional field for additional information)
        );

        // If the new appointment details are valid and updated successfully
        if ($response['success']) {
            return redirect()->route('appointments.index')->with('success', 'Appointment updated successfully.');
        }

        // If there's a conflict or another issue
        return redirect()->route('appointments.index')->with('error', $response['message']);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $appointment = Appointment::findOrFail($id);
        $appointment->delete();
        return redirect()->route('appointments.index')->with('success', 'Appointment deleted successfully.');
    }
}
