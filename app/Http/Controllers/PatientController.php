<?php

namespace App\Http\Controllers;

use App\Models\Patient;
use Illuminate\Support\Facades\Auth;


class PatientController extends Controller
{    
    /**
     * __construct
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('permission:show-patient', ['only' => ['index']]);

    }
    
    /**
     * Display a listing of patients.
     *
     * @return void
     */
    public function index()
    {

        $user = Auth::user();

        if ($user->hasRole('Admin')){
            $patients = Patient::paginate(5);
        }
        else if ($user->hasRole('doctor') )  {
            $patients = Patient::whereHas('medicalFile.prescriptions', function ($query) use ($user) {
                $query->where('doctor_id', $user->employee->id);
            })->paginate(5);
        }
        else if ($user->hasRole('employee') ){
            $departmentId = $user->employee->department_id;
            $patients = Patient::whereHas('medicalFile.prescriptions', function ($query) use ($departmentId) {
                $query->whereHas('employee', function ($query) use ($departmentId) {
                    $query->where('department_id', $departmentId);
                });
            })->paginate(10);
        }
        else {
        abort(403, 'Unauthorized');
        }
        return view('patients.index',compact('patients'));
    }
    
    /**
     * Show the form for creating a new Patient.
     *
     * @return void
     */
    public function create()
    {
        // $departments = Department::all();
        return view('patients.create');
    }
    
    /**
     * Display the specified Patient.
     *
     * @param  mixed $patient
     * @return void
     */
    public function show(Patient $patient)
    {
        return view('patients.show', compact('patient'));
    }
    
    /**
     * Show the form for editing the specified Patient.
     *
     * @param  mixed $patient
     * @return void
     */
    public function edit(Patient $patient)
    {
        return view('patients.edit', compact('patient'));
    }
    
    /**
     * destroy the specified resource from storage.
     *
     * @param  mixed $patient
     * @return void
     */
    public function destroy(Patient $patient)
    {
        $patient->delete();
        return redirect()->route('patients.index');
    }
    
    /**
     * Display the trashed Patients
     *
     * @return void
     */
    public function trash()
    {
        $deletedPatients = Patient::onlyTrashed()->with([
            'user' => function ($query) {
                $query->withTrashed();
            }
        ])->paginate(5);
        return view('patients.trash', compact('deletedPatients'));
    }
    
    /**
     * Restore the specified patient from trash
     *
     * @param  mixed $id
     * @return void
     */
    public function restore(string $id)
    {
        $patient = Patient::withTrashed()->where('id', $id)->first();
        $patient->restore();
        return redirect()->route('patients.trash')->with('success', 'patient restored successfully.');
    }
    
    /**
     * Remove specified patient from storage
     *
     * @param  mixed $id
     * @return void
     */
    public function forceDelete(string $id)
    {
        $patient = Patient::withTrashed()->findOrFail($id);
        $patient->forceDelete();
        return redirect()->route('patients.trash')->with('success', 'patient permanently deleted.');
    }

}
