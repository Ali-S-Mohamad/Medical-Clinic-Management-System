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
    
        $statistics=[
            'totalPatients' => $totalPatients,
            'totalDoctors'  => $totalDoctors,
            'totalemployees'=> $totalemployees,
            'departments'   => $departments,
        ];
        return view('admin.dashboard',compact('statistics'));
    }
}
