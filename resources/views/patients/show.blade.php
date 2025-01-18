@extends('layouts.master')

@section('title')
Patient
@endsection

@section('css')
@endsection


@section('content')
    <div class="content">

        <div class="d-flex justify-content-center align-items-center" style="min-height: 100vh;">
            <div class="card shadow-lg" style="width: 50rem; max-width: 90%; border-radius: 15px; padding: 20px;">
                <div class="card-body text-center">
                    <div class="doctor-img mb-4">
                        @php
                            $image_path = $patient->user->image
                                                ? asset('storage/' . $patient->user->image->image_path)
                                                : asset('assets/img/user.jpg');
                        @endphp
 
                        <a class="avatar" href="{{$image_path}}" target="_blank" style="display: flex; justify-content: center; align-items: center;">
                            <img alt="ُpatient Image" 
                                 src="{{ $image_path }}" 
                                 style="max-width: 100%; max-height: 100%; width: 300px; height: 300px; object-fit: cover; border-radius: 50%;">
                        </a>                        
                    </div>
                    <div>
                        <h3 class="card-title mb-3" style="font-weight: bold; color: #333; font-size: 1.2rem;">
                            {{ $patient->user->firstname }}   {{ $patient->user->lastname }}
                        </h3>
                        
                        <h2 class="card-title mb-3" style="font-weight: bold; color: #333;">
                            @php
                               $interval=(new DateTime('today'))->diff(new DateTime($patient->dob));
                               $years = $interval->y; 
                               $months = $interval->m;
                            @endphp
                            Age:  {{$years}}y, {{   $months }}m
                             
                        </h2>
                        <p class="card-text mb-4" style="font-size: 1.1rem; color: #555;">
                            {{ $patient->user->email }}
                        </p>
                        <p class="card-text mb-4" style="font-size: 1.1rem; color: #555;">
                            @if ($patient->user->phone_number)
                                Mobile Number: <br>  {{ $patient->user->phone_number }}
                             @endif
                        </p>
                        <p class="card-text mb-4" style="font-size: 1.1rem; color: #555;">
                                gender: <br>  {{ $patient->user->gender }}
                        </p>
                        <p style="font-size: 1.1rem; color: #555;">
                            
                        </p>
                        <br>
                        <br>
                        <p class="card-text mb-4" style="font-size: 1.0rem; color: #555;">
                            @if($patient->insurance_number )
                               Insurance Number: <br> {{ $patient->insurance_number }}
                            @endif
                        </p>
                        
                    </div>
                    <a href="javascript:history.back()" class="btn btn-secondary mb-3" rel="prev">
                        <i class="fa fa-arrow-left mr-2"></i> Back
                    </a>
                    <a href="{{ route('patients.edit', $patient->id) }}" class="btn btn-primary mb-3" rel="prev">
                        <i class="fa fa-pencil m-r-5"></i> Edit
                    </a>

                </div>
            </div>
        </div>
    </div>
@endsection



@section('scripts')
 
@endsection
