@extends('admin.dashboard')
@section('admin_content')
    {{-- Breadcrumb --}}
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">Service Add</h1>
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="./">Home</a></li>
            <li class="breadcrumb-item"><a href="{{ route('admin.Service.list') }}">Service List</a></li>
            <li class="breadcrumb-item active" aria-current="page">
                <a href="{{ url()->previous() }}">Back</a>
            </li>
        </ol>
    </div>

    {{-- Service Form --}}
    <div class="row">

        <div class="col-lg-12">

            <div class="card mb-4">

                <div class="card-body">

                    @include('widgets.errors')

                    <form action="{{ route('admin.Service.store') }}" method="POST" enctype="multipart/form-data">
                        @csrf

                        <div class="form-group">
                            <label>Service Title</label>
                            <input type="text" class="form-control @error('service_title') is-invalid @enderror" name="service_title" value="{{ old('service_title') }}">
                        </div>

                        <div class="form-group">
                            <label>Service Slug</label>
                            <input type="text" class="form-control @error('service_slug') is-invalid @enderror" name="service_slug" value="{{ old('service_slug') }}">
                        </div>

                        <div class="form-group">
                            <label>Service Price (৳)</label>
                            <input type="number" min="0" class="form-control @error('service_price') is-invalid @enderror" name="service_price" value="{{ old('service_price') }}">
                        </div>

                        <div class="form-group">
                            <label>Service Duration</label>
                            <input type="text" class="form-control @error('service_duration') is-invalid @enderror" name="service_duration" value="{{ old('service_duration') }}">
                        </div>

                        <div class="form-group">
                            <label>Service Short Description</label>
                            <textarea class="form-control @error('service_short_description') is-invalid @enderror" name="service_short_description" rows="3">{{ old('service_short_description') }}</textarea>
                        </div>

                        <div class="form-group">
                            <label>Service Long Description</label>
                            <textarea class="form-control summernote @error('service_long_description') is-invalid @enderror" name="service_long_description" rows="5">{{ old('service_long_description') }}</textarea>
                        </div>

                        <div class="form-group">
                            <label>Service Image [914px by 536px]</label>
                            <input type="file" class="form-control @error('service_image') is-invalid @enderror" name="service_image" onchange="showImage(this)">
                            <img id="image" src="" alt="" style="max-width: 100px; margin-top: 10px">
                        </div>

                        <button type="submit" class="btn btn-primary">
                            Submit
                        </button>

                    </form>

                </div>

            </div>

        </div>

    </div>

    <script>
        function showImage(input) {
            if (input.files && input.files[0]) {
                var reader = new FileReader();
                reader.onload = function(e) {
                    $('#image').attr('src', e.target.result);
                }
                reader.readAsDataURL(input.files[0]);
            }
        }
    </script>
@endsection
