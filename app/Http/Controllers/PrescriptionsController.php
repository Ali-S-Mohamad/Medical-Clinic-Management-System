<?php

namespace App\Http\Controllers;

use App\Models\Appointment;
use App\Models\MedicalFile;
use App\Models\Prescription;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Services\PrescriptionFilterService;
use App\Http\Requests\StorePrescriptionRequest;
use App\Http\Requests\UpdatePrescriptionRequest;

class PrescriptionsController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('permission:show-prescription', ['only' => ['index','show']]);
        $this->middleware('permission:create-prescription', ['only' => ['create','store']]);
        $this->middleware('permission:edit-prescription', ['only' => ['edit','update']]);
        $this->middleware('permission:Archive-prescription', ['only' => ['destroy']]);
        $this->middleware('permission:view-archivePrescription', ['only' => ['trash']]);
        $this->middleware('permission:restore-prescription', ['only' => ['restore']]);
        $this->middleware('permission:delete-prescription', ['only' => ['forcedelete']]);

    }
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        // Retrieve input values
        $filters = $request->only(['search_name', 'medications_names']);
        
        // Start the query with the necessary relationships
        $prescriptions = Prescription::with('employee', 'appointment');

        // Check user role
        $user = Auth::user();
        if ($user->hasRole('doctor')) {
            // If the user is a doctor, filter prescriptions by the doctor's ID
            $prescriptions = $prescriptions->where('doctor_id', $user->employee->id);
        }
    
        //Apply filters before pagination
        if (!empty($filters['medications_names'])) {
            $prescriptions = $prescriptions->filterByMedication($filters['medications_names']);
        }
    
        if (!empty($filters['search_name'])) {
            $prescriptions = $prescriptions->filterByPatientName($filters['search_name']);
        }
        // Pagination
        $prescriptions = $prescriptions->paginate(4);     
        return view('prescriptions.index', compact('prescriptions'));
    }

    
    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $user =  Auth::user();
        if($user->hasRole('doctor')){
            $doctorId = Auth::user()->employee->id;
        } else {
            return
            redirect()->route('prescriptions.index')->with('error', 'You are not allowed to add prescription');
        }

        $appointments = Appointment::with('patient')
            ->where('doctor_id', $doctorId)
            ->where('status', 'scheduled')
            ->get();
        return view('prescriptions.create', compact('appointments'));
    }
    /**
     * Store a newly created resource in storage.
     */
    public function store(StorePrescriptionRequest $request)
    {
        $appointment = Appointment::findOrFail($request->appointment_id);
        $patient = $appointment->patient;
        $medicalFile = $patient->medicalFile;

        // If there is no medical file, create one
        if (!$medicalFile) {
            $medicalFile = new MedicalFile();
            $medicalFile->patient_id = $patient->id;
            $medicalFile->save();
        }
        $doctorId = Auth::user()->employee->id;
        Prescription::create([
            'medical_file_id' => $medicalFile->id,
            'doctor_id' => $doctorId,
            'appointment_id' => $appointment->id,
            'medications_names' => $request->medications_names,
            'instructions' => $request->instructions,
            'details' => $request->details,
        ]);
        
        return redirect()->route('prescriptions.index')->with('success', 'Prescription is added successfully');
    }
    /**
     * Display the specified resource.
     */
    public function show(Prescription $prescription)
    {
        return view('prescriptions.show', compact('prescription'));
    }


    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Prescription $prescription)
    {
        return view('prescriptions.edit', compact('prescription'));
    }
    /**
     * Update the specified resource in storage.
     */
    public function update(UpdatePrescriptionRequest $request, Prescription $prescription)
    {
        $prescription->update([
            'medications_names' => $request->medications_names,
            'instructions' => $request->instructions,
            'details' => $request->details,
        ]);
        return redirect()->route('prescriptions.index')->with('success', 'Prescription is updated successfully');
    }
    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $prescription = Prescription::findOrFail($id);
        $prescription->delete();
        return redirect()->route('prescriptions.index')->with('success', 'Prescription is deleted successfully');
    }
    public function trash()
    {
        $prescriptions = Prescription::onlyTrashed()->get();
        return view('prescriptions.trash', compact('prescriptions'));
    }

    public function restore($id)
    {
        $prescription = Prescription::withTrashed()->find($id);
        if ($prescription && $prescription->trashed()) {
            $prescription->restore();
            //restore the medical file associated with the prescription
            $medicalFile = $prescription->medicalFile()->withTrashed()->first();
            if ($medicalFile && $medicalFile->trashed()) {
                $medicalFile->restore();
            }
        }
        return redirect()->route('prescriptions.index')->with('success', 'prescription restored successfully.');
    }

    public function forceDelete(string $id)
    {
        Prescription::withTrashed()->where('id', $id)->forceDelete();
        return redirect()->route('prescriptions.index')->with('success', 'prescriptions permanently deleted.');
    }
}
