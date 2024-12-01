Viewed
Original file line number Diff line number Diff line change
@@ -0,0 +1,55 @@

@extends('layouts.master')

@section('title')
@endsection

@section('css')
@endsection


@section('content')
    <div class="content">
        <a href="javascript:history.back()" class="btn btn-secondary mb-3" rel="prev">
            <i class="fa fa-arrow-left mr-2"></i> Back
        </a>
        <div class="d-flex justify-content-center align-items-center" style="min-height: 100vh;">
            <div class="card shadow-lg" style="width: 50rem; max-width: 90%; border-radius: 15px; padding: 20px;">
                <div class="card-body text-center">
                    <div class="doctor-img mb-4">
                        <a class="avatar" href="{{ route('departments.show', $department->id) }}">
                            <img alt="Department Image" src="assets/img/department-thumb.jpg" class="rounded-circle"
                                style="width: 150px; height: 150px; object-fit: cover; border: 3px solid #007bff;">
                        </a>
                    </div>
                    <h3 class="card-title mb-3" style="font-weight: bold; color: #333;">
                        <a href="{{ route('departments.show', $department->id) }}"
                            style="text-decoration: none; color: inherit;">
                            {{ $department->name }}
                        </a>
                    </h3>
                    <p class="card-text mb-4" style="font-size: 1.1rem; color: #555;">
                        {{ $department->description }}
                    </p>
                    <form action="{{ route('departments.toggleStatus', $department->id) }}" method="POST"
                        style="display: inline;">
                        @csrf
                        @method('PATCH')
                        <button type="submit"
                            class="btn btn-link text-decoration-none {{ $department->status == 1 ? 'text-success' : 'text-danger' }}"
                            style="font-size: 1.2rem;">
                            {{ $department->status == 1 ? 'Active' : 'Inactive' }}
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection


@section('scripts')
@endsection
