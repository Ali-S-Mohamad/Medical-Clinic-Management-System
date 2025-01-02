@extends('layouts.master')

@section('title')
@endsection

@section('css')
@endsection


@section('content')
    <div class="container mt-4">
        <h1>Trash</h1>

        <h2>Prescription</h2>
        <table class="table">
            <thead>
                <tr>
                    <th>Doctor name</th>
                    <th>Patient name</th>
                    <th>Appointment</th>
                    <th>Medications names</th>
                    <th>instructions</th>
                    <th>details</th>
                    <th>Action</th>


                </tr>
            </thead>
            <tbody>
                @foreach ($prescriptions as $prescription)
                    <tr>
                        <td>{{ $prescription->employee->user->name }}</td>
                        <td>{{ $prescription->Appointment->patient->user->name }}</td>
                        <td>{{ $prescription->appointment->appointment_date }}</td>
                        <td>{{ $prescription->medications_names }}</td>
                        <td>{{ $prescription->instructions }}</td>
                        <td>{{ $prescription->details }}</td>
                        <td>
                            <form action="{{ route('prescriptions.restore', $prescription->id) }}" method="POST"
                                style="display: inline;">
                                @csrf

                                <button type="submit" class="btn btn-success btn-sm">Restore</button>
                            </form>
                            <form action="{{ route('prescriptions.hardDelete', $prescription->id) }}" method="POST"
                                style="display: inline;">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger btn-sm"
                                    onclick="return confirm('Are you sure you want to delete this item permanently?')">Delete
                                    Permanently</button>
                            </form>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
        <div class="m-t-20 text-left">
            <a href="{{route('prescriptions.index')}}" class="btn btn-secondary mb-3" rel="prev">
                <i class="fa fa-arrow-left mr-2"></i> Back
            </a>
        </div>
    </div>
@endsection


@section('scripts')
@endsection
