<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\Report;
use App\Models\Appointment;
use Illuminate\Http\Request;
use App\Exports\ReportsExport;
use Maatwebsite\Excel\Facades\Excel;

class ReportController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('permission:show-report', ['only' => ['index']]);
        $this->middleware('permission:export-report', ['only' => ['export']]);

    }
    /**
     * Display a listing of the resource.
     */

    public function index()
    {
        $reports = Report::paginate(5);
        return view('reports.index', compact('reports'));
    }


    public function export()
    { 
       // add  export date to file name
        $fileName = 'reports_' . Carbon::now()->format('Y_m_d_H_i_s') . '.xlsx';
        return Excel::download(new ReportsExport, $fileName);
    } 


    public function exportSingle($id)
    {
        $fileName = 'report_' . $id . '_' . Carbon::now()->format('Y_m_d_H_i_s') . '.xlsx';
        return Excel::download(new ReportsExport($id), $fileName);
    
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
