@extends('cleaner.dashboard')
@section('admin_content')
    <!-- jQuery should be loaded BEFORE your custom scripts -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">My Assigned Bookings</h1>
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('cleaner.dashboard') }}">Home</a></li>
            <li class="breadcrumb-item active" aria-current="page">My Bookings</li>
        </ol>
    </div>

    <div class="row">

        {{-- Left: Details --}}
        <div class="col-lg-12">
            <div class="card mb-4">
                <div class="card-header d-flex align-items-center justify-content-between">
                    <h6 class="m-0 font-weight-bold text-primary">
                        Invoice: <span class="text-dark">{{ $booking->invoice_no }}</span>
                    </h6>

                    <a href="{{ route('cleaner.Booking.list') }}" class="btn btn-sm btn-secondary">Back</a>
                </div>

                <div class="card-body">

                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <h6 class="font-weight-bold">Customer</h6>
                            <p class="mb-1"><strong>Name:</strong> {{ $booking->name }}</p>
                            <p class="mb-1"><strong>Email:</strong> {{ $booking->email ?? 'N/A' }}</p>
                            <p class="mb-1"><strong>Phone:</strong> {{ $booking->phone }}</p>
                            <p class="mb-0"><strong>User Account:</strong> {{ optional($booking->user)->name ?? 'N/A' }}</p>
                        </div>

                        <div class="col-md-6 mb-3">
                            <h6 class="font-weight-bold">Service</h6>
                            <p class="mb-1"><strong>Title:</strong> {{ optional($booking->service)->service_title ?? 'N/A' }}</p>
                            <p class="mb-1"><strong>Price:</strong> ৳{{ optional($booking->service)->service_price ?? '0' }}</p>
                            <p class="mb-1"><strong>Duration:</strong> {{ optional($booking->service)->service_duration ?? 'N/A' }}</p>
                            <p class="mb-0"><strong>Booking Date:</strong> {{ optional($booking->booking_date)->format('d M Y') }}</p>
                        </div>
                    </div>

                    <hr>
                    <h6 class="font-weight-bold">Note</h6>
                    <p class="mb-0">{{ $booking->note ?? 'No note' }}</p>

                </div>
            </div>
        </div>
    </div>
@endsection
