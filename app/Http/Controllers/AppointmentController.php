<?php
namespace App\Http\Controllers;
use App\Models\User;
use App\Models\Patient;
use App\Models\Employee;
use App\Models\Appointment;
use Illuminate\Http\Request;
use App\Events\AppointmentCreated;
use App\Services\AppointmentService;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\AppointmentRequest;
use Carbon\Carbon;
class AppointmentController extends Controller
{
    protected $appointmentService; // Declare variable to hold the service
    public function __construct(AppointmentService $appointmentService)
    {
        $this->middleware('auth');
        $this->middleware('permission:show-Appointment', ['only' => ['index', 'show']]);
        $this->middleware('permission:create-Appointment', ['only' => ['create', 'store']]);
        $this->middleware('permission:edit-Appointment', ['only' => ['edit', 'update']]);
        $this->middleware('permission:delete-Appointment', ['only' => ['destroy']]);
        // Constructor to inject AppointmentService
        $this->appointmentService = $appointmentService; // Inject the service into the controller
    }
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        try {
            $user = Auth::user(); 
            $appointments = $this->appointmentService->getAppointmentsForUser($user);
            return view('appointments.index', compact('appointments'));
        } catch (\Exception $e) {
            return redirect()->back()->withErrors(['error' => $e->getMessage()]);
        }
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
     * Function to fetch available slots for a doctor on a selected date
     * @param \Illuminate\Http\Request $request
     * @param mixed $doctorId
     * @return mixed|\Illuminate\Http\JsonResponse
     */
    public function getAvailableSlots(Request $request, $doctorId)
    {
        $appointmentDate = $request->date;
        $dayOfWeek = Carbon::parse($appointmentDate)->dayOfWeek;  // Get the day of the week from the appointment date
        $availableSlots = $this->appointmentService->getAvailableSlots($doctorId, $dayOfWeek, $appointmentDate);
        $appointmentDate = $request->input('date');
        if (!$appointmentDate) {
            return response()->json([
                'message' => 'Appointment date is required.'
            ], 400);
        }
        $dayOfWeek = Carbon::parse($appointmentDate)->dayOfWeek;
        $availableSlots = $this->appointmentService->getAvailableSlots($doctorId, $appointmentDate);
        return response()->json([
            'availableSlots' => $availableSlots
        ]);
    }
    


    public function store(AppointmentRequest $request)
    {
        $appointmentDateTime = $request->appointment_date . ' ' . $request->appointment_time;
        // Use AppointmentService to book the appointment
        $response = $this->appointmentService->bookAppointment(
            $request->patient_id,
            $request->doctor_id,
            $appointmentDateTime,
            $request->status,
            $request->notes,
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
    
    public function updateStatus(Request $request, $id)
    {
        $appointment = Appointment::findOrFail($id);
        $appointment->status = $request->status;
        $appointment->save();
        // Returns the modified HTML of the row after changing the case
        $appointmentRowHtml = view('appointments.partials.appointment_row', compact('appointment'))->render();
    
        return response()->json([
            'success' => true,
            'message' => 'Status updated successfully!',
            'appointment' => $appointment,
            'html' => $appointmentRowHtml 
        ]);
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
