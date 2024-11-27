<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreUser;
use App\Models\User;
use App\Models\Department;
use Illuminate\Http\Request;

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
        $departments=Department::all();
        return view('users.create', compact('departments'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreUser $request)
    { //dd($request);
        $user = User::create([ 
            'name' => $request->name, 
            'email' => $request->email, 
            'password' => bcrypt($request->password), 
            'is_patient'=>false,
             ]);
        return redirect()->action([EmployeeController::class, 'storemp'], 
                      ['user_id'       => $user->id,
                       'qualifications'=> $request->qualifications,
                       'experience'    => $request->experience,
                       'department_id' => $request->department_id]);
    }

    public function update_user(Request $request){
        $user = User::findOrFail($request->user_id);
        // dd($request->password );
        $user->update([
            'name'=>$request->name,
            'email'=>$request->email,
            'password' => $request->password ? ($request->password) : $user->password,
        ]);
        return redirect()->route('employees.index'); //
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
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(User $user)
    {
        // $user->delete();
        // return redirect()->route('employees.index');
    }

    public function restore(string $id){
        // $user=User::withTrashed()->where('id',$id)->first();
        // $user->restore();
        // return redirect()->route('employees.index');
    }
}
