@extends('admin.dashboard')
@section('admin_content')
    {{-- Breadcrumb --}}
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">Slider Add</h1>
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="./">Home</a></li>
            <li class="breadcrumb-item"><a href="{{ route('admin.slider.list') }}">Slider List</a></li>
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

                    <form action="{{ route('admin.slider.update', $slider_info->id) }}" method="POST" enctype="multipart/form-data">

                        @csrf

                        <div class="form-group">
                            <label>Slider Image [1920px by 780px]</label>
                            <input type="file" class="form-control @error('slider_image') is-invalid @enderror" name="slider_image" onchange="showImage(this)">
                            <img id="image" src="{{ $slider_info->slider_image ? asset('upload/slider_image/' . $slider_info->slider_image) : '' }}" class="img-thumbnail" style="width: 250px; margin-top: 10px">
                        </div>

                        <div class="form-group">
                            <label>Slider Status</label>
                            <select name="slider_status" class="form-control @error('slider_status') is-invalid @enderror">
                                <option value="active" {{ old('slider_status', $slider_info->slider_status) == 'active' ? 'selected' : '' }}>
                                    Active
                                </option>
                                <option value="inactive" {{ old('slider_status', $slider_info->slider_status) == 'inactive' ? 'selected' : '' }}>
                                    Inactive
                                </option>
                            </select>
                            @error('slider_status')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <button type="submit" class="btn btn-primary">
                            Update
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
