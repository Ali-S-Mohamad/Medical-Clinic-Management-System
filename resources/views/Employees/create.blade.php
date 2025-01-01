@extends('layouts.master')

@section('title')
    Add Employee
@endsection

@section('css')
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
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

                    <div class="row">
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label class="display-block">is doctor?</label>
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="checkbox" name="is_doctor" id="is_doctor"
                                        value="1">
                                    <label class="form-check-label" for="is_doctor">
                                        yes
                                    </label>
                                </div>
                            </div>
                        </div>
                        {{-- image section --}}
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label for="photo">profile image :</label>
                                <div style="display: flex; align-items: center;">
                                    <i class="fas fa-upload" id="upload-icon" style="font-size: 30px; cursor: pointer;"></i>
                                    <!-- حقل إدخال الصورة -->
                                    <input type="file" id="photo" name="profile_image" accept=".jpg,.jpeg,.png"
                                        style="display: none;"> <!-- مكان عرض الصورة المصغرة -->
                                    <img id="thumbnail"
                                        style="display:none; width: 70px; height: 70px; margin-left: 10px; cursor: pointer;">

                                </div>
                            </div>
                        </div>
                        {{-- image section --}}
                    </div> {{-- row end --}}

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
                                    @foreach ($languages as $index => $language)
                                        <div class="col-sm-6 mb-2">
                                            <div class='form-check' id='language'>
                                                <input name='languages_ids[]' value='{{ $language->id }}'
                                                    class='form-check-input' type="checkbox"
                                                    id='flexCeckCecked{{ $index }}'>
                                                <label class='form-check-label' for='flexCeckCecked{{ $index }}'>
                                                    {{ $language->name }} </label>
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
                                        <input type="file" name="pdf_cv" accept=".pdf" class="form-control">
                                        <p id="errorMessage" style="color: red; display: none;"> size must be less than 2
                                            MB</p>
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
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

    <script>
        // image & image icon
        document.getElementById('upload-icon').onclick = function() {
            document.getElementById('photo').click();
        };
        document.getElementById('photo').onchange = function(event) {
            var file = event.target.files[0];
            if (file) {
                var reader = new FileReader();
                reader.onload = function(e) {
                    document.getElementById('upload-icon').style.display = 'none';
                    var img = document.getElementById('thumbnail');
                    img.src = e.target.result;
                    img.style.display = 'block';
                }
                reader.readAsDataURL(file);
            }
        }

        document.getElementById('thumbnail').onclick = function() {
            document.getElementById('photo').click();
        }
    </script>
@endsection
