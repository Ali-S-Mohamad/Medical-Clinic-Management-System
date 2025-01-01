<?php

namespace App\Services;

use App\Models\MedicalFile;



class MidecalFileFilterService
{
    public function filter(array $filters)
{
    $query = MedicalFile::with(['patient.user']) 
        ->filterByInsurance($filters['search_insurance'] ?? null)
        ->filterByName($filters['search_name'] ?? null);

    return $query;
}
}