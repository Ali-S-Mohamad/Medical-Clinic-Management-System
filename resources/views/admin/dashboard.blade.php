@extends('layouts.master')

@section('title')
Dashboard
@endsection

@section('css')
  <style> 
     .dash-widget { cursor: pointer; }
  </style>
@endsection


@section('content')
 
<div class="content">

{{-- Cards Statistics --}}
<div class="row">

    <div class="col-md-6 col-sm-6 col-lg-6 col-xl-3">
        <div class="dash-widget">
            <a href="{{route('doctors.index')}}">
                <span class="dash-widget-bg1"><i class="fa fa-stethoscope" aria-hidden="true"></i></span>
                <div class="dash-widget-info text-right">
                    <h3>{{$statistics['totalDoctors']}}</h3>
                    <span class="widget-title1">Doctors <i class="fa fa-check" aria-hidden="true"></i></span>
                </div>
            </a>
        </div>
    </div>

    <div class="col-md-6 col-sm-6 col-lg-6 col-xl-3">
        <div class="dash-widget">
            <a href="{{route('patients.index')}}">
            <span class="dash-widget-bg2"><i class="fa fa-user-o"></i></span>
            <div class="dash-widget-info text-right">
                <h3>{{$statistics ['totalPatients']}}</h3>
                <span class="widget-title2">Patients <i class="fa fa-check" aria-hidden="true"></i></span>
            </div>
            </a>
        </div>
    </div>
    <div class="col-md-6 col-sm-6 col-lg-6 col-xl-3">
        <div class="dash-widget">
            <a href="{{route('employees.index')}}">
            <span class="dash-widget-bg3"><i class="fa fa-user-md" aria-hidden="true"></i></span>
            <div class="dash-widget-info text-right">
                <h3>{{$statistics ['totalemployees']}}</h3>
                <span class="widget-title3">Employees <i class="fa fa-check" aria-hidden="true"></i></span>
            </div>
            </a>
        </div>
    </div>
    <div class="col-md-6 col-sm-6 col-lg-6 col-xl-3">
        <div class="dash-widget">
            <span class="dash-widget-bg1"><i class="fa fa-stethoscope" aria-hidden="true"></i></span>
            <div class="dash-widget-info text-right">
                <h3>####</h3>
                <span class="widget-title1">unKnown <i class="fa fa-check" aria-hidden="true"></i></span>
            </div>
        </div>
    </div>
    <div class="col-md-6 col-sm-6 col-lg-6 col-xl-4">
        <div class="dash-widget">
            <a href="{{route('departments.index')}}">
            <span class="dash-widget-bg4"><i class="fa fa-heartbeat" aria-hidden="true"></i></span>
            <div class="dash-widget-info text-right">
                <h3>{{$statistics ['active_departments']}}</h3>
                <span class="widget-title4">Active dpartmnts <i class="fa fa-check" aria-hidden="true"></i></span>
            </div>
            </a>
        </div>
    </div>
    <div class="col-md-6 col-sm-6 col-lg-6 col-xl-4">
        <div class="dash-widget">
            <span class="dash-widget-bg2"><i class="fa fa-user-o"></i></span>
            <div class="dash-widget-info text-right">
                <h3> ### </h3>
                <span class="widget-title2">Active appointmnts <i class="fa fa-check" aria-hidden="true"></i></span>
            </div>
        </div>
    </div>

    <div class="col-md-6 col-sm-6 col-lg-6 col-xl-4">
        <div class="dash-widget">
            <a href="{{route('departments.index')}}">
            <span class="dash-widget-bg3"><i class="fa fa-heartbeat" aria-hidden="true"></i></span>
            <div class="dash-widget-info text-right">
                <h3>{{$statistics ['inactive_departments']}}</h3>
                <span class="widget-title3">Idle dpartmnts <i class="fa fa-check" aria-hidden="true"></i></span>
            </div>
            </a>
        </div>
    </div>

    
</div>

{{-- Doctor Ratings --}}
@php 
$doctors=$statistics ['doctors']
@endphp 

<br><br>

<div class="row"> 
    <div class="col-12 col-md-6 col-lg-6 col-xl-6">
        <div class="hospital-barchart">
            <h4 class="card-title d-inline-block"> Doctor Avarage Ratings </h4>
        </div>
        <a href="{{route('ratings.index')}}">
        <div class="bar-chart">
            <div class="chart clearfix">
                @foreach ($doctors as $doctor) 
                    @if(isset($doctor->employee->avg_ratings))
                            <div class="item">
                                <div class="bar">   
                                    <span class="percent" >{{ ($doctor->employee->avg_ratings)*10 }}%</span>
                                    <div class="item-progress" data-percent="{{$doctor->employee->avg_ratings*10}}" >
                                       <span class="title" >{{ $doctor->name }} </span>
                                    </div>
                                </div>
                            </div>               
                    @endif
                @endforeach
            </div>      
        </div>
        </a>
    </div>    {{-- bar section / Ratings--}}  
</div> {{-- row --}}

 
<canvas id="linegraph" style="display: none;" ></canvas>
<canvas id="bargraph"  style="display: none;"> </canvas>
 

</div>  {{-- div content --}}
 
@endsection



@section('scripts')

@endsection