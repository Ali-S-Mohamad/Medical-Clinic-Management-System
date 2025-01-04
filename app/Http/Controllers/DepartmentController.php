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
        $departments = Department::paginate(5);
        return view('departments.index' , compact('departments'));
    }
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
    
        saveImage('Departments images', $request, $department);
    
        return redirect()->route('departments.index');
    }
    
    

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $department = Department::findOrFail($id);
        return view('departments.show',compact('department'));    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $department = Department::findOrFail($id);
        return view('departments.edit',compact('department'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request , string $id)
    {
        // dd($request->all());
        $department = Department::findOrFail($id);
        $department->name = $request->name;
        $department->description = $request->description;
        $department->status = $request->status === 'active' ? 1 : 0;
        $department->save();    

        saveImage('Departments images', $request, $department);

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
    return redirect()->route('departments.index')->with('success', 'Department status updated successfully.');
    }
    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id){
        $department = Department::findOrFail($id);
        $department->delete();
        return redirect()->route('departments.index');
    }

    public function trash(){
        $departments = Department::onlyTrashed()->get();
        return view('departments.trash', compact('departments'));
    }

    public function restore($id){
        $department = Department::withTrashed()->findOrFail($id);
        $department->restore();
        return redirect()->route('departments.trash')->with('success', 'department restored successfully.');
    }

    public function forcedelete(string $id)
    {
    $department = Department::withTrashed()->findOrFail($id); 
    $department->forceDelete(); // حذف نهائي
    return redirect()->route('departments.trash')->with('success', 'Department permanently deleted.');
    }

}