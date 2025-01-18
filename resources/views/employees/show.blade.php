@extends('layouts.master')

@section('title')
    Show Employee
@endsection

@section('css')
@endsection


@section('content')
    <div class="content">
            <div class="row">
                <div class="col-sm-7 col-6">
                    <h4 class="page-title">My Profile</h4>
                </div>

                <div class="col-sm-5 col-6 text-right m-b-30">
                    <a href="{{ route('employees.edit', $employee->id) }}" class="btn btn-primary "><i class="fa fa-plus"></i> Edit Profile</a>
                    {{-- <a href="javascript:history.back()" class="btn btn-secondary " rel="prev">
                        <i class="fa fa-arrow-left mr-2"></i> Back
                    </a> --}}
                    <a href="{{ route('employees.index')}}" class="btn btn-secondary" rel="prev" id="backButton">
                        <i class="fa fa-arrow-left mr-2"></i> Back
                    </a>

                </div>
            </div>
            <div class="card-box profile-header">
                <div class="row">
                    <div class="col-md-12">
                        <div class="profile-view">
                            <div class="profile-img-wrap">
                                <div class="profile-img">
                                    @php
                                                $image_path = $employee->user->image
                                                    ? asset('storage/' . $employee->user->image->image_path)
                                                    : asset('assets/img/user.jpg');
                                            @endphp
                                            <img width="40" height="40" src="{{ $image_path }}"
                                                class="rounded-circle" alt="">
                                </div>
                            </div>
                            <div class="profile-basic">
                                <div class="row">
                                    <div class="col-md-5">
                                        <div class="profile-info-left">
                                            <h3 class="user-name m-t-0 mb-0">{{ $employee->user->firstname }}  {{ $employee->user->lastname }}</h3>
                                            <small class="text-muted"> {{ $employee->department->name }}</small>
                                            <h2 class="card-title mb-3" style="font-weight: bold; color: {{ $employee->avg_ratings < 6 ? 'orange' : ' #4caa59;' }};">
                                                @if($employee->avg_ratings)
                                                    {{ $employee->avg_ratings }} /10
                                                @endif
                                           </h2>
                                        </div>
                                    </div>
                                    <div class="col-md-7">
                                        <ul class="personal-info">
                                            <li>
                                                <span class="title">Phone:</span>
                                                <span class="text"><a href="#">{{ $employee->user->phone_number }}</a></span>
                                            </li>
                                            <li>
                                                <span class="title">Email:</span>
                                                <span class="text"><a href="#"> {{ $employee->user->email }}</a></span>
                                            </li>
                                            <li>
                                                <span class="title">Gender:</span>
                                                <span class="text"><a href="#"> {{ $employee->user->gender }}</a></span>
                                            </li>
                                        </br>
                                    </br>
                                </br>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="profile-tabs">
                <ul class="nav nav-tabs nav-tabs-bottom">
                    <li class="nav-item"><a class="nav-link" href="#bottom-tab2" data-toggle="tab">Profile</a></li>
                </ul>


        <div class="card-box profile-header">
            <div class="row">
                <div class="col-md-12">
                    <div class="profile-view">
                        <div class="profile-img-wrap">
                            <div class="profile-img">
                                @php
                                    $image_path = $employee->user->image
                                        ? asset('storage/' . $employee->user->image->image_path)
                                        : asset('assets/img/user.jpg');
                                @endphp
                                <img width="40" height="40" src="{{ $image_path }}" class="rounded-circle"
                                    alt="">
                            </div>
                        </div>
                        <div class="profile-basic">
                            <div class="row">
                                <div class="col-md-5">
                                    <div class="profile-info-left">
                                        <h3 class="user-name m-t-0 mb-0">{{ $employee->user->name }}</h3>
                                        <small class="text-muted"> {{ $employee->department->name }}</small>
                                        <h2 class="card-title mb-3"
                                            style="font-weight: bold; color: {{ $employee->avg_ratings < 6 ? 'orange' : ' #4caa59;' }};">
                                            @if ($employee->avg_ratings)
                                                {{ $employee->avg_ratings }} /10
                                            @endif
                                        </h2>
                                    </div>
                                </div>
                                <div class="col-md-7">
                                    <ul class="personal-info">
                                        <li>
                                            <span class="title">Phone:</span>
                                            <span class="text"><a
                                                    href="#">{{ $employee->user->phone_number }}</a></span>
                                        </li>
                                        <li>
                                            <span class="title">Email:</span>
                                            <span class="text"><a href="#"> {{ $employee->user->email }}</a></span>
                                        </li>
                                        </br>
                                        </br>
                                        </br>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="profile-tabs">
            <ul class="nav nav-tabs nav-tabs-bottom">
                <li class="nav-item"><a class="nav-link" href="#bottom-tab2" data-toggle="tab">Profile</a></li>
            </ul>


            <div class="tab-content">
                <div class="tab-pane show active" id="about-cont">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="card-box">
                                <h3 class="card-title"> Academic Qualifications:</h3>
                                <div class="experience-box">
                                    <ul class="experience-list">
                                        <li>
                                            <div class="experience-user">
                                                <div class="before-circle"></div>
                                            </div>
                                            <div class="experience-content">
                                                <div class="timeline-content">
                                                    <a href="#/" class="name">
                                                        @if ($employee->academic_qualifications)
                                                            {{ $employee->academic_qualifications }}
                                                        @endif
                                                    </a>
                                                </div>
                                            </div>
                                        </li>

                                    </ul>
                                </div>
                            </div>
                            <div class="card-box ">
                                <h3 class="card-title">Previous Experience</h3>
                                <div class="experience-box">
                                    <ul class="experience-list">
                                        <li>
                                            <div class="experience-user">
                                                <div class="before-circle"></div>
                                            </div>
                                            <div class="experience-content">
                                                <div class="timeline-content">
                                                    <a href="#/" class="name">
                                                        @if ($employee->previous_experience)
                                                            {{ $employee->previous_experience }}
                                                        @endif
                                                    </a>
                                                </div>
                                            </div>
                                        </li>
                                    </ul>
                                </div>
                            </div>


                            <div class="card-box ">
                                <h3 class="card-title">language :</h3>
                                <div class="experience-box">
                                    <ul class="experience-list">
                                        <li>
                                            <div class="experience-user">
                                                <div class="before-circle"></div>
                                            </div>
                                            @if (!$employee->languages->isEmpty())
                                                @foreach ($employee->languages as $language)
                                                    <div class="experience-content">
                                                        <div class="timeline-content">
                                                            {{ $language->name }}
                                                        </div>
                                                    </div>
                                                @endforeach
                                            @endif
                                        </li>
                                    </ul>
                                </div>
                            </div>

                            <div class="card-box mb-0">
                                <h3 class="card-title">Cv :</h3>
                                <div class="experience-box">
                                    <ul class="experience-list">
                                        <li>
                                            <div class="experience-user">
                                                <div class="before-circle"></div>
                                            </div>
                                            <div class="experience-content">
                                                <div class="timeline-content">
                                                    @if ($employee->cv_path)
                                                        @php
                                                            $cvFileName = basename($employee->cv_path);
                                                            $originalFileName = preg_replace(
                                                                '/^\d+_/',
                                                                '',
                                                                $cvFileName,
                                                            );
                                                        @endphp
                                                        <a href="{{ asset('storage/' . $employee->cv_path) }}"
                                                            target="_blank"> {{ $originalFileName }}</a>
                                                    @endif
                                                    </p>
                                                </div>
                                            </div>
                                </div>
                            </div>

                        </div>
                    </div>
                </div>
            </div>
        @endsection



        @section('scripts')
        @endsection
