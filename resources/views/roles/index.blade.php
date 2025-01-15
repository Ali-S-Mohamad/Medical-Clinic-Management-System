@extends('layouts.master')

@section('title')
    Roles & Permissions
@endsection

@section('css')

@endsection


@section('content')
@if(session('error'))
<div class="alert alert-danger fade show" role="alert" style="animation: fadeOut 3s forwards;">
    {{ session('error') }}
    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
        <span aria-hidden="true">&times;</span>
    </button>
</div>
@endif
@if(session('success'))
<div class="alert alert-success fade show" role="alert" style="animation: fadeOut 3s forwards;">
    {{ session('success') }}
    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
        <span aria-hidden="true">&times;</span>
    </button>
</div>
@endif
<div class="card">

    <div class="card-header d-flex justify-content-between align-items-center">
        <h5 class="mb-0">Manage Roles</h5>
        <div class="text-right">
            @can('create-role')
            <a href="{{ route('roles.create') }}" class="btn btn-primary btn-rounded">
                <i class="fa fa-plus"></i> Add Role
            </a>
            @endcan
        </div>
    </div>

    <div class="card-body">
        <table class="table table-striped table-bordered">
            <thead>
                <tr>
                <th scope="col">S#</th>
                <th scope="col">Name</th>
                <th scope="col" style="width: 250px;">Action</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($roles as $role)
                <tr>
                    <th scope="row">{{ $loop->iteration }}</th>
                    <td>{{ $role->name }}</td>
                    <td class="text-right">
                            <div class="action-buttons" style="white-space: nowrap;">
                                <a class="btn btn-sm btn-info"
                                    href="{{ route('roles.show', $role->id) }}"
                                    style="display: inline-block; margin-right: 5px;">
                                    <i class="fa fa-eye m-r-5"></i> Show
                                </a>
                                @if ($role->name != 'Admin')
                                    @can('edit-role')
                                    <a class="btn btn-sm btn-primary"
                                    href="{{ route('roles.edit', $role->id) }}"
                                    style="display: inline-block; margin-right: 5px;">
                                    <i class="fa fa-pencil m-r-5"></i> Edit
                                </a>
                                    @endcan
                                    <form action="{{ route('roles.destroy', $role->id) }}"
                                        method="POST" style="display: inline-block; margin: 0;">
                                        @csrf
                                        @method('DELETE')
                                        @if ($role->name != Auth::user()->hasRole($role->name))
                                        <button type="submit" class="btn btn-danger btn-sm"
                                            style="padding: 2px 6px; font-size: 0.9rem; display: inline-block;">
                                            <i class="fa fa-trash-o"
                                                style="font-size: 0.8rem; margin-right: 3px;"></i> Delete
                                        </button>
                                        @endif
                                    </form>
                                @endif
                            </div>
                        </div>
                    </td>
                </tr>
                @empty
                    <td colspan="3">
                        <span class="text-danger">
                            <strong>No Role Found!</strong>
                        </span>
                    </td>
                @endforelse
            </tbody>
        </table>
        {{ $roles->links() }}

    </div>
</div>
@endsection



@section('scripts')


@endsection
