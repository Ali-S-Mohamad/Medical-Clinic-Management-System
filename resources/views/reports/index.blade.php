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
             <!-- زر  تصدير -->
             <a href="{{ route('reports.export') }}" class="btn btn-primary btn-rounded mr-3">
                <i class="fa fa-plus"></i> Export Table
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
                                    </tr>
                                </thead>
                                <tbody>
                                
                                    @foreach ($reports as $report) 
                                        <tr role="row" class="odd">
                                            <td>{{ $loop->iteration }}</td> <!-- العد التلقائي -->
                                            <td>{{ $report->patient_id }}</td> 
                                            <td>{{ $report->patient_name }}</td>
                                            <td>{{ $report->doctor_name }}</td>
                                            <td>{{ $report->appointment_date }}</td>
                                            <td>{{ $report->medications_names }}</td>
                                            <td>{{ $report->instructions }}</td>
                                            <td>{{ $report->details }}</td>
                                            <td>{{ $report->created_at }}</td>
                                    @endforeach
                                    </tr>
                                </tbody>
                            </table>
                    </div>
                </div>

                {{ $reports->links()}} 
            </div>
        </div>
    </div>
</div>
</div>

@endsection
