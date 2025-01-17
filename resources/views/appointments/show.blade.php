@extends('layouts.master')
@section('title','Appointment Details')

@section('css')
@endsection

@section('content')
<div class="content">
    <div class="row">
        <div class="col-lg-8 offset-lg-2">
            <h4 class="page-title">Appointment Details</h4>
        </div>
    </div>
    <div class="row">
        <div class="col-lg-8 offset-lg-2">
            <div class="card">
                <div class="card-body">

                    <h5>Patient Information</h5>
                    <p><strong>Name:</strong> {{ $appointment->patient->user->firstname }} {{ $appointment->patient->user->lastname }}</p>
                    <p><strong>Email:</strong> {{ $appointment->patient->user->email }}</p>
                    <p><strong>Email:</strong> {{ $appointment->patient->user->gender }}</p>
                    <p><strong>Phone:</strong> {{ $appointment->patient->user->phone_number }}</p>

                    <hr>

                    <h5>Doctor Information</h5>
                    <p><strong>Name:</strong> {{ $appointment->employee->user->name  }}</p>
                    <p><strong>Email:</strong> {{ $appointment->employee->user->email }}</p>
                    <p><strong>Phone:</strong> {{ $appointment->employee->user->phone_number }}</p>

                    <hr>

                    <h5>Appointment Information</h5>
                    <p><strong>Date:</strong> {{ $appointment->appointment_date }}</p>
                    <p><strong>Status:</strong>
                    @if($appointment->status == 'scheduled') Scheduled
                    @elseif($appointment->status == 'completed') Completed
                    @elseif($appointment->status == 'canceled') Canceled
                    @elseif($appointment->status == 'pending') Pending
                    @endif
                  </p>

                    <p><strong>Notes:</strong> {{ $appointment->notes ?? 'No notes provided' }}</p>
                </div>

                <div class="card-footer text-center">
                    <a href="{{ route('appointments.index') }}" class="btn btn-secondary">Back to Appointments</a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
@endsection
