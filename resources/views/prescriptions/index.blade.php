@extends('layouts.master')

@section('title')

@endsection

@section('css')

@endsection


@section('content')
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
            <a href="">
                <i class="fa fa-trash-o" style="font-size:36px"></i>
            </a>
        </div>
    </div>
    <div class="row">
        <div class="col-md-12">
            <div id="DataTables_Table_0_wrapper" class="dataTables_wrapper dt-bootstrap4 no-footer">
                <div class="row">
                    <div class="col-sm-12 col-md-6">
                        <div class="dataTables_length" id="DataTables_Table_0_length"><label>Show <select
                                    name="DataTables_Table_0_length" aria-controls="DataTables_Table_0"
                                    class="custom-select custom-select-sm form-control form-control-sm">
                                    <option value="10">10</option>
                                    <option value="25">25</option>
                                    <option value="50">50</option>
                                    <option value="100">100</option>
                                </select> entries</label></div>
                    </div>
                    <div class="col-sm-12 col-md-6"></div>
                </div>
                <div class="row">
                    <div class="col-sm-12">
                        <role="row" class="even">
                            </role="row"><table
                                class="table table-striped custom-table mb-0 datatable dataTable no-footer"
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
                                    @foreach ($prescriptions as $prescription)
                                        <tr role="row" class="odd">
                                            <td>{{ $loop->iteration }}</td> <!-- العد التلقائي -->
                                            <td>{{ $prescription->employee->user->name }}</td>
                                            <td>{{ $prescription->appointment->appointment_date }}</td>
                                            <td>{{ $prescription->medications_names }}</td>
                                            <td>{{ $prescription->instructions }}</td>
                                            <td>{{ $prescription->details }}</td>
                                            <td class="text-right">
                                                <div class="dropdown dropdown-action">
                                                    <a href="#" class="action-icon dropdown-toggle"
                                                        data-toggle="dropdown" aria-expanded="false">
                                                        <i class="fa fa-ellipsis-v"></i>
                                                    </a>
                                                    <div class="dropdown-menu dropdown-menu-right">
                                                        <a class="dropdown-item"
                                                            href="{{ route('prescriptions.edit', $prescription->id) }}">
                                                            <i class="fa fa-pencil m-r-5"></i> Edit
                                                        </a>
                                                        <a class="dropdown-item"
                                                            href="{{ route('prescriptions.show', $prescription->id) }}">
                                                            <i class="fa fa-eye m-r-5"></i> Show
                                                        </a>
                                                        <form
                                                            action="{{ route('prescriptions.destroy', $prescription->id) }}"
                                                            method="POST" class="dropdown-item p-0 m-0">
                                                            @csrf
                                                            @method('DELETE')
                                                            <button type="submit"
                                                                class="btn btn-link text-danger p-0 m-0 d-flex align-items-center">
                                                                <i class="fa fa-trash-o m-r-5"></i> Move To Trash
                                                            </button>
                                                        </form>
                                                    </div>
                                                </div>

                                            </td>
                                    @endforeach
                                    </tr>
                                </tbody>
                            </table>
                    </div>
                </div>
                <div class="row">
                    <div class="col-sm-12 col-md-5">
                        <div class="dataTables_info" id="DataTables_Table_0_info" role="status" aria-live="polite">
                            Showing 1 to 6 of 6 entries</div>
                    </div>
                    <div class="col-sm-12 col-md-7">
                        <div class="dataTables_paginate paging_simple_numbers" id="DataTables_Table_0_paginate">
                            <ul class="pagination">
                                <li class="paginate_button page-item previous disabled"
                                    id="DataTables_Table_0_previous"><a href="#"
                                        aria-controls="DataTables_Table_0" data-dt-idx="0" tabindex="0"
                                        class="page-link">Previous</a></li>
                                <li class="paginate_button page-item active"><a href="#"
                                        aria-controls="DataTables_Table_0" data-dt-idx="1" tabindex="0"
                                        class="page-link">1</a></li>
                                <li class="paginate_button page-item next disabled" id="DataTables_Table_0_next"><a
                                        href="#" aria-controls="DataTables_Table_0" data-dt-idx="2"
                                        tabindex="0" class="page-link">Next</a></li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
</div>
@endsection



@section('scripts')
    
@endsection