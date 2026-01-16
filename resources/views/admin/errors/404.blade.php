@extends('admin.dashboard')
@section('admin_content')
    <div class="text-center">
        <img src="{{ asset('backend/assets/img/error.svg') }}" style="max-height: 100px;" class="mb-3">
        <h3 class="text-gray-800 font-weight-bold">Oopss!</h3>
        <p class="lead text-gray-800 mx-auto">404 Page Not Found</p>
        <a href="{{ route('admin.dashboard') }}">&larr; Back to Dashboard</a>
    </div>
@endsection
