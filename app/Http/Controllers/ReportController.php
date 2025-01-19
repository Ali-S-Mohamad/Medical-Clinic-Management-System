<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\Report;
use App\Models\Appointment;
use Illuminate\Http\Request;
use App\Exports\ReportsExport;
use Maatwebsite\Excel\Facades\Excel;
use App\Services\ReportFilterService;

class ReportController extends Controller
{
    protected $reportFilterService;    
    /**
     * __construct
     *
     * @param  mixed $reportFilterService
     * @return void
     */
    public function __construct(ReportFilterService $reportFilterService)
    {
        $this->middleware('auth');
        $this->middleware('permission:show-report', ['only' => ['index', 'show']]);
        $this->middleware('permission:export-report', ['only' => ['export','exportSingle']]);
        $this->middleware('permission:Archive-report', ['only' => ['destroy']]);
        $this->middleware('permission:view-archivereport', ['only' => ['trash']]);
        $this->middleware('permission:restore-report', ['only' => ['restore']]);
        $this->middleware('permission:delete-report', ['only' => ['forceDelete']]);

        $this->reportFilterService = $reportFilterService;
    }
       
    /**
     * Display a listing of the resource.
     *
     * @param  mixed $request
     * @return void
     */
    public function index(Request $request)
    {
        $filters = $request->only(['patient_name', 'doctor_name', 'appointment_date']);
        // Service call
        $reports = $this->reportFilterService->filter($filters);

        return view('reports.index', compact('reports', 'filters'));
    }
    
    /**
     * export Export all reports for a specific period
     *
     * @param  mixed $request
     * @return void
     */
    public function export(Request $request)
    {
        $filters = $request->only(['patient_name', 'doctor_name', 'appointment_date']);
        $fileName = 'reports_' . Carbon::now()->format('Y_m_d_H_i_s') . '.xlsx';
        return Excel::download(new ReportsExport($filters), $fileName);
    }

    
    /**
     * exportSingle Export a single report
     *
     * @param  mixed $id
     * @param  mixed $request
     * @return void
     */
    public function exportSingle($id ,Request $request)
    {
        $filters = $request->only(['patient_name', 'doctor_name', 'appointment_date']);
        $fileName = 'report_' . $id . '_' . Carbon::now()->format('Y_m_d_H_i_s') . '.xlsx';
        return Excel::download(new ReportsExport($filters , $id), $fileName);

    }
    
    /**
     * Display the specified report.
     *
     * @param  mixed $id
     * @return void
     */
    public function show($id)
    {
        $report = Report::findOrFail($id);
        return view('reports.show', compact('report'));
    }
    
    /**
     * destroy the specified resource from storage.
     *
     * @param  mixed $id
     * @return void
     */
    public function destroy($id)
    {
        $report = Report::findOrFail($id);
        $report->delete();
        return redirect()->route('reports.index')->with('success', 'report is deleted successfully');
    }
    
    /**
     * Display the trashed reports
     *
     * @return void
     */
    public function trash()
    {
        $reports = Report::onlyTrashed()->paginate(5);
        return view('reports.trash', compact('reports'));
    }
    
    /**
     * Restore the specified Report from trash
     *
     * @param  mixed $id
     * @return void
     */
    public function restore($id)
    {
        $report = Report::onlyTrashed()->findOrFail($id);
        $report->restore();
        return redirect()->route('reports.index')->with('success', 'report restored successfully.');
    }
    
    /**
     * Remove specified Report from storage
     *
     * @param  mixed $id
     * @return void
     */
    public function forceDelete(string $id)
    {
        Report::withTrashed()->where('id', $id)->forceDelete();
        return redirect()->route('reports.trash')->with('success', 'report permanently deleted.');
    }

}
