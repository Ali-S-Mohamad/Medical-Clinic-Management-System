@extends('layouts.master')

@section('title')
    Employees
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
                <h4 class="page-title">Employees</h4>
            </div>
            <div class="col-sm-7 col-7 text-right m-b-30 d-flex justify-content-end align-items-center">
                <a href="{{ route('users.create') }}" class="btn btn-primary btn-rounded mr-3">
                    <i class="fa fa-plus"></i> Add Employee
                </a>
                <!-- trash icon -->
                <a href="{{ route('employees.trash') }}">
                    <i class="fa fa-trash-o" style="font-size:36px"></i>
                </a>
            </div>
        </div>
        <div class="row filter-row">
            <form method="GET" action="{{ route('employees.index') }}" class="d-flex w-100" id="filterForm">
                <div class="col-sm-6 col-md-3">
                    <div class="form-group form-focus">
                        <label class="focus-label">Employee Name</label>
                        <input type="text" name="employee_name" class="form-control floating"
                            value="{{ request('employee_name') }}">
                    </div>
                </div>
                <div class="col-sm-6 col-md-3">
                    <div class="form-group form-focus select-focus">
                        <label class="focus-label">Department</label>
                        <select class="select floating" name="department">
                            <option value="">Select Department</option>
                            @foreach ($departments as $department)
                                <option value="{{ $department->id }}"{{ request('department') == $department->id ? 'selected' : '' }}>
                                    {{ $department->name }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="col-sm-6 col-md-2">
                    <div class="form-group form-focus select-focus">
                        <label class="focus-label">Role</label>
                        <select name="role" class="select floating">
                            <option value="">Select Role</option>
                            @foreach ($roles as $role)
                                @continue(in_array($role->name, ['Admin', 'patient']))
                                <option value="{{ $role->name }}" {{ request('role') == $role->name ? 'selected' : '' }}>
                                    {{ $role->name }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="col-sm-6 col-md-2">
                    <button type="submit" class="btn btn-success btn-block ">Search</button>
                </div>
                <div>
                    <a href="{{ route('employees.index') }}" class="btn btn-primary btn-rounded mr-3">
                        All Employees
                    </a>
                </div>
            </form>
        </div>
        @if ($employees->isEmpty())
            <h3>No Employees .. please add one</h3>
        @else
            <div class="row">
                <div class="col-md-12">
                    <div class="table-responsive">
                        <table class="table table-striped custom-table">
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th style="min-width:175px;">Name</th>
                                    <th>Email</th>
                                    <th>Department</th>
                                    <th class="text-center">Languages</th>
                                    <th class="text-center">Role</th>
                                    <th class="text-center">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($employees as $employee)
                                    <tr role="row"
                                        onclick="window.location='{{ route('employees.show', $employee->id) }}' "
                                        class="odd">
                                        <td>{{ $employee->id }}</td>
                                        <td>
                                            @php
                                                $image_path = $employee->image
                                                    ? asset('storage/' . $employee->image->image_path)
                                                    : asset('assets/img/user.jpg');
                                            @endphp
                                            <img width="40" height="40" src="{{ $image_path }}"
                                                class="rounded-circle" alt="">
                                            <h2>{{ $employee->user->name }}</h2>
                                        </td>
                                        <td>{{ $employee->user->email }}</td>
                                        <td>{{ $employee->department?->name }}</td>
                                        <td>
                                            @if (!$employee->Languages->isEmpty())
                                                @foreach ($employee->Languages as $Language)
                                                    <p class="badge badge-pill badge-dark"> {{ $Language->name }}</p>
                                                @endforeach
                                            @endif
                                        </td>
                                        <td>
                                            @if ($employee->user->roles->isNotEmpty())
                                                @php
                                                    $role = $employee->user->roles->first()->name;
                                                    $badgeClass = match ($role) {
                                                        'doctor' => 'status-green',
                                                        'employee' => 'status-blue',
                                                        default => 'status-grey',
                                                    };
                                                @endphp
                                                <span class="custom-badge {{ $badgeClass }}">{{ $role }}</span>
                                            @else
                                                <span class="custom-badge status-red">No Role Assigned</span>
                                            @endif
                                        </td>

                                        <td class="text-right">
                                            <div class="action-buttons" style="white-space: nowrap;">
                                                <a class="btn btn-sm btn-primary"
                                                    href="{{ route('employees.edit', $employee->id) }}"
                                                    onclick="event.stopPropagation();"
                                                    style="display: inline-block; margin-right: 5px;">
                                                    <i class="fa fa-pencil m-r-5"></i> Edit
                                                </a>
                                                <form action="{{ route('employees.destroy', $employee->id) }}"
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
        @endif

        
        {{ $employees->links()}}

    </div> {{-- content div --}}
@endsection


@section('scripts')


@endsection
