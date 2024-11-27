<?php

namespace App\Http\Controllers;

use App\Http\Requests\DepartmentRequest;
use App\Models\Department;
use Illuminate\Http\Request;

class DepartmentController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $departments = Department::all();
<<<<<<< HEAD
        return view('departments.index' , compact('departments'));  
    }
=======
        return view('departments.index', compact('departments'));
    }

>>>>>>> 80eabe856da1f5424eab8d38476e0782d1eb464c
    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('departments.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(DepartmentRequest $request)
    {
        $department = new Department();
        $department->name = $request->name;
        $department->description = $request->description;
        $department->status = $request->status === 'active' ? 1 : 0;
        $department->save();

<<<<<<< HEAD
        return redirect()->route('departments.index');    }
=======
        return redirect()->route('departments.index');
    }
>>>>>>> 80eabe856da1f5424eab8d38476e0782d1eb464c

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $department = Department::findOrFail($id);
<<<<<<< HEAD
        return view('departments.show',compact('department'));    }
=======
        return view('departments.show', compact('department'));
    }
>>>>>>> 80eabe856da1f5424eab8d38476e0782d1eb464c

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $department = Department::findOrFail($id);
<<<<<<< HEAD
        return view('departments.edit',compact('department'));
=======
        return view('departments.edit', compact('department'));
>>>>>>> 80eabe856da1f5424eab8d38476e0782d1eb464c
    }

    /**
     * Update the specified resource in storage.
     */
<<<<<<< HEAD
    public function update(DepartmentRequest $request , string $id)
=======
    public function update(DepartmentRequest $request, string $id)
>>>>>>> 80eabe856da1f5424eab8d38476e0782d1eb464c
    {
        $department = Department::findOrFail($id);
        $department->name = $request->name;
        $department->description = $request->description;
        $department->status = $request->status === 'active' ? 1 : 0;
        $department->save();

<<<<<<< HEAD
        return redirect()->route('departments.index');  
    }
    
    /**
     * to toggle the status
     */
    public function toggleStatus($id)
    {
    $department = Department::findOrFail($id);
    $department->status = $department->status == 1 ? 0 : 1;
    $department->save();
    return redirect()->back()->with('success', 'Department status updated successfully.');
    }
    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id){
=======
        return redirect()->route('departments.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
>>>>>>> 80eabe856da1f5424eab8d38476e0782d1eb464c
        $department = Department::findOrFail($id);
        $department->delete();
        return redirect()->route('departments.index');
    }

<<<<<<< HEAD
    public function trash(){
=======
    public function trash()
    {
>>>>>>> 80eabe856da1f5424eab8d38476e0782d1eb464c
        $departments = Department::onlyTrashed()->get();
        return view('departments.trash', compact('departments'));
    }

<<<<<<< HEAD
    public function restore($id){
        $department = department::withTrashed()->findOrFail($id);
=======
    public function restore($id)
    {
        $department = Department::withTrashed()->findOrFail($id);
>>>>>>> 80eabe856da1f5424eab8d38476e0782d1eb464c
        $department->restore();
        return redirect()->route('departments.trash')->with('success', 'department restored successfully.');
    }

    public function hardDelete(string $id)
    {
<<<<<<< HEAD
    $department = Department::withTrashed()->findOrFail($id); // يشمل السجلات المحذوفة
    $department->forceDelete(); // حذف نهائي
    return redirect()->route('departments.trash')->with('success', 'Department permanently deleted.');
    }

=======
        $department = Department::withTrashed()->findOrFail($id); // Contain trashed files
                $department->forceDelete(); // Delete For ever
        return redirect()->route('departments.trash')->with('success', 'Department permanently deleted.');
    }
>>>>>>> 80eabe856da1f5424eab8d38476e0782d1eb464c
}
