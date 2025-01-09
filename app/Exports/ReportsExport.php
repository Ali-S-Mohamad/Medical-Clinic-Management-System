<?php

namespace App\Exports;

use App\Models\Report;
use App\Models\Appointment;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\FromCollection;

class ReportsExport implements FromCollection, WithHeadings
{
    /**
    * @return \Illuminate\Support\Collection
    */


    public function collection()
    {
        return Report::all();
    }

    public function headings(): array
    {
        return [
            '#',
            'patient_id',
            'Patient Name',
            'Doctor Name',
            'Appointment Date',
            'Medications Names',
            'Instructions',
            'Details',
            'Created_at',
            'Updated_at'
        ];

}

}