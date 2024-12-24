@extends('layouts.master')

@section('title')
@endsection

@section('css')
@endsection


@section('content')
<div class="container">
    <h1 class="my-4">Create Medical File</h1>

    @if ($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('medicalFiles.store') }}" method="POST">
        @csrf
        <div class="form-group">
            <label for="patient_name">اسم المريض</label>
            <input type="text" id="patient_name" name="patient_name" class="form-control" placeholder="ابحث عن اسم المريض" required>
        </div>

        <!-- حقل إدخال التشخيصات -->
        <div class="form-group">
            <label for="diagnoses">التشخيصات</label>
            <textarea id="diagnoses" name="diagnoses" class="form-control" rows="4" required></textarea>
        </div>

        <div class="d-flex justify-content-start align-items-center gap-2 mt-3">
            <button type="submit" class="btn btn-primary">Create Medical File</button>
            <a href="{{route('medicalFiles.index')}}" class="btn btn-secondary ml-2" rel="prev">
                <i class="fa fa-arrow-left mr-2"></i> Back
            </a>
        </div>
        
    </form>
  
</div>
@endsection


@section('scripts')
@endsection
