<?php

namespace App\Http\Controllers;

use App\Models\Report;
use App\Models\Appointment;
use Illuminate\Http\Request;
use App\Exports\ReportsExport;
use Maatwebsite\Excel\Facades\Excel;

class ReportController extends Controller
{
    /**
     * Display a listing of the resource.
     */

     public function index()
     {
        $reports = Report::paginate(5); // استرجاع كل التقارير
        return view('reports.index', compact('reports'));
     }

     public function export()
    {
         return Excel::download(new ReportsExport, 'reports.xlsx');
    } 

     
     public function storeReport(Appointment $appointment)
     {
         if ($appointment->status === 'completed') {
            $prescription = $appointment->prescription;
            Report::create([
                'patient_id' => $appointment->patient_id,
                'doctor_id' => $appointment->doctor_id,
                'appointment_date' => $appointment->appointment_date,
                'medications_names' => $prescription -> medications_names,
                'instructions' => $prescription ->instructions,
                'details' => $prescription ->details,
            ]);
         }
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
    public function show(Report $report)
    {
        //
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
    public function destroy(Report $report)
    {
        //
    }

   

}
