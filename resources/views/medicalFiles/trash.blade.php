@extends('layouts.master')

@section('title')

@endsection

@section('css')

@endsection


@section('content')
<div class="container mt-4">
    <h1>Trash</h1>

    <h2>Medical Files</h2>
    <table class="table">
        <thead>
            <tr>
                <th>#</th>
                <th>patient id</th>
                <th>Patient name</th>
                <th>patient email</th>
                <th>phone number</th>
                <th>Date of Birth</th>
                <th>Insurance number</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
                        @foreach($medicalFiles as $file)                              
                                <tr role="row" class="odd">
                                <td>{{ $file->id }}</td>
                                <td>{{ $file->patient->id }}</td>
                                <td>{{ $file->patient->user->name }}</td>
                                <td>{{ $file->patient->user->email }}</td>
                                <td>{{ $file->patient->user->phone_number }}</td>
                                <td>{{ $file->patient->dob }}</td>
                                <td>{{ $file->patient->insurance_number }}</td>
                                 <td >
                                <form action="{{ route('medicalFiles.restore', $file->id) }}" method="POST"
                                    style="display: inline-block; margin-right: 5px;">
                                    @csrf
                                    
                                    <button type="submit" class="btn btn-success btn-sm">Restore</button>
                                </form>
                                <form action="{{route('medicalFiles.hardDelete',$file->id)}}" method="POST"
                                    style="display: inline-block; margin-right: 5px;">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-danger btn-sm"
                                        onclick="return confirm('Are you sure you want to delete this item permanently?')">Delete
                                        Permanently</button>
                                </form>
                                </td>
                            @endforeach
                                </tr>
        </tbody>
    </table>
            </div>
        </div>
     
        <div class="m-t-20 text-right">
            <a href="{{route('medicalFiles.index')}}" class="btn btn-secondary mb-3" rel="prev">
                <i class="fa fa-arrow-left mr-2"></i> Back
            </a>
        </div>
    </div>
</div>
</div>
</div>

</div>
</div>
@endsection



@section('scripts')
    
@endsection