@extends('layouts.master')

@section('title')

@endsection

@section('css')
@endsection

@section('content')
    <div class="content">
        <div class="row">
            <div class="col-lg-8 offset-lg-2">
                <h4 class="page-title">Add Department</h4>
            </div>
        </div>
        <div class="row">
            <div class="col-lg-8 offset-lg-2">
                <form action="{{ route('departments.store') }}" method="post" enctype="multipart/form-data">
                    @csrf
                    {{-- image section --}}
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label for="photo">image :</label>
                                <div style="display: flex; align-items: center;">
                                    <i class="fas fa-upload" id="upload-icon" style="font-size: 30px; cursor: pointer;"></i>
=                                    <input type="file" id="photo" name="profile_image" accept=".jpg,.jpeg,.png"
                                        style="display: none;">
                                    <img id="thumbnail"
                                        style="display:none; width: 70px; height: 70px; margin-left: 10px; cursor: pointer;">

                                </div>
                            </div>
                        </div>
                        {{-- image section --}}
                    <div class="form-group">
                        <label>Department Name</label>
                        <input required class="form-control" type="text" name="name">
                    </div>
                    <div class="form-group">
                        <label>Description</label>
                        <textarea required name="description" cols="30" rows="4" class="form-control"></textarea>
                    </div>
                    <div class="form-group">
                        <label class="display-block">Department Status</label>
                        <div class="form-check form-check-inline">
                            <input required class="form-check-input" type="radio" name="status" id="product_active"
                                value="active">
                            <label class="form-check-label" for="product_active">
                                Active
                            </label>
                        </div>
                        <div class="form-check form-check-inline">
                            <input class="form-check-input" type="radio" name="status" id="product_inactive"
                                value="inactive">
                            <label class="form-check-label" for="product_inactive">
                                Inactive
                            </label>
                        </div>
                    </div>

                    <div class="m-t-20 text-center">
                        <button class="btn btn-primary submit-btn">Create Department</button>
                    </div>
                    <a href="javascript:history.back()" class="btn btn-secondary mb-3" rel="prev">
                        <i class="fa fa-arrow-left mr-2"></i> Back
                    </a>
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
