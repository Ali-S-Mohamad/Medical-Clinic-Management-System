<?php

namespace App\Services;

use App\Models\Employee;

class EmployeeFilterService
{
    public function filter(array $filters)
    {
        $result = Employee::with(['department', 'roles'])
            ->filterByName($filters['employee_name'] ?? null)
            ->filterByDepartment($filters['department'] ?? null)
            ->filterByRole($filters['role'] ?? null);
            // dd($result);
        return $result;
    }
}

