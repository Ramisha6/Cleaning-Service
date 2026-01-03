@extends('admin.dashboard')
@section('admin_content')
    {{-- Breadcrumb --}}
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">Service List</h1>
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="./">Home</a></li>
            <li class="breadcrumb-item"><a href="{{ route('admin.Service.add') }}">Service Add</a></li>
            <li class="breadcrumb-item active" aria-current="page">Back</li>
        </ol>
    </div>

    {{-- Main Datatable --}}
    <div class="row">

        <!-- DataTable with Hover -->
        <div class="col-lg-12">

            <div class="card mb-4">

                <div class="table-responsive p-3">

                    <table class="table align-items-center table-flush table-hover" id="dataTableHover">

                        <thead class="thead-light">
                            <tr>
                                <th>SN</th>
                                <th>Title</th>
                                <th>Price</th>
                                <th>Image</th>
                                <th>Status</th>
                                <th>Action</th>
                            </tr>
                        </thead>

                        <tbody>
                            @foreach ($service_list as $key => $service)
                                <tr>
                                    <td>{{ $key + 1 }}</td>
                                    <td>{{ $service->service_title }}</td>
                                    <td>{{ $service->service_price }}</td>
                                    <td>
                                        <img src="{{ asset($service->service_image) }}" width="100"
                                            alt="{{ $service->service_title }}">
                                    </td>
                                    <td><span class="badge badge-success">{{ $service->service_status }}</span></td>
                                    <td>
                                        <a href="{{ route('admin.Service.edit', $service->id) }}"
                                            class="btn btn-sm btn-info">Edit</a>
                                        <a href="{{ route('admin.Service.delete', $service->id) }}"
                                            class="btn btn-sm btn-danger"
                                            onclick="confirmDelete({{ $service->id }})">Delete</a>
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
