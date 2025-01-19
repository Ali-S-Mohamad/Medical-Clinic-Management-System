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
     * Summary of __construct
     */
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
     * Display a listing of the medical files.
     * @param \Illuminate\Http\Request $request
     * @return mixed|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View|\Illuminate\Http\JsonResponse
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
     * Show the form for creating a new medical file.
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function create()
    {
    $patients = Patient::whereDoesntHave('medicalFile') // Requirement to bring patients who do not have medical files
        ->with('user') 
        ->get();

    return view('medicalFiles.create', compact('patients'));
    }

    

    /**
     * Store a newly created medical file in storage.
     * @param \App\Http\Requests\MedicalFileRequest $request
     * @return \Illuminate\Http\RedirectResponse
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
     * Display the specified medical file
     * @param \App\Models\MedicalFile $medicalFile
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function show(MedicalFile $medicalFile)
    {   $prescriptions= $medicalFile->prescriptions()->paginate(3);
        return  view('medicalFiles.show' , compact('medicalFile','prescriptions'));
    }


    /**
     * Show the form for editing the specified medical file.
     * @param \App\Models\MedicalFile $medicalFile
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function edit(MedicalFile $medicalFile)
    {
        return  view('medicalFiles.edit',compact('medicalFile'));

    }

    /**
     * Update the specified medical file in storage.
     * @param \App\Http\Requests\UpdateMedicalFileRequest $request
     * @param \App\Models\MedicalFile $medicalFile
     * @return \Illuminate\Http\RedirectResponse
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
     * Move the specified medical file to trash
     * @param mixed $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy($id)
    {
        $medicalFile = MedicalFile::findOrFail($id);
        $medicalFile->delete();
        return redirect()->route('medicalFiles.index')->with('success', 'medicalFiles is deleted successfully');
    }

    /**
     * Display the trashed medical files
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function trash()
    {
        $medicalFiles = MedicalFile::onlyTrashed()->with([
            'patient' => function ($query) { $query->withTrashed()->with([
                'user' => function ($query) { $query->withTrashed(); } ]); }
                ])->paginate(5);
        return view ('medicalFiles.trash' , compact('medicalFiles'));
    }

    /**
     *Restore the specified medical file from trash
     * @param mixed $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function restore($id)
    {
        $medicalFile = MedicalFile::withTrashed()->find($id);
            $medicalFile->restore();

        return redirect()->route('medicalFiles.index')->with('success', 'medicalFile restored successfully.');
    }

    /**
     * Remove specified medical file from storage
     * @param string $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function forceDelete(string $id)
    {
        MedicalFile::withTrashed()->where('id',$id)->forceDelete();
        return redirect()->route('medicalFiles.index')->with('success', 'medicalFile permanently deleted.');
    }
}
