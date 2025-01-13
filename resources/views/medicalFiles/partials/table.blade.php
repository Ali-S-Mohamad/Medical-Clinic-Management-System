<table class="table table-striped custom-table" id="medicalFilesTableContainer">
    <thead>
        <tr role="row">
            <th>#</th>
            <th>Patient ID</th>
            <th>Patient Name</th>
            <th>Patient Email</th>
            <th>Phone Number</th>
            <th>Date of Birth</th>
            <th>Insurance Number</th>
            <th class="text-right">Action</th>
        </tr>
    </thead>
    <tbody>
        @forelse ($medicalFiles as $file)
            <tr role="row" class="odd">
                <td>{{ $file->id }}</td>
                <td>{{ $file->patient->id }}</td>
                <td>{{ $file->patient->user->name }}</td>
                <td>{{ $file->patient->user->email }}</td>
                <td>{{ $file->patient->user->phone_number }}</td>
                <td>{{ $file->patient->dob }}</td>
                <td>{{ $file->patient->insurance_number }}</td>
                <td class="text-right">
                    <a class="btn btn-sm btn-primary" href="{{ route('medicalFiles.edit', $file->id) }}">Edit</a>
                    <a class="btn btn-sm btn-info" href="{{ route('medicalFiles.show', $file->id) }}">Show</a>
                    <form action="{{ route('medicalFiles.destroy', $file->id) }}" method="POST" style="display:inline-block;">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger btn-sm">Trash</button>
                    </form>
                </td>
            </tr>
        @empty
            <tr>
                <td colspan="8" class="text-center">No medical files found.</td>
            </tr>
        @endforelse
    </tbody>
</table>
