<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Language;
use App\Models\Department;
use Illuminate\Http\Request;
use App\Services\UserService;
use App\Services\PatientService;
use App\Services\EmployeeService;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\StoreUserRequest;
use App\Http\Requests\UpdateUserRequest;
use App\Http\Controllers\EmployeeController;

class UserController extends Controller
{
    protected $userService;

    protected $employeeService;
    protected $patientService;

    public function __construct(UserService $userService, EmployeeService $employeeService, PatientService $patientService)
    {
        $this->userService = $userService;
        $this->employeeService = $employeeService;
        $this->patientService = $patientService;
    }
    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $departments = Department::all();
        $languages   = Language::all();
        return view('employees.create', compact('departments', 'languages'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreUserRequest $request)
    {
        $data = $request->validated();
        // Store The Basic Information Of User Using User Service
        $user = $this->userService->saveOrUpdateUserDetails($data, $request->id);

        // If user is doctor/employee store the specialized information
        if ($user->hasAnyRole(['doctor', 'employee'])) {
            $employee = $this->employeeService->saveOrUpdateEmployeeDetails($request, $user);
            return redirect()->route('employees.index');
            // If user is patient store the specialized information
        } elseif ($user->hasRole('patient')) {
            $patient = $this->patientService->saveOrUpdatePatientDetails($user, $request, false);
            return redirect()->route('patients.index');
        }
    }

    /**
     * Summary of update
     * @param \App\Http\Requests\UpdateUserRequest $request
     * @param string $id
     * @return mixed|\Illuminate\Http\RedirectResponse
     */
    public function update(UpdateUserRequest $request, string $id)
    {
        $user = User::findOrFail($id);
        $data = $request->validated();
        $user = $this->userService->saveOrUpdateUserDetails($data, $id);
        saveImage($request->has('is_patient') ? 'Patient images' : 'Employees images', $request, $user);


        // If user is doctor/employee update the specialized information
        if ($user->hasAnyRole(['doctor', 'employee'])) {
            $employee = $this->employeeService->saveOrUpdateEmployeeDetails($request, $user);
        }

        // If user is patient update the specialized information
        if ($user->hasRole('patient')) {
            $patient = $this->patientService
                ->saveOrUpdatePatientDetails($user->id, $request->only(['insurance_number', 'dob']), false);
            return redirect()->route('patients.index');
        }
        if (Auth::id() == $id) {
            return redirect()->route('employees.show', $user->employee->id)->with('success', ' update successfully.');
        } else {
            return redirect()->route('employees.index')->with('success', ' update successfully.');
        }
    }
}
