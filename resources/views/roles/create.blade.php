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
<div class="row justify-content-center">
    <div class="col-md-8">

        <div class="card">
            <div class="card-header">
                <div class="float-start">
                    Add New Role
                </div>
                <div class="float-end">
                    <a href="{{ route('roles.index') }}" class="btn btn-primary btn-sm">&larr; Back</a>
                </div>
            </div>
            <div class="card-body">
                <form action="{{ route('roles.store') }}" method="post">
                    @csrf

                    <div class="mb-3 row">
                        <label for="name" class="col-md-4 col-form-label text-md-end text-start">Name</label>
                        <div class="col-md-6">
                          <input type="text" class="form-control @error('name') is-invalid @enderror" id="name" name="name" value="{{ old('name') }}">
                            @if ($errors->has('name'))
                                <span class="text-danger">{{ $errors->first('name') }}</span>
                            @endif
                        </div>
                    </div>

                    <div class="mb-3 row">
                        <label for="permissions" class="col-md-4 col-form-label text-md-end text-start">Permissions</label>
                        <div class="col-md-6">
                            <label for="permissions">الصلاحيات</label>
                            @forelse ($permissions as $permission)
                                <div class="form-check">
                                    <input 
                                        class="form-check-input @error('permissions') is-invalid @enderror" 
                                        type="checkbox" 
                                        id="permission_{{ $permission->id }}" 
                                        name="permissions[]" 
                                        value="{{ $permission->id }}" 
                                        {{ in_array($permission->id, old('permissions') ?? []) ? 'checked' : '' }}>
                                    <label class="form-check-label" for="permission_{{ $permission->id }}">
                                        {{ $permission->name }}
                                    </label>
                                </div>
                            @empty
                                <p> No pemissions  </p>
                            @endforelse
                        
                            @if ($errors->has('permissions'))
                                <span class="text-danger">{{ $errors->first('permissions') }}</span>
                            @endif
                        </div>
                    </div>
                    
                    <div class="mb-3 row">
                        <input type="submit" class="col-md-3 offset-md-5 btn btn-primary" value="Add Role">
                    </div>
                    
                </form>
            </div>
        </div>
    </div>    
</div>
@endsection



@section('scripts')

@endsection