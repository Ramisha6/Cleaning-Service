@extends('admin.dashboard')
@section('admin_content')
    {{-- Breadcrumb --}}
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">Service Add</h1>
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="./">Home</a></li>
            <li class="breadcrumb-item"><a href="{{ route('admin.Service.list') }}">Service List</a></li>
            <li class="breadcrumb-item active" aria-current="page">Back</li>
        </ol>
    </div>


    <div class="row">

        <div class="col-lg-12">

            <div class="card mb-4">

                <div class="card-body">

                    <form action="{{ route('admin.Service.store') }}" method="post" enctype="multipart/form-data"
                        autocomplete="off">

                        @csrf

                        <div class="form-group">
                            <label>Service Title</label>
                            <input type="text" class="form-control" name="service_title"
                                placeholder="Enter cleaning service title" required>
                        </div>
                        <div class="form-group">
                            <label>Service Slug</label>
                            <input type="text" class="form-control" name="service_slug"
                                placeholder="Enter cleaning service slug" required>
                        </div>

                        <div class="form-group">
                            <label>Service Price</label>
                            <input type="text" class="form-control" name="service_price"
                                placeholder="Enter cleaning service price" required>
                        </div>

                        <div class="form-group">
                            <label>Service Short Description</label>
                            <textarea class="form-control" name="service_short_description" rows="3" required></textarea>
                        </div>

                        <div class="form-group">
                            <label>Service Long Description</label>
                            <textarea class="form-control summernote" name="service_long_description" rows="5" required></textarea>
                        </div>

                        <div class="form-group">
                            <div class="custom-file">
                                <input type="file" class="custom-file-input" id="customFile" name="service_image"
                                    required>
                                <label class="custom-file-label" for="customFile">Choose file</label>
                            </div>
                        </div>

                        <button type="submit" class="btn btn-primary">Submit</button>

                    </form>

                </div>

            </div>

        </div>

    </div>
@endsection
