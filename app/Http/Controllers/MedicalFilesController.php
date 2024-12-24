<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Patient;
use App\Models\MedicalFile;
use Illuminate\Http\Request;
use App\Http\Requests\MedicalFileRequest;

class MedicalFilesController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $searchName = $request->input('search_name');
        $searchInsurance = $request->input('search_insurance');
        
        // بدء البحث في ملفات طبية
        $medicalFiles = MedicalFile::query();
    
        if ($searchName || $searchInsurance) {
            // البحث عن المريض باستخدام الاسم أو رقم التأمين
            $medicalFiles->whereHas('patient', function($query) use ($searchName, $searchInsurance) {
                if ($searchInsurance) {
                    $query->where('insurance_number', 'LIKE', "%{$searchInsurance}%");
                }
                if ($searchName) {
                    $query->whereHas('user', function($userQuery) use ($searchName) {
                        $userQuery->where('name', 'LIKE', "%{$searchName}%");
                    });
                }
            });
    
            // التحقق من وجود ملفات طبية بناءً على البحث
            if ($medicalFiles->count() == 0) {
                return view('medicalFiles.index', [
                    'medicalFiles' => $medicalFiles->paginate(4),
                    'message' => 'there is no medical file with this name.'
                ]);
            }
        }
    
        // إذا لم يكن هناك عملية بحث، عرض كل النتائج
        $medicalFiles = $medicalFiles->paginate(4);
    
        return view('medicalFiles.index', compact('medicalFiles'));
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
    // البحث عن المريض باستخدام الاسم
    $patient = Patient::whereHas('user', function($query) use ($request) {
        $query->where('name', $request->patient_name);
    })->firstOrFail();

    // التحقق مما إذا كان لدى المريض ملف طبي سابق
    if ($patient->medicalFile()->exists()) {
        return redirect()->back()->withErrors(['message' => 'the patient has a previous medical record']);
    }

    // إنشاء ملف طبي جديد باستخدام دالة create
    $medicalFile = MedicalFile::create([
        'patient_id' => $patient->id,
        'diagnoses' => $request->diagnoses,
    ]);

    // إعادة التوجيه مع رسالة نجاح
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
    public function update(Request $request, MedicalFile $medicalFile)
    {   $request->validate([
        'diagnoses' => 'required|string'
    ]);
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
