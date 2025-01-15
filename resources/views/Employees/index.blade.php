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
@if (session('error'))
        <div class="alert alert-danger fade show" role="alert" style="animation: fadeOut 3s forwards;">
            {{ session('error') }}
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
    @endif
    @if (session('success'))
        <div class="alert alert-success fade show" role="alert" style="animation: fadeOut 3s forwards;">
            {{ session('success') }}
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
    @endif
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
    @include('employees.partials.table', ['employees' => $employees])
@endif

{{ $employees->links() }}
    </div>
@endsection

@section('scripts')
<script>
    $(document).ready(function() {
        $('#filterForm').on('submit', function(e) {
            e.preventDefault(); // Prevent page reloading

            // Collect filter data page
            let filters = $(this).serialize();

            // Make an AJAX request
            $.ajax({
                url: "{{ route('employees.index') }}", // The link supports AJAX requests
                method: "GET",
                data: filters,
                beforeSend: function() {
                    // Add a loading indicator
                    $('#employeeTable').html('<tr><td colspan="7" class="text-center">Loading...</td></tr>');
                },
                success: function(response) {
                    $('#employeeTable').html(response);
                },
                error: function(xhr, status, error) {
                    console.error("An error occurred:", error);
                    alert("Failed to filter employees. Please try again.");
                }
            });
        });
    });
</script>
@endsection
