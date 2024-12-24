@extends('layouts.master')

@section('title')
Edit prescription
@endsection

@section('css')

@endsection


@section('content')
<div class="content">
    <div class="row">
        <div class="col-lg-8 offset-lg-2">
            <h4 class="page-title">Edit prescription</h4>
        </div>
    </div>
    <div class="row">
        <div class="col-lg-8 offset-lg-2">
            <form action="{{route('prescriptions.update',$prescription->id)}}"  method="post">
                @csrf
                @method('PUT')
                <div class="form-group">
                    <label>Medications Name</label>
                    <input class="form-control" type="text" value="{{$prescription->medications_names}}" name="medications_names" >
                </div>
                <div class="form-group">
                    <label>Instructions</label>
                    <textarea name="instructions" cols="30" rows="4" class="form-control">{{$prescription->instructions}}</textarea>
                </div>
                <div class="form-group">
                    <label>Details</label>
                    <textarea name="details" cols="30" rows="4" class="form-control">{{$prescription->details}}</textarea>
                </div>
                
                <div class="m-t-20 text-center">
                    <button class="btn btn-primary submit-btn">Update prescription</button>
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