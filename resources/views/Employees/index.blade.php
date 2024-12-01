@extends('layouts.master')

@section('title')
    Employees
@endsection

@section('css')
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
                <!-- أيقونة سلة المحذوفات -->
                <a href="{{ route('employees.trash') }}">
                    <i class="fa fa-trash-o" style="font-size:36px"></i>
                </a>
            </div>
        </div>
        <div class="row filter-row">
            <div class="col-sm-6 col-md-3">
                <div class="form-group form-focus">
                    <label class="focus-label">Employee ID</label>
                    <input type="text" class="form-control floating">
                </div>
            </div>
            <div class="col-sm-6 col-md-3">
                <div class="form-group form-focus">
                    <label class="focus-label">Employee Name</label>
                    <input type="text" class="form-control floating">
                </div>
            </div>
            <div class="col-sm-6 col-md-3">
                <div class="form-group form-focus select-focus">
                    <label class="focus-label">Role</label>
                    <select class="select floating">
                        <option>Select Role</option>
                        <option>Nurse</option>
                        <option>Pharmacist</option>
                        <option>Laboratorist</option>
                        <option>Accountant</option>
                        <option>Receptionist</option>
                    </select>
                </div>
            </div>
            <div class="col-sm-6 col-md-3">
                <a href="#" class="btn btn-success btn-block"> Search </a>
            </div>
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
                                    <th style="min-width:200px;">Name</th>
                                    <th>Employee ID</th>
                                    <th>Email</th>
                                    <th>Department</th>
                                    <th style="min-width: 110px;">Languages</th>
                                    <th>Role</th>
                                    <th class="text-right">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($employees as $employee)
                                    <tr role="row" class="odd">
                                        <td>
                                            <img width="28" height="28" src={{ asset('assets/img/user.jpg') }}
                                                class="rounded-circle" alt="">
                                            <h2>{{ $employee->user->name }}</h2>
                                        </td>
                                        <td>{{ $employee->id }}</td>
                                        <td>{{ $employee->user->email }}</td>
                                        <td>{{ $employee->department->name }}</td>
                                        <td>{{ $employee->languages_spoken }}</td>
                                        <td>
                                            @if($employee->user->roles->isNotEmpty())
                                                <span class="custom-badge status-green">{{ $employee->user->roles->first()->name }}</span>
                                            @else
                                                <span class="custom-badge status-red">No Role Assigned</span>
                                            @endif
                                        </td>

                                        <td class="text-right">
                                            <div class="action-buttons" style="white-space: nowrap;">
                                                <a class="btn btn-sm btn-primary"
                                                    href="{{ route('employees.edit', $employee->id) }}"
                                                    style="display: inline-block; margin-right: 5px;">
                                                    <i class="fa fa-pencil m-r-5"></i> Edit
                                                </a>
                                                <a class="btn btn-sm btn-info"
                                                    href="{{ route('employees.show', $employee->id) }}"
                                                    style="display: inline-block; margin-right: 5px;">
                                                    <i class="fa fa-eye m-r-5"></i> Show
                                                </a>
                                                <form action="{{ route('employees.destroy', $employee->id) }}"
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
                    </div>
                </div>
            </div>
        @endif
    </div>

@endsection



@section('scripts')
@endsection
