<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Traits\ApiResponse;
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
        return $this->apiResponse([$patient], 'Patient details stored successfully', 201);
    }
}
