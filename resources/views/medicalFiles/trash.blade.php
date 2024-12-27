@extends('layouts.master')

@section('title')

@endsection

@section('css')

@endsection


@section('content')

<div class="container mt-4">
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
                                    style="width: 307.875px;">patient id</th>
                                <th class="sorting" tabindex="0" aria-controls="DataTables_Table_0"
                                    rowspan="1" colspan="1"
                                    aria-label="Department Name: activate to sort column ascending"
                                    style="width: 307.875px;">patient name</th>
                                <th class="sorting" tabindex="0" aria-controls="DataTables_Table_0"
                                    rowspan="1" colspan="1"
                                    aria-label="Status: activate to sort column ascending"
                                    style="width: 194.188px;">patient email</th>
                                <th class="sorting" tabindex="0" aria-controls="DataTables_Table_0"
                                    rowspan="1" colspan="1"
                                    aria-label="Status: activate to sort column ascending"
                                    style="width: 194.188px;">phone number</th>
                                <th class="sorting" tabindex="0" aria-controls="DataTables_Table_0"
                                    rowspan="1" colspan="1"
                                    aria-label="Status: activate to sort column ascending"
                                    style="width: 194.188px;">Date of Birth</th>
                                <th class="sorting" tabindex="0" aria-controls="DataTables_Table_0"
                                    rowspan="1" colspan="1"
                                    aria-label="Status: activate to sort column ascending"
                                    style="width: 194.188px;">Insurance number</th>
                                <th class="text-right sorting" tabindex="0" aria-controls="DataTables_Table_0"

                                rowspan="1" colspan="1"
                                    aria-label="Action: activate to sort column ascending"
                                    style="width: 138.812px;">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                        @foreach($medicalFiles as $file)                              
                                <tr role="row" class="odd">
                                <td>{{ $file->id }}</td>
                                <td>{{ $file->patient->id }}</td>
                                <td>{{ $file->patient->user->name }}</td>
                                <td>{{ $file->patient->user->email }}</td>
                                <td>{{ $file->patient->user->phone_number }}</td>
                                <td>{{ $file->patient->dob }}</td>
                                <td>{{ $file->patient->insurance_number }}</td>
                                 <td >
                                <form action="{{ route('medicalFiles.restore', $file->id) }}" method="POST"
                                    style="display: inline-block; margin-right: 5px;">
                                    @csrf
                                    
                                    <button type="submit" class="btn btn-success btn-sm">Restore</button>
                                </form>
                                <form action="{{route('medicalFiles.hardDelete',$file->id)}}" method="POST"
                                    style="display: inline-block; margin-right: 5px;">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-danger btn-sm"
                                        onclick="return confirm('Are you sure you want to delete this item permanently?')">Delete
                                        Permanently</button>
                                </form>
                            </td>
                            @endforeach
                            </tr>
                        </tbody>
                    </table>
            </div>
        </div>
     
        <div class="m-t-20 text-right">
            <a href="{{route('medicalFiles.index')}}" class="btn btn-secondary mb-3" rel="prev">
                <i class="fa fa-arrow-left mr-2"></i> Back
            </a>
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