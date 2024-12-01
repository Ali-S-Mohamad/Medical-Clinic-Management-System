@extends('layouts.master')

@section('title')
    Edit Medical File
@endsection

@section('css')
@endsection

@section('content')
<div class="container">
    <h1 class="my-4">Edit Medical File</h1>

    <!-- عرض الأخطاء إن وجدت -->
    @if ($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('medicalFiles.update', $medicalFile->id) }}" method="POST">
        @csrf
        @method('PUT') 

        <div class="form-group">
            <label for="patient_id">Patient ID</label>
            <input type="number" id="patient_id" name="patient_id" class="form-control" 
                   value="{{ $medicalFile->patient_id }}" >
        </div>

        <button type="submit" class="btn btn-success">Update Medical File</button>
    </form>
</div>
@endsection

@section('scripts')
@endsection
