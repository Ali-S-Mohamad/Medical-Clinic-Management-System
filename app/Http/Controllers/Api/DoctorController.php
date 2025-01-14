<?php

namespace App\Http\Controllers\Api;

use App\Models\User;
use App\Models\Employee;
use Illuminate\Http\Request;
use App\Http\Traits\ApiResponse;
use App\Http\Controllers\Controller;
use App\Http\Resources\DoctorResource;
use App\Http\Resources\DoctorsResource;

class DoctorController extends Controller
{
    use ApiResponse;

    /**
     * Summary of listDoctors
     * @return \Illuminate\Http\JsonResponse
     */
    public function listDoctors(){
        $doctors = User::role('doctor')->get();
        return $this->apiResponse(DoctorsResource::collection($doctors), 'All Doctors retrieved successfully.', 200);
    }


    /**
     * Summary of showDoctor
     * @param string $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function showDoctor(string $id){
        $doctor = Employee::findOrFail($id);
        return $this->apiResponse(new DoctorResource($doctor), 'The Doctor retrieved successfully.', 200);
    }
}
