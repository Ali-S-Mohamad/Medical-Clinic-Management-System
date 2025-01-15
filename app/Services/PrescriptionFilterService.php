<?php

namespace App\Services;

use App\Models\Prescription;

class PrescriptionFilterService
{
    public function filter(array $filters)
{
    $query = Prescription::with(['medicalFile.patient.user']) 
        ->filterByMedication($filters['medications_names'] ?? null)
        ->FilterByPatientName($filters['search_name'] ?? null);

    return $query;
}
}