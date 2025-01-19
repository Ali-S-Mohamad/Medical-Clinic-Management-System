<?php

namespace App\Http\Controllers;

use App\Models\TimeSlot;
use App\Http\Requests\TimeSlotRequest;
use App\Models\Employee;
use App\Models\User;
use App\Services\AppointmentService;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class TimeSlotController extends Controller
{    
    /**
     * __construct
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('permission:show-TimeSlot', ['only' => ['index', 'show']]);
        $this->middleware('permission:create-TimeSlot', ['only' => ['create', 'store']]);
        $this->middleware('permission:edit-TimeSlot', ['only' => ['edit', 'update']]);
        $this->middleware('permission:delete-TimeSlot', ['only' => ['destroy']]);
    }
    
    /**
     * index
     *
     * @return void
     */
    public function index()
    {
        // Get the current user
        $user = Auth::user();

        // If Admin or Employee, display all times
        if ($user->hasAnyRole(['Admin', 'employee'])) {
            // Fetch times with doctors' data and split them into pages
            $timeSlots = TimeSlot::with('doctor.user')->paginate(5);
        }
        // If Doctor, display only his times
        elseif ($user->hasRole('doctor')) {
       // Fetches the current doctor's times and splits them into pages
            $timeSlots = TimeSlot::with('doctor.user')
                ->where('doctor_id', $user->employee->id)
                ->paginate(5);
        } else {
            abort(403, 'Unauthorized');
        }

        return view('timeslots.index', compact('timeSlots'));
    }
    /**
     * create
     *
     * @return void
     */
    public function create()
    {
        $doctors = Employee::with('user')
            ->whereHas('user.roles', function ($query) {
                $query->where('name', 'doctor');
            })
            ->get();

        return view('timeslots.create', compact('doctors'));
    }
    /**
     * store
     *
     * @param  mixed $request
     * @return void
     */
    public function store(TimeSlotRequest $request)
    {
        // Check if there is a Time Slot for yourself today to the doctor
        $existingSlot = TimeSlot::where('doctor_id', $request->doctor_id)
            ->where('day_of_week', $request->day_of_week)
            ->where('is_available', true)
            ->first();

        if ($existingSlot) {
            return redirect()->back()->withErrors([
                'error' => 'Cannot add time slot for a day that is already marked as available.',
            ])->withInput();
        }

        // If no available case is found, a TimeSlot is created
        TimeSlot::create([
            'doctor_id' => $request->doctor_id,
            'start_time' => $request->start_time,
            'end_time' => $request->end_time,
            'day_of_week' => $request->day_of_week,
            'is_available' => $request->is_available,
            'slot_duration' => $request->slot_duration,
        ]);

        return redirect()->route('time-slots.index')->with('success', 'Time Slot created successfully.');
    }
    /**
     * edit
     *
     * @param  mixed $timeSlot
     * @return void
     */
    public function edit(TimeSlot $timeSlot)
    {
        $doctors = Employee::with('user')
            ->whereHas('user.roles', function ($query) {
                $query->where('name', 'doctor');
            })
            ->get();
        return view('timeslots.edit', compact('timeSlot', 'doctors'));
    }     
    /**
     * update
     *
     * @param  mixed $request
     * @param  mixed $timeSlot
     * @return void
     */
    public function update(TimeSlotRequest $request, TimeSlot $timeSlot)
    {
        // Check if there is a same-day time slot for the doctor (other than the current time slot)
        $existingSlot = TimeSlot::where('doctor_id', $request->doctor_id)
            ->where('day_of_week', $request->day_of_week)
            ->where('is_available', true)
            ->where('id', '!=', $timeSlot->id) // Exclude current slot time
            ->first();

        if ($existingSlot) {
            return redirect()->back()->withErrors([
                'error' => 'Cannot update time slot to be available for a day that already has an available time slot.',
            ])->withInput();
        }

        // If no available case is found, the time slot is updated
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
    /**
     * toggleAvailability
     *
     * @param  mixed $id
     * @return void
     */
    public function toggleAvailability($id)
    {
        // Get the current slot time
        $timeSlot = TimeSlot::findOrFail($id);

        // If the change will make the status Available
        if (!$timeSlot->is_available) {
            $existingSlot = TimeSlot::where('doctor_id', $timeSlot->doctor_id)
                ->where('day_of_week', $timeSlot->day_of_week)
                ->where('is_available', true)
                ->where('id', '!=', $timeSlot->id) // Exclude current slot time
                ->first();

            if ($existingSlot) {
                return redirect()->back()->withErrors([
                    'error' => 'Cannot make this time slot available because another time slot for the same day is already available.',
                ]);
            }
        }

        // Change status
        $timeSlot->is_available = !$timeSlot->is_available;
        $timeSlot->save();

        return redirect()->route('time-slots.index')->with('success', 'Time slot availability updated successfully.');
    }   
    /**
     * destroy
     *
     * @param  mixed $timeSlot
     * @return void
     */
    public function destroy(TimeSlot $timeSlot)
    {
        $timeSlot->delete();

        return redirect()->route('time-slots.index')->with('success', 'Time Slot deleted successfully.');
    }
}
