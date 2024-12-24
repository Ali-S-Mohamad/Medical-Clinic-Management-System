<?php

namespace App\Http\Controllers;

use Illuminate\View\View;
use Illuminate\Support\Facades\DB;
use Spatie\Permission\Models\Role;
use Illuminate\Http\RedirectResponse;
use App\Http\Requests\StoreRoleRequest;
use App\Http\Requests\UpdateRoleRequest;
use Spatie\Permission\Models\Permission;

class RoleController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('permission:create-role|edit-role|delete-role', ['only' => ['index','show']]);
        $this->middleware('permission:create-role', ['only' => ['create','store']]);
        $this->middleware('permission:edit-role', ['only' => ['edit','update']]);
        $this->middleware('permission:delete-role', ['only' => ['destroy']]);
    }
    /**
     * Display a listing of the resource.
     */
    public function index()
    {   $roles = Role::orderBy('id','DESC')->paginate(3);
        return view('roles.index', compact('roles'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {   $permissions = Permission::get();
        return view('roles.create', compact('permissions'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreRoleRequest $request)
    {
        $role = Role::create([
            'name' => $request->name
        ]);
        $permissions = Permission::whereIn('id', $request->permissions)->get(['name'])->toArray();
        $role->syncPermissions($permissions);

        return redirect()->route('roles.index')
                ->withSuccess('New role is added successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Role $role)
    {
        $rolePermissions = Permission::join("role_has_permissions","permission_id","=","id")
            ->where("role_id",$role->id)
            ->select('name')
            ->get();
        return view('roles.show', compact('role' , 'rolePermissions'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Role $role)
    {
        if($role->name=='Admin'){
            abort(403, 'ADMIN ROLE CAN NOT BE EDITED');
        }

        $rolePermissions = DB::table("role_has_permissions")->where("role_id",$role->id)
            ->pluck('permission_id')
            ->all();
        $permissions = Permission::get();
        return view('roles.edit', compact('role','permissions', 'rolePermissions'));
        
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateRoleRequest $request, Role $role)
    {
        $input = $request->only('name');
        $role->update($input);
        $permissions = Permission::whereIn('id', $request->permissions)->get(['name'])->toArray();
        $role->syncPermissions($permissions);

        return redirect()->route('roles.index')
                ->withSuccess('Role is updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Role $role)
    {
        if($role->name=='Admin'){
            abort(403, 'ADMIN ROLE CAN NOT BE DELETED');
        }
        if(auth()->user()->hasRole($role->name)){
            abort(403, 'CAN NOT DELETE SELF ASSIGNED ROLE');
        }
        $role->delete();
        return redirect()->route('roles.index')
                ->with('error' , 'Role is deleted successfully.');
    }
}
