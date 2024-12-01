<?php

namespace App\Http\Controllers;

use App\Models\Prescription;
use Illuminate\Http\Request;
use App\Http\Requests\PrescriptionsRequest;

class PrescriptionsController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // الحصول على المستخدم الحالي
        $user = auth()->user(); 
        if($user->hasRole('doctor')){  
        // إذا كان الطبيب، احصل على الوصفات الخاصة به فقط مع تحميل العلاقة
        $prescriptions = Prescription::with('employee','appointment')
                                          ->where('doctor_id', $user->id)
                                          ->get();
        return view('prescriptions.index', compact('prescriptions'));
    }}
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
        //الحصول على المسخدم الحالي والتحقق من دوره اذا كان طبيب
        $user=auth()->user();
        if (!$user->hasRole('doctor')) {
            return redirect()->back()->withErrors(['error' => 'ليس لديك إذن لإنشاء وصفة طبية.']);
        }
        // الحصول على معرف الطبيب من المستخدم الحالي
        $doctorId = $user->id;
        $prescription=Prescription::create([
            'medical_file_id' => $request->medical_file_id,
            'doctor_id' => $doctor_id,
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
        // الحصول على المستخدم الحالي
        $user = auth()->user();

        //التحقق مما إذا كان المستخدم طبيبًا
        // if (!$user->hasRole('Admin') && !$user->hasRole('doctor') ) {
        //     return redirect()->back()->withErrors(['error' => 'ليس لديك إذن لتحديث وصفة طبية.']);
        // }
        // البحث عن الوصفة الطبية
        //$prescription = Prescriptions::findOrFail($id);

        //التحقق مما إذا كانت الوصفة الطبية تخص الطبيب الحالي
        // if ($prescription->doctor_id !== $user->id) {
        //     return redirect()->back()->withErrors(['error' => 'ليس لديك إذن لتحديث هذه الوصفة الطبية.']);
        // }
        $prescription->update([
            'medical_file_id' => $request->medical_file_id,
            'appointment_id' => $request->appointment_id,
            'medications_names' => $request->medications_names,
            'instructions' => $request->instructions,
            'details' => $request->details,
        ]);
        try{
        $prescription->update($request->only(['medications_names', 'instructions', 'details']));
        return redirect()->route('prescriptions.index');
        }  catch (Exception $e) {
            return redirect()->back()->withErrors(['error' => 'حدث خطأ أثناء تحديث الوصفة الطبية: ' . $e->getMessage()]);
        }
}

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Prescription $prescription)
{
        // الحصول على المستخدم الحالي
        $user = auth()->user();
        // التحقق مما إذا كان المستخدم طبيبًا
        if (!$user->hasRole('doctor')) {
            return redirect()->back()->withErrors(['error' => 'ليس لديك إذن لحذف وصفة طبية.']);
        }

        // البحث عن الوصفة الطبية
        // $prescription = Prescriptions::findOrFail($id);
        // التحقق مما إذا كانت الوصفة الطبية تخص الطبيب الحالي
        if ($prescription->doctor_id !== $user->id) {
            return redirect()->back()->withErrors(['error' => 'ليس لديك إذن لحذف هذه الوصفة الطبية.']);
        }
        // حذف الوصفة الطبية
        $prescription->delete();

        return redirect()->route('prescriptions.index');
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

    public function hardDelete(string $id)
    {
        Prescription::withTrashed()->where('id',$id)->forceDelete();
        return redirect()->back();
    }
}
