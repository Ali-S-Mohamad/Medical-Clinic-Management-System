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
    /**
     * Summary of __construct
     */
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
     * Display a listing of prescription.
     * @param \Illuminate\Http\Request $request
     * @param \App\Services\PrescriptionFilterService $filterService
     * @return mixed|string|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function index(Request $request, PrescriptionFilterService $filterService)
    {
        $filters = $request->only(['search_name', 'medications_names']);

        $query = Prescription::with(['employee', 'appointment']);

        $user = Auth::user();
        if ($user->hasRole('doctor')) {
            $query->where('doctor_id', $user->employee->id);
        }

        if (!empty($filters)) {
            $query = $filterService->filter($filters);
        }

        if ($request->ajax()) {
            $prescriptions = $query->paginate(5);
            return view('prescriptions.partials.table', compact('prescriptions'))->render();
        }

        $prescriptions = $query->paginate(5);
        return view('prescriptions.index', compact('prescriptions'));
    }

    /**
     * Show the form for creating a new prescription.
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View|\Illuminate\Http\RedirectResponse
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
     * Store a new Prescription
     * @param \App\Http\Requests\StorePrescriptionRequest $request
     * @return \Illuminate\Http\RedirectResponse
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
     * Display the specified Prescription.
     * @param \App\Models\Prescription $prescription
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function show(Prescription $prescription)
    {
        return view('prescriptions.show', compact('prescription'));
    }
    /**
     * Show the form for editing the specified Prescription.
     * @param \App\Models\Prescription $prescription
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function edit(Prescription $prescription)
    {
        return view('prescriptions.edit', compact('prescription'));
    }

    /**
     * Update the specified prescription in storage.
     * @param \App\Http\Requests\UpdatePrescriptionRequest $request
     * @param \App\Models\Prescription $prescription
     * @return \Illuminate\Http\RedirectResponse
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
     * Remove the specified Prescription from storage.
     * @param mixed $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy($id)
    {
        $prescription = Prescription::findOrFail($id);
        $prescription->delete();
        return redirect()->route('prescriptions.index')->with('success', 'Prescription is deleted successfully');
    }

    /**
     * Display the trashed prescription
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function trash()
    {
        $prescriptions = Prescription::onlyTrashed()->get();
        return view('prescriptions.trash', compact('prescriptions'));
    }
    /**
     * Restore the specified Prescription from trash
     * @param mixed $id
     * @return \Illuminate\Http\RedirectResponse
     */
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

    /**
     * Remove specified Prescription from storage
     * @param string $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function forceDelete(string $id)
    {
        Prescription::withTrashed()->where('id', $id)->forceDelete();
        return redirect()->route('prescriptions.index')->with('success', 'prescriptions permanently deleted.');
    }
}
