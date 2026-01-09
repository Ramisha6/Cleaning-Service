@extends('admin.dashboard')
@section('admin_content')
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">Booking List</h1>
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Home</a></li>
            <li class="breadcrumb-item active" aria-current="page">Bookings</li>
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
                                <th>Invoice</th>
                                <th>User</th>
                                <th>Service</th>
                                <th>Date</th>
                                <th>Payment</th>
                                <th>Payment Status</th>
                                <th>Status</th>
                                <th>Action</th>
                            </tr>
                        </thead>

                        <tbody>
                            @foreach ($booking_list as $key => $booking)
                                <tr>
                                    <td>{{ $key + 1 }}</td>
                                    <td><strong>{{ $booking->invoice_no }}</strong></td>
                                    <td>{{ optional($booking->user)->name ?? 'N/A' }}</td>
                                    <td>{{ optional($booking->service)->service_title ?? 'N/A' }}</td>
                                    <td>{{ optional($booking->booking_date)->format('d M Y') }}</td>

                                    <td>
                                        <span class="badge badge-secondary">
                                            {{ strtoupper($booking->payment_method) }}
                                        </span>
                                    </td>

                                    <td>
                                        @if ($booking->payment_status === 'verified')
                                            <span class="badge badge-success">Verified</span>
                                        @elseif($booking->payment_status === 'unverified')
                                            <span class="badge badge-warning">Unverified</span>
                                        @elseif($booking->payment_status === 'rejected')
                                            <span class="badge badge-danger">Rejected</span>
                                        @else
                                            <span class="badge badge-secondary">{{ ucfirst($booking->payment_status) }}</span>
                                        @endif
                                    </td>

                                    <td>
                                        @if ($booking->status === 'confirmed')
                                            <span class="badge badge-success">Confirmed</span>
                                        @elseif($booking->status === 'cancelled')
                                            <span class="badge badge-danger">Cancelled</span>
                                        @else
                                            <span class="badge badge-warning">Pending</span>
                                        @endif
                                    </td>

                                    <td style="display: block ruby;">
                                        <a href="{{ route('admin.Booking.show', $booking->id) }}" class="btn btn-sm btn-primary">
                                            View
                                        </a>

                                        <a href="{{ route('admin.Booking.invoice', $booking->id) }}" class="btn btn-sm btn-info">
                                            Invoice
                                        </a>

                                        <a href="{{ route('admin.Booking.invoice.download', $booking->id) }}" class="btn btn-sm btn-dark" target="_blank">
                                            Download
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
