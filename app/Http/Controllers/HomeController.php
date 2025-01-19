<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\ClinicInfo;
use App\Models\Appointment;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $clinic = ClinicInfo::first();
        return view('clinic.show', compact('clinic'));
    }
}
