<?php

namespace App\Exports;

use App\Models\Report;
use App\Models\Appointment;
use PhpOffice\PhpSpreadsheet\Style\Fill;
use Maatwebsite\Excel\Concerns\WithStyles;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\FromCollection;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class ReportsExport implements FromCollection, WithHeadings , WithStyles
{
    /**
    * @return \Illuminate\Support\Collection
    */

    protected $reportId;
    protected $filters;

    public function __construct($filters = [] , $reportId = null)
    {
        $this->filters = $filters;
        $this->reportId = $reportId;
    }


    public function collection()
    {
        if ($this->reportId) {
        // export one report
            return Report::where('id', $this->reportId)->get();
        } else {
        //export all reports
           // return Report::all();
            return Report::filterByName($this->filters)->get();

        }
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

public function styles(Worksheet $sheet)
    {

        $sheet->getStyle('A1:J1')->applyFromArray([
            'font' => [
                'bold' => true,
                'color' => ['argb' => 'FFFFFFFF'],
            ],
            'fill' => [
                'fillType' => Fill::FILL_SOLID,
                'startColor' => ['argb' => 'FF0000FF'],
            ],
        ]);

        foreach (range('A', 'J') as $columnID) {
            $sheet->getColumnDimension($columnID)->setAutoSize(true);
        }


}

}
