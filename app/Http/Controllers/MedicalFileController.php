<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreMedicalFileRequest;
use App\Models\Employee;
use App\Models\MedicalFile;
use App\Models\Patient;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class MedicalFileController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        if (!auth()->check()) { 
            abort(403, 'Unauthorized'); 
        }
        
        $doctor = Employee::where('user_id', auth()->user()->id)->first();
        if (!$doctor) { 
            abort(403, 'Unauthorized'); 
        }
        $medicalFiles = MedicalFile::whereHas('patient.appointments', function ($query) use ($doctor) {
        $query->where('doctor_id', $doctor->id);
         })->get();

        return view('medicalFiles.index', compact('medicalFiles'));
    } 
    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('medicalFiles.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreMedicalFileRequest $request)
    {
        if (!auth()->check()) { 
            abort(403, 'Unauthorized'); 
        }
        
        $doctor = Employee::where('user_id', auth()->user()->id)->first();
        if (!$doctor) { 
            abort(403, 'Unauthorized'); 
        }
    
        $patient = Patient::find($request->patient_id);
        if (!$patient) {
            return redirect()->back()->with('error', 'Patient not found.');
        }
        MedicalFile::create([
            'patient_id' => $request->patient_id,
        ]);
    
        return redirect()->route('medicalFiles.index')->with('success', 'Medical file created successfully.');
    }
    
    
    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $medicalFile = MedicalFile::with(['patient.appointments', 'prescriptions'])->findOrFail($id);
        return view('medicalFiles.show', compact('medicalFile'));
    }
    
    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $medicalFile = MedicalFile::findOrFail($id); 
        return view('medicalFiles.edit', compact('medicalFile'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(StoreMedicalFileRequest $request, $id)
    {
        $medicalFile = MedicalFile::findOrFail($id);
        $patient = Patient::findOrFail($request->patient_id);
  
        $medicalFile->update([
            'patient_id' => $request->patient_id,
        ]);

        return redirect()->route('medicalFiles.index')->with('success', 'Medical file updated successfully.');
    }
    
    
    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $medicalfile = MedicalFile::findOrFail($id);
        $medicalfile->delete();
        return redirect()->route('medicalFiles.index');
    }

    public function trash()
    {
        $medicalfiles = MedicalFile::onlyTrashed()->get();
        return view('medicalFiles.trash', compact('medicalfiles'));
    }

    public function restore($id)
    {
        $medicalfile = MedicalFile::withTrashed()->findOrFail($id);
        $medicalfile->restore();
        return redirect()->route('medicalFiles.trash')->with('success', 'medicalfile restored successfully.');
    }

    public function hardDelete(string $id)
    {
        $medicalfile = MedicalFile::withTrashed()->findOrFail($id); // Contain trashed files
                $medicalfile->forceDelete(); // Delete For ever
        return redirect()->route('medicalFiles.trash')->with('success', 'medicalfile permanently deleted.');
    }
}
