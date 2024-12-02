@extends('layouts.master')

@section('title')

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
    <div class="card-header">Manage Roles</div>
    <div class=" text-right m-b-30 d-flex justify-content-end align-items-center">
        <!-- زر إضافة الدور -->
        @can('create-role')
        <a href="{{ route('roles.create') }}" class="btn btn-primary btn-rounded mr-3">
            <i class="fa fa-plus"></i> Add Role
        </a>
        @endcan
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
                        <div class="dropdown dropdown-action">
                            <a href="#" class="action-icon dropdown-toggle"
                                data-toggle="dropdown" aria-expanded="false">
                                <i class="fa fa-ellipsis-v"></i>
                            </a>
                            <div class="dropdown-menu dropdown-menu-right">
                                <a class="dropdown-item"
                                    href="{{ route('roles.show', $role->id) }}">
                                    <i class="fa fa-eye m-r-5"></i> Show
                                </a>
                                @if ($role->name != 'Admin')
                                    @can('edit-role')
                                    <a class="dropdown-item"
                                        href="{{ route('roles.edit', $role->id) }}">
                                        <i class="fa fa-pencil m-r-5"></i> Edit
                                    </a>
                                    @endcan
                    
                                    <form
                                        action="{{ route('roles.destroy', $role->id) }}"
                                        method="POST" class="dropdown-item p-0 m-0">
                                        @csrf
                                        @method('DELETE')
                                        @can('delete-role')
                                            @if ($role->name != Auth::user()->hasRole($role->name))
                                            <button type="submit"
                                                class="dropdown-item text-danger">
                                                <i class="fa fa-trash-o m-r-6"></i> Delete
                                            </button>
                                            @endif
                                        @endcan
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