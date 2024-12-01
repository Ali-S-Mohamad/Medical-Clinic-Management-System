@extends('layouts.master')

@section('title')

@endsection

@section('css')

@endsection


@section('content')
<div class="content">
    <div class="row">
        <div class="col-sm-4 col-3">
            <h4 class="page-title">Doctors</h4>
        </div>
        <div class="col-sm-8 col-9 text-right m-b-20">
            <a href="add-doctor.html" class="btn btn-primary btn-rounded float-right"><i class="fa fa-plus"></i> Add Doctor</a>
        </div>
    </div>
    @php
        $doctors = App\Models\User::role('doctor')->get();
    @endphp
    @foreach ($doctors as $doctor )

    <div class="row doctor-grid">
        <div class="col-md-4 col-sm-4  col-lg-3">
            <div class="profile-widget">
                <div class="doctor-img">
                    <a class="avatar" href="profile.html"><img alt="" src="assets/img/doctor-thumb-03.jpg"></a>
                </div>
                <div class="dropdown profile-action">
                    <a href="#" class="action-icon dropdown-toggle" data-toggle="dropdown" aria-expanded="false"><i class="fa fa-ellipsis-v"></i></a>
                    <div class="dropdown-menu dropdown-menu-right">
                        <a class="dropdown-item" href="{{route('doctors.edit')}}"><i class="fa fa-pencil m-r-5"></i> Edit</a>
                        <a class="dropdown-item" href="#" data-toggle="modal" data-target="#delete_doctor"><i class="fa fa-trash-o m-r-5"></i> Delete</a>
                    </div>
                </div>
                <h4 class="doctor-name text-ellipsis"><a href="profile.html">{{$doctor->name}}</a></h4>
                <div class="doc-prof">Gynecologist</div>
                <div class="user-country">
                    <i class="fa fa-map-marker"></i> United States, San Francisco
                </div>
            </div>
        </div>
    </div>
    @endforeach
    <div class="row">
        <div class="col-sm-12">
            <div class="see-all">
                <a class="see-all-btn" href="javascript:void(0);">Load More</a>
            </div>
        </div>
    </div>
</div>
@endsection



@section('scripts')

@endsection
