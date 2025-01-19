<?php

namespace App\Services;

use App\Models\Employee;

class EmployeeService
{
    /**
     * filter employees
     * @param array $filters
     * @return mixed
     */
    public function filter(array $filters)
    {
        $result = Employee::with(['department', 'roles'])
            ->filterByName($filters['employee_name'] ?? null)
            ->filterByDepartment($filters['department'] ?? null)
            ->filterByRole($filters['role'] ?? null);
        return $result;
    }


    /**
     * a function to save or update employee details
     * @param mixed $request
     * @param mixed $user
     * @return Employee|\Illuminate\Database\Eloquent\Model
     */
    public function saveOrUpdateEmployeeDetails($request,  $user)
    {
        saveImage($request->has('is_patient') ? 'Patient images' : 'Employees images', $request, $user);
        $userId = $user->id;
        $employee = Employee::updateOrCreate(
            ['user_id' => $userId],
            [
                'department_id' => $request->department_id,
                'academic_qualifications' => $request->qualifications,
                'previous_experience' => $request->experience,
            ]
        );

        $employee->languages()->sync($request->languages_ids);

        $cvFilePath = uploadCvFile('Employees CVs', $request, $employee->cv_path);
        $employee->cv_path = $cvFilePath;
        $employee->save();

        if ($request->has('is_patient_employee')){
            $user->assignRole('patient');
        }

        return $employee;
    }

}
