@extends('layouts.master')

@section('title')
    Deleted Patients
@endsection

@section('css')
@endsection


@section('content')
    <div class="content">
        <div class="row">
            <div class="col-sm-4 col-3">
                <h4 class="page-title">Deleted Patients</h4>
            </div>
            {{-- <div class="col-sm-8 col-9 text-right m-b-20">
                <a href="{{ route('users.create') }}" class="btn btn-primary float-right btn-rounded"><i
                        class="fa fa-plus"></i> Add Patient</a>
            </div> --}}
        </div>
        <div class="row filter-row">
            <div class="col-sm-6 col-md-3">
                <div class="form-group form-focus">
                    <label class="focus-label">Patient ID</label>
                    <input type="text" class="form-control floating">
                </div>
            </div>
            <div class="col-sm-6 col-md-3">
                <div class="form-group form-focus">
                    <label class="focus-label">Patient Name</label>
                    <input type="text" class="form-control floating">
                </div>
            </div>
          
            <div class="col-sm-6 col-md-3">
                <a href="#" class="btn btn-success btn-block"> Search </a>
            </div>
        </div>
        @if ($deletedPatients->isEmpty())
            <h3>No Deleted Patients ..</h3>
            <a href="javascript:history.back()" class="btn btn-secondary mb-3" rel="prev">
                        <i class="fa fa-arrow-left mr-2"></i> Back
                    </a>
        @else
            <div class="row">
                <div class="col-md-12">
                    <div class="table-responsive">
                        <table class="table table-striped custom-table">
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th style="min-width:200px;">Name</th>
                                    <th>Email</th>
                                    <th>Gender</th>
                                    <th>Birth date</th>
                                    <th>insurance Number</th>
                                     
                                    <th class="text-right">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($deletedPatients as $patient)
                                    <tr>
                                        <td>{{ $patient->id }}</td>
                                        <td>
                                            @php
                                                $image_path = $patient->user->image
                                                    ? asset('storage/' . $patient->user->image->image_path)
                                                    : asset('assets/img/user.jpg');
                                            @endphp
                                            <img width="40" height="40" src="{{ $image_path }}"
                                                class="rounded-circle" alt="">
                                        <h2>{{ $patient->user->firstname }} {{ $patient->user->lastname }}</h2>
                                        </td>
                                        <td>{{ $patient->user->email }}</td>
                                        <td>{{ $patient->user->gender }}</td>
                                        
                                        <td> {{$patient->dob}} </td>
                                        <td> {{$patient->insurance_number}}</td>
                                        <td>
                                            <form action="{{ route('patients.restore', $patient->id) }}" method="POST"
                                                style="display: inline;">
                                                @csrf
                                                <button type="submit" class="btn btn-success btn-sm">Restore</button>
                                            </form>
                                            <form action="{{ route('patients.forceDelete', $patient->id) }}" method="POST"
                                                style="display: inline;">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-danger btn-sm"
                                                    onclick="return confirm('Are you sure you want to delete this item permanently?')">Delete
                                                    Permanently</button>
                                            </form>
                                        </td>
                    </div>
                    </td>
                    </tr>
        @endforeach
        </tbody>
        </table> 
        <a href="javascript:history.back()" class="btn btn-secondary mb-3" rel="prev">
                        <i class="fa fa-arrow-left mr-2"></i> Back
                    </a>
        {{ $deletedPatients->links()}}
    </div>
    </div>
    </div>
    @endif
    </div>

@endsection



@section('scripts')
@endsection
