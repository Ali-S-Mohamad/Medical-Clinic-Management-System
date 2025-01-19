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
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('permission:show-MedicalFile', ['only' => ['index','show']]);
        $this->middleware('permission:create-MedicalFile', ['only' => ['create','store']]);
        $this->middleware('permission:edit-MedicalFile', ['only' => ['edit','update']]);
        $this->middleware('permission:Archive-MedicalFile', ['only' => ['destroy']]);
        $this->middleware('permission:view-archiveMedicalFile', ['only' => ['trash']]);
        $this->middleware('permission:restore-MedicalFile', ['only' => ['restore']]);
        $this->middleware('permission:delete-MedicalFile', ['only' => ['forcedelete']]);

    }
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
{
    $filters = $request->only(['search_name', 'search_insurance']);

    $query = MedicalFile::query();

    if (!empty($filters['search_name'])) {
        $query->whereHas('patient.user', function ($q) use ($filters) {
            $q->whereRaw("CONCAT(firstname, ' ', lastname) LIKE ?", ["%{$filters['search_name']}%"]);
        });
    }

    if (!empty($filters['search_insurance'])) {
        $query->whereHas('patient', function ($q) use ($filters) {
            $q->where('insurance_number', 'like', '%' . $filters['search_insurance'] . '%');
        });
    }

    $medicalFiles = $query->paginate(5);

    if ($request->ajax()) {
        return response()->json([
            'html' => view('medicalFiles.partials.table', compact('medicalFiles'))->render()
        ]);
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
    //earch for patient by name
    $patient = Patient::whereHas('user', function($query) use ($request) {
        $query->whereRaw("CONCAT(firstname, ' ', lastname) = ?", [$request->patient_name]);
    })->first();

     //search for patient by name if exist
    if (!$patient) {
        return redirect()->back()->withErrors(['message' => 'This patient is not on the patient list']);
    }

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
                    ->with('success','the medical file was created successfully');
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
        $medicalFiles = MedicalFile::onlyTrashed()->with([
            'patient' => function ($query) { $query->withTrashed()->with([
                'user' => function ($query) { $query->withTrashed(); } ]); }
                ])->paginate(5);
        return view ('medicalFiles.trash' , compact('medicalFiles'));
    }

    public function restore($id)
    {
        $medicalFile = MedicalFile::withTrashed()->find($id);
            $medicalFile->restore();

        return redirect()->route('medicalFiles.index')->with('success', 'medicalFile restored successfully.');
    }

    public function forceDelete(string $id)
    {
        MedicalFile::withTrashed()->where('id',$id)->forceDelete();
        return redirect()->route('medicalFiles.index')->with('success', 'medicalFile permanently deleted.');
    }

}
