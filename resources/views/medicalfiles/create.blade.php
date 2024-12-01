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
            <label for="patient_id">Patient ID</label>
            <input type="number" id="patient_id" name="patient_id" class="form-control" placeholder="Enter Patient ID" required>
        </div>

        <button type="submit" class="btn btn-primary">Create Medical File</button>
    </form>
</div>
@endsection


@section('scripts')
@endsection
