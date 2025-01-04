@extends('layouts.master')

@section('title')
Edit {{ $clinic->name }} Info
@endsection

@section('css')
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
@endsection

@section('content')
<div class="content">
    <a href="javascript:history.back()" class="btn btn-secondary mb-3" rel="prev">
        <i class="fa fa-arrow-left mr-2"></i> Back
    </a>
    <div class="row">
        <div class="col-lg-8 offset-lg-2">
            <h4 class="page-title">Edit info</h4>
        </div>
    </div>

    <div class="row">
        <div class="col-lg-8 offset-lg-2">
            <form action="{{ route('clinic.update', $clinic->id) }}" method="post" enctype='multipart/form-data'>
                @csrf
                @method('PUT')
                <div class="row">
                    <div class="col-sm-6">
                        <div class="form-group">
                            <label for="logo">Logo:</label>
                            <div style="display: flex; align-items: center;">
                                @if($clinic->image)
                                    <img id="thumbnail" src="{{ asset('storage/' . $clinic->image->image_path) }}" 
                                         style="width: 70px; height: 70px; margin-left: 10px; cursor: pointer; border-radius: 50%;">
                                @else
                                    <i class="fas fa-upload" id="upload-icon" style="font-size: 30px; cursor: pointer;"></i>
                                @endif
                                <input type="file" id="logo" name="profile_image" accept=".jpg,.jpeg,.png" style="display: none;">
                            </div>
                        </div>
                    </div> 
                </div>
                <div class="row">
                    <div class="col-sm-6">
                        <div class="form-group">
                            <label>Name <span class="text-danger">*</span></label>
                            <input required name='name' value='{{ $clinic->name }}' class="form-control" type="text">
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label>Established at</label> <span class="text-danger">*</span>
                            <input required type="date" name="established_at" class="form-control"
                              value="{{ old('established_at', $clinic->established_at ? \Carbon\Carbon::parse($clinic->established_at)->format('Y-m-d') : '') }}">
                        </div>
                    </div>
                    <div class="col-sm-6">
                        <div class="form-group">
                            <label>Email</label>
                            <span class="text-danger">*</span>
                            <input required name='email' class="form-control" type="email" value="{{ $clinic->email }}">
                        </div>
                    </div>
                    <div class="col-sm-6">
                        <div class="form-group">
                            <label>Phone Number</label>
                            <span class="text-danger">*</span>
                            <input required name='phone' class="form-control" type="text" value="{{ $clinic->phone_number }}">
                        </div>
                    </div>
                    <div class="col-sm-6">
                        <div class="form-group">
                            <label>Address</label>
                            <span class="text-danger">*</span>
                            <input required name='address' class="form-control" type="text" value="{{ $clinic->address }}">
                        </div>
                    </div>
                    <div class="form-group">
                        <label>About</label>
                        <span class="text-danger">*</span>
                        <textarea class="form-control" id="qualifications" name="about" rows="8" cols="200">{{ $clinic->about }}</textarea>
                    </div>
                </div>
                <div class="m-t-20 text-center">
                    <button class="btn btn-primary submit-btn">Update Info</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    var uploadIcon = document.getElementById('upload-icon');
    var thumbnail = document.getElementById('thumbnail');
    var photoInput = document.getElementById('logo');

    console.log('DOM loaded');
    console.log('uploadIcon:', uploadIcon);
    console.log('thumbnail:', thumbnail);

    function bindClickEvent(element, input) {
        if (element) {
            element.addEventListener('click', function() {
                console.log('Click event triggered on', element.id);
                input.click();
            });
        }
    }

    bindClickEvent(uploadIcon, photoInput);
    bindClickEvent(thumbnail, photoInput);

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
                    bindClickEvent(thumbnail, photoInput);
                }
            };
            reader.readAsDataURL(file);
        }
    });
});
</script>
@endsection
