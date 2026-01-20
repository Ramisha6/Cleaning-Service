@extends('admin.dashboard')
@section('admin_content')
    {{-- Breadcrumb --}}
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">Booking Details</h1>

        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Home</a></li>
            <li class="breadcrumb-item"><a href="{{ route('admin.Booking.list') }}">Booking List</a></li>
            <li class="breadcrumb-item active" aria-current="page">{{ $booking->invoice_no }}</li>
        </ol>
    </div>

    <div class="row">

        {{-- Left: Details --}}
        <div class="col-lg-8">
            <div class="card mb-4">
                <div class="card-header d-flex align-items-center justify-content-between">
                    <h6 class="m-0 font-weight-bold text-primary">
                        Invoice: <span class="text-dark">{{ $booking->invoice_no }}</span>
                    </h6>

                    <a href="{{ route('admin.Booking.list') }}" class="btn btn-sm btn-secondary">Back</a>
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

                            <p class="mb-0">
                                <strong>Booking Date:</strong>
                                {{ $booking->booking_date
                                    ? \Carbon\Carbon::parse($booking->booking_date)->format('d M Y')
                                    : 'N/A' }}
                            </p>

                            <p class="mb-0">
                                <strong>Booking Time:</strong>
                                @if ($booking->booking_start_at && $booking->booking_end_at)
                                    {{ \Carbon\Carbon::parse($booking->booking_start_at)->format('h:i A') }}
                                    -
                                    {{ \Carbon\Carbon::parse($booking->booking_end_at)->format('h:i A') }}
                                @else
                                    <span class="text-muted">Time not set yet</span>
                                @endif
                            </p>
                        </div>
                    </div>

                    <hr>

                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <h6 class="font-weight-bold">Payment</h6>
                            <p class="mb-1"><strong>Method:</strong> {{ strtoupper($booking->payment_method) }}</p>

                            <p class="mb-1">
                                <strong>Payment Status:</strong>
                                @if ($booking->payment_status === 'verified')
                                    <span class="badge badge-success">Verified</span>
                                @elseif($booking->payment_status === 'unverified')
                                    <span class="badge badge-warning">Unverified</span>
                                @elseif($booking->payment_status === 'rejected')
                                    <span class="badge badge-danger">Rejected</span>
                                @else
                                    <span class="badge badge-secondary">{{ ucfirst($booking->payment_status) }}</span>
                                @endif
                            </p>

                            @if ($booking->payment_method === 'bkash')
                                <p class="mb-1"><strong>bKash Number:</strong> {{ $booking->bkash_number ?? 'N/A' }}</p>
                                <p class="mb-0"><strong>Transaction ID:</strong> {{ $booking->transaction_id ?? 'N/A' }}</p>
                            @endif
                        </div>

                        <div class="col-md-6 mb-3">
                            <h6 class="font-weight-bold">Booking Status</h6>

                            <p class="mb-1">
                                <strong>Status:</strong>
                                @if ($booking->status === 'confirmed')
                                    <span class="badge badge-success">Confirmed</span>
                                @elseif($booking->status === 'cancelled')
                                    <span class="badge badge-danger">Cancelled</span>
                                @else
                                    <span class="badge badge-warning">Pending</span>
                                @endif
                            </p>

                            <p class="mb-1">
                                <strong>Progress Status:</strong>
                                @if ($booking->progress_status === 'completed')
                                    <span class="badge badge-success">Completed</span>
                                @elseif($booking->progress_status === 'in_progress')
                                    <span class="badge badge-primary">In Progress</span>
                                @elseif($booking->progress_status === 'rejected')
                                    <span class="badge badge-danger">Rejected</span>
                                @else
                                    <span class="badge badge-warning">Pending</span>
                                @endif
                            </p>

                            <p class="mb-0">
                                <strong>Created:</strong> {{ optional($booking->created_at)->format('d M Y, h:i A') }}
                            </p>
                        </div>
                    </div>

                    <hr>

                    <h6 class="font-weight-bold">Note</h6>
                    <p class="mb-0">{{ $booking->note ?? 'No note' }}</p>

                </div>
            </div>
        </div>

        {{-- Right: Actions --}}
        <div class="col-lg-4">

            <div class="card mb-4">
                <div class="card-header">
                    <h6 class="m-0 font-weight-bold text-primary">Actions</h6>
                </div>

                <div class="card-body">

                    <h6 class="font-weight-bold mb-2">Status Actions</h6>

                    {{-- Booking Actions --}}
                    <form action="{{ route('admin.booking.confirm', $booking->id) }}" method="POST" class="mb-2">
                        @csrf
                        <button type="submit" class="btn btn-success btn-block">
                            Confirm Booking
                        </button>
                    </form>

                    <form action="{{ route('admin.booking.cancel', $booking->id) }}" method="POST" class="mb-3">
                        @csrf
                        <button type="submit" class="btn btn-danger btn-block">
                            Cancel Booking
                        </button>
                    </form>

                    {{-- Payment Actions (bKash only) --}}
                    @if ($booking->payment_method === 'bkash')
                        <hr>

                        <h6 class="font-weight-bold mb-2">Payment Actions</h6>

                        <div class="text-small mb-2">
                            bKash payment requires verification.
                        </div>

                        <form action="{{ route('admin.booking.payment.verify', $booking->id) }}" method="POST" class="mb-2">
                            @csrf
                            <button type="submit" class="btn btn-success btn-block">
                                Verify Payment
                            </button>
                        </form>

                        <form action="{{ route('admin.booking.payment.reject', $booking->id) }}" method="POST">
                            @csrf
                            <button type="submit" class="btn btn-danger btn-block">
                                Reject Payment
                            </button>
                        </form>
                    @endif

                    {{-- ✅ Progress Status + Progress Actions removed এখান থেকে --}}
                </div>
            </div>

        </div>

    </div>
@endsection
