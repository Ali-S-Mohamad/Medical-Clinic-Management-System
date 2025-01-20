@extends('layouts.master')

@section('title')
    Edit Patient
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
    @if ($errors->any())
    <div class="alert alert-danger">
        <ul>
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif
    <div class="content">
        <div class="row">
            <div class="col-lg-8 offset-lg-2">
                <h4 class="page-title">Edit Patient</h4>
            </div>
        </div>
        <div class="row">
            <div class="col-lg-8 offset-lg-2">
                <form action="{{ route('users.update', $patient->user->id) }}" method="post" enctype='multipart/form-data'>
                    @csrf
                    @method('PUT')

                    <div class="row">
                        {{-- image section --}}
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label for="photo"> Image:</label>
                                <div style="display: flex; align-items: center;">
                                    @if ($patient->user->image)
                                        <!-- IF there is an image -> display it -->
                                        <img id="thumbnail"
                                            src="{{ asset('storage/' . $patient->user->image->image_path) }}"
                                            style="width: 70px; height: 70px; margin-left: 10px; cursor: pointer; border-radius: 50%;">
                                    @else
                                        <!-- IF there is not an image -> display upload icon -->
                                        <i class="fas fa-upload" id="upload-icon"
                                            style="font-size: 30px; cursor: pointer;"></i>
                                    @endif
                                    <!-- input field -->
                                    <input type="file" id="photo" name="profile_image" accept=".jpg,.jpeg,.png"
                                        style="display: none;">

                                </div>
                            </div>
                        </div>
                        {{-- image section --}}
                    </div> {{-- row end --}}

                    <div class="row">
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label>First name <span class="text-danger">*</span></label>
                                <input required name='firstname' value='{{ $patient->user->firstname }}'
                                    class="form-control" type="text">
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label>Last name <span class="text-danger">*</span></label>
                                <input required name='lastname' value='{{ $patient->user->lastname }}' class="form-control"
                                    type="text">
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label>Phone Number <span class="text-danger">*</span> </label>
                                <input required name='phone_number' value='{{ $patient->user->phone_number }}'
                                    class="form-control" type="text">
                            </div>
                        </div>

                        <div class="col-sm-6">
                            <div class="form-group">
                                <label>Email <span class="text-danger">*</span></label>
                                <input required name='email' value='{{ $patient->user->email }}' class="form-control"
                                    type="email">
                            </div>

                        </div>
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label>Password</label>
                                <input type="password" name="password" id="password" class="form-control"
                                    placeholder="Enter new password">
                                <small class="text-muted">Leave empty to keep the current password.</small>
                            </div>
                            <div class="form-group">
                                <label> Confirm Password</label>
                                <input type="password" name="confirm_password" id="confirm_password"
                                    class="form-control" placeholder="Confirm new password">
                                <small class="text-muted">Leave empty to keep the current password.</small>
                            </div>
                        </div>

                        <div class="col-sm-6">
                            <div class="form-group">
                                <label>Insurance Number </label>
                                <input name='insurance_number' value='{{ $patient->insurance_number }}' class="form-control"
                                    type="text" placeholder="INS-00000">
                                    <small class="text-muted">Make sure that the number is like the format above.</small>
                            </div>
                            <div class="form-group">
                                <label for="gender">Gender</label>
                                <select name="gender" id="gender" class="form-control" required>
                                    <option value="male" {{ old('gender', $patient->user->gender ?? '') == 'male' ? 'selected' : '' }}>Male</option>
                                    <option value="female" {{ old('gender', $patient->user->gender ?? '') == 'female' ? 'selected' : '' }}>Female</option>
                                </select>
                                @error('gender')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>

                        </div>

                        <div class="col-sm-6">
                            <div class="form-group">
                                <label>Date of birth <span class="text-danger">*</span> </label>
                                <input required name='dob' value='{{ $patient->dob }}' class="form-control"
                                    type="date">
                            </div>
                        </div>


                        <input type="hidden" name="is_patient" value="1">

                    </div>
                    <div class="m-t-20 text-center">
                        <button class="btn btn-primary submit-btn">Edit Patient</button>
                    </div>

                    <div class="m-t-20 text-center">
                        <a href="{{ route('patients.index') }}" class="btn btn-secondary mb-3" rel="prev">
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
        document.addEventListener('DOMContentLoaded', function() {
            var uploadIcon = document.getElementById('upload-icon');
            var thumbnail = document.getElementById('thumbnail');
            var photoInput = document.getElementById('photo');

            // Handle clicking on the image icon
            if (uploadIcon) {
                uploadIcon.addEventListener('click', function() {
                    photoInput.click();
                });
            }

            // Handle by clicking on the image
            if (thumbnail) {
                thumbnail.addEventListener('click', function() {
                    photoInput.click();
                });
            }

            // Handle image change
            photoInput.addEventListener('change', function(event) {
                var file = event.target.files[0];
                if (file) {
                    var reader = new FileReader();
                    reader.onload = function(e) {
                        if (thumbnail) {
                            thumbnail.src = e.target.result;
                        } else {
                            thumbnail = document.createElement('img');
                            thumbnail.id = 'thumbnail';
                            thumbnail.src = e.target.result;
                            thumbnail.style.width = '80px';
                            thumbnail.style.height = '80px';
                            thumbnail.style.marginLeft = '10px';
                            thumbnail.style.cursor = 'pointer';
                            thumbnail.style.borderRadius = '50%';
                            uploadIcon.parentNode.replaceChild(thumbnail, uploadIcon);

                            // add image click event on the new image
                            thumbnail.addEventListener('click', function() {
                                photoInput.click();
                            });
                        }
                    };
                    reader.readAsDataURL(file);
                }
            });
        });
    </script>
@endsection
