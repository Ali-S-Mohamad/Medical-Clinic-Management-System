@extends('layouts.master')

@section('title')
{{ $clinic->name }}
@endsection

@section('css')

@endsection


@section('content')
<div class="container">
<br><br><br>
    <h1> </h1>

    <div class="card-box profile-header">
        <div class="row">
            <div class="col-md-12">
                <div class="profile-view">
                    <div class="profile-img-wrap">
                        <div class="profile-img">
                            @php
                               $logo_path=$clinic->image ? asset('storage/' . $clinic->image->image_path) : asset('assets/img/user.jpg');
                            @endphp
                             <a class="avatar" href="{{$logo_path}}" target="_blank" style="display: flex; justify-content: center; align-items: center;">
                                <img alt="ُlogo" 
                                     src="{{ $logo_path }}" 
                                     style="max-width: 100%; max-height: 100%; width: 300px; height: 300px; object-fit: cover; border-radius: 50%;">
                            </a> 
                        </div>
                    </div>
                    <div class="profile-basic">
                        <div class="row">
                            <div class="col-md-5" style='min-height: 175px' >
                                <div class="profile-info-left">
                                    <br>  
                                    <h3 class="user-name m-t-0 mb-0">{{ $clinic->name }}</h3>
                                    <small class="text-muted">Medical Center</small>
                                    <div class="staff-id">Founded : {{ $clinic->established_at}}</div>
                                   
                                </div>
                            </div>
                            <div class="col-md-7">
                                <ul class="personal-info">
                                    <br>  
                                    <li>
                                        <span class="title">Phone:</span>
                                        <span class="text"><a href="#">{{ $clinic->name }}</a></span>
                                    </li>
                                    <li>
                                        <span class="title">Email:</span>
                                        <span class="text"><a href="#">{{ $clinic->email }}</a></span>
                                    </li>
                                
                                    <li>
                                        <span class="title">Address:</span>
                                        <span class="text">{{ $clinic->address }}</span>
                                    </li>
                                    
                                </ul>
                            </div>
                        </div>
                    </div>    
                </div>                        
            </div>
        </div>
    </div>

    <div class="tab-content">
        <div class="tab-pane show active" id="about-cont">
    <div class="row">
        <div class="col-md-12">
             {{-- about content --}}
             <div class="card-box">
                <h3 class="card-title">About {{ $clinic->name }} </h3>
                <div class="experience-box">
                    <ul class="experience-list">
                        <li>
                            <div class="experience-user">
                                <div class="before-circle"></div>
                            </div>
                            <div class="experience-content">
                                <div class="timeline-content">
                                    <a href="#/" class="name">{{ $clinic->about }}</a>
                                     
                                </div>
                            </div>
                        </li>
                        <li>
                           
                        </li>
                    </ul>
                </div>
            </div>
            {{-- end of about container --}}
            @if (Auth::check()  && Auth::user()->hasRole('Admin'))
                <div class="m-t-20 text-center">
                    <a href="{{ route('clinic.edit', $clinic->id) }}" class="btn btn-primary mb-3" rel="prev">
                        <i class="fa fa-pencil m-r-5"></i> Edit Info
                    </a>
                </div>
            @endif

        </div>
    </div>
</div>
</div>


</div>

@endsection



@section('scripts')

@endsection
