<?php

namespace App\Http\Controllers;

use App\Models\ClinicInfo;
use Illuminate\Http\Request;
use App\Http\Requests\ClinicInfoRequest;

class ClinicInfoController extends Controller
{
    /**
     * The constructer of the class
     */
    public function __construct() {
        $this->middleware('role:Admin')->only(['edit', 'update']);
    }


    /**
     * Show the clinic information
     * @param string $id
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function show(string $id)
    {
        $clinic = ClinicInfo::findOrFail($id);
        return view('clinic.show', compact('clinic'));
    }

    /**
     * Show the form for editing the clinic information.
     * @param \App\Models\ClinicInfo $clinic
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function edit(ClinicInfo $clinic)
    {
        return view('clinic.edit', compact('clinic'));
    }

    /**
     * Update the clinic information in storage.
     * @param \App\Http\Requests\ClinicInfoRequest $request
     * @param string $id
     * @return mixed|\Illuminate\Http\RedirectResponse
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
}
