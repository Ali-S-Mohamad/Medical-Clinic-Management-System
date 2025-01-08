<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Traits\ApiResponse;
use App\Http\Controllers\Controller;

class ReportController extends Controller
{
    use ApiResponse;
    public function getPatientReports($patientId)
    {
        $reports = Report::where('patient_id', $patientId)->get();
        //return response()->json($reports);
        return $this->apiResponse([$reports], 'all reports', 200);

    }

    public function exportPatientReports($patientId)
    {
       // add date export to file name
        $fileName = 'reports_' . Carbon::now()->format('Y_m_d_H_i_s') . '.xlsx';
        return Excel::download(new ReportsExport, $fileName);
    }
}
