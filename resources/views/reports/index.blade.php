@extends('layouts.master')

@section('title')
Reports
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
            <h4 class="page-title">Reports</h4>
        </div>
        <div class="col-sm-7 col-7 text-right m-b-30 d-flex justify-content-end align-items-center">
            <!-- زر  تصدير -->
            <a href="{{ route('reports.export', request()->all()) }}" class="btn btn-primary btn-rounded mr-3">
                <i class="fa fa-plus"></i> Export Table
            </a>
            <!-- أيقونة سلة المحذوفات -->
            <a href="{{route('reports.trash')}}">
                <i class="fa fa-trash-o" style="font-size:36px"></i>
            </a>
        </div>
    </div>
        {{-- for search --}}
    <form action="{{ route('reports.index') }}" method="GET">
        <div class="row filter-row">
            <div class="col-sm-6 col-md-3">
                <div class="form-group form-focus">
                    <label class="focus-label">Patient Name</label>
                    <input type="text" name="patient_name" value="{{ request()->input('patient_name') }}" class="form-control floating">
                </div>
            </div>
            <div class="col-sm-6 col-md-3">
                <div class="form-group form-focus">
                    <label class="focus-label">Doctor name</label>
                    <input type="text" name="doctor_name" value="{{ request()->input('doctor_name') }}" class="form-control floating">
                </div>
            </div>
        <div class="col-sm-6 col-md-3">
            <div class="form-group form-focus">
            <input type="date" name="appointment_date" class="form-control" value="{{ request()->input('appointment_date') }}">
        </div>
    </div>
            <div class="col-sm-6 col-md-3">
                <button type="submit" class="btn btn-success btn-block">
                    <i class="icon-android-search"></i> Search
                </button>
            </div>
        </div>
    </form>
    <div class="row">
        <div class="col-md-12">
            <div id="DataTables_Table_0_wrapper" class="dataTables_wrapper dt-bootstrap4 no-footer">
                <div class="row">
                    <div class="col-sm-12">
                        <role="row" class="even">
                            </role="row">
                            <table
                                class="table table-striped custom-table mb-0  no-footer"
                                id="DataTables_Table_0" role="grid" aria-describedby="DataTables_Table_0_info">
                                <thead>
                                    <tr role="row">
                                        <th class="sorting_asc" tabindex="0" aria-controls="DataTables_Table_0"
                                            rowspan="1" colspan="1" aria-sort="ascending"
                                            aria-label="#: activate to sort column descending" style="width: 62.125px;">
                                            #</th>
                                            <th class="sorting_asc" tabindex="0" aria-controls="DataTables_Table_0"
                                            rowspan="1" colspan="1" aria-sort="ascending"
                                            aria-label="#: activate to sort column descending" style="width: 62.125px;">
                                            Patient_id</th>
                                            <th class="sorting" tabindex="0" aria-controls="DataTables_Table_0"
                                            rowspan="1" colspan="1"
                                            aria-label="Department Name: activate to sort column ascending"
                                            style="width: 307.875px;">Patient Name</th>
                                        <th class="sorting" tabindex="0" aria-controls="DataTables_Table_0"
                                            rowspan="1" colspan="1"
                                            aria-label="Department Name: activate to sort column ascending"
                                            style="width: 307.875px;">Doctor Name</th>
                                        <th class="sorting" tabindex="0" aria-controls="DataTables_Table_0"
                                            rowspan="1" colspan="1"
                                            aria-label="Department Name: activate to sort column ascending"
                                            style="width: 307.875px;">Appointment</th>
                                            <th class="sorting" tabindex="0" aria-controls="DataTables_Table_0"
                                            rowspan="1" colspan="1"
                                            aria-label="Department Name: activate to sort column ascending"
                                            style="width: 307.875px;">Medications names</th>
                                            <th class="sorting" tabindex="0" aria-controls="DataTables_Table_0"
                                            rowspan="1" colspan="1"
                                            aria-label="Department Name: activate to sort column ascending"
                                            style="width: 307.875px;">instructions</th>
                                            <th class="sorting" tabindex="0" aria-controls="DataTables_Table_0"
                                            rowspan="1" colspan="1"
                                            aria-label="Department Name: activate to sort column ascending"
                                            style="width: 307.875px;">details</th>

                                        <th class="text-right sorting" tabindex="0" aria-controls="DataTables_Table_0"
                                            rowspan="1" colspan="1"
                                            aria-label="Action: activate to sort column ascending"
                                            style="width: 138.812px;">Created_at</th>
                                            <th class="text-right sorting" tabindex="0" aria-controls="DataTables_Table_0"
                                            rowspan="1" colspan="1"
                                            aria-label="Action: activate to sort column ascending"
                                            style="width: 138.812px;">Action</th>
                                    </tr>
                                </thead>
                                <tbody>

                                    @foreach ($reports as $report)
                                        <tr role="row" class="odd">
                                            <td>{{ $loop->iteration }}</td> <!-- Automatic counting -->
                                            <td>{{ $report->patient_id }}</td>
                                            <td>{{ $report->patient_name }}</td>
                                            <td>{{ $report->doctor_name }}</td>
                                            <td>{{ $report->appointment_date }}</td>
                                            <td>{{ $report->medications_names }}</td>
                                            <td>{{ $report->instructions }}</td>
                                            <td>{{ $report->details }}</td>
                                            <td>{{ $report->created_at }}</td>
                                            <td class="text-right">
                                                <div class="action-buttons" style="white-space: nowrap;">
                                                    <a class="btn btn-sm btn-primary"
                                                        href="{{ route('reports.exportOne', $report->id) }}"
                                                        style="display: inline-block; margin-right: 5px;">
                                                        <i class="fa fa-pencil m-r-5"></i> Export File
                                                    </a>
                                                    <a class="btn btn-sm btn-info"
                                                        href="{{ route('reports.show', $report->id) }}"
                                                        style="display: inline-block; margin-right: 5px;">
                                                        <i class="fa fa-eye m-r-5"></i> Show
                                                    </a>
                                                    <form action="{{ route('reports.destroy', $report->id) }}"
                                                        method="POST" style="display: inline-block; margin: 0;">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit" class="btn btn-danger btn-sm"
                                                            style="padding: 2px 6px; font-size: 0.9rem; display: inline-block;">
                                                            <i class="fa fa-trash-o"
                                                                style="font-size: 0.8rem; margin-right: 3px;"></i> Trash
                                                        </button>
                                                    </form>
                                                </div>
                                            </td>
                                    @endforeach
                                    </tr>
                                </tbody>
                            </table>
                    </div>
                </div>

                {{ $reports->links()}}

                <div class="m-t-20 text-left">
                    <a href="{{ route('reports.index') }}" class="btn btn-secondary mb-3" rel="prev">
                        <i class="fa fa-arrow-left mr-2"></i> Back
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>
</div>

@endsection
