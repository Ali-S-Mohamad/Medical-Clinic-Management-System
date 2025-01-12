<?php

namespace App\Http\Controllers;

use App\Http\Requests\DepartmentRequest;
use App\Models\Department;
use Illuminate\Http\Request;

class DepartmentController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('permission:show-department', ['only' => ['index','show']]);
        $this->middleware('permission:create-department', ['only' => ['create','store']]);
        $this->middleware('permission:edit-department', ['only' => ['edit','update','toggleStatus']]);
        $this->middleware('permission:Archive-department', ['only' => ['destroy']]);
        $this->middleware('permission:view-archiveDepartment', ['only' => ['trash']]);
        $this->middleware('permission:restore-department', ['only' => ['restore']]);
        $this->middleware('permission:delete-department', ['only' => ['forcedelete']]);

    }
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
    public function update(DepartmentRequest $request , string $id)
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
     * Summary of toggleStatus
     * @param mixed $id
     * @return \Illuminate\Http\RedirectResponse
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
