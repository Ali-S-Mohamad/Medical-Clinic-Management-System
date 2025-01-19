<?php

namespace App\Http\Controllers;

use App\Models\ClinicInfo;
use Illuminate\Http\Request;
use App\Http\Requests\ClinicInfoRequest;

class ClinicInfoController extends Controller
{
    public function __construct() {
        $this->middleware('role:Admin')->only(['edit', 'update']);
    }

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
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Show details of the specified resource.
     * 
     * @param string $id
     * @return \Illuminate\View\View
     */
    public function show(string $id)
    {
        $clinic = ClinicInfo::findOrFail($id);
        return view('clinic.show', compact('clinic'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param ClinicInfo $clinic
     * @return \Illuminate\View\View
     */
    public function edit(ClinicInfo $clinic)
    {
        return view('clinic.edit', compact('clinic'));
    }

    /**
     * Update clinic resource info.
     *
     * @param ClinicInfoRequest $request
     * @param string $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(ClinicInfoRequest $request, string $id)
    {
        $clinic = ClinicInfo::findOrFail($id);
        $clinic->update([
            'name'  => $request->name,
            'email' => $request->email,
            'address' => $request->address,
            'phone_number'   => $request->phone,
            'established_at' => $request->established_at,
            'about' => $request->about,
        ]);
        saveImage('logos', $request, $clinic);
        return redirect()->route('clinic.show',compact('clinic') );
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
