@extends('layouts.master')

@section('title')
    Appointments
@endsection

@section('css')
@endsection

@section('content')
    <div class="content">
        <div class="row">
            <div class="col-sm-4 col-3">
                <h4 class="page-title">Appointments</h4>
            </div>
            <div class="col-sm-8 col-9 text-right m-b-20">
                <a href="{{ route('appointments.create') }}" class="btn btn-primary btn-rounded float-right">
                    <i class="fa fa-plus"></i> Add Appointment
                </a>
            </div>
        </div>
        <div class="row">
            <div class="col-md-12">
                <div class="table-responsive">
                    <table class="table table-striped custom-table">
                        <thead>
                            <tr>
                                <th>Appointment ID</th>
                                <th>Patient Name</th>
                                <th>Doctor Name</th>
                                <th>Appointment Date</th>
                                <th>Status</th>
                                <th class="text-right">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($appointments as $appointment)
                                <tr>
                                    <td>{{ $appointment->id }}</td>
                                    <td>
                                        <img width="28" height="28" src="{{ asset('assets/img/user.jpg') }}"
                                            class="rounded-circle m-r-5" alt="">
                                        {{ $appointment->patient->user->name }}
                                    </td>
                                    <td>{{ $appointment->employee->user->name }}</td>
                                    <td>{{ $appointment->appointment_date }}</td>
                                    <td>
                                        <span
                                            class="custom-badge {{ $appointment->status === 'scheduled' ? 'status-blue' : ($appointment->status === 'completed' ? 'status-green' : 'status-red') }}">
                                            {{ ucfirst($appointment->status) }}
                                        </span>
                                    </td>


                                    <td class="text-right">
                                        <div class="action-buttons" style="white-space: nowrap;">
                                            <a class="btn btn-sm
                                             {{ ($appointment->status === 'completed' || $appointment->status === 'canceled') ?
                                             'btn-secondary disabled' : 'btn-primary' }}"
                                             href="{{ ($appointment->status === 'completed' || $appointment->status === 'cancelled') ? '#' :
                                              route('appointments.edit', $appointment->id) }}"
                                             style="display: inline-block; margin-right: 5px;
                                             {{ ($appointment->status === 'completed' && $appointment->status === 'cancelled')
                                              ? 'pointer-events: none; color: #6c757d;' : '' }}">
                                             <i class="fa fa-pencil m-r-5"></i> Edit
                                         </a>


                                            <a class="btn btn-sm btn-info"
                                                href="{{ route('appointments.show', $appointment->id) }}"
                                                style="display: inline-block; margin-right: 5px;">
                                                <i class="fa fa-eye m-r-5"></i> Show
                                            </a>
                                            <form action="{{ route('appointments.destroy', $appointment->id) }}"
                                                method="POST" style="display: inline-block; margin: 0;">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-danger btn-sm"
                                                    style="padding: 2px 6px; font-size: 0.9rem; display: inline-block;">
                                                    <i class="fa fa-trash-o"
                                                        style="font-size: 0.8rem; margin-right: 3px;"></i> Trash
                                                </button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>

                    {{ $appointments->links()}}
                    <a href="javascript:history.back()" class="btn btn-secondary mb-3" rel="prev"> <i
                            class="fa fa-arrow-left mr-2"></i>Back</a>
                </div>
            </div>
        </div>
    </div>
@endsection


@section('scripts')
@endsection
