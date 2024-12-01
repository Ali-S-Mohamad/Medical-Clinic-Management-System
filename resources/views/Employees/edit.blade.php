@extends('layouts.master')

@section('title')
    Edit Employee
@endsection

@section('css')
@endsection

@section('content')
    <div class="content">
        <div class="row">
            <div class="col-lg-8 offset-lg-2">
                <h4 class="page-title">Edit Employee</h4>
            </div>
        </div>
        <div class="row">
            <div class="col-lg-8 offset-lg-2">
                <form action="{{ route('users.update', $employee->user->id) }}" method="post" enctype='multipart/form-data'>
                    @csrf
                    @method('PUT')
                    <div class="form-group">
                        <label class="display-block">is doctor?</label>
                        <div class="form-check form-check-inline">
                            <input class="form-check-input" type="checkbox" name="is_doctor" id="is_doctor" value="1"
                                @if ($employee->user->getRoleNames()->first() == 'doctor') checked @endif>
                            <label class="form-check-label" for="is_doctor">
                                yes
                            </label>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label>Name <span class="text-danger">*</span></label>
                                <input name='name' value='{{ $employee->user->name }}' class="form-control"
                                    type="text">
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label for="department-name" class="nb-2">Department</label>
                                <select required name="department_id" id="department-name" class="form-control">
                                    @foreach ($departments as $department)
                                        <option value="{{ $department->id }}"
                                            {{ $employee->department_id == $department->id ? 'selected' : '' }}>
                                            {{ $department->name }} </option>
                                    @endforeach
                                </select>
                                <br />
                            </div>
                        </div>

                        <div class="col-sm-6">
                            <div class="form-group">
                                <label>Email <span class="text-danger">*</span></label>
                                <input name='email' class="form-control" type="email"
                                    value="{{ $employee->user->email }}">
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label>Password</label>
                                <input name='password' class="form-control" type="password">
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label>Phone Number</label>
                                <input name='phone' class="form-control" type="text"
                                    value="{{ $employee->user->phone_number }}">
                            </div>
                        </div>

                        <div class="col-sm-6">
                            <div class="form-group">
                                <label class="nb-2" for="languages">Languages</label>
                                <select class="form-control" id="languages" name="languages">
                                    <option selected value="{{ $employee->languages_spoken }}">
                                        {{ $employee->languages_spoken }}</option>
                                    <option>English</option>
                                    <option>Arabic</option>
                                    <option>Hindi</option>
                                    <option>Germany</option>
                                    <option>French</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label>CV:</label>
                                <div class="profile-upload">
                                    <div class="upload-input">
                                        <input type="file" class="form-control">
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div id="doctor-info">
                            <div class="form-group">
                                <label>Academic Qualifications</label>
                                <textarea class="form-control" id="qualifications" name="qualifications" rows="5" cols="200">{{ $employee->academic_qualifications }}</textarea>
                            </div>
                            <div class="form-group">
                                <label>Work Experience</label>
                                <textarea class="form-control" id="Experience" name="experience" rows="5" cols="200">{{ $employee->previous_experience }}</textarea>
                            </div>
                        </div>
                    </div>
                    <div class="m-t-20 text-center">
                        <button class="btn btn-primary submit-btn">Update Employee</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection




@section('scripts')
@endsection
