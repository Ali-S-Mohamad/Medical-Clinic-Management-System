@extends('layouts.master')

@section('title')
    Prescriptions
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
        <div class="col-sm-5 col-5">
            <h4 class="page-title">Prescriptions</h4>
        </div>
        <div class="col-sm-7 col-7 text-right m-b-30 d-flex justify-content-end align-items-center">
            <!-- زر إضافة الوصفة -->
            <a href="{{ route('prescriptions.create') }}" class="btn btn-primary btn-rounded mr-3">
                <i class="fa fa-plus"></i> Add Prescriptions
            </a>
            <!-- أيقونة سلة المحذوفات -->
            <a href="{{route('prescriptions.trash')}}">
                <i class="fa fa-trash-o" style="font-size:36px"></i>
            </a>
        </div>
    </div>
    {{-- for search --}}
    <form id="filterForm" action="{{ route('prescriptions.index') }}" method="GET">
    <div class="row filter-row">
        <div class="col-sm-6 col-md-3">
            <div class="form-group form-focus">
                <label class="focus-label">Patient Name</label>
                <input type="text" name="search_name" class="form-control floating">
            </div>
        </div>
        <div class="col-sm-6 col-md-3">
            <div class="form-group form-focus">
                <label class="focus-label">Medications Name</label>
                <input type="text" name="medications_names" class="form-control floating">
            </div>
        </div>
        <div class="col-sm-6 col-md-3">
            <button type="submit" class="btn btn-success btn-block">
                <i class="icon-android-search"></i> Search
            </button>
        </div>
    </div>
</form>
<div id="prescriptionsTableContainer">
    @if ($prescriptions->isEmpty())
        <h3>No prescriptions .. please add one</h3>
    @else
        @include('prescriptions.partials.table', ['prescriptions' => $prescriptions])
    @endif
</div>
{{ $prescriptions->links() }}
    </div>

@endsection


@section('scripts')
<script>
    $(document).ready(function() {
        $('#filterForm').on('submit', function(e) {
            e.preventDefault();

            var filters = $(this).serialize(); 

            $.ajax({
                url: "{{ route('prescriptions.index') }}", 
                method: "GET",
                data: filters,
                beforeSend: function() {
                    $('#prescriptionsTableContainer').html('<p>Loading...</p>');
                },
                success: function(response) {
                    $('#prescriptionsTableContainer').html(response); 
                },
                error: function(xhr, status, error) {
                    console.error('Error:', error);
                    alert('An error occurred while fetching data.');
                }
            });
        });
    });
</script>

@endsection
