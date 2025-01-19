<?php

namespace App\Http\Controllers\Api;

use Carbon\Carbon;
use App\Models\Report;
use Illuminate\Http\Request;
use App\Exports\ReportsExport;
use App\Http\Traits\ApiResponse;
use App\Http\Controllers\Controller;
use Maatwebsite\Excel\Facades\Excel;
use App\Services\ReportFilterService;

class ReportController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth:sanctum', 'permission:show-report'])->only(['getPatientReports']);
        $this->middleware(['auth:sanctum', 'permission:export-report'])->only(['exportPatientReports']);
    }
    use ApiResponse;
    // public function getPatientReports($patientId)
    // {
    //     $reports = Report::where('patient_id', $patientId)->get();
    //     //return response()->json($reports);
    //     return $this->apiResponse([$reports], 'all reports', 200);

    // }

    // public function exportPatientReports($patientId)
    // {
    //    // add date export to file name
    //     $fileName = 'reports_' . Carbon::now()->format('Y_m_d_H_i_s') . '.xlsx';
    //     return Excel::download(new ReportsExport, $fileName);
    // }
    public function getPatientReports()
    {
        // Get the authenticated user
        $user = auth()->user();

        // Ensure the user has a patient profile
        if (!$user->patient) {
            return $this->errorResponse('You are not authorized to access this resource.', 403);
        }

        // Get filters from request
        $filters = request()->only(['patient_name', 'doctor_name', 'appointment_date']);

        // Use the ReportFilterService for filtering
        $reportFilterService = new ReportFilterService();
        $reports = $reportFilterService->filter(array_merge($filters, ['patient_id' => $user->patient->id]));

        // Return the filtered reports
        return $this->apiResponse($reports, 'Reports retrieved successfully', 200);
    }


    public function exportPatientReports()
    {
        // Get the authenticated user
        $user = auth()->user();

        // Ensure the user has a patient profile
        if (!$user->patient) {
            return $this->errorResponse('You are not authorized to access this resource.', 403);
        }

        // Get filters from request
        $filters = request()->only(['patient_name', 'doctor_name', 'appointment_date']);
        $filters['patient_id'] = $user->patient->id;

        // Set the export file name with a timestamp
        $fileName = 'patient_reports_' . Carbon::now()->format('Y_m_d_H_i_s') . '.xlsx';

        // Export reports using the existing ReportsExport class
        return Excel::download(new ReportsExport($filters), $fileName);
    }
}
