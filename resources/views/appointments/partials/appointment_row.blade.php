<tr id="appointment-row-{{ $appointment->id }}">
    <td>{{ $appointment->id }}</td>
    <td>
        <img width="28" height="28" src="{{ asset('assets/img/user.jpg') }}"
                class="rounded-circle m-r-5" alt="">
        {{ $appointment->patient->user->firstname }} {{ $appointment->patient->user->lastname }}
    </td>
    <td>{{ $appointment->employee->user->firstname }} {{ $appointment->employee->user->lastname }}</td>
    <td>{{ \Carbon\Carbon::parse($appointment->appointment_date)->format('Y-m-d H:i') }}</td>
    <td>
        <span class="custom-badge {{ $appointment->status === 'scheduled' ? 'status-blue' : ($appointment->status === 'completed' ? 'status-green' : 'status-red') }}">
            {{ ucfirst($appointment->status) }}
        </span>
    </td>
    <td class="text-right">
        <div class="action-buttons" style="white-space: nowrap;">
            <!-- زر تغيير الحالة -->
            <button class="btn btn-sm btn-primary" data-toggle="modal"
                data-target="#changeStatusModal-{{ $appointment->id }}">
                <i class="fa fa-refresh m-r-5"></i>
            </button>

            <!-- نافذة تعديل الحالة -->
            <div class="modal fade" id="changeStatusModal-{{ $appointment->id }}" tabindex="-1" role="dialog" aria-labelledby="changeStatusModalLabel" aria-hidden="true">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="changeStatusModalLabel">Change Appointment Status</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <form action="{{ route('appointments.updateStatus', $appointment->id) }}" method="POST" class="update-status-form">
                            @csrf
                            @method('PATCH')
                            <div class="modal-body">
                                <div class="form-group">
                                    <label for="status">New Status</label>
                                    <select name="status" id="status" class="form-control" required>
                                        <option value="scheduled" {{ $appointment->status === 'scheduled' ? 'selected' : '' }}>Scheduled</option>
                                        <option value="completed" {{ $appointment->status === 'completed' ? 'selected' : '' }}>Completed</option>
                                        <option value="canceled" {{ $appointment->status === 'canceled' ? 'selected' : '' }}>Canceled</option>
                                    </select>
                                </div>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                <button type="submit" class="btn btn-primary">Save changes</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
            <!-- نهاية نافذة تعديل الحالة -->

            <!-- زر التعديل الكامل -->
            <a class="btn btn-sm btn-primary"
                href="{{ route('appointments.edit', $appointment->id) }}"
                style="display: inline-block; margin-right: 5px;">
                <i class="fa fa-pencil m-r-5"></i> Edit
            </a>

            <!-- زر العرض -->
            <a class="btn btn-sm btn-info"
                href="{{ route('appointments.show', $appointment->id) }}"
                style="display: inline-block; margin-right: 5px;">
                <i class="fa fa-eye m-r-5"></i> Show
            </a>

            <!-- زر الحذف -->
            <form action="{{ route('appointments.destroy', $appointment->id) }}"
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
</tr>
