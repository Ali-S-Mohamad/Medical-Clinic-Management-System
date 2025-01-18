@extends('layouts.master')

@section('title')
    Add Patient
@endsection

@section('css')
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
@endsection

@section('content')
@if (session('error'))
        <div class="alert alert-danger fade show" role="alert" style="animation: fadeOut 3s forwards;">
            {{ session('error') }}
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
    @endif
    @if (session('success'))
        <div class="alert alert-success fade show" role="alert" style="animation: fadeOut 3s forwards;">
            {{ session('success') }}
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
    @endif
    <div class="content">
        <div class="row">
            <div class="col-lg-8 offset-lg-2">
                <h4 class="page-title">Add Patient</h4>
            </div>
        </div>
        <div class="row">
            <div class="col-lg-8 offset-lg-2">
                <form action="{{ route('users.store') }}" method="post" enctype='multipart/form-data'>
                    @csrf

                    <div class="row">
                        {{-- image section --}}
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label for="photo">Image :</label>
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
                                <label>first name <span class="text-danger">*</span></label>
                                <input required name='firstname' class="form-control" type="text">
                            </div>

                        </div>
                        <div class="col-sm-6">
                        <div class="form-group">
                            <label>last name <span class="text-danger">*</span></label>
                            <input required name='lastname' class="form-control" type="text">
                        </div>
                    </div>
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label>Phone Number <span class="text-danger">*</span> </label>
                                <input required name='phone_number' class="form-control" type="text">
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
                            <div class="form-group">
                                <label>Confirm Password <span class="text-danger">*</span></label>
                                <input required name='confirm_password' class="form-control" type="password">
                            </div>
                        </div>

                        <div class="col-sm-6">
                            <div class="form-group">
                                <label>Insurance Number   </label>
                                <input  name='insurance_number' class="form-control" type="text">
                            </div>
                            <div class="form-group">
                                <label>gender  </label>
                                <input  name='gender' class="form-control" type="text">
                            </div>
                        </div>

                        <div class="col-sm-6">
                            <div class="form-group">
                                <label>Date of birth <span class="text-danger">*</span> </label>
                                <input required name='dob' class="form-control" type="date">
                            </div>
                        </div>


                        <input type="hidden" name="is_patient" value="1">

                    </div>
                    <div class="m-t-20 text-center">
                        <button class="btn btn-primary submit-btn">Create Patient</button>
                    </div>

                    <div class="m-t-20 text-center">
                        <a href="{{ route('employees.index') }}" class="btn btn-secondary mb-3" rel="prev">
                            <i class="fa fa-arrow-left mr-2"></i> Back
                        </a>
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
