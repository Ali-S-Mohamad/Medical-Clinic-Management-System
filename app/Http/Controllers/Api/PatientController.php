<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Patient;
use Illuminate\Http\Request;

class PatientController extends Controller
{
    public function storePatientDetails(string $id, $input=[]){
        Patient::create([
            'user_id' => $id,
            'dob' => $input['dob'],
            'insurance_number' => $input['insurance_number']
        ]);
    }
}
