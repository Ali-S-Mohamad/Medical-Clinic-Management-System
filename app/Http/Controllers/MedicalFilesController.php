<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Patient;
use App\Models\MedicalFile;
use Illuminate\Http\Request;
use App\Http\Requests\MedicalFileRequest;
use App\Services\MidecalFileFilterService;
use App\Http\Requests\UpdateMedicalFileRequest;

class MedicalFilesController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    protected $medicalFileFilterService;
    public function index(Request $request)
    {

    // Retrive input values
    $filters = $request->only(['search_name', 'search_insurance']);

    // Service call
    $medicalFileFilterService = app(MidecalFileFilterService::class);
    $medicalFiles = $medicalFileFilterService->filter($filters);

    if(!empty($filter['search_name']) || !empty($filter['search_insurance'])){
        if ($medicalFiles->count() == 0) {
                return redirect()->route('medicalFiles.index');
            }
        } else {

     // Is there no search, show all result
    $medicalFiles = $medicalFiles->orderBy('created_at','asc')->paginate(4);
    }
    return view('medicalFiles.index', compact('medicalFiles', 'filters'));

    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return  view('medicalFiles.create');

    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(MedicalFileRequest $request)
{
    // Search for patient by name
    $patient = Patient::whereHas('user', function($query) use ($request) {
        $query->where('name', $request->patient_name);
    })->firstOrFail();

    // Check if the patient has a previous medical record
    if ($patient->medicalFile()->exists()) {
        return redirect()->back()->withErrors(['message' => 'the patient has a previous medical record']);
    }

    // create medical file
    $medicalFile = MedicalFile::create([
        'patient_id' => $patient->id,
        'diagnoses' => $request->diagnoses,
    ]);

    return redirect()->route('medicalFiles.show', $medicalFile->id)
                    ->with('success', 'the medical file was created successfully');
}


    /**
     * Display the specified resource.
     */
    public function show(MedicalFile $medicalFile)
    {   $prescriptions= $medicalFile->prescriptions()->paginate(3);
        return  view('medicalFiles.show' , compact('medicalFile','prescriptions'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(MedicalFile $medicalFile)
    {
        return  view('medicalFiles.edit',compact('medicalFile'));

    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateMedicalFileRequest $request, MedicalFile $medicalFile)
    {
        $medicalFile->update([
            'diagnoses' => $request->diagnoses,
        ]);
        return redirect()->route('medicalFiles.show', $medicalFile->id)
        ->with('success', 'the medical file was updated successfully');

    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $medicalFile = MedicalFile::findOrFail($id);
        $medicalFile->delete();
        return redirect()->route('medicalFiles.index')->with('success', 'medicalFiles is deleted successfully');
    }
    public function trash()
    {
        $medicalFiles= MedicalFile::onlyTrashed()->get();
        return view ('medicalFiles.trash' , compact('medicalFiles'));
    }

    public function restore($id)
    {
        $medicalFile = MedicalFile::withTrashed()->find($id);
            $medicalFile->restore();

        return redirect()->route('medicalFiles.index')->with('success', 'medicalFile restored successfully.');
    }

    public function hardDelete(string $id)
    {
        MedicalFile::withTrashed()->where('id',$id)->forceDelete();
        return redirect()->route('medicalFiles.index')->with('success', 'medicalFile permanently deleted.');
    }

}
