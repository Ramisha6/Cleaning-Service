@extends('admin.dashboard')
@section('admin_content')
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">Cleaner Edit</h1>
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="./">Home</a></li>
            <li class="breadcrumb-item"><a href="{{ route('admin.cleaner.list') }}">Cleaner List</a></li>
            <li class="breadcrumb-item active">Edit</li>
        </ol>
    </div>

    <div class="row">
        <div class="col-lg-12">
            <div class="card mb-4">
                <div class="card-body">

                    @include('widgets.errors')

                    <form action="{{ route('admin.cleaner.update', $cleaner->id) }}" method="POST">
                        @csrf

                        <div class="form-group">
                            <label>Cleaner Name</label>
                            <input type="text" name="name" value="{{ old('name', $cleaner->name) }}" class="form-control">
                        </div>

                        <div class="form-group">
                            <label>Cleaner Email</label>
                            <input type="email" name="email" value="{{ old('email', $cleaner->email) }}" class="form-control">
                        </div>

                        <button class="btn btn-primary">Update</button>
                    </form>

                </div>
            </div>
        </div>
    </div>
@endsection
