@extends('admin.dashboard')
@section('admin_content')
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">Cleaner List</h1>
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="./">Home</a></li>
            <li class="breadcrumb-item"><a href="{{ route('admin.cleaner.add') }}">Cleaner Add</a></li>
            <li class="breadcrumb-item active">List</li>
        </ol>
    </div>

    <div class="row">
        <div class="col-lg-12">
            <div class="card mb-4">
                <div class="table-responsive p-3">
                    <table class="table align-items-center table-flush table-hover" id="dataTableHover">
                        <thead class="thead-light">
                            <tr>
                                <th>SN</th>
                                <th>Name</th>
                                <th>Email</th>
                                <th>Role</th>
                                <th>Action</th>
                            </tr>
                        </thead>

                        <tbody>
                            @foreach ($cleaner_list as $key => $cleaner)
                                <tr>
                                    <td>{{ $key + 1 }}</td>
                                    <td>{{ $cleaner->name }}</td>
                                    <td>{{ $cleaner->email }}</td>
                                    <td>
                                        <span class="badge badge-info">Cleaner</span>
                                    </td>
                                    <td>
                                        <a href="{{ route('admin.cleaner.edit', $cleaner->id) }}" class="btn btn-sm btn-info">Edit</a>

                                        <a href="{{ route('admin.cleaner.delete', $cleaner->id) }}" class="btn btn-sm btn-danger" onclick="return confirm('Are you sure?')">
                                            Delete
                                        </a>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>

                    </table>
                </div>
            </div>
        </div>
    </div>
@endsection
