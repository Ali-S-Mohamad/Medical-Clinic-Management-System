@extends('layouts.master')

@section('title')
Patients
@endsection

@section('css')
@endsection


@section('content')
    <div class="content">
        <div class="row">
            <div class="col-sm-4 col-3">
                <h4 class="page-title">Patients</h4>
            </div>
        </div>
        <div class="row">
            <div class="col-md-12">
                <div class="table-responsive">
                    <table class="table table-border table-striped custom-table datatable mb-0">
                        <thead>
                            <tr>
                                <th>Name</th>
                                <th>Email</th>
                                <th>birth date</th>
                                <th>photo</th>
                                <th>insurance Number</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($patients as $patient )
                                <td>{{$patient->name}}</td>
                                <td>{{$patient->email}}</td>
                                <td>{{$patient->patient->dob}}</td>
                                <td></td>
                                <td>{{$patient->patient->insurance_number}}</td>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
@endsection
