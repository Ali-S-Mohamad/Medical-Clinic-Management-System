
@extends('layouts.master')

@section('title')

@endsection

@section('css')

@endsection


@section('content')
<div class="content">
<<<<<<< HEAD
    <a href="javascript:history.back()" class="btn btn-secondary mb-3" rel="prev">
        <i class="fa fa-arrow-left mr-2"></i> Back
    </a>
    <div class="d-flex justify-content-center align-items-center" style="min-height: 100vh;">
        <div class="card shadow-lg" style="width: 50rem; max-width: 90%; border-radius: 15px; padding: 20px;">
            <div class="card-body text-center">
                <div class="doctor-img mb-4">
                    <a class="avatar" href="{{ route('departments.show', $department->id) }}">
                        <img alt="Department Image" src="assets/img/department-thumb.jpg" 
                             class="rounded-circle" style="width: 150px; height: 150px; object-fit: cover; border: 3px solid #007bff;">
                    </a>
                </div>
                <h3 class="card-title mb-3" style="font-weight: bold; color: #333;">
                    <a href="{{ route('departments.show', $department->id) }}" style="text-decoration: none; color: inherit;">
                        {{$department->name}}
                    </a>
                </h3>
                <p class="card-text mb-4" style="font-size: 1.1rem; color: #555;">
                    {{$department->description}}
                </p>
                <form action="{{ route('departments.toggleStatus', $department->id) }}" method="POST" style="display: inline;">
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
=======
<div class="d-flex justify-content-center align-items-center" style="min-height: 100vh;">
    <div class="card" style="width: 40rem;">
        <div class="card-body text-center">
            <div class="doctor-img mb-3">
                <a class="avatar" href="profile.html">
                    <img alt="Department Image" src="assets/img/department-thumb.jpg" class="rounded-circle" style="width: 100px; height: 100px; object-fit: cover;">
                </a>
            </div>
            <h4 class="card-title">
                <a href="profile.html">{{$department->name}}</a>
            </h4>
            <p class="card-text">{{$department->description}}</p>
            <p class="text-muted">
            <span class="custom-badge {{ $department->status == 1 ? 'status-green' : 'status-red' }}">
                    {{ $department->status == 1 ? 'Active' : 'Inactive' }}
                   </span>
            </p>
        </div>
    </div>
</div>
</div>
>>>>>>> 80eabe856da1f5424eab8d38476e0782d1eb464c


@endsection


@section('scripts')

@endsection
