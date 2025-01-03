<?php

namespace App\Http\Controllers;

use App\Models\TimeSlot;
use App\Http\Requests\TimeSlotRequest;

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

        return view('time_slots.index', compact('timeSlots'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('time_slots.create');
    }

   /**
     * Store a newly created resource in storage.
     */
    public function store(TimeSlotRequest $request)
    {
        TimeSlot::create($request->validated());
        return redirect()->route('time_slots.index')->with('success', 'Time Slot created successfully.');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(TimeSlot $timeSlot)
    {
        return view('time_slots.edit', compact('timeSlot'));
    }


    /**
     * Update the specified resource in storage.
     */
    public function update(TimeSlotRequest $request, TimeSlot $timeSlot)
    {
        $timeSlot->update($request->validated());

        return redirect()->route('time_slots.index')->with('success', 'Time Slot updated successfully.');
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
