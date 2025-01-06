@extends('layouts.master')

@section('title')
    Edit Time Slot
@endsection

@section('css')
@endsection

@section('content')
    <div class="content">
        <div class="row">
            <div class="col-lg-8 offset-lg-2">
                <h4 class="page-title">Edit Time Slot</h4>
            </div>
        </div>
        <div class="row">
            <div class="col-lg-8 offset-lg-2">
                <form action="{{ route('time-slots.update', $timeSlot->id) }}" method="post">
                    @csrf
                    @method('PUT') 
                    
                    {{-- Doctor Section --}}
                    <div class="form-group">
                        <label for="doctor_id">Doctor</label>
                        <select name="doctor_id" class="form-control" required>
                            <option value="">Select Doctor</option>
                            @foreach($doctors as $employee)
                            <option value="{{ $employee->id }}" {{ $employee->id == $timeSlot->doctor_id ? 'selected' : '' }}>
                                   {{ $employee->user->name }}
                            </option>
                             @endforeach
                            </select>
                    </div>

                    {{-- Day of the Week --}}
                    <div class="form-group">
                        <label for="day_of_week">Day of Week</label>
                        <select required name="day_of_week" id="day_of_week" class="form-control">
                            <option value="">Select Day</option>
                            @foreach(['Sunday', 'Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday'] as $index => $day)
                                <option value="{{ $index }}" {{ $index == $timeSlot->day_of_week ? 'selected' : '' }}>
                                    {{ $day }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    {{-- Start Time --}}
                    <div class="form-group">
                        <label for="start_time">Start Time</label>
                        <input required type="time" name="start_time" id="start_time" class="form-control" value="{{ $timeSlot->start_time }}">
                    </div>

                    {{-- End Time --}}
                    <div class="form-group">
                        <label for="end_time">End Time</label>
                        <input required type="time" name="end_time" id="end_time" class="form-control" value="{{ $timeSlot->end_time }}">
                    </div>

                    {{-- Slot Duration --}}
                    <div class="form-group">
                        <label for="slot_duration">Slot Duration (minutes)</label>
                        <input required type="number" name="slot_duration" id="slot_duration" class="form-control" value="{{ $timeSlot->slot_duration }}" min="1">
                    </div>

                    {{-- Availability --}}
                    <div class="form-group">
                        <label class="display-block">Availability</label>
                        <div class="form-check form-check-inline">
                            <input required class="form-check-input" type="radio" name="is_available" id="available_yes" value="1" {{ $timeSlot->is_available == 1 ? 'checked' : '' }}>
                            <label class="form-check-label" for="available_yes">
                                Available
                            </label>
                        </div>
                        <div class="form-check form-check-inline">
                            <input class="form-check-input" type="radio" name="is_available" id="available_no" value="0" {{ $timeSlot->is_available == 0 ? 'checked' : '' }}>
                            <label class="form-check-label" for="available_no">
                                Not Available
                            </label>
                        </div>
                    </div>

                    <div class="m-t-20 text-center">
                        <button class="btn btn-primary submit-btn">Update Time Slot</button>
                    </div>
                    <a href="javascript:history.back()" class="btn btn-secondary mb-3" rel="prev">
                        <i class="fa fa-arrow-left mr-2"></i> Back
                    </a>
                </form>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
@endsection
