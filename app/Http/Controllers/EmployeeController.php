<?php

namespace App\Http\Controllers;

use App\Models\Employee;
use App\Models\Language;
use App\Models\Department;
use Illuminate\Http\Request;
use App\Http\Requests\UpdateUserRequest;

class EmployeeController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $employees = Employee::with(['user.roles', 'department'])->get();
        return view('employees.index', compact('employees'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create() {}

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request){
        //
    }

    public function storeEmployeeDetails($userId, Request  $request)
    {
        $employee = Employee::create([
            'user_id' => $userId,
            'department_id' => $request->department_id,
            'academic_qualifications' => $request->qualifications,
            'previous_experience' => $request->experience,     
        ]);

        $cvFilePath = uploadCvFile('Employees CVs' , $request , $employee->cv_path );
        $employee->cv_path=$cvFilePath;
        $employee->save();

        $employee->languages()->sync($request->languages_ids);
        return redirect()->route('employees.index');
    }

    public function updateEmployeeDetails($userId, Request $request)
    {   
        
        $employee = Employee::where('user_id',$userId)->first();
        // ممكن هالسطر يكون بعد تعديل معلومات الموظف،
        //  بس حطيتو هون لاختصر سطر انو ارجع عدل مسار سيرتو  بعد ما كون خالصة تعديل البيانات وارجع استدعي السيف
        $cvFilePath = uploadCvFile('Employees CVs', $request , $employee->cv_path );

        $employee->update([
            'department_id' => $request->department_id,
            'cv_path' => $cvFilePath,
            'academic_qualifications' => $request->qualifications,
            'previous_experience' => $request->experience,
        ]);

        $employee->languages()->sync($request->languages_ids);
        return redirect()->route('employees.index');
    }

    /**
     * Display the specified resource.
     */
    public function show(Employee $employee)
    {
        
        return view('employees.show', compact('employee'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Employee $employee)
    {
        $departments = Department::all();
        $languages   = Language::all();
        $role = $employee->user->roles->first()->name; 
        return view('employees.edit', compact('employee', 'departments','languages','role'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Employee $employee)
    {
      //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Employee $employee)
    {
        $employee->delete();
        return redirect()->route('employees.index');
    }

    public function trash()
    {
        $deletedEmployees = Employee::onlyTrashed()->with([
            'user' => function ($query) {
                $query->withTrashed();
            }
        ])->get();
        return view('employees.trash', compact('deletedEmployees'));
    }

    public function restore(string $id)
    {
        $employee = Employee::withTrashed()->where('id', $id)->first();
        $employee->restore();
        return redirect()->route('employees.trash')->with('success', 'employee restored successfully.');
    }

    public function hardDelete(string $id)
    {
        $employee = Employee::withTrashed()->findOrFail($id); // Contain trashed files
        $employee->forceDelete(); // Delete For ever
        return redirect()->route('employees.trash')->with('success', 'Employess permanently deleted.');
    }
}