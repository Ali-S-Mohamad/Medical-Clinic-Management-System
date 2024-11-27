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
<<<<<<< HEAD
            'dob' => $input['dob']
=======
            'dob' => $input['dob'],
            'insurance_number' => $input['insurance_number']
>>>>>>> 80eabe856da1f5424eab8d38476e0782d1eb464c
        ]);
    }
}
