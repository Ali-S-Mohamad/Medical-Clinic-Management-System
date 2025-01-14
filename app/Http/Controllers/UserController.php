<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Department;
use Illuminate\Http\Request;
use App\Http\Requests\StoreUserRequest;
use App\Http\Requests\UpdateUserRequest;
use App\Http\Controllers\EmployeeController;
use App\Models\Language;

class UserController extends Controller
{
    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $departments = Department::all();
        $languages   = Language::all();
        return view('employees.create', compact('departments','languages'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreUserRequest $request)
    {
        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'phone_number' => $request->phone,
            'password' => bcrypt($request->password),
            
        ]);
      
        if ($request->has('is_patient')) { // هو مريض 
            $user->assignRole('patient'); 
            saveImage('Patient images', $request, $user);

            $patientController = new PatientController();
            return $patientController->storePatientDetails($user->id, $request);
        } 
        else { // هو موظف 
            $isDoctor = $request->input('is_doctor', 0);
            if ($isDoctor) {
                $user->assignRole('doctor');
            } else {
                $user->assignRole('employee');
            }
            $user->update([ 'is_patient' => false ]); 

            saveImage('Employee images', $request, $user);

            // Calling EmployeeController to store Employee Details
            $employeeController = new EmployeeController();
            return $employeeController->storeEmployeeDetails($user->id, $request);

        }
       
        
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateUserRequest $request, string $id)
    {   
        $user = User::findOrFail($id);
        $user->update([
            'name' => $request->name,
            'email' => $request->email,
            'phone_number' => $request->phone,
            'password' => bcrypt($request->password),
        ]);
       
        if ($request->has('is_patient')) { 
            $user->assignRole('patient'); 
            saveImage('Patient images', $request, $user);

            $patientController = new PatientController();
            return $patientController->updatePatientDetails($user->id, $request);
        } 
        else { 
            $isDoctor = $request->input('is_doctor', 0);
            if ($isDoctor) {
                $user->assignRole('doctor');
            } else {
                $user->assignRole('employee');
            }
            $user->update([ 'is_patient' => false ]); 

            saveImage('Employee images', $request, $user);

            // Calling EmployeeController to Update Employee Details
            $employeeController = new EmployeeController();
            return $employeeController->updateEmployeeDetails($user->id, $request);

        }

       
    }

}
