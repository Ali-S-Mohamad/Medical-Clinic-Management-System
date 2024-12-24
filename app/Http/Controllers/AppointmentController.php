<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Patient;
use App\Models\Employee;
use App\Models\Appointment;
use Illuminate\Http\Request;
use App\Http\Requests\AppointmentRequest;

class AppointmentController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {


        $employee = Employee::where('user_id', auth()->user()->id)->first();

        if (!$employee) {
            return redirect()->back()->withErrors(['error' => 'The employee associated with this user was not found.']);
        }

        $isDoctor = auth()->user()->hasRole('doctor');

        $appointments = Appointment::all();

        // $appointments = Appointment::with(['patient.user', 'employee.user'])
        //     ->when($isDoctor, function ($query) use ($employee) {
        //         $query->where('doctor_id', $employee->id);
        //     }, function ($query) use ($employee) {

        //         $query->whereHas('employee', function ($subQuery) use ($employee) {
        //             $subQuery->where('department_id', $employee->department_id);
        //         });
        //     })
        //     ->whereHas('patient')
        //     ->get();

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


    /**
     * Store a newly created resource in storage.
     */
    public function store(AppointmentRequest  $request)
    {
        $appointmentDateTime = $request->appointment_date . ' ' . $request->appointment_time;

        Appointment::create([
            'patient_id' => $request->patient_id,
            'doctor_id' => $request->doctor_id,
            'appointment_date' => $appointmentDateTime,
            'status' => $request->status,
            'notes' => $request->notes,
        ]);

        return redirect()->route('appointments.index')->with('success', 'Appointment created successfully.');
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
    public function update(AppointmentRequest  $request, string $id)
    {
        $appointmentDateTime = $request->appointment_date . ' ' . $request->appointment_time;

        $appointment = Appointment::findOrFail($id);
        $appointment->update([
            'patient_id' => $request->patient_id,
            'doctor_id' => $request->doctor_id,
            'appointment_date' => $appointmentDateTime,
            'status' => $request->status,
            'notes' => $request->notes,
        ]);

        return redirect()->route('appointments.index')->with('success', 'Appointment updated successfully.');
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
