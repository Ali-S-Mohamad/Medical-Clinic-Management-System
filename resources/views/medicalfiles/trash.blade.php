@extends('layouts.master')

@section('title')
    Trash - Medical Files
@endsection

@section('css')
@endsection

@section('content')
    <div class="container mt-4">
        <h1>Trash - Medical Files</h1>

        <table class="table">
            <thead>
                <tr>
                    <th>File ID</th>
                    <th>Patient Name</th>
                    <th>Patient Email</th>
                    <th>Patient Phone</th>
                    <th>Date of Birth</th>
                    <th>Insurance Number</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($medicalfiles as $file)
                <tr>
                    <td>{{ $file->id }}</td>
                    <td>{{ $file->patient->user->name }}</td>
                    <td>{{ $file->patient->user->email }}</td>
                    <td>{{ $file->patient->user->phone_number }}</td>
                    <td>{{ $file->patient->dob }}</td>
                    <td>{{ $file->patient->insurance_number }}</td>
                    <td>
                        <!-- زر استعادة -->
                        <form action="{{ route('medicalFiles.restore', $file->id) }}" method="POST" style="display: inline;">
                            @csrf
                            @method('PUT')
                            <button type="submit" class="btn btn-success btn-sm">Restore</button>
                        </form>

                        <!-- زر حذف نهائي -->
                        <form action="{{ route('medicalFiles.hardDelete', $file->id) }}" method="POST" style="display: inline;">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Are you sure you want to delete this item permanently?')">
                                Delete Permanently
                            </button>
                        </form>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
@endsection

@section('scripts')
@endsection
