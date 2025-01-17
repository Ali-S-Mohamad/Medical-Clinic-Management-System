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
        $user = new User();
        return $this->saveOrUpdateUserDetails($user, $request);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateUserRequest $request, string $id)
    {
        $user = User::findOrFail($id);
        return $this->saveOrUpdateUserDetails($user, $request);
    }

    protected function saveOrUpdateUserDetails($user, $request) {
        //check password
        if ($request->password !== $request->confirm_password) {
           return redirect()->back()->with('error', 'Pasword does not match .');
        
        }

        $user->fill([
            'firstname' => $request->firstname,
            'lastname' => $request->lastname,
            'email' => $request->email,
            'gender' => $request->gender,
            'phone_number' => $request->phone,
            'password' => bcrypt($request->password),
            'confirm_password' => bcrypt($request->confirm_password),
            'is_verified' => true,
        ])->save();

        if ($request->has('is_patient')) {
            $user->assignRole('patient');
            saveImage('Patient images', $request, $user);

            $patientController = new PatientController();
            return $patientController->saveOrupdatePatientDetails($user->id, $request);
        }
        else {
            $isDoctor = $request->input('is_doctor', 0);
            if ($isDoctor) {
                $user->assignRole('doctor');
            } else {
                $user->assignRole('employee');
            }
            $user->update([ 'is_patient' => false ]);

            saveImage('Employees images', $request, $user);

            // Calling EmployeeController to Update Employee Details
            $employeeController = new EmployeeController();
            return $employeeController->saveOrUpdateEmployeeDetails($user->id, $request);

        }

    }

}
