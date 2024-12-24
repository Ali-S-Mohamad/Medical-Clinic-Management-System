@extends('layouts.master')

@section('title')
Add prescription
@endsection

@section('css')

@endsection


@section('content')
<div class="content">
    <div class="row">
        <div class="col-lg-8 offset-lg-2">
            <h4 class="page-title">Add prescription</h4>
        </div>
    </div>
    <div class="row">
        <div class="col-lg-8 offset-lg-2">
            <form action="{{route('prescriptions.store')}}"  method="post">
                 @csrf
                 <div class="form-group">
                    <label class="nb-2" for="appointment_id">Choose Patient: </label>
                    <select class="form-control" name="appointment_id" id="appointment_id" required>
                        @foreach($appointments as $appointment)
                        <option value="" disabled selected hidden>select Patient</option>
                            <option value="{{ $appointment->id }}">
                                {{ $appointment->patient->user->name }} - {{ $appointment->appointment_date }}
                            </option>
                        @endforeach
                    </select>
                </div>
                <div class="form-group">
                    <label>Medications Name</label>
                    <input class="form-control" type="text" name="medications_names" >
                </div>
                <div class="form-group">
                    <label>Instructions</label>
                    <textarea name="instructions" cols="30" rows="4" class="form-control"></textarea>
                </div>
                <div class="form-group">
                    <label>Details</label>
                    <textarea name="details" cols="30" rows="4" class="form-control"></textarea>
                </div>
                
                <div class="m-t-20 text-center">
                    <button class="btn btn-primary submit-btn">Create prescription</button>
                </div>
                <div class="m-t-20 text-center">
                <a href="{{route('prescriptions.index')}}" class="btn btn-secondary mb-3" rel="prev">
                    <i class="fa fa-arrow-left mr-2"></i> Back
                </a>
                </div>
               
                
                </form>
              </div>
             </div>
            </div>
@endsection



@section('scripts')
    
@endsection