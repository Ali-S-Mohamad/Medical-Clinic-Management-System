    @extends('layouts.master')

    @section('title')
    Patients
    @endsection

    @section('css')
    @endsection


    @section('content')
        <div class="content">
            <div class="row">
                <div class="col-sm-5 col-5">
                    <h4 class="page-title">Patients</h4>
                </div>
                <div class="col-sm-7 col-7 text-right m-b-30 d-flex justify-content-end align-items-center">
                    <a href="{{ route('patients.create') }}" class="btn btn-primary btn-rounded mr-3">
                        <i class="fa fa-plus"></i> Add Patient
                    </a>
                    <!-- أيقونة سلة المحذوفات -->
                    <a href="{{ route('patients.trash') }}">
                        <i class="fa fa-trash-o" style="font-size:36px"></i>
                    </a>
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
                                <tr>
                                    <td>{{$patient->user->name}}</td>
                                    <td>{{$patient->user->email}}</td>
                                    <td>{{$patient->dob}}</td>
                                    <td>@php
                                        $image_path = $patient->image
                                            ? asset('storage/' . $patient->image->image_path)
                                            : asset('assets/img/user.jpg');
                                    @endphp
                                    <img width="40" height="40" src="{{ $image_path }}"
                                        class="rounded-circle" alt=""></td>
                                    <td>{{$patient->insurance_number}}</td>
                                </tr>
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
