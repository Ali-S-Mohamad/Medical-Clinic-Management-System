@extends('layouts.master')

@section('title')
    Edit Medical File
@endsection

@section('css')
@endsection

@section('content')
<div class="container">
    <h1 class="my-4">Edit Medical File</h1>

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
            <label for="diagnoses">Diagnoses</label>
            <textarea id="diagnoses" name="diagnoses" class="form-control" rows="4" required>{{$medicalFile->diagnoses}}</textarea>
        </div>

        <div class="d-flex justify-content-start align-items-center gap-2 mt-3">
            <a href="{{route('medicalFiles.index')}}" class="btn btn-secondary mr-2" rel="prev">
                <i class="fa fa-arrow-left mr-2"></i> Back
            </a>
            <button type="submit" class="btn btn-primary">update Medical File</button>
        </div>

    </form>

</div>
@endsection

@section('scripts')
@endsection
