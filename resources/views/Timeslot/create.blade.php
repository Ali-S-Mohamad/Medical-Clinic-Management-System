@extends('layouts.master')

@section('title')
    Add Time Slot
@endsection

@section('css')
@endsection

@section('content')
    <div class="content">
        <div class="row">
            <div class="col-lg-8 offset-lg-2">
                <h4 class="page-title">Add Time Slot</h4>
            </div>
        </div>
        <div class="row">
            <div class="col-lg-8 offset-lg-2">
                <form action="{{ route('time-slots.store') }}" method="post" enctype="multipart/form-data">
                    @csrf
                    {{-- Doctor Section --}}
                    <div class="form-group">
                        <label for="doctor_id">Doctor</label>
                        <select name="doctor_id" class="form-control" required>
                            @auth
                                @php
                                    $employee = Auth::user();
                                @endphp
                                @hasrole('doctor')
                                    <option value="{{ $employee->employee->id }}">{{ $employee->name }}</option>
                                @endhasrole
                                @hasanyrole(['Admin', 'employee'])
                                    <option value="">Select Doctor</option>
                                    @foreach ($doctors as $doctor)
                                        <option value="{{ $doctor->id }}">{{ $doctor->user->name }}</option>
                                    @endforeach
                                @endhasanyrole
                            @endauth
                        </select>
                    </div>

                    {{-- Day of the Week --}}
                    <div class="form-group">
                        <label for="day_of_week">Day of Week</label>
                        <select required name="day_of_week" id="day_of_week" class="form-control">
                            <option value="">Select Day</option>
                            <option value="0">Sunday</option>
                            <option value="1">Monday</option>
                            <option value="2">Tuesday</option>
                            <option value="3">Wednesday</option>
                            <option value="4">Thursday</option>
                            <option value="5">Friday</option>
                            <option value="6">Saturday</option>
                        </select>
                    </div>

                    {{-- Start Time --}}
                    <div class="form-group">
                        <label for="start_time">Start Time</label>
                        <input required type="time" name="start_time" id="start_time" class="form-control">
                    </div>

                    {{-- End Time --}}
                    <div class="form-group">
                        <label for="end_time">End Time</label>
                        <input required type="time" name="end_time" id="end_time" class="form-control">
                    </div>

                    {{-- Slot Duration --}}
                    <div class="form-group">
                        <label for="slot_duration">Slot Duration (minutes)</label>
                        <input required type="number" name="slot_duration" id="slot_duration" class="form-control"
                            min="1">
                    </div>

                    {{-- Availability --}}
                    <div class="form-group">
                        <label class="display-block">Availability</label>
                        <div class="form-check form-check-inline">
                            <input required class="form-check-input" type="radio" name="is_available" id="available_yes"
                                value="1">
                            <label class="form-check-label" for="available_yes">
                                Available
                            </label>
                        </div>
                        <div class="form-check form-check-inline">
                            <input class="form-check-input" type="radio" name="is_available" id="available_no"
                                value="0">
                            <label class="form-check-label" for="available_no">
                                Not Available
                            </label>
                        </div>
                    </div>

                    <div class="m-t-20 text-center">
                        <button class="btn btn-primary submit-btn">Add Time Slot</button>
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
    <script>
        // Additional JavaScript for interactions if needed
    </script>
@endsection
