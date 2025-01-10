@extends('layouts.master')

@section('title')
error
@endsection

@section('css')

@endsection


@section('content')

    <div class="main-wrapper error-wrapper">
        <div class="error-box">
            <h1>403</h1>
            <h3><i class="fa fa-warning"></i> Oops! Page not found!</h3>
            <p>The page you requested is not authorized to access.</p>
            <a href="javascript:history.back()" class="btn btn-primary go-home">Go to Home</a>
        </div>

@endsection



@section('scripts')

@endsection
