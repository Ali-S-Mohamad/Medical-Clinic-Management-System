<table id="employeeTable" class="table table-striped custom-table">
    <thead>
        <tr>
            <th>ID</th>
            <th style="min-width:175px;">Name</th>
            <th>Email</th>
            <th>Department</th>
            <th class="text-center">Languages</th>
            <th class="text-center">Role</th>
            <th class="text-center">Action</th>
        </tr>
    </thead>
    <tbody id="employeeTableBody">
        @foreach ($employees as $employee)
            <tr role="row" onclick="window.location='{{ route('employees.show', $employee->id) }}'" class="odd">
                <td>{{ $employee->id }}</td>
                <td>
                    @php
                        $image_path = $employee->user->image
                            ? asset('storage/' . $employee->user->image->image_path)
                            : asset('assets/img/user.jpg');
                    @endphp
                    <img width="40" height="40" src="{{ $image_path }}" class="rounded-circle" alt="">
                    <h2>{{ $employee->user->name }}</h2>
                </td>
                <td>{{ $employee->user->email }}</td>
                <td>{{ $employee->department?->name }}</td>
                <td class="language-container d-flex flex-wrap">
                    @if (!$employee->Languages->isEmpty())
                        @foreach ($employee->Languages as $Language)
                            <p class="badge badge-pill badge-dark"> {{ $Language->name }}</p>
                        @endforeach
                    @endif
                </td>
                <td>
                    @if ($employee->user->roles->isNotEmpty())
                        @php
                            $role = $employee->user->roles->first()->name;
                            $badgeClass = match ($role) {
                                'doctor' => 'status-green',
                                'employee' => 'status-blue',
                                default => 'status-grey',
                            };
                        @endphp
                        <span class="custom-badge {{ $badgeClass }}">{{ $role }}</span>
                    @else
                        <span class="custom-badge status-red">No Role Assigned</span>
                    @endif
                </td>

                <td class="text-right">
                    <div class="action-buttons" style="white-space: nowrap;">
                        <a class="btn btn-sm btn-primary" href="{{ route('employees.edit', $employee->id) }}"
                            onclick="event.stopPropagation();" style="display: inline-block; margin-right: 5px;">
                            <i class="fa fa-pencil m-r-5"></i> Edit
                        </a>
                        <form action="{{ route('employees.destroy', $employee->id) }}" method="POST"
                            style="display: inline-block; margin: 0;" onclick="event.stopPropagation();">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger btn-sm"
                                style="padding: 2px 6px; font-size: 0.9rem; display: inline-block;">
                                <i class="fa fa-trash-o" style="font-size: 0.8rem; margin-right: 3px;"></i> Trash
                            </button>
                        </form>
                    </div>
                </td>
            </tr>
        @endforeach
    </tbody>
</table>
