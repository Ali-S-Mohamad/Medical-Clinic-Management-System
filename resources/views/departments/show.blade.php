@extends('layouts.master')

@section('title')
    Department Details
@endsection

@section('css')

@endsection

@section('content')
    <div class="content">
        <div class="d-flex justify-content-center align-items-center" style="min-height: 100vh;">
            <div class="card shadow-lg" style="width: 50rem; max-width: 90%; border-radius: 30px; padding: 40px;">
                <div class="department-card-body">
                    <div class="department-doctor-img">
                            @php
                                $image_path = $department->image
                                    ? asset('storage/' . $department->image->image_path)
                                    : asset('assets/img/user.jpg');
                            @endphp
                            <img src="{{ $image_path }}" alt="Department Image">
                    </div>
                  <center><div>
                        <br>
                        <h3 class="department-title">
                         <a href="{{ route('departments.show', $department->id) }}" style="text-decoration: none; color: inherit;">
                              {{ $department->name }}
                         </a>
                         </h3>
                         <p class="department-description">
                            {{ $department->description }}
                        </p>
                        <form class="department-status-form" action="{{ route('departments.toggleStatus', $department->id) }}" method="POST">
                            @csrf
                            @method('PATCH')
                        <button type="submit"
                        class="btn btn-link text-decoration-none {{ $department->status == 1 ? 'text-success' : 'text-danger' }}"
                        style="font-size: 1.2rem;">
                        {{ $department->status == 1 ? 'Active' : 'Inactive' }}
                        </button>
                        </form>
                      <div class="department-buttons">
                      <a href="javascript:history.back()" class="btn btn-secondary" rel="prev">
                      <i class="fa fa-arrow-left mr-2"></i> Back
                      </a>
                      <a href="{{ route('departments.edit', $department->id) }}" class="btn btn-primary" rel="prev">
                        <i class="fa fa-pencil m-r-5"></i> Edit
                    </a>
                </div>
            </div></center>  
        </div>
    </div>
@endsection

@section('scripts')
@endsection
