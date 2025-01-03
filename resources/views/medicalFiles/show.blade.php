
@extends('layouts.master')

@section('title')
Show Medical file
@endsection

@section('css')

@endsection


@section('content')
<div class="content">
    <div class="row">
        <div class="col-sm-7 col-6">
            <h4 class="page-title">Medical File</h4>
        </div>
    </div>
    <div class="card-box profile-header">
        <div class="row">
            <div class="col-md-12">
                <div class="profile-view">
                    <div class="profile-basic">
                        <div class="row">
                            <div class="col-md-5">
                                <div class="profile-info-left">
                                    <h3 class="user-name m-t-0 mb-0">{{ $medicalFile->patient->user->name }}</h3>
                                    <div class="staff-id">Patient insurance number : {{ $medicalFile->patient->insurance_number }}</div>
                                </div>
                            </div>
                            <div class="col-md-7">
                                <ul class="personal-info">
                                    <li>
                                        <span class="title">Phone:</span>
                                        <span class="text"><a href="#">{{ $medicalFile->patient->user->phone_number }}</a></span>
                                    </li>
                                    <li>
                                        <span class="title">Email:</span>
                                        <span class="text"><a href="#">{{ $medicalFile->patient->user->email }}</a></span>
                                    </li>
                                    <li>
                                        <span class="title">Birthday:</span>
                                        <span class="text">{{ $medicalFile->patient->dob }}</span>
                                    </li>
                                    <li>
                                        {{-- <span class="title">Gender:</span>
                                        <span class="text">Female</span> --}}
                                    </li>
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
            <li class="nav-item"><a class="nav-link active" href="#about-cont" data-toggle="tab">About</a></li>
        </ul>

        <div class="tab-content">
            <div class="tab-pane show active" id="about-cont">
    <div class="row">
        <div class="col-md-12">
            <div class="card-box">
                <h3 class="card-title">old diagnoses:</h3>
                <div class="experience-box">
                    <ul class="experience-list">
                        <li>
                            <div class="experience-user">
                                <div class="before-circle"></div>
                            </div>
                            <div class="experience-content">
                                <div class="timeline-content">
                                    <a href="#/" class="name">{{$medicalFile->diagnoses}}</a>
                                </div>
                            </div>
                        </li>
                    </ul>
                </div>
            </div>
            <div class="card-box mb-0">
                <h3 class="card-title">Recent prescription</h3>
                <div class="experience-box">
                    @foreach($prescriptions as $prescription)
                    <p class="card-text"><strong>Doctor:</strong> {{ $prescription->employee->user->name }} </p>
                    <p class="card-text"><strong>Appointment date: </strong>{{ $prescription->appointment->appointment_date }}</p>
                    <p class="card-text"><strong>Medication name: </strong>{{ $prescription->medications_names }}</p>
                    <p class="card-text"><strong>instruction:</strong>{{ $prescription->instructions }}</p>
                    <p class="card-text"><strong>details: </strong> {{ $prescription->details }}</p>
                    <br>
                @endforeach
                {{ $prescriptions->links()}}
                <hr>

                <!-- زر إضافة وصفة جديدة -->
                <a href="{{ route('prescriptions.create', ['patient_id' => $medicalFile->patient->id,'$doctorId' => Auth::id()]) }}" class="btn btn-primary btn-rounded"><i class="fa fa-plus"></i> Add new Prescriptions</a>
                <a href="{{ route('medicalFiles.edit', $medicalFile->id) }}" class="btn btn-primary " rel="prev">
                    <i class="fa fa-pencil m-r-5"></i> Edit
                </a>
                <a href="{{route('medicalFiles.index')}}" class="btn btn-secondary " rel="prev"> <i class="fa fa-arrow-left mr-2"></i>Back</a>
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
