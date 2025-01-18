@extends('layouts.master')

@section('title', 'Add Appointment')

@section('css')
    <style>
        tbody tr:hover {
            cursor: pointer;
        }
    </style>
@endsection

@section('content')
<div class="content">
    <div class="row">
        <div class="col-lg-8 offset-lg-2">
            <h4 class="page-title">Add Appointment</h4>
        </div>
    </div>
    <div class="row">
        <div class="col-lg-8 offset-lg-2">
            <form action="{{ route('appointments.store') }}" method="POST" enctype='multipart/form-data'>
                @csrf
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label>Patient Name</label>
                            <select name="patient_id" class="form-control" required>
                                  <option value="">Select</option>
                                @foreach ($patients as $patient)
                                <option value="{{ $patient->id }}">{{ $patient->user->firstname }} {{ $patient->user->lastname }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label>Doctor</label>
                            <select name="doctor_id" id="doctor_id" class="form-control" required>
                                <option value="">Select</option>
                                @foreach ($doctors as $doctor)
                                <option value="{{ $doctor->employee->id }}">{{ $doctor->employee->user->firstname }} {{ $doctor->employee->user->lastname }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label>Date</label>
                            <input type="date" name="appointment_date" id="appointment_date" class="form-control" required>
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="appointment_time">Available Time</label>
                            <select name="appointment_time" id="appointment_time" class="form-control" required>
                                <option value="">Select Time</option>
                            </select>
                        </div>
                    </div>
                </div>

                <div class="form-group">
                    <label>Notes</label>
                    <textarea name="notes" required cols="30" rows="4" class="form-control"></textarea>
                </div>

                <div class="m-t-20 text-center">
                    <button class="btn btn-primary submit-btn">Create Appointment</button>
                </div>

                <div class="m-t-20 text-center">
                    <a href="javascript:history.back()" class="btn btn-secondary mb-3" rel="prev">
                        <i class="fa fa-arrow-left mr-2"></i>Back
                    </a>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script>
// When doctor or date is selected, fetch available slots
$('#doctor_id, #appointment_date').change(function() {
    var doctorId = $('#doctor_id').val(); // Get your doctor's ID

    var appointmentDate = $('#appointment_date').val(); // Get date from input date

    if (doctorId && appointmentDate) {
        $.ajax({
            url: '/get-available-slots/' + doctorId, // Use only the doctor ID in the link
            method: 'GET',
            data: { date: appointmentDate }, // Submit date as Query Parameter
            success: function(response) {
                $('#appointment_time').empty(); // Dump current options

                if (response.availableSlots && response.availableSlots.length > 0) {
                    response.availableSlots.forEach(function(slot) {
                        $('#appointment_time').append('<option value="' + slot + '">' + slot + '</option>');
                    });
                } else {
                    $('#appointment_time').append('<option value="">No available slots</option>');
                }
            },
            error: function(xhr) {
                var errorMessage = xhr.responseJSON && xhr.responseJSON.message ? xhr.responseJSON.message : 'An error occurred';
                alert('Error fetching available slots: ' + errorMessage);
            }
        });
    }
});
</script>
@endsection
