@extends('layouts.master')

@section('title')
    Add Employee
@endsection

@section('css')

@endsection

@section('content')
    <div class="content">
        <a href="javascript:history.back()" class="btn btn-secondary mb-3" rel="prev">
            <i class="fa fa-arrow-left mr-2"></i> Back
        </a>
        <div class="row">
            <div class="col-lg-8 offset-lg-2">
                <h4 class="page-title">Add Employee</h4>
            </div>
        </div>
        <div class="row">
            <div class="col-lg-8 offset-lg-2">
                <form action="{{ route('users.store') }}" method="post" enctype='multipart/form-data'>
                    @csrf
                    <div class="form-group">
                        <label class="display-block">is doctor?</label>
                        <div class="form-check form-check-inline">
                            <input class="form-check-input" type="checkbox" name="is_doctor" id="is_doctor" value="1">
                            <label class="form-check-label" for="is_doctor">
                                yes
                            </label>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label>Name <span class="text-danger">*</span></label>
                                <input required name='name' class="form-control" type="text">
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label for="department-name" class="nb-2">Department <span
                                        class="text-danger">*</span></label>
                                <select required name="department_id" id="department-name" class="form-control">
                                    <option value="" disabled selected hidden>select Department</option>
                                    @foreach ($departments as $department)
                                        <option value="{{ $department->id }}"> {{ $department->name }} </option>
                                    @endforeach
                                </select>
                                <br />
                            </div>
                        </div>

                        <div class="col-sm-6">
                            <div class="form-group">
                                <label>Email <span class="text-danger">*</span></label>
                                <input required name='email' class="form-control" type="email">
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label>Password <span class="text-danger">*</span></label>
                                <input required name='password' class="form-control" type="password">
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label>Phone Number <span class="text-danger">*</span> </label>
                                <input required name='phone' class="form-control" type="text">
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label class="nb-2" for="languages">Languages</label>
                                <div class="d-flex flex-wrap">
                                    @foreach($languages as $index => $language)
                                        <div class="col-sm-6 mb-2">
                                            <div class='form-check' id='language'>
                                                <input name='languages_ids[]' value='{{$language->id}}' class='form-check-input' type="checkbox"  id='flexCeckCecked{{$index}}'  >
                                                <label class='form-check-label'  for='flexCeckCecked{{$index}}'> {{$language->name}}  </label>
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label>CV:</label>
                                <div class="profile-upload">
                                    <div class="upload-input">
                                        <input type="file"  name="pdf_cv" accept=".pdf" class="form-control" >
                                        <p id="errorMessage" style="color: red; display: none;"> size must be less than 2 MB</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div id="doctor-info">
                            <div class="form-group">
                                <label>Academic Qualifications</label>
                                <textarea class="form-control" id="qualifications" name="qualifications" rows="5" cols="200"></textarea>
                            </div>
                            <div class="form-group">
                                <label>Work Experience</label>
                                <textarea class="form-control" id="experience" name="experience" rows="5" cols="200"></textarea>
                            </div>
                        </div>
                    </div>
                    <div class="m-t-20 text-center">
                        <button class="btn btn-primary submit-btn">Create Employee</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
      <script> 
         $(document).ready(function() { 
            $("#doctor-info").hide(); 
            $("#is_doctor").change(function() { 
                if ($(this).is(':checked')) 
                    $("#doctor-info").show(); 
                else $("#doctor-info").hide(); 
            }); 
            
            $('#pdf_cv').change(function() { 
                var file = this.files[0]; 
                console.log('File selected:', file.size); 
                var errorMessage = $('#errorMessage'); 
                if (file) { 
                    console.log('File selected:', file.size); 
 
                    if (file.size > 2 * 1024 * 1024) { 
                         errorMessage.show(); 
                        this.value = ''; //      
                        } else { errorMessage.hide(); } } }); 
        });

    </script>
@endsection
