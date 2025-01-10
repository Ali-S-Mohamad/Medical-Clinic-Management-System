<?php

namespace App\Http\Controllers;

use App\Models\Employee;
use App\Models\Language;
use App\Models\ClinicInfo;
use App\Models\Department;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Services\EmployeeFilterService;
use App\Http\Requests\UpdateUserRequest;

class EmployeeController extends Controller
{
    protected $employeeFilterService;

    /**
     * Display a listing of the resource.
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function index(Request $request)
    {

        // Retrieve input values
        $filters = $request->only(['employee_name', 'department', 'role']);

        // call the service
        $employeeFilterService = app(EmployeeFilterService::class);

        $employees = $employeeFilterService->filter($filters)->paginate(5);

        // get Roles & Departments
        $departments = Department::active()->get();
        $roles = DB::table('roles')->get();

        return view('employees.index', compact('employees', 'departments', 'roles', 'filters'));
    }

    /**
     * Summary of storeEmployeeDetails
     * @param mixed $userId
     * @param \Illuminate\Http\Request $request
     * @return mixed|\Illuminate\Http\RedirectResponse
     */
    public function storeEmployeeDetails($userId, Request $request)
    {
        $employee = Employee::create([
            'user_id' => $userId,
            'department_id' => $request->department_id,
            'academic_qualifications' => $request->qualifications,
            'previous_experience' => $request->experience,
        ]);

        $employee->languages()->sync($request->languages_ids);

        $cvFilePath = uploadCvFile('Employees CVs' , $request , $employee->cv_path );
        $employee->cv_path=$cvFilePath;
        $employee->save();


        return redirect()->route('employees.index');
    }

    /**
     * Summary of updateEmployeeDetails
     * @param mixed $userId
     * @param \Illuminate\Http\Request $request
     * @return mixed|\Illuminate\Http\RedirectResponse
     */
    public function updateEmployeeDetails($userId, Request $request)
    {

        $employee = Employee::where('user_id',$userId)->first();
        $cvFilePath = uploadCvFile('Employees CVs', $request , $employee->cv_path );

        $employee->update([
            'department_id' => $request->department_id,
            'cv_path' => $cvFilePath,
            'academic_qualifications' => $request->qualifications,
            'previous_experience' => $request->experience,
        ]);


        saveImage('Employees images', $request, $employee->user);
        $employee->languages()->sync($request->languages_ids);
        return redirect()->route('employees.index');
    }

    /**
     * Display the specified resource.
     * @param \App\Models\Employee $employee
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function show(Employee $employee)
    {

        return view('employees.show', compact('employee'));
    }

    /**
     * Show the form for editing the specified resource.
     * @param \App\Models\Employee $employee
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function edit(Employee $employee)
    {
        $departments = Department::all();
        $languages   = Language::all();
        $role = $employee->user->roles->first()->name;
        return view('employees.edit', compact('employee', 'departments','languages','role'));
    }


    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Employee $employee)
    {
        $employee->delete();
        return redirect()->route('employees.index');
    }

    /**
     * Summary of trash
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function trash()
    {
        $deletedEmployees = Employee::onlyTrashed()->with([
            'user' => function ($query) {
                $query->withTrashed();
            }
        ])->get();
        return view('employees.trash', compact('deletedEmployees'));
    }

    /**
     * Summary of restore
     * @param string $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function restore(string $id)
    {
        $employee = Employee::withTrashed()->where('id', $id)->first();
        $employee->restore();
        return redirect()->route('employees.trash')->with('success', 'employee restored successfully.');
    }

    /**
     * Summary of forceDelete
     * @param string $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function forceDelete(string $id)
    {
        $employee = Employee::withTrashed()->findOrFail($id); // Contain trashed files
        $employee->forceDelete(); // Delete For ever
        return redirect()->route('employees.trash')->with('success', 'Employess permanently deleted.');
    }
}
