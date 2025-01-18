<?php

namespace App\Services;

use App\Models\Patient;
use Illuminate\Http\Request;


class PatientService
{
    public function saveOrUpdatePatientDetails($userId, $data, $redirect = true)
    {
        $patient = Patient::updateOrCreate(
            ['user_id' => $userId],
            [
                'insurance_number' => $data['insurance_number'],
                'dob' => $data['dob']
            ]
        );
        if ($redirect) {
            return redirect()->route('patients.index');
        }
        return $patient;
    }
}
