@extends('layouts.master')

@section('title')
    Edit Employee
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
                                <input required name='name' value='{{ $employee->user->name }}' class="form-control"
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
                                <input  required name='email' class="form-control" type="email"
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
                                <input  required name='phone' class="form-control" type="text"
                                    value="{{ $employee->user->phone_number }}">
                            </div>
                        </div>

                        <div class="col-sm-6">
                            <div class="form-group">
                                <label class="nb-2" for="languages">Languages</label>
                                <div class="d-flex flex-wrap">
                                    @foreach($languages as $index => $language)
                                        <div class="col-sm-6 mb-2">
                                            <div class='form-check' id='language'>
                                                <input name='languages_ids[]' value='{{$language->id}}'   {{ $employee->languages->contains($language->id) ? 'checked' : '' }} class='form-check-input' type="checkbox"  id='flexCeckCecked{{$index}}'  >
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
                                    @if($employee->cv_path)
                                        @php 
                                            $cvFileName = basename($employee->cv_path); 
                                            // إزالة أي أرقام متبوعة بشرطة سفلية في بداية الملف للتخلص من التايم ستامب
                                            $originalFileName = preg_replace('/^\d+_/', '', $cvFileName);    
                                        @endphp 
                                        <p id="existing-file"> 
                                          <a href="{{ asset('storage/'.$employee->cv_path) }}" target="_blank">{{ $originalFileName }}</a>
                                        </p>
                                    @endif
                                    <div class="upload-input"> 
                                          <input type="file" id="new-cv" name="pdf_cv" accept=".pdf" class="form-control" > 
                                   </div>
                                </div>
                            </div>
                        </div>
                        
                        <div id="doctor-info"  style="display: none;">
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
    <script>
    
        //  اظهار واخفاء قسم الخبرة والعمل السابق حسب رول الموظف / طبيب / موظف اداري
        var employeeRole ="{{ $role }}";
        document.addEventListener('DOMContentLoaded', function () { 
            if (employeeRole === 'doctor') 
                document.getElementById('doctor-info').style.display = 'block'; 
            else 
                document.getElementById('doctor-info').style.display = 'none'; 
             });

            $(document).ready(function() { 
             
            $("#is_doctor").change(function() { 
                if ($(this).is(':checked')) 
                    $("#doctor-info").show(); 
                else $("#doctor-info").hide(); 
            }); })


      //  اخفاء قسم اسم الملف القديم في ال اختيار ملف جديد
            document.getElementById('new-cv').addEventListener('change', function() { 
                var existingFileMessage = document.getElementById('existing-file'); 
                if (existingFileMessage) { 
                    existingFileMessage.style.display = 'none'; } 
                });
          
    </script>
@endsection
