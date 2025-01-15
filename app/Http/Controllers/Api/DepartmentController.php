<?php

namespace App\Http\Controllers\Api;

use App\Models\User;
use App\Models\Department;
use App\Http\Traits\ApiResponse;
use App\Http\Controllers\Controller;
use App\Http\Resources\DoctorsResource;
use App\Http\Resources\DepartmentsResource;
use App\Models\ClinicInfo;

class DepartmentController extends Controller
{
    use ApiResponse;

    /**
     * Summary of listDepartments
     * @return mixed
     */
    public function listDepartments(){
        $departments = Department::all();
        return $this->apiResponse(DepartmentsResource::collection($departments), 'All Departments retrieved successfully.', 200);
    }


    /**
     * Summary of showDepartment
     * @param \App\Models\Department $department
     * @return \Illuminate\Http\JsonResponse
     */
    public function showDepartment(string $id){
        $department = Department::find($id);
        if(!$department){
            return $this->errorResponse('There isn\'t department with that id.', 400);
        }
        $doctorsInDepartment = $this->getAvailableDoctorsInDepartment($id);
        return $this->apiResponse([new DepartmentsResource($department),'doctors:',$doctorsInDepartment], 'Department retrieved successfully.', 200);
    }



    /**
     * Summary of getActiveDepartments
     * @return mixed|\Illuminate\Http\JsonResponse
     */
    public function getActiveDepartments()
    {
        $activeDepartments = Department::active()->paginate(5);
        return $this->apiResponse(DepartmentsResource::collection($activeDepartments), 'Active Departments retrieved successfully.', 200);
    }



    /**
     * Summary of getAvailableDoctorsInDepartment
     * @param mixed $departmentId
     * @return \Illuminate\Http\JsonResponse
     */
    public function getAvailableDoctorsInDepartment($departmentId)
    {
        $department = Department::find($departmentId);
        if(!$department){
            return $this->errorResponse('There isn\'t department with that id.', 400);
        }
        $availableDoctors = User::role('doctor')->with('employee')
            ->whereHas('employee', function ($query) use ($departmentId) {
                $query->where('department_id', $departmentId);
            })->get();
        if($availableDoctors->isEmpty()){
            return $this->errorResponse('There isn\'t doctors in this department.', 400);
        }
        return $this->apiResponse(DoctorsResource::collection($availableDoctors), 'Active Doctors retrieved successfully.', 200);
    }


    public function getClinicInfo(){
        $info = ClinicInfo::first();
        return $this->apiResponse($info, 'Clinic Information retrieved successfully.', 200);
    }
}
