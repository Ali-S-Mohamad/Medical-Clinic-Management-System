<?php

namespace App\Http\Controllers;

use App\Models\Employee;
use App\Models\Department;
use Illuminate\Http\Request;
use App\Http\Requests\UpdateUser;

class EmployeeController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $employees=Employee::all();
        // $categories=Category::all(); ,['books'=>$books,'categories'=>$categories]
        return view('employees.index',compact('employees'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {   
    }

    /**
     * Store a newly created resource in storage.
     */
    // public function store(Request $request)
    // { 
    // }

    public function storemp(Request $request)
    {   
        Employee::create([ 
            'user_id' => $request->user_id, 
            'department_id'=>$request->department_id,
            'academic_qualifications'=>$request->qualifications,
            'previous_experience'=>$request->experience,// 'other_information' => $request->other_information, 
        ]); 
        return redirect()->route('employees.index');
    }


    /**
     * Display the specified resource.
     */
    public function show(Employee $employee)
    {
        // $book_categories=Book::findOrFail($book->id);
        return view('employees.show', compact('employee'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Employee $employee)
    {
        $departments=Department::all();
        return view('employees.edit',compact('employee','departments'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateUser $request,Employee $employee)
    { // dd('asasa');
        $employee->update([
            'department_id'=>$request->department_id,
            'academic_qualifications'=>$request->qualifications,
            'previous_experience'=>$request->experience,
        ]);
        if ($request->filled('password')) { 
            $password = bcrypt($request->password);}
        return redirect()->action([UserController::class, 'update_user'], 
        ['user_id'  => $employee->user_id,
         'name'     => $request->name,
         'email'    => $request->email,
         'password' => $request->filled('password') ? bcrypt($request->password) : "",
        ]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Employee $employee)
    {
        $employee->delete();
        return redirect()->route('employees.index');
    }

    public function trash(){
        $deletedEmployees = Employee::onlyTrashed()->with([
            'user' => function ($query) { $query->withTrashed(); }])->get();
        return view('employees.trash', compact('deletedEmployees'));
    }

    public function restore(string $id)
    {
        // $employee = Employee::withTrashed()->findOrFail($id);
        $employee = Employee::withTrashed()->where('id',$id)->first();
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
