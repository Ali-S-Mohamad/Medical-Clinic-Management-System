<?php

namespace App\Exports;

use App\Models\Report;
use App\Models\Appointment;
use Maatwebsite\Excel\Concerns\FromCollection;

class ReportsExport implements FromCollection
{
    /**
    * @return \Illuminate\Support\Collection
    */


    public function collection()
    {
        return Report::all();
    }

}
