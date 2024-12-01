@extends('layouts.master')

@section('title')
@endsection

@section('css')
@endsection


@section('content')
    <div class="container mt-4">
        <h1>Trash</h1>

        <h2>Department</h2>
        <table class="table">
            <thead>
                <tr>
                    <th>name</th>
                    <th>description</th>
                    <th>status</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($departments as $department)
                    <tr>
                        <td>{{ $department->name }}</td>
                        <td>{{ $department->description }}</td>
                        <td>{{ $department->status }}</td>
                        <td>
                            <form action="{{ route('departments.restore', $department->id) }}" method="POST"
                                style="display: inline;">
                                @csrf
                                @method('PUT')
                                <button type="submit" class="btn btn-success btn-sm">Restore</button>
                            </form>
                            <form action="{{ route('departments.hardDelete', $department->id) }}" method="POST"
                                style="display: inline;">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger btn-sm"
                                    onclick="return confirm('Are you sure you want to delete this item permanently?')">Delete
                                    Permanently</button>
                            </form>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
        <a href="javascript:history.back()" class="btn btn-secondary mb-3" rel="prev">
            <i class="fa fa-arrow-left mr-2"></i> Back</a>
    </div>
@endsection


@section('scripts')
@endsection
