@extends('admin.dashboard')
@section('admin_content')
    {{-- Breadcrumb --}}
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">Event Edit</h1>
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="./">Home</a></li>
            <li class="breadcrumb-item"><a href="{{ route('admin.event.list') }}">Event List</a></li>
            <li class="breadcrumb-item active" aria-current="page">
                <a href="{{ url()->previous() }}">Back</a>
            </li>
        </ol>
    </div>

    <div class="row">
        <div class="col-lg-12">
            <div class="card mb-4">
                <div class="card-body">

                    @include('widgets.errors')

                    <form action="{{ route('admin.event.update', $event_info->id) }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        {{-- If your update route uses PUT/PATCH --}}
                        @method('POST')
                        {{-- Change above to @method('PUT') if your route is Route::put(...) --}}
                        {{-- Or @method('PATCH') if your route is Route::patch(...) --}}

                        <div class="row">

                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Event Title <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control @error('title') is-invalid @enderror" name="title" value="{{ old('title', $event_info->title) }}" placeholder="Enter event title">
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Event Slug <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control @error('slug') is-invalid @enderror" name="slug" value="{{ old('slug', $event_info->slug) }}" placeholder="example: cleaning-campaign-2026">
                                    <small class="text-muted">Slug must be unique. Use lowercase + hyphen (-).</small>
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Event Date <span class="text-danger">*</span></label>
                                    <input type="date" class="form-control @error('event_date') is-invalid @enderror" name="event_date" value="{{ old('event_date', optional($event_info->event_date)->format('Y-m-d') ?? $event_info->event_date) }}">
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Event Time</label>
                                    <input type="time" class="form-control @error('event_time') is-invalid @enderror" name="event_time" value="{{ old('event_time', $event_info->event_time) }}">
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Location</label>
                                    <input type="text" class="form-control @error('location') is-invalid @enderror" name="location" value="{{ old('location', $event_info->location) }}" placeholder="Dhaka, Bangladesh">
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Status <span class="text-danger">*</span></label>
                                    <select name="status" class="form-control @error('status') is-invalid @enderror">
                                        <option value="active" {{ old('status', $event_info->status) == 'active' ? 'selected' : '' }}>Active</option>
                                        <option value="inactive" {{ old('status', $event_info->status) == 'inactive' ? 'selected' : '' }}>Inactive</option>
                                    </select>
                                </div>
                            </div>

                            <div class="col-md-12">
                                <div class="form-group">
                                    <label>Short Description</label>
                                    <textarea class="form-control @error('short_description') is-invalid @enderror" name="short_description" rows="3" placeholder="Short summary for event list page">{{ old('short_description', $event_info->short_description) }}</textarea>
                                </div>
                            </div>

                            <div class="col-md-12">
                                <div class="form-group">
                                    <label>Event Details <span class="text-danger">*</span></label>
                                    <textarea class="form-control summernote @error('description') is-invalid @enderror" name="description" rows="6">{{ old('description', $event_info->description) }}</textarea>
                                </div>
                            </div>

                            <div class="col-md-12">
                                <div class="form-group">
                                    <label>Event Image [914px by 536px]</label>
                                    <input type="file" class="form-control @error('event_image') is-invalid @enderror" name="event_image" accept="image/*" onchange="showImage(this)">

                                    <img id="imagePreview" src="{{ $event_info->event_image ? asset('upload/event_image/' . $event_info->event_image) : '' }}" alt="" style="max-width: 220px; margin-top: 10px; {{ $event_info->event_image ? '' : 'display:none;' }}">
                                </div>
                            </div>

                        </div>

                        <button type="submit" class="btn btn-primary">Update</button>

                    </form>

                </div>
            </div>
        </div>
    </div>

    <script>
        function showImage(input) {
            const preview = document.getElementById('imagePreview');
            if (input.files && input.files[0]) {
                const reader = new FileReader();
                reader.onload = function(e) {
                    preview.style.display = 'block';
                    preview.src = e.target.result;
                }
                reader.readAsDataURL(input.files[0]);
            }
        }
    </script>
@endsection
