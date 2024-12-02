@extends('layouts.master')

@section('title')

@endsection

@section('css')

@endsection


@section('content')
<div class="content">

    <div class="d-flex justify-content-center align-items-center" style="min-height: 100vh;">
        <div class="card shadow-lg" style="width: 50rem; max-width: 90%; border-radius: 15px; padding: 20px;">
            <div class="card-body text-center">                
                <div>
                    <h3 class="card-title mb-3" style="font-weight: bold; color: #333;"> Prescription</h3>
                    <h2 class="card-title mb-3" style="font-weight: bold; color: #333;">
                    Doctor: {{ $prescription->employee->user->name }} 
                    </h2>
                    <h2 class="card-title mb-3" style="font-weight: bold; color: #333;">
                    Patient: {{ $prescription->Appointment->patient->user->name }}
                    </h2>

                    <p class="card-text mb-4" style="font-size: 1.1rem; color: #555;">
                        {{ $prescription->appointment->appointment_date }}
                    </p>
                    <p class="card-text mb-4" style="font-size: 1.1rem; color: #555;">
                    Medication Names: {{ $prescription->medications_names }}
                    </p>
                    <p class="card-text mb-4" style="font-size: 1.1rem; color: #555;">
                    Instructions: {{ $prescription->instructions }}
                    </p>
                    <p class="card-text mb-4" style="font-size: 1.1rem; color: #555;">
                    Details: {{ $prescription->details }}
                    </p>
                </div>
                <a href="{{route('prescriptions.index')}}" class="btn btn-secondary mb-3" rel="prev">
                    <i class="fa fa-arrow-left mr-2"></i> Back
                </a>
                <a href="{{ route('prescriptions.edit', $prescription->id) }}" class="btn btn-primary mb-3" rel="prev">
                    <i class="fa fa-pencil m-r-5"></i> Edit
                </a>

            </div>
        </div>
    </div>
</div>
@endsection



@section('scripts')
    
@endsection