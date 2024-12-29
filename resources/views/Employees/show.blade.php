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
                        @php
                            $image_path=$employee->image ? asset('storage/' . $employee->image->image_path) : asset('assets/img/user.jpg');
                        @endphp
                        <a class="avatar" href="{{$image_path}}" target="_blank" style="display: flex; justify-content: center; align-items: center;">
                            <img alt="ُEmployee Image" 
                                 src="{{ $image_path }}" 
                                 style="max-width: 100%; max-height: 100%; width: 300px; height: 300px; object-fit: cover; border-radius: 50%;">
                        </a>                        
                    </div>
                    <div>
                        <h3 class="card-title mb-3" style="font-weight: bold; color: #333; font-size: 1.2rem;">
                            {{ $employee->user->name }}
                        </h3>
                        <h2 class="card-title mb-3" style="font-weight: bold; color: {{ $employee->avg_ratings < 6 ? 'orange' : ' #4caa59;' }};">
                             @if($employee->avg_ratings)
                                 {{ $employee->avg_ratings }} /10 
                             @endif
                        </h2>
                        <h2 class="card-title mb-3" style="font-weight: bold; color: #333;">
                            {{ $employee->department->name }}
                        </h2>
                        <p class="card-text mb-4" style="font-size: 1.1rem; color: #555;">
                            {{ $employee->user->email }}
                        </p>
                        <p class="card-text mb-4" style="font-size: 1.1rem; color: #555;">
                            {{ $employee->user->phone_number }}
                        </p>
                        <p style="font-size: 1.1rem; color: #555;">
                            @if(!$employee->languages->isEmpty())
                                <label for="languages">Languages:</label> <br/>
                                @foreach($employee->languages as $language)                          
                                    {{ ($language->name);}}
                                @endforeach     
                            @endif 
                        </p>
                        <br>
                        <p class="card-text mb-4" style="font-size: 1.0rem; color: #555;">
                            @if($employee->academic_qualifications)
                              Academic Qualifications:<br/> {{ $employee->academic_qualifications }}
                            @endif
                        </p>
                        <br>
                        <p class="card-text mb-4" style="font-size: 1.0rem; color: #555;">
                            @if($employee->previous_experience)
                               Previous Experience: <br> {{ $employee->previous_experience }}
                            @endif
                        </p>
                        <p class="card-text mb-4" style="font-size: 1.0rem; color: #555;">
                            @if($employee->cv_path)
                                @php
                                   $cvFileName = basename($employee->cv_path);
                                   $originalFileName = preg_replace('/^\d+_/', '', $cvFileName);  
                                @endphp           
                                cv: <br>
                               <a href="{{asset('storage/'.$employee->cv_path)}}" target="_blank"> {{ $originalFileName }}</a>
                            @endif
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
