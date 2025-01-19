<?php

namespace App\Services;

use App\Models\Report;

class ReportFilterService
{

    /**
     * filter reports
     * @param array $filters
     * @return mixed
     */
    public function filter(array $filters)
    {
        $query = Report::with(['patient.user'])
            ->filterByName($filters['patient_name'] ?? null)
            ->filterByDoctor($filters['doctor_name'] ?? null)
            ->filterByDate($filters['appointment_date'] ?? null);

        return $query->paginate(5);
    }


}
