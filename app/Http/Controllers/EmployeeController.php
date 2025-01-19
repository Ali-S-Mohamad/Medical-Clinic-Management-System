<?php

namespace App\Http\Controllers;

use App\Models\Employee;
use App\Models\Language;
use App\Models\Department;
use Illuminate\Http\Request;
use App\Services\EmployeeService;
use Illuminate\Support\Facades\DB;

class EmployeeController extends Controller
{
    protected $employeeService;

    public function __construct(EmployeeService $employeeService)
    {
        $this->middleware('auth');
        $this->middleware('permission:show-employee', ['only' => ['index','show']]);
        $this->middleware('permission:create-employee', ['only' => ['create','store']]);
        $this->middleware('permission:edit-employee', ['only' => ['edit','update']]);
        $this->middleware('permission:Archive-employee', ['only' => ['destroy']]);
        $this->middleware('permission:view-archiveEmpolyess', ['only' => ['trash']]);
        $this->middleware('permission:restore-employee', ['only' => ['restore']]);
        $this->middleware('permission:delete-employee', ['only' => ['forcedelete']]);

        $this->employeeService = $employeeService; // Inject the service into the controller
    }
    /**
     * Display a listing of the employees including doctors and administrative staffs.
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function index(Request $request)
    {
        // Retrieve input values
        $filters = $request->only(['employee_name', 'department', 'role']);

        // Fetch the filtered employees
        $employees = $this->employeeService->filter($filters)->paginate(5);

        // Check if the request is AJAX
        if ($request->ajax()) {
            // Return the table partial with employees data
            return view('employees.partials.table', compact('employees'));
        }

        // get Roles & Departments
        $departments = Department::active()->get();
        $roles = DB::table('roles')->get();

        // Return the main index view with employees, departments, roles, and filters
        return view('employees.index', compact('employees', 'departments', 'roles', 'filters'));
    }

    /**
     *  continue save or update employee info in employees table
     * @param mixed $userId
     * @param \Illuminate\Http\Request $request
     * @return mixed|\Illuminate\Http\RedirectResponse
     */
    public function saveOrUpdateEmployeeDetails($userId, Request $request)
    {
        $employee = Employee::updateOrCreate(
            ['user_id' => $userId],
            [
                'department_id' => $request->department_id,
                'academic_qualifications' => $request->qualifications,
                'previous_experience' => $request->experience,
            ]
        );

        $employee->languages()->sync($request->languages_ids);

        $cvFilePath = uploadCvFile('Employees CVs', $request, $employee->cv_path);
        $employee->cv_path = $cvFilePath;
        $employee->save();

        return redirect()->route('employees.index');
    }

    /**
     * Display the specified employee.
     * @param \App\Models\Employee $employee
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function show(Employee $employee)
    {

        return view('employees.show', compact('employee'));
    }

    /**
     * Show the form for editing the specified employee.
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
     * move the specified employee info to trash (soft delete)
     * @param \App\Models\Employee $employee
     * @return mixed|\Illuminate\Http\RedirectResponse
     */
    public function destroy(Employee $employee)
    {
        $employee->delete();
        return redirect()->route('employees.index');
    }

    /**
     * Display the trashed employees
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function trash()
    {
        $deletedEmployees = Employee::onlyTrashed()->with([
            'user' => function ($query) {
                $query->withTrashed();
            }
        ])->paginate(5);
        return view('employees.trash', compact('deletedEmployees'));
    }

    /**
     * Restore the specified employee from trash
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
     * permanent delete employee info
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
