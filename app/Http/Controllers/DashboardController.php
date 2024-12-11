<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Patient;
use App\Models\Employee;
use App\Models\Department;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        
        $totalPatients  = Patient::count();
        $totalDoctors   = User::role('doctor')  ->count();
        $totalemployees = User::role('employee')->count();
        $departments    = Department::count();
        $doctors        = User::role('doctor')->get();
        $active_departments   = Department::where('status', 1)->count();
        $inactive_departments = Department::where('status', 0)->count();
    
    
        $statistics=[
            'totalPatients' => $totalPatients,
            'totalDoctors'  => $totalDoctors,
            'totalemployees'=> $totalemployees,
            'active_departments'   => $active_departments,
            'inactive_departments' => $inactive_departments,
            'doctors'       => $doctors,
        ];
        return view('admin.dashboard',compact('statistics'));
    }
}
