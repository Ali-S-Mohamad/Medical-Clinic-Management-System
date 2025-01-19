@extends('layouts.master')

@section('title')
    Appointments
@endsection

@section('css')
@endsection

@section('content')
@if(session('error'))
    <div class="alert alert-danger fade show" role="alert" style="animation: fadeOut 3s forwards;">
        {{ session('error') }}
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
    </div>
@endif
@if(session('success'))
    <div class="alert alert-success fade show" role="alert" style="animation: fadeOut 3s forwards;">
        {{ session('success') }}
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
    </div>
@endif
<div class="content">
    <div class="row">
        <div class="col-sm-4 col-3">
            <h4 class="page-title">Appointments</h4>
        </div>
        <div class="col-sm-8 col-9 text-right m-b-20">
            <a href="{{ route('appointments.create') }}" class="btn btn-primary btn-rounded float-right">
                <i class="fa fa-plus"></i> Add Appointment
            </a>
        </div>
    </div>
    <div class="row">
        <div class="col-md-12">
            <div class="table-responsive">
                <table class="table table-striped custom-table">
                    <thead>
                        <tr>
                            <th class="text-center">Appointment ID</th>
                            <th class="text-center">Patient Name</th>
                            <th class="text-center">Doctor Name</th>
                            <th class="text-center">Appointment Date</th>
                            <th class="text-center">Status</th>
                            <th class="text-center">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($appointments as $appointment)
                            @include('appointments.partials.appointment_row', ['appointment' => $appointment])
                        @endforeach
                    </tbody>
                </table>

                {{ $appointments->links() }}
                <a href="javascript:history.back()" class="btn btn-secondary mb-3" rel="prev"> 
                    <i class="fa fa-arrow-left mr-2"></i>Back
                </a>
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script>
$(document).on('submit', '.update-status-form', function(e) {
    e.preventDefault();

    let form = $(this);
    let actionUrl = form.attr('action');
    let formData = form.serialize();

    $.ajax({
        url: actionUrl,
        type: 'PATCH',
        data: formData,
        success: function(response) {
            if (response.success) {
                alert(response.message || 'Status updated successfully!');
                
                // Update only the specified row
                $('#appointment-row-' + response.appointment.id).replaceWith(response.html);

                //Move to the index page after success
                window.location.href = "{{ route('appointments.index') }}";
            } else {
                alert(response.message || 'Something went wrong.');
            }
        },
        error: function(xhr) {
            let errors = xhr.responseJSON?.errors || {};
            alert(errors[Object.keys(errors)[0]] || 'Error updating status.');
        }
    });
});
</script>
@endsection
