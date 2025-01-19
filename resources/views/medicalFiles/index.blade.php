@extends('layouts.master')

@section('title')
 Medical files
@endsection

@section('css')
@endsection


@section('content')
    @if (session('error'))
        <div class="alert alert-danger fade show" role="alert" style="animation: fadeOut 3s forwards;">
            {{ session('error') }}
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
    @endif
    @if (session('success'))
        <div class="alert alert-success fade show" role="alert" style="animation: fadeOut 3s forwards;">
            {{ session('success') }}
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
    @endif
    <div class="content">
        <div class="row">
            <div class="col-sm-5 col-5">
                <h4 class="page-title">Medical Files</h4>
            </div>
            <div class="col-sm-7 col-7 text-right m-b-30 d-flex justify-content-end align-items-center">

                <a href="{{ route('medicalFiles.create') }}" class="btn btn-primary btn-rounded mr-3">
                    <i class="fa fa-plus"></i> Add Medical File
                </a>
                <!-- Recycle bin icon-->
                <a href="{{ route('medicalFiles.trash') }}">
                    <i class="fa fa-trash-o" style="font-size:36px"></i>
                </a>
            </div>
        </div>
        {{-- for search --}}
        <form action="{{ route('medicalFiles.index') }}" method="GET" id="filterForm">
    <div class="row filter-row">
        <div class="col-sm-6 col-md-3">
            <div class="form-group form-focus">
                <label class="focus-label">Patient Name</label>
                <input type="text" name="search_name" class="form-control floating">
            </div>
        </div>
        <div class="col-sm-6 col-md-3">
            <div class="form-group form-focus">
                <label class="focus-label">Patient Insurance Number</label>
                <input type="text" name="search_insurance" class="form-control floating">
            </div>
        </div>
        <div class="col-sm-6 col-md-3">
            <button type="submit" class="btn btn-success btn-block">
                <i class="icon-android-search"></i> Search
            </button>
        </div>
    </div>
</form>
@if ($medicalFiles->isEmpty())
    <h3>No medicalFiles .. please add one</h3>
@else
    @include('medicalFiles.partials.table', ['medicalFiles' => $medicalFiles])
@endif
{{ $medicalFiles->links() }}
    </div>

@endsection

@section('scripts')
<script>
   $(document).ready(function() {
    $('#filterForm').on('submit', function(e) {
        e.preventDefault(); // Prevent default form submission

        var filters = $(this).serialize(); // Collect input data

        $.ajax({
            url: "{{ route('medicalFiles.index') }}", // Link to request results
            method: "GET",
            data: filters,
            beforeSend: function() {
                $('#medicalFilesTableContainer').html('<p>Loading...</p>'); // Show loading indicator
            },
            success: function(response) {
                // Update the table with the content of the response
                $('#medicalFilesTableContainer').html(response.html);
            },
            error: function(xhr, status, error) {
                console.error('Error fetching medical files:', error);
                alert('Failed to fetch medical files.');
            }
        });
    });
});
</script>

@endsection
