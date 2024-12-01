<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Department;
use Illuminate\Http\Request;
use App\Http\Requests\StoreUserRequest;
use App\Http\Requests\UpdateUserRequest;
use App\Http\Controllers\EmployeeController;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $departments = Department::all();
        return view('users.create', compact('departments'));
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
            'is_patient' => false,
        ]);
        // Checking User's role
        $isDoctor = $request->input('is_doctor', 0);
        if ($isDoctor) {
            $user->assignRole('doctor');
        } else {
            $user->assignRole('employee');
        }

        // Calling EmployeeController to store Employee Details
        $employeeController = new EmployeeController();
        return $employeeController->storeEmployeeDetails($user->id, $request);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
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
            'is_patient' => false,
        ]);
        $isDoctor = $request->input('is_doctor', 0);
        if (! $isDoctor) {
            $user->syncRoles('employee');
        } else {
            $user->syncRoles('doctor');
        }

        // Calling EmployeeController to Update Employee Details
        $employeeController = new EmployeeController();
        return $employeeController->updateEmployeeDetails($user->id, $request);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(User $user)
    {
        //
    }

    public function restore(string $id)
    {
        //
    }
}
