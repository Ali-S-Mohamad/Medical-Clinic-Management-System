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
     */
    protected $reportFilterService;
    public function index(Request $request)
    {
        $filters = $request->only(['patient_name', 'doctor_name', 'appointment_date']);
        // Service call
        $reportFilterService = app(ReportFilterService::class);
        $reports = $reportFilterService->filter($filters);

        return view('reports.index', compact('reports', 'filters'));
    }

    public function export(Request $request)
    {
        $filters = $request->only(['patient_name', 'doctor_name', 'appointment_date']);
        $fileName = 'reports_' . Carbon::now()->format('Y_m_d_H_i_s') . '.xlsx';
        return Excel::download(new ReportsExport($filters), $fileName);
    }


    public function exportSingle($id ,Request $request)
    {
        $filters = $request->only(['patient_name', 'doctor_name', 'appointment_date']);
        $fileName = 'report_' . $id . '_' . Carbon::now()->format('Y_m_d_H_i_s') . '.xlsx';
        return Excel::download(new ReportsExport($filters , $id), $fileName);

    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $report = Report::findOrFail($id);
        return view('reports.show', compact('report'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Report $report)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Report $report)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $report = Report::findOrFail($id);
        $report->delete();
        return redirect()->route('reports.index')->with('success', 'report is deleted successfully');
    }

    public function trash()
    {
        $reports = Report::onlyTrashed()->paginate(5);
        return view('reports.trash', compact('reports'));
    }

    public function restore($id)
    {
        $report = Report::onlyTrashed()->findOrFail($id);
        $report->restore();
        return redirect()->route('reports.index')->with('success', 'report restored successfully.');
    }

    public function forceDelete(string $id)
    {
        Report::withTrashed()->where('id', $id)->forceDelete();
        return redirect()->route('reports.trash')->with('success', 'report permanently deleted.');
    }

}
