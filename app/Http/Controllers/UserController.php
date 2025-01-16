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
        $user->fill([
            'name' => $request->name,
            'email' => $request->email,
            'phone_number' => $request->phone,
            'password' => bcrypt($request->password),
        ])->save();

        // Handel image
        saveImage($request->has('is_patient') ? 'Patient images' : 'Employees images', $request, $user);
       
        // User is both patient & employee  (only for edit edit request)
        if ($request->has('is_patient_employee')) { 
            if ($request->input('is_doctor', 0)) { 
                $user->assignRole('doctor'); 
            } else { 
                $user->assignRole('employee'); 
            }  
            $user->assignRole('patient'); 
            $user->assignRole('employee'); 
            $user->update([ 'is_patient' => true]);
            // Pass false to avoid redirect 
            $patientController = new PatientController();
            $patientController->saveOrUpdatePatientDetails($user->id, $request, false); 
            
            $employeeController = new EmployeeController();
            $employeeController->saveOrUpdateEmployeeDetails($user->id, $request); 
            return redirect()->route('employees.index'); 
        } 
        // User is only patient 
        elseif ($request->has('is_patient')) {     
            $user->assignRole('patient'); 
            $patientController = new PatientController();
            return $patientController->saveOrupdatePatientDetails($user->id, $request);
        } 
        // User is only employee / doctor 
        else {      
            if ($request->input('is_doctor', 0)) { 
                $user->assignRole('doctor'); 
            } else { 
                $user->assignRole('employee');
            }  
            $user->update([ 'is_patient' => false]);
            $employeeController = new EmployeeController();
            return $employeeController->saveOrUpdateEmployeeDetails($user->id, $request);
        } 
    }
          
        //old
//         if ($request->has('is_patient')) {  // only patient
//             $user->assignRole('patient');
//             saveImage('Patient images', $request, $user);
// ///dd('alaaa');
//             $patientController = new PatientController();
//             return $patientController->saveOrupdatePatientDetails($user->id, $request);
//         }
//         else {   // employee or doctor
//             $isDoctor = $request->input('is_doctor', 0);
//             if ($isDoctor) {
//                 $user->assignRole('doctor');
//             } else {
//                 $user->assignRole('employee');
//             }
//             $user->update([ 'is_patient' => $request->has('is_patient_employee') ]);
//             saveImage('Employees images', $request, $user);

//             // Calling EmployeeController to Update Employee Details
//             $employeeController = new EmployeeController();
//             return $employeeController->saveOrUpdateEmployeeDetails($user->id, $request);

//         }

//     }

}
