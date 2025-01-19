<?php

namespace App\Services;

use App\Models\Prescription;

class PrescriptionFilterService
{
    /**
     * filter prescriptions
     * @param array $filters
     * @return mixed
     */
    public function filter(array $filters)
    {
        $query = Prescription::with(['medicalFile.patient.user'])
            ->filterByMedication($filters['medications_names'] ?? null)
            ->FilterByPatientName($filters['search_name'] ?? null);

        return $query;
    }
}
