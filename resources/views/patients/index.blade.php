    @extends('layouts.master')

    @section('title')
    Patients
    @endsection

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
                                    <th>ID</th>
                                    <th>Name</th>
                                    <th>Email</th>
                                    <th>Birth date</th>
                                    <th>insurance Number</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($patients as $patient )
                                <tr onclick="window.location='{{ route('patients.show', $patient->id) }}' ">
                                    <td>{{ $patient->id }}</td>
                                    <td>
                                        @php
                                            $image_path = $patient->user->image
                                                ? asset('storage/' . $patient->user->image->image_path)
                                                : asset('assets/img/user.jpg');
                                        @endphp
                                    <img width="40" height="40" src="{{ $image_path }}"
                                        class="rounded-circle" alt="">
                                    <h2>{{ $patient->user->name }}</h2>
                                    </td>
                                    <td>{{$patient->user->email}}</td>
                                    <td>{{$patient->dob}}</td>

                                    <td>{{$patient->insurance_number}}</td>

                                    <td class="text-right">
                                        <div class="action-buttons" style="white-space: nowrap;">
                                            <a class="btn btn-sm btn-primary"
                                                href="{{ route('patients.edit', $patient->id) }}"
                                                onclick="event.stopPropagation();"
                                                style="display: inline-block; margin-right: 5px;">
                                                <i class="fa fa-pencil m-r-5"></i> Edit
                                            </a>
                                            <form action="{{ route('patients.destroy', $patient->id) }}"
                                                method="POST" style="display: inline-block; margin: 0;"
                                                onclick="event.stopPropagation();">
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
                    </div>
                </div>
            </div>
            <br>
            {{ $patients->links()}}
        </div>
    @endsection

    @section('scripts')


    @endsection
