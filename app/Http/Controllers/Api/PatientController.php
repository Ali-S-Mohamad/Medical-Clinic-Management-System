<?php

namespace App\Http\Controllers\Api;

use App\Models\Patient;
use Illuminate\Http\Request;
use App\Http\Traits\ApiResponse;
use App\Http\Controllers\Controller;



class PatientController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth:sanctum','permission:get-PatientPrescriptions'])->only(['getMyPrescriptions']);
        $this->middleware(['auth:sanctum','permission:get-ActiveDepartments'])->only(['getActiveDepartments']);
        $this->middleware(['auth:sanctum','permission:get-AvailableDoctorforPatient'])->only('getAvailableDoctorsInDepartment');

    }
    use ApiResponse;

    /**
     * Summary of storePatientDetails
     * @param mixed $user_id
     * @param \Illuminate\Http\Request $request
     * @return mixed|\Illuminate\Http\JsonResponse
     */
    public function storePatientDetails($user_id, Request $request){
        $patient = Patient::create([
            'user_id' => $user_id,
            'dob' => $request->dob,
            'insurance_number' => $request->insurance_number,
        ]);
        return $this->apiResponse([$patient], 'Patient details stored successfully', 201);
    }

    /**
     * Summary of getMyPrescriptions
     * @param \Illuminate\Http\Request $request
     * @return mixed|\Illuminate\Http\JsonResponse
     */
    public function getMyPrescriptions(Request $request){
        $user = $request->user();
        $patient = $user->patient;
        $prescriptions = $patient->medicalFile->prescriptions()->get();
        return $this->apiResponse($prescriptions, 'Prescriptions retrieved successfully.', 200);
    }
}
