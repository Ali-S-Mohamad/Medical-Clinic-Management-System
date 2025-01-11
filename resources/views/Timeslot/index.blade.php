@extends('layouts.master')

@section('title')
    Time Slots
@endsection

@section('css')
    <style>
        tbody tr:hover {
            cursor: pointer;
        }
    </style>
@endsection

@section('content')
@if($errors->any())
    <div class="alert alert-danger">
        <ul>
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif
    <div class="content">
        <div class="row">
            <div class="col-sm-5 col-5">
                <h4 class="page-title">time slots</h4>
            </div>
            <div class="col-sm-7 col-7 text-right m-b-30 d-flex justify-content-end align-items-center">
                <a href="{{ route('time-slots.create') }}" class="btn btn-primary btn-rounded mr-3">
                    <i class="fa fa-plus"></i> Add time slots
                </a>
            </div>
        </div>
        <div class="row">
        <div class="col-md-12">
        <div id="DataTables_Table_0_wrapper" class="dataTables_wrapper dt-bootstrap4 no-footer">
            <div class="row">
                <div class="col-sm-12">
                    <table class="table table-striped custom-table mb-0 datatable dataTable no-footer" id="DataTables_Table_0" role="grid">
                        <thead>
                            <tr role="row">
                                <th>ID</th>
                                <th>Doctor Name</th>
                                <th>Day of Week</th>
                                <th>Start Time</th>
                                <th>End Time</th>
                                <th>Slot Duration</th>
                                <th>Availability</th>
                                <th class="text-right">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                        @foreach($timeSlots as $timeSlot)
                            <tr role="row">
                                <td>{{ $timeSlot->id }}</td>
                                <td>{{ $timeSlot->doctor->user->name}}</td> 
                                <td>{{ ['Sunday', 'Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday'][$timeSlot->day_of_week] }}</td>
                                <td>{{ $timeSlot->start_time }}</td>
                                <td>{{ $timeSlot->end_time }}</td>
                                <td>{{ $timeSlot->slot_duration }}</td>
                                <td>
                                    <form action="{{ route('time-slots.toggleAvailability', $timeSlot->id) }}" method="POST" style="display: inline;">
                                        @csrf
                                        @method('PATCH')
                                        <button type="submit" class="btn btn-link p-0 m-0 text-decoration-none {{ $timeSlot->is_available ? 'status-green' : 'status-red' }}" style="border: none; background: none;">
                                            {{ $timeSlot->is_available ? 'Available' : 'Not Available' }}
                                        </button>
                                    </form>
                                </td>
                                <td class="text-right">
                                    <div class="action-buttons">
                                        <a class="btn btn-sm btn-primary" href="{{ route('time-slots.edit', $timeSlot->id) }}" style="margin-right: 5px;">
                                            <i class="fa fa-pencil m-r-5"></i> Edit
                                        </a>
                                        <form action="{{ route('time-slots.destroy', $timeSlot->id) }}" method="POST" style="display: inline-block;">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-danger btn-sm">
                                                <i class="fa fa-trash-o"></i> Delete
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                    {{ $timeSlots->links() }}
                </div>
            </div>
        </div>
        <a href="javascript:history.back()" class="btn btn-secondary mb-3" rel="prev">
            <i class="fa fa-arrow-left mr-2"></i>Back
        </a>
      </div>
     </div>
    </div>
@endsection

@section('scripts')
@endsection
