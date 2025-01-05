<?php

namespace App\Http\Controllers;

use App\Models\TimeSlot;
use App\Http\Requests\TimeSlotRequest;
use App\Models\User;

class TimeSlotController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        if (auth()->user()->hasRole('Admin')) {
            $timeSlots = TimeSlot::with('doctor')->get();
        } elseif (auth()->user()->hasRole('Doctor')) {
            $timeSlots = TimeSlot::where('doctor_id', auth()->user()->employee->id)->get();
        } else {
            abort(403, 'You do not have permission to view time slots.');
        }

        return view('Timeslot.index', compact('timeSlots'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $doctors = User::role('doctor')->get();
        return view('Timeslot.create', compact('doctors'));
    }
    
   /**
     * Store a newly created resource in storage.
     */
    public function store(TimeSlotRequest $request)
    {
        TimeSlot::create($request->validated());
        return redirect()->route('time-slots.index')->with('success', 'Time Slot created successfully.');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(TimeSlot $timeSlot)
    {
        return view('time-slots.edit', compact('timeSlot'));
    }


    /**
     * Update the specified resource in storage.
     */
    public function update(TimeSlotRequest $request, TimeSlot $timeSlot)
    {
        $timeSlot->update($request->validated());

        return redirect()->route('time_slots.index')->with('success', 'Time Slot updated successfully.');
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
