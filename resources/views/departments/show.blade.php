
@extends('layouts.master')

@section('title')

@endsection

@section('css')

@endsection


@section('content')
<div class="content">
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


@endsection


@section('scripts')

@endsection
