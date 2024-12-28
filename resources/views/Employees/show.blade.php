@extends('layouts.master')

@section('title')
@endsection

@section('css')
@endsection


@section('content')
    <div class="content">

        <div class="d-flex justify-content-center align-items-center" style="min-height: 100vh;">
            <div class="card shadow-lg" style="width: 50rem; max-width: 90%; border-radius: 15px; padding: 20px;">
                <div class="card-body text-center">
                    <div class="doctor-img mb-4">
                        <a class="avatar" href="">
                            <img alt="Department Image" src="{{ asset('assets/img/user.jpg') }}" class="rounded-circle"
                                style="width: 150px; height: 150px; object-fit: cover; border: 3px solid #007bff;">
                        </a>
                    </div>
                    <div>
                        <h3 class="card-title mb-3" style="font-weight: bold; color: #333;">
                            {{-- <a href="{{ route('departments.show', $department->id) }}" style="text-decoration: none; color: inherit;"> --}}
                            {{ $employee->user->name }}
                            {{-- </a> --}}
                        </h3>
                        <h2 class="card-title mb-3" style="font-weight: bold; color: #333;">
                            {{-- <a href="{{ route('departments.show', $department->id) }}" style="text-decoration: none; color: inherit;"> --}}
                            {{ $employee->department->name }}
                            {{-- </a> --}}
                        </h2>
                        <p class="card-text mb-4" style="font-size: 1.1rem; color: #555;">
                            {{ $employee->user->email }}
                        </p>
                        <p class="card-text mb-4" style="font-size: 1.1rem; color: #555;">
                            {{ $employee->user->phone_number }}
                        </p>
                        <p class="card-text mb-4" style="font-size: 1.1rem; color: #555;">
                            {{ $employee->academic_qualifications }}
                        </p>
                        <p class="card-text mb-4" style="font-size: 1.1rem; color: #555;">
                            {{ $employee->previous_experience }}
                        </p>
                    </div>
                    <a href="javascript:history.back()" class="btn btn-secondary mb-3" rel="prev">
                        <i class="fa fa-arrow-left mr-2"></i> Back
                    </a>
                    <a href="{{ route('employees.edit', $employee->id) }}" class="btn btn-primary mb-3" rel="prev">
                        <i class="fa fa-pencil m-r-5"></i> Edit
                    </a>

                </div>
            </div>
        </div>
    </div>
@endsection



@section('scripts')
@endsection
