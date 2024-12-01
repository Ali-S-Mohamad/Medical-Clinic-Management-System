<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\PrescriptionsRequest;

class PrescriptionsController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $prescriptions=Prescriptions::all();
        return view ('prescriptions.index' , compact('prescriptions'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view ('prescriptions.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(PrescriptionsRequest $request)
    {
        $prescription=Prescriptions::create([
            'medical_file_id' => $request->medical_file_id,
            'doctor_id' => $request->doctor_id,
            'appointment_id' => $request->appointment_id,
            'medications_names' => $request->medications_names,
            'instructions' => $request->instructions,
            'details' => $request->details
        ]);
        return redirect()->route('prescriptions.index')
                        ->with('success', 'Prescription created successfully');
    }

    /**
     * Display the specified resource.
     */
    public function show(Prescription $prescription)
    {
        return view ('prescriptions.show' , compact('prescription'));

    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Prescription $prescription)
    {
        return view ('prescriptions.edit' , compact('prescription'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(PrescriptionsRequest $request, Prescription $prescription)
    {
        $prescription->update([
            'medical_file_id' => $request->medical_file_id,
            'doctor_id' => $request->doctor_id,
            'appointment_id' => $request->appointment_id,
            'medications_names' => $request->medications_names,
            'instructions' => $request->instructions,
            'details' => $request->details
        ]);
        return redirect()->route('prescriptions.index')
                        ->with('success', 'Prescription updated successfully');

    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Prescription $prescription)
    {
        $prescription->delete();
        return redirect()->route('prescriptions.index')
                        ->with('success', 'Prescription deleted successfully');
    }

    public function trash()
    {
        $prescriptions= Prescription::onlyTrashed()->get();
        return view ('prescriptions.trash' , compact('prescriptions'));
    }

    public function restore(string $id)
    {
        $prescriptions= Prescription::withTrashed()->where('id',$id)->restore();
        return redirect()->back();
    }

    public function forceDelete(string $id)
    {
        Prescription::withTrashed()->where('id',$id)->forceDelete();
        return redirect()->back();
    }
}
