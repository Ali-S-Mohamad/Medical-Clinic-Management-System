@extends('layouts.master')

@section('title')
Reports
@endsection

@section('css')

@endsection


@section('content')
<div class="content">
    <div class="row">
        <div class="col-sm-5 col-5">
            <h4 class="page-title">Reports</h4>
        </div>
        <div class="col-sm-7 col-7 text-right m-b-30 d-flex justify-content-end align-items-center">           
            <!-- أيقونة سلة المحذوفات -->
            <a href="">
                <i class="fa fa-trash-o" style="font-size:36px"></i>
            </a>
        </div>
    </div>
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
                                        <th class="sorting" tabindex="0" aria-controls="DataTables_Table_0"
                                            rowspan="1" colspan="1"
                                            aria-label="Department Name: activate to sort column ascending"
                                            style="width: 307.875px;">Doctor Name</th>
                                            <th class="sorting" tabindex="0" aria-controls="DataTables_Table_0"
                                            rowspan="1" colspan="1"
                                            aria-label="Department Name: activate to sort column ascending"
                                            style="width: 307.875px;">Patient Name</th>
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
                                            style="width: 138.812px;">Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($reports as $report)
                                        <tr role="row" class="odd">
                                            <td>{{ $loop->iteration }}</td> <!-- العد التلقائي -->
                                            <td>{{ $report->patient_name }}</td>
                                            <td>{{ $report->doctor_name }}</td>
                                            <td>{{ $report->appointment_date }}</td>
                                            <td>{{ $report->created_at }}</td>
                                            <td>{{ $report->instructions }}</td>
                                            <td>{{ $report->details }}</td>
                                            <td class="text-right">
                                                <div class="action-buttons" style="white-space: nowrap;">
                                                    <a class="btn btn-sm btn-primary"
                                                        href=""
                                                        style="display: inline-block; margin-right: 5px;">
                                                        <i class="fa fa-pencil m-r-5"></i> Edit
                                                    </a>
                                                    <a class="btn btn-sm btn-info"
                                                        href=""
                                                        style="display: inline-block; margin-right: 5px;">
                                                        <i class="fa fa-eye m-r-5"></i> Show
                                                    </a>
                                                    <form action=""
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
{{-- 
                {{ $prescriptions->links()}} --}}
            </div>
        </div>
    </div>
</div>
</div>

@endsection