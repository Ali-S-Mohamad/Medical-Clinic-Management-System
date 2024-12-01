@extends('layouts.master')

@section('title')
    Deleted Employees
@endsection

@section('css')
@endsection


@section('content')
    <div class="content">
        <div class="row">
            <div class="col-sm-4 col-3">
                <h4 class="page-title">Deleted Employees</h4>
            </div>
            <div class="col-sm-8 col-9 text-right m-b-20">
                <a href="{{ route('users.create') }}" class="btn btn-primary float-right btn-rounded"><i
                        class="fa fa-plus"></i> Add Employee</a>
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
        @if ($deletedEmployees->isEmpty())
            <h3>No Deleted Employees ..</h3>
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
                                @foreach ($deletedEmployees as $employee)
                                    <tr>
                                        <td>
                                            <img width="28" height="28" src={{ asset('assets/img/user.jpg') }}
                                                class="rounded-circle" alt="">
                                            <h2>{{ $employee->user->name }}</h2>
                                        </td>
                                        <td>{{ $employee->id }}</td>
                                        <td>{{ $employee->user->email }}</td>
                                        <td>{{ $employee->department->name }}</td>
                                        <td>...</td>
                                        <td>
                                            <span class="custom-badge status-green">Nurse</span>
                                        </td>
                                        <td>
                                            <form action="{{ route('employees.restore', $employee->id) }}" method="POST"
                                                style="display: inline;">
                                                @csrf
                                                <button type="submit" class="btn btn-success btn-sm">Restore</button>
                                            </form>
                                            <form action="{{ route('employees.hardDelete', $employee->id) }}" method="POST"
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
    </div>
    </div>
    </div>
    @endif
    </div>

@endsection



@section('scripts')
@endsection
