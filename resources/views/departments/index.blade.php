@extends('layouts.master')

@section('title')
<<<<<<< HEAD
Departments
=======
    Departments
>>>>>>> 63bd8b7415a4781a4fa9ba5c8ea098923839fe3b
@endsection

@section('css')
    <style>
        tbody tr:hover {
            cursor: pointer;
        }
    </style>
@endsection


@section('content')
    <div class="content">
        <div class="row">
            <div class="col-sm-5 col-5">
                <h4 class="page-title">Departments</h4>
            </div>
            <div class="col-sm-7 col-7 text-right m-b-30 d-flex justify-content-end align-items-center">
                <a href="{{ route('departments.create') }}" class="btn btn-primary btn-rounded mr-3">
                    <i class="fa fa-plus"></i> Add Department
                </a>
                <a href="{{ route('departments.trash') }}">
                    <i class="fa fa-trash-o" style="font-size:36px"></i>
                </a>
            </div>
        </div>
        <div class="row">
<<<<<<< HEAD
        <div class="col-md-12">
        <div id="DataTables_Table_0_wrapper" class="dataTables_wrapper dt-bootstrap4 no-footer">
                <div class="row">
                                        <div class="col-sm-12 col-md-6"></div></div> 
                                        <div class="row">
                                        <div class="col-sm-12"><role="row" class="even">
                    </role="row">
                    <table class="table table-striped custom-table mb-0  no-footer" id="DataTables_Table_0" role="grid" aria-describedby="DataTables_Table_0_info">
            <thead>
                <tr role="row">
                <th class="sorting_asc" tabindex="0" aria-controls="DataTables_Table_0" rowspan="1" colspan="1" aria-sort="ascending" aria-label="#: activate to sort column descending" style="width: 62.125px;">ID</th>
                <th class="sorting" tabindex="0" aria-controls="DataTables_Table_0" rowspan="1" colspan="1" aria-label="Department Name: activate to sort column ascending" style="width: 307.875px;">Department Name</th>
                <th class="sorting" tabindex="0" aria-controls="DataTables_Table_0" rowspan="1" colspan="1" aria-label="Department Name: activate to sort column ascending" style="width: 307.875px;">Description</th>
                <th class="sorting" tabindex="0" aria-controls="DataTables_Table_0" rowspan="1" colspan="1" aria-label="Status: activate to sort column ascending" style="width: 194.188px;">Status</th>
                <th class="text-right sorting" tabindex="0" aria-controls="DataTables_Table_0" rowspan="1" colspan="1" aria-label="Action: activate to sort column ascending" style="width: 138.812px;">Action</th></tr>
            </thead>
            <tbody>
            @foreach($departments as $department)
            <tr role="row" onclick="window.location='{{ route('departments.show', $department->id) }}' " class="odd">
                    <td>{{ $department->id }}</td> 
                    <td>{{ $department->name }}</td>
                    <td>{{ $department->description }}</td>
                    <td>
                    <p class="text-muted">
                    <form action="{{ route('departments.toggleStatus', $department->id) }}" method="POST" style="display: inline;">
                    @csrf
                    @method('PATCH')
                    <button type="submit" class="btn btn-link p-0 m-0 text-decoration-none {{ $department->status == 1 ? 'status-green' : 'status-red' }}" style="border: none; background: none;">
                    {{ $department->status == 1 ? 'Active' : 'Inactive' }}
                    </button>
                    </form></p></td>
                    <td class="text-right">
                    <div class="action-buttons" style="white-space: nowrap;">
                    <a class="btn btn-sm btn-primary" href="{{ route('departments.edit', $department->id) }}" style="display: inline-block; margin-right: 5px;">
                    <i class="fa fa-pencil m-r-5"></i> Edit
                    </a>
                    
                    <form action="{{ route('departments.destroy', $department->id) }}" method="POST" style="display: inline-block; margin: 0;">
                     @csrf
                     @method('DELETE')
                     <button type="submit" class="btn btn-danger btn-sm" style="padding: 2px 6px; font-size: 0.9rem; display: inline-block;">
                     <i class="fa fa-trash-o" style="font-size: 0.8rem; margin-right: 3px;"></i> Trash
                     </button>
                     </form>
                     </div>
                     </td>
                    @endforeach
                  </tr></tbody>
            </table>
        </div>
</div>

 {{ $departments->links()}}

@endsection
=======
            <div class="col-md-12">
                <div id="DataTables_Table_0_wrapper" class="dataTables_wrapper dt-bootstrap4 no-footer">
                    <div class="row">
                        <div class="col-sm-12 col-md-6"></div>
                    </div>
                    <div class="row">
                        <div class="col-sm-12">
                            <role="row" class="even">
                                </role="row">
                                <table class="table table-striped custom-table mb-0  no-footer" id="DataTables_Table_0"
                                    role="grid" aria-describedby="DataTables_Table_0_info">
                                    <thead>
                                        <tr role="row">
                                            <th class="sorting_asc" tabindex="0" aria-controls="DataTables_Table_0"
                                                rowspan="1" colspan="1" aria-sort="ascending"
                                                aria-label="#: activate to sort column descending" style="width: 62.125px;">
                                                ID</th>
                                            <th class="sorting" tabindex="0" aria-controls="DataTables_Table_0"
                                                rowspan="1" colspan="1"
                                                aria-label="Department Name: activate to sort column ascending"
                                                style="width: 307.875px;">Department Name</th>
                                            <th class="sorting" tabindex="0" aria-controls="DataTables_Table_0"
                                                rowspan="1" colspan="1"
                                                aria-label="Department Name: activate to sort column ascending"
                                                style="width: 307.875px;">Description</th>
                                            <th class="sorting" tabindex="0" aria-controls="DataTables_Table_0"
                                                rowspan="1" colspan="1"
                                                aria-label="Status: activate to sort column ascending"
                                                style="width: 194.188px;">Status</th>
                                            <th class="text-right sorting" tabindex="0" aria-controls="DataTables_Table_0"
                                                rowspan="1" colspan="1"
                                                aria-label="Action: activate to sort column ascending"
                                                style="width: 138.812px;">Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($departments as $department)
                                            <tr role="row"
                                                onclick="window.location='{{ route('departments.show', $department->id) }}' "
                                                class="odd">
                                                <td>{{ $department->id }}</td>
                                                <td>{{ $department->name }}</td>
                                                <td>{{ $department->description }}</td>
                                                <td>
                                                    <p class="text-muted">
                                                    <form action="{{ route('departments.toggleStatus', $department->id) }}"
                                                        method="POST" style="display: inline;">
                                                        @csrf
                                                        @method('PATCH')
                                                        <button type="submit"
                                                            class="btn btn-link p-0 m-0 text-decoration-none {{ $department->status == 1 ? 'status-green' : 'status-red' }}"
                                                            style="border: none; background: none;">
                                                            {{ $department->status == 1 ? 'Active' : 'Inactive' }}
                                                        </button>
                                                    </form>
                                                    </p>
                                                </td>
                                                <td class="text-right">
                                                    <div class="action-buttons" style="white-space: nowrap;">
                                                        <a class="btn btn-sm btn-primary"
                                                            href="{{ route('departments.edit', $department->id) }}"
                                                            style="display: inline-block; margin-right: 5px;">
                                                            <i class="fa fa-pencil m-r-5"></i> Edit
                                                        </a>

                                                        <form action="{{ route('departments.destroy', $department->id) }}"
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

                    {{ $departments->links() }}
                @endsection
>>>>>>> 63bd8b7415a4781a4fa9ba5c8ea098923839fe3b


                @section('scripts')
                @endsection
