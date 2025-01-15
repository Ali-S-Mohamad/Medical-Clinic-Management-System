<table class="table table-striped custom-table mb-0  no-footer" id="DataTables_Table_0" role="grid" aria-describedby="DataTables_Table_0_info">
<thead>
<tr role="row">
<th class="sorting_asc" tabindex="0" aria-controls="DataTables_Table_0" rowspan="1" colspan="1" aria-sort="ascending" aria-label="#: activate to sort column descending" style="width: 62.125px;">#</th>
<th class="sorting" tabindex="0" aria-controls="DataTables_Table_0" rowspan="1" colspan="1" aria-label="Department Name: activate to sort column ascending" style="width: 307.875px;">Doctor Name</th>
<th class="sorting" tabindex="0" aria-controls="DataTables_Table_0" rowspan="1" colspan="1" aria-label="Department Name: activate to sort column ascending" style="width: 307.875px;">Patient Name</th>
<th class="sorting" tabindex="0" aria-controls="DataTables_Table_0" rowspan="1" colspan="1" aria-label="Department Name: activate to sort column ascending" style="width: 307.875px;">Appointment</th>
<th class="sorting" tabindex="0" aria-controls="DataTables_Table_0" rowspan="1" colspan="1" aria-label="Department Name: activate to sort column ascending" style="width: 307.875px;">Medications names</th>
<th class="sorting" tabindex="0" aria-controls="DataTables_Table_0" rowspan="1" colspan="1" aria-label="Department Name: activate to sort column ascending" style="width: 307.875px;">instructions</th>
<th class="sorting" tabindex="0" aria-controls="DataTables_Table_0" rowspan="1" colspan="1" aria-label="Department Name: activate to sort column ascending" style="width: 307.875px;">details</th>
<th class="text-right sorting" tabindex="0" aria-controls="DataTables_Table_0" rowspan="1" colspan="1" aria-label="Action: activate to sort column ascending" style="width: 138.812px;">Action</th>
</tr>
</thead>
<tbody>
@foreach ($prescriptions as $prescription)
<tr role="row" class="odd">
<td>{{ $loop->iteration }}</td> 
<td>{{ $prescription->employee->user->name }}</td>
<td>{{ $prescription->Appointment->patient->user->name }}</td>
<td>{{ $prescription->appointment->appointment_date }}</td>
<td>{{ $prescription->medications_names }}</td>
<td>{{ $prescription->instructions }}</td>
<td>{{ $prescription->details }}</td>
<td class="text-right">
<div class="action-buttons" style="white-space: nowrap;">
<a class="btn btn-sm btn-primary" href="{{ route('prescriptions.edit', $prescription->id) }}" style="display: inline-block; margin-right: 5px;">
<i class="fa fa-pencil m-r-5"></i> Edit </a>
<a class="btn btn-sm btn-info" href="{{ route('prescriptions.show', $prescription->id) }}" style="display: inline-block; margin-right: 5px;">
<i class="fa fa-eye m-r-5"></i> Show </a>
<form action="{{ route('prescriptions.destroy', $prescription->id) }}" method="POST" style="display: inline-block; margin: 0;">
@csrf
@method('DELETE')
<button type="submit" class="btn btn-danger btn-sm" style="padding: 2px 6px; font-size: 0.9rem; display: inline-block;">
<i class="fa fa-trash-o" style="font-size: 0.8rem; margin-right: 3px;"></i> Trash
</button>
</form>
</div>
</td>
@endforeach
</tr>
</tbody>
</table>