<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Traits\ApiResponse;
use App\Models\Department;
use App\Models\Patient;
use Illuminate\Http\Request;


class PatientController extends Controller
{
    use ApiResponse;
    public function storePatientDetails($user_id, Request $request){
        $patient = Patient::create([
            'user_id' => $user_id,
            'dob' => $request->dob,
            'insurance_number' => $request->insurance_number,
        ]);
        saveImage('Patient images', $request, $patient);
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


    public function getActiveDepartments(){
        $activeDepartments = Department::active()->get();
        return $this->apiResponse($activeDepartments, 'Active Departments retrieved successfully.', 200);

    }
}
