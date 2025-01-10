@extends('layouts.master')

@section('title')
Ratings
@endsection

@section('css')
    <style>  
        tbody tr:hover { cursor: pointer; } 
        .table td.details-cell { 
            max-width: 75px; 
            white-space: nowrap; /* لمنع النص من الانتقال إلى سطر جديد */ 
            overflow: hidden; /* لإخفاء النص الزائد */ 
            text-overflow: ellipsis; /* لإضافة النقاط الثلاثة (...) عند تقليص النص */ }

    </style>
@endsection


@section('content')
  <div class="content">
        <div class="row">
            <div class="col-sm-5 col-5">
                <h4 class="page-title">Ratings</h4>
            </div>
        </div>
        <div class="row filter-row">
            <div class="col-sm-6 col-md-3">
                <div class="form-group form-focus">
                    <label class="focus-label">Rate ID</label>
                    <input type="text" class="form-control floating">
                </div>
            </div>
            <div class="col-sm-6 col-md-3">
                <div class="form-group form-focus">
                    <label class="focus-label">Doctor Name</label>
                    <input type="text" class="form-control floating">
                </div>
            </div>   
            <div class="col-sm-6 col-md-3">
                <div class="form-group form-focus select-focus">
                    <label class="focus-label">Rate</label>
                    <select class="select floating">
                        <option>Select Range</option>
                        <option> 0 ..  4 </option>
                        <option> 4 ..  6 </option>
                        <option> 6 ..  8 </option>
                        <option> 8 .. 10 </option>
                         
                    </select>
                </div>
            </div>
            <div class="col-sm-6 col-md-3">
                <a href="#" class="btn btn-success btn-block"> Search </a>
            </div>
        </div> 

        @if ($ratings->isEmpty())
        <h3>No Ratings added</h3>
        @else
        <div class="row">
            <div class="col-md-12">
                <div class="table-responsive">
                    <table class="table table-striped custom-table">
                        <thead>
                            <tr>
                                <th> ID</th>
                                <th > Doctor Name</th>
                                <th > patient Name</th>
                                <th style="max-width:60px;"> Rate (out of 10)</th>
                                <th style="max-width:60px;"> Details</th>
                                @if (Auth::check()  && Auth::user()->hasRole('Admin'))
                                <th class="text-center"> Action</th>
                                @endif
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($ratings as $rating)
                                <tr role="row" onclick="window.location='{{ route('ratings.show', $rating->id) }}' " class="odd">
                                    <td>{{ $rating->id }}</td>
                                    <td>  
                                         <h2>{{ $rating->doctor->user->name }}</h2> 
                                    </td>                          
                                    <td> {{ $rating->patient->user->name }}</td>
                                    <td> {{ $rating->doctor_rate }}</td>
                                    <td class="details-cell"> {{ $rating->details }} </td>
                                   
                                    <td class="text-right">
                                        <div class="action-buttons" style="white-space: nowrap;">
                                            @if (Auth::check()  && Auth::user()->hasRole('Admin'))
                                                <form action="{{ route('ratings.destroy', $rating->id) }}"
                                                    method="POST" style="display: inline-block; margin: 0;"
                                                    onclick="event.stopPropagation();" >
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="btn btn-danger btn-sm"
                                                        style="padding: 2px 6px; font-size: 0.9rem; display: inline-block;">
                                                        <i class="fa fa-trash-o"
                                                            style="font-size: 0.8rem; margin-right: 3px;"></i> Delete
                                                    </button>
                                                </form>
                                            @endif
                                        </div>
                                    </td>

                                </tr>
                            @endforeach

                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        @endif
        {{ $ratings->links()}}
  </div>
@endsection



@section('scripts')
    
@endsection