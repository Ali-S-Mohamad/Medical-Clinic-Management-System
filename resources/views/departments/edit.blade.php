@extends('layouts.master')

@section('title')
@endsection

@section('css')
@endsection


@section('content')
    <div class="content">
        <a href="javascript:history.back()" class="btn btn-secondary mb-3" rel="prev">
            <i class="fa fa-arrow-left mr-2"></i> Back
        </a>
        <div class="row">
            <div class="col-lg-8 offset-lg-2">
                <h4 class="page-title">Edit Department</h4>
            </div>
        </div>
        <div class="row">
            <div class="col-lg-8 offset-lg-2">
                <form action="{{ route('departments.update', $department->id) }}" method="POST">
                    @csrf
                    @method('PUT')
                    <div class="form-group">
                        <label>Department Name</label>
                        <input class="form-control" name="name" type="text" value="{{ $department->name }}">
                    </div>
                    <div class="form-group">
                        <label>Description</label>
                        <textarea cols="30" name="description" rows="4" class="form-control">{{ $department->description }}</textarea>
                    </div>
                    <div class="form-group">    
                        <label class="display-block">Department Status</label>
                        <div class="form-check form-check-inline">
                            <input class="form-check-input" type="radio" name="status" value="active"
                                {{ $department->status == 1 ? 'checked' : '' }}>
                            <label class="form-check-label" for="product_active">Active</label>
                        </div>
                        <div class="form-check form-check-inline">
                            <input class="form-check-input" type="radio" name="status" value="inactive"
                                {{ $department->status == 0 ? 'checked' : '' }}>
                            <label class="form-check-label" for="product_inactive"> Inactive </label>
                        </div>
                    </div>
                    <div class="m-t-20 text-center">
                        <button class="btn btn-primary submit-btn">Save Department</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection


@section('scripts')
@endsection
