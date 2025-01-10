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
        // $now = Carbon::now();
        // $reminderTime = $now->addRealMinutes(1);
        // $appointments = Appointment::whereBetween('appointment_date', [
        //     $now->format('Y-m-d H:i:00'),
        //     $reminderTime->format('Y-m-d H:i:59')
        // ])->get();
        // dd($appointments);
        $clinic = ClinicInfo::first();
        return view('clinic.show', compact('clinic'));
        // return view('temp');
    }
}
