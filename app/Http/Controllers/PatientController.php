<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Patient;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;



class PatientController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('permission:show-patient', ['only' => ['index']]);

    }
    /**
     * Display a listing of the resource.
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
     * Show the form for creating a new resource.
     */
    public function create()
    {
        // $departments = Department::all();
        return view('patients.create');
    }


    /**
     * Display the specified resource.
     */
    public function show(Patient $patient)
    {
        return view('patients.show', compact('patient'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Patient $patient)
    {
        return view('patients.edit', compact('patient'));
    }


    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Patient $patient)
    {
        $patient->delete();
        return redirect()->route('patients.index');
    }

    public function trash()
    {
        $deletedPatients = Patient::onlyTrashed()->with([
            'user' => function ($query) {
                $query->withTrashed();
            }
        ])->paginate(5);
        return view('patients.trash', compact('deletedPatients'));
    }

    public function restore(string $id)
    {
        $patient = Patient::withTrashed()->where('id', $id)->first();
        $patient->restore();
        return redirect()->route('patients.trash')->with('success', 'patient restored successfully.');
    }

    // Delete patient For ever
    public function forceDelete(string $id)
    {
        $patient = Patient::withTrashed()->findOrFail($id);
        $patient->forceDelete();
        return redirect()->route('patients.trash')->with('success', 'patient permanently deleted.');
    }

}
