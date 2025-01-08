<?php

namespace App\Http\Controllers;

use App\Models\TimeSlot;
use App\Http\Requests\TimeSlotRequest;
use App\Models\Employee;
use App\Models\User;
use App\Services\AppointmentService;
use Carbon\Carbon;
use Illuminate\Http\Request;

class TimeSlotController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        if (auth()->user()->hasRole('Admin')) {
            // إذا كان المستخدم Admin، يتم جلب جميع الـ TimeSlots مع العلاقة
            $timeSlots = TimeSlot::with('doctor')->get();
        } elseif (auth()->user()->hasRole('Doctor')) {
            // إذا كان المستخدم Doctor، يتم جلب السجلات الخاصة به فقط
            $timeSlots = TimeSlot::where('doctor_id', auth()->user()->employee->id)->with('doctor')->get();
        } else {
            // إذا لم يكن المستخدم Admin أو Doctor، يتم منعه من الوصول
            abort(403, 'You do not have permission to view time slots.');
        }
    
        return view('Timeslot.index', compact('timeSlots'));
    }
    

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $doctors = Employee::with('user') 
                    ->whereHas('user.roles', function ($query) {
                        $query->where('name', 'doctor'); 
                    })
                    ->get();
    
        return view('Timeslot.create', compact('doctors'));
    }
    
    
   /**
     * Store a newly created resource in storage.
     */
    public function store(TimeSlotRequest $request)
    {
        TimeSlot::create([
            'doctor_id' => $request->doctor_id,
            'start_time' => $request->start_time,
            'end_time' => $request->end_time,
            'day_of_week' => $request->day_of_week,
            'is_available' => $request->is_available,
            'slot_duration' => $request->slot_duration,
        ]);        return redirect()->route('time-slots.index')->with('success', 'Time Slot created successfully.');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(TimeSlot $timeSlot)
    {
        $doctors = Employee::with('user') 
        ->whereHas('user.roles', function ($query) {
            $query->where('name', 'doctor'); 
        })
        ->get();
            return view('Timeslot.edit', compact('timeSlot' ,'doctors'));
    }


    /**
     * Update the specified resource in storage.
     */
    public function update(TimeSlotRequest $request, TimeSlot $timeSlot)
    {
            // dd($request);
        $timeSlot->update([
            'doctor_id' => $request->doctor_id,
            'start_time' => $request->start_time,
            'end_time' => $request->end_time,
            'day_of_week' => $request->day_of_week,
            'is_available' => $request->is_available,
            'slot_duration' => $request->slot_duration,
        ]);
        return redirect()->route('time-slots.index')->with('success', 'Time Slot updated successfully.');
    }

    public function toggleAvailability($id)
    {
    $timeSlot = TimeSlot::findOrFail($id);
    $timeSlot->is_available = !$timeSlot->is_available;
    $timeSlot->save();

    return redirect()->route('time-slots.index')->with('success', 'time slot availability updated successfully.');
    }    
    /**
     * Remove the specified resource from storage.
     */
    public function destroy(TimeSlot $timeSlot)
    {
        $timeSlot->delete();

        return redirect()->route('time_slots.index')->with('success', 'Time Slot deleted successfully.');
    }
}
