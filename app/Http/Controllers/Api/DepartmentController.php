<?php

namespace App\Http\Controllers\Api;

use App\Models\User;
use App\Models\Department;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\DoctorsResource;
use App\Http\Resources\DepartmentsResource;

class DepartmentController extends Controller
{
    /**
     * Summary of getActiveDepartments
     * @return mixed|\Illuminate\Http\JsonResponse
     */
    public function getActiveDepartments()
    {
        $activeDepartments = Department::active()->get();
        return $this->apiResponse(DepartmentsResource::collection($activeDepartments), 'Active Departments retrieved successfully.', 200);
    }


    /**
     * Summary of getAvailableDoctorsInDepartment
     * @param mixed $departmentId
     * @return \Illuminate\Http\JsonResponse
     */
    public function getAvailableDoctorsInDepartment($departmentId)
    {

        $availableDoctors = User::role('doctor')->with('employee')
            ->whereHas('employee', function ($query) use ($departmentId) {
                $query->where('department_id', $departmentId);
            })->get();
        return $this->apiResponse(DoctorsResource::collection($availableDoctors), 'Active Doctors retrieved successfully.', 200);
    }
}
