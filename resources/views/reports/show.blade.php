@extends('layouts.master')

@section('title')
Show report
@endsection

@section('css')

@endsection


@section('content')
<div class="container my-4">
    <div class="card">
        <div class="card-header">
          Report {{ $report->id }}
        </div>
        <div class="card-body">
            <h5 class="card-title"> Report Details</h5>
            <ul class="list-group list-group-flush">
                <li class="list-group-item"><strong>Insurance Number :</strong> {{ $report->patient->insurance_number}}</li>
                <li class="list-group-item"><strong>Patient Name :</strong> {{ $report->patient_name }}</li>
                <li class="list-group-item"><strong>Doctor Nama :</strong> {{ $report->doctor_name }}</li>
                <li class="list-group-item"><strong>Appointment Date :</strong> {{ $report->appointment_date }}</li>
                <li class="list-group-item"><strong> Medications Names:</strong> {{ $report->medications_names }}</li>
                <li class="list-group-item"><strong>instructions:</strong> {{ $report->instructions }}</li>
                <li class="list-group-item"><strong>Details:</strong> {{ $report->details }}</li>
                <li class="list-group-item"><strong>Created at :</strong> {{ $report->created_at }}</li>
            </ul>
        </div>
        <div class="card-footer text-muted">
            <a href="{{ route('reports.exportOne', $report->id) }}" class="btn btn-primary"> Export File</a>
            <a href="{{route('reports.index')}}" class="btn btn-secondary" rel="prev">
                <i class="fa fa-arrow-left mr-2"></i> Back
            </a>
        </div>
    </div>
</div>

@endsection



@section('scripts')

@endsection
