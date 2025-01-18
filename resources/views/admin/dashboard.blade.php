@extends('layouts.master')

@section('title')
    Dashboard
@endsection

@section('css')
    <style>
        .dash-widget {
            cursor: pointer;
        }

        .card {
            box-shadow: 0 4px 15px rgba(1, 26, 107, 0.3);
        }

    </style>
@endsection


@section('content')
    <div class="content">

        {{-- Cards Statistics --}}
        <div class="row">

            <div class="col-md-6 col-sm-6 col-lg-6 col-xl-3">
                <div class="dash-widget">
                    <a href="{{ route('employees.index') }}">
                        <span class="dash-widget-bg1"><i class="fa fa-stethoscope" aria-hidden="true"></i></span>
                        <div class="dash-widget-info text-right">
                            <h3>{{ $statistics['totalDoctors'] }}</h3>
                            <span class="widget-title1">Doctors <i class="fa fa-check" aria-hidden="true"></i></span>
                        </div>
                    </a>
                </div>
            </div>

            <div class="col-md-6 col-sm-6 col-lg-6 col-xl-3">
                <div class="dash-widget">
                    <a href="{{ route('patients.index') }}">
                        <span class="dash-widget-bg2"><i class="fa fa-user-o"></i></span>
                        <div class="dash-widget-info text-right">
                            <h3>{{ $statistics['totalPatients'] }}</h3>
                            <span class="widget-title2">Patients <i class="fa fa-check" aria-hidden="true"></i></span>
                        </div>
                    </a>
                </div>
            </div>
            <div class="col-md-6 col-sm-6 col-lg-6 col-xl-3">
                <div class="dash-widget">
                    <a href="{{ route('employees.index') }}">
                        <span class="dash-widget-bg3"><i class="fa fa-user-md" aria-hidden="true"></i></span>
                        <div class="dash-widget-info text-right">
                            <h3>{{ $statistics['totalEmployees'] }}</h3>
                            <span class="widget-title3">Employees <i class="fa fa-check" aria-hidden="true"></i></span>
                        </div>
                    </a>
                </div>
            </div>
            <div class="col-md-6 col-sm-6 col-lg-6 col-xl-3">
                <div class="dash-widget">
                    <span class="dash-widget-bg1"><i class="fa fa-stethoscope" aria-hidden="true"></i></span>
                    <div class="dash-widget-info text-right">
                        <h3>####</h3>
                        <span class="widget-title1">unKnown <i class="fa fa-check" aria-hidden="true"></i></span>
                    </div>
                </div>
            </div>
            <div class="col-md-6 col-sm-6 col-lg-6 col-xl-4">
                <div class="dash-widget">
                    <a href="{{ route('departments.index') }}">
                        <span class="dash-widget-bg4"><i class="fa fa-heartbeat" aria-hidden="true"></i></span>
                        <div class="dash-widget-info text-right">
                            <h3>{{ $statistics['active_departments'] }}</h3>
                            <span class="widget-title4">Active dpartmnts <i class="fa fa-check"
                                    aria-hidden="true"></i></span>
                        </div>
                    </a>
                </div>
            </div>
            <div class="col-md-6 col-sm-6 col-lg-6 col-xl-4">
                <div class="dash-widget">
                    <a href="{{ route('appointments.index') }}">
                        <span class="dash-widget-bg2"><i class="fa fa-user-o"></i></span>
                        <div class="dash-widget-info text-right">
                            <h3> {{ $statistics['active_appointments'] }} </h3>
                            <span class="widget-title2">Active appointmnts <i class="fa fa-check"
                                    aria-hidden="true"></i></span>
                        </div>
                    </a>
                </div>
            </div>

            <div class="col-md-6 col-sm-6 col-lg-6 col-xl-4">
                <div class="dash-widget">
                    <a href="{{ route('departments.index') }}">
                        <span class="dash-widget-bg3"><i class="fa fa-heartbeat" aria-hidden="true"></i></span>
                        <div class="dash-widget-info text-right">
                            <h3>{{ $statistics['inactive_departments'] }}</h3>
                            <span class="widget-title3">Idle dpartmnts <i class="fa fa-check" aria-hidden="true"></i></span>
                        </div>
                    </a>
                </div>
            </div>


        </div>

        {{-- Doctor Ratings --}}
        @php
            $doctors = $statistics['doctors'];
        @endphp

        <br><br>

        <div class="row">
            <div class="col-12 col-md-6 col-lg-6 col-xl-6">
                <div class="hospital-barchart">
                    <h4 class="card-title d-inline-block"> Doctor Avarage Ratings </h4>
                </div>
                <a href="{{ route('ratings.index') }}">
                    <div class="bar-chart">
                        <div class="chart clearfix">
                            @foreach ($doctors as $doctor)
                                @if (isset($doctor->employee->avg_ratings))
                                    <div class="item">
                                        <div class="bar">
                                            <span class="percent">{{ $doctor->employee->avg_ratings * 10 }}%</span>
                                            <div class="item-progress"
                                                data-percent="{{ $doctor->employee->avg_ratings * 10 }}">
                                                <span class="title">{{ $doctor->name }} </span>
                                            </div>
                                        </div>
                                    </div>
                                @endif
                            @endforeach
                        </div>
                    </div>
                </a>
            </div> {{-- bar section / Ratings --}}
        </div> {{-- row --}}

        @php
            $appointments = $statistics['upcoming_appointments'];
        @endphp
        <div class="row">
            <div class="col-12 col-md-6 col-lg-8 col-xl-8">
                <div class="card member-panel">
                    <div class="card-header">
                        <h4 class="card-title d-inline-block">Upcoming Appointments</h4> <a href="#"
                            class="btn btn-primary float-right">View all</a>
                    </div>
                    <div class="card-body p-0">
                        <div class="table-responsive">
                            <table class="table mb-0">
                                <thead class="d-none">
                                    <tr>
                                        <th>Patient Name</th>
                                        <th>Doctor Name</th>
                                        <th>Timing</th>
                                        <th class="text-right">Status</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($appointments as $appointment)
                                        <tr>
                                            <td style="min-width: 200px;">
                                                <div class="float-left user-img m-r-10">
                                                    @php
                                                        $image_path = $appointment->patient->user->image
                                                            ? asset(
                                                                'storage/' .
                                                                    $appointment->patient->user->image->image_path,
                                                            )
                                                            : asset('assets/img/user.jpg');
                                                    @endphp
                                                    <a href="#" title="John Doe"><img src="{{ $image_path }}"
                                                            alt="" class="w-40 rounded-circle"><span
                                                            class="status online"></span></a>
                                                </div>
                                                <h2><a href="#">{{ $appointment->patient->user->name }}
                                                        <span>{{ $appointment->employee->department->name }}</span></a>
                                                </h2>
                                            </td>
                                            <td style="min-width: 150px;">
                                                <h5 class="time-title p-0">Appointment With</h5>
                                                <p>Dr. {{ $appointment->employee->user->name }}</p>
                                            </td>
                                            <td>
                                                <h5 class="time-title p-0">Timing</h5>
                                                <p>{{ $appointment->appointment_date }}</p>
                                            </td>
                                            <td class="text-right">
                                                <a href="#" class="btn btn-outline-primary take-btn">Take
                                                    up</a>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                    <div class="card-footer text-center bg-white">
                        <a href="{{ route('appointments.index') }}" class="text-muted">View all
                            Appointments</a>
                    </div>
                </div>
            </div>
            <div class="col-12 col-md-6 col-lg-4 col-xl-4">
                <div class="card member-panel">
                    <div class="card-header bg-white">
                        <h4 class="card-title mb-0">Doctors</h4>
                    </div>
                    <div class="card-body">
                        <ul class="contact-list">
                            @foreach ($doctors as $doctor)
                                <li>
                                    <div class="contact-cont">
                                        <div class="float-left user-img m-r-10">
                                            @php
                                                $image_path = $doctor->image
                                                    ? asset('storage/' . $doctor->image->image_path)
                                                    : asset('assets/img/user.jpg');
                                            @endphp
                                            <a href="#" title="John Doe"><img src="{{ $image_path }}"
                                                    alt="" class="w-40 rounded-circle"><span
                                                    class="status online"></span></a>
                                        </div>
                                        <div class="contact-info">
                                            <span class="contact-name text-ellipsis">Dr. {{ $doctor->firstname . ' ' . $doctor->lastname}}</span>
                                            <span class="contact-date">{{ $doctor->employee->department->name }}</span>
                                        </div>
                                    </div>
                                </li>
                            @endforeach
                        </ul>
                    </div>
                    <div class="card-footer text-center bg-white">
                        <a href="{{ route('employees.index', ['role' => 'doctor']) }}" class="text-muted">View all
                            Doctors</a>
                    </div>
                </div>
            </div>
        </div>


        <canvas id="linegraph" style="display: none;"></canvas>
        <canvas id="bargraph" style="display: none;"> </canvas>


    </div> {{-- div content --}}
@endsection



@section('scripts')
@endsection
