@extends('layouts.master')

@section('title')
@endsection

@section('css')
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
@endsection

@section('content')
    <div class="content">
        <div class="row">
            <div class="col-lg-8 offset-lg-2">
                <h4 class="page-title">Edit Department</h4>
            </div>
        </div>
        <div class="row">
            <div class="col-lg-8 offset-lg-2">
                <form action="{{ route('departments.update', $department->id) }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')
                    {{-- image section --}}
                    <div class="col-sm-6">
                    <div class="form-group">
                     <label for="photo">Department Image:</label>
                     <div style="display: flex; align-items: center;">
                        @if($department->image)
                    <!-- If there is an image, display it -->
                      <img id="thumbnail" src="{{ asset('storage/' . $department->image->image_path) }}" 
                      style="width: 70px; height: 70px; margin-left: 10px; cursor: pointer; border-radius: 50%;">
                       @else
                       <!-- If there is no image, display the upload icon -->
                       <i class="fas fa-upload" id="upload-icon" style="font-size: 30px; cursor: pointer;"></i>
                       @endif
                       <!-- Input field to upload new image -->
                       <input type="file" id="photo" name="profile_image" accept=".jpg,.jpeg,.png" style="display: none;">
                     </div>
                    </div>
                   </div>
                   {{-- end  of image section --}} 
                    <div class="form-group">
                        <label>Department Name</label>
                        <input class="form-control" name="name" type="text" value="{{ $department->name }}">
                    </div>
                    <div class="form-group">
                        <label>Description</label>
                        <textarea cols="30" name="description" rows="4" class="form-control">{{ $department->description }}</textarea>
                    </div>
                    <div class="form-group">
                        <label class="display-block">Department Status</label>
                        <div class="form-check form-check-inline">
                            <input class="form-check-input" type="radio" name="status" value="1"
                                {{ $department->status == 1 ? 'checked' : '' }}>
                            <label class="form-check-label" for="product_active">Active</label>
                        </div>
                        <div class="form-check form-check-inline">
                            <input class="form-check-input" type="radio" name="status" value="0"
                                {{ $department->status == 0 ? 'checked' : '' }}>
                            <label class="form-check-label" for="product_inactive">Inactive</label>
                        </div>
                    </div>
                    <div class="form-group text-right">
                        <button type="submit" class="btn btn-primary">
                            <i class="fa fa-save mr-1"></i> Save Changes
                        </button>
                        <a href="javascript:history.back()" class="btn btn-secondary">
                            <i class="fa fa-arrow-left mr-1"></i> Back
                        </a>
                    </div>
                </form>
            </div>
        </div>
    </div>
      
@endsection

@section('scripts')
<script>

// image & image icon
            document.addEventListener('DOMContentLoaded', function() {
                var uploadIcon = document.getElementById('upload-icon');
                var thumbnail = document.getElementById('thumbnail');
                var photoInput = document.getElementById('photo');

                // Handle clicking on the image icon
                if (uploadIcon) {
                    uploadIcon.addEventListener('click', function() {
                        photoInput.click();});
                }

                // Handle by clicking on the image
                if (thumbnail) {
                    thumbnail.addEventListener('click', function() {
                        photoInput.click();});
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

