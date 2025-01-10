@extends('layouts.master')

@section('title')
Rating Details
@endsection

@section('css')
@endsection


@section('content')
    <div class="content">

        <div class="d-flex justify-content-center align-items-center" style="min-height: 100vh;">
            <div class="card shadow-lg" style="width: 50rem; max-width: 90%; border-radius: 15px; padding: 20px;">
                <div class="card-body text-center">
                    
                    <div>
                        <h3 class="card-title mb-3" style="font-weight: bold; color: #333; font-size: 1.2rem;">
                            Doctor : {{ $rating->doctor->user->name }}
                        </h3>
                         
                        <h2 class="card-title mb-3" style="font-weight: bold; color: #333;">
                            Patient : {{ $rating->patient->user->name }}
                        </h2>
                        <p class="card-text mb-4" style="font-size: 1.1rem;  color: {{ $rating->doctor_rate < 6 ? 'orange' : ' #4caa59;' }};">
                            Rate : {{ $rating->doctor_rate }} / 10
                        </p>
                        <p class="card-text mb-4" style="font-size: 1.1rem; color: #555;">
                            @if($rating->details )
                               Details : <br> {{ $rating->details  }}
                            @endif
                        </p> 
                        <br>
                        <p class="card-text mb-4" style="font-size: 1.0rem; color: #555;">
                               Added at: <br> {{ $rating->created_at->format('Y-m-d') }}     
                        </p>
                        
                    </div>
                    <a href="javascript:history.back()" class="btn btn-secondary mb-3" rel="prev">
                        <i class="fa fa-arrow-left mr-2"></i> Back
                    </a>

                </div>
            </div>
        </div>
    </div>
@endsection



@section('scripts')
 
@endsection
