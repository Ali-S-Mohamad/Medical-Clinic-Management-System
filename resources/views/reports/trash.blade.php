@extends('layouts.master')

@section('title')
Deleted Reports
@endsection

@section('css')
@endsection


@section('content')
    <div class="container mt-4">
        <h1>Trash</h1>

        <h2>Reports</h2>
        <table class="table">
            <thead>
                <tr>
                    <th>#</th>
                    <th>Patient id</th>
                    <th>Patient name</th>
                    <th>Doctor name</th>
                    <th>Appointment Date</th>
                    <th>Medications names</th>
                    <th>instructions</th>
                    <th>details</th>
                    <th>Created at</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($reports as $report)
                    <tr>
                        <td>{{ $loop->iteration }}</td> <!-- العد التلقائي -->
                        <td>{{ $report->patient_id }}</td> 
                        <td>{{ $report->patient_name }}</td>
                        <td>{{ $report->doctor_name }}</td>
                        <td>{{ $report->appointment_date }}</td>
                        <td>{{ $report->medications_names }}</td>
                        <td>{{ $report->instructions }}</td>
                        <td>{{ $report->details }}</td>
                        <td>{{ $report->created_at }}</td>
                        <td>
                            <form action="{{ route('reports.restore', $report->id) }}" method="POST"
                                style="display: inline;">
                                @csrf

                                <button type="submit" class="btn btn-success btn-sm">Restore</button>
                            </form>
                            <form action="{{ route('reports.forceDelete', $report->id) }}" method="POST"
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
            <a href="{{route('reports.index')}}" class="btn btn-secondary mb-3" rel="prev">
                <i class="fa fa-arrow-left mr-2"></i> Back
            </a>
        </div>
    </div>
@endsection


@section('scripts')
@endsection

