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

    public function __construct($reportId = null)
    {
        $this->reportId = $reportId;
    }

    // public function collection()
    // {
    //     return Report::all();
    // }
    
    public function collection()
    {
        if ($this->reportId) {
            // تصدير تقرير فردي
            return Report::where('id', $this->reportId)->get();
        } else {
            // تصدير جميع التقارير
            return Report::all();
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