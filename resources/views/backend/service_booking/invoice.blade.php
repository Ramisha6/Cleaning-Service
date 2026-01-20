@extends('admin.dashboard')
@section('admin_content')
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">Invoice</h1>
        <div>
            <a href="{{ route('admin.Booking.show', $booking->id) }}" class="btn btn-sm btn-secondary">Back</a>
            <a href="{{ route('admin.Booking.invoice.download', $booking->id) }}" class="btn btn-sm btn-dark" target="_blank">Download</a>
        </div>
    </div>

    <div class="card mb-4">
        <div class="card-body">
            <h5 class="mb-1">Invoice No: <strong>{{ $booking->invoice_no }}</strong></h5>
            <p class="mb-3 text-muted">Issued: {{ $booking->created_at->format('d M Y') }}</p>

            <div class="row">
                <div class="col-md-6">
                    <h6><strong>Customer</strong></h6>
                    <p class="mb-1">{{ $booking->name }}</p>
                    <p class="mb-1">{{ $booking->email ?? 'N/A' }}</p>
                    <p class="mb-1">{{ $booking->phone }}</p>
                </div>

                <div class="col-md-6 text-md-right">
                    <h6><strong>Service</strong></h6>
                    <p class="mb-1">{{ optional($booking->service)->service_title ?? 'N/A' }}</p>

                    <p class="mb-1">
                        Booking Date:
                        {{ $booking->booking_date ? \Carbon\Carbon::parse($booking->booking_date)->format('d M Y') : 'N/A' }}
                    </p>

                    <p class="mb-1">
                        Booking Time:
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

            <div class="table-responsive">
                <table class="table table-bordered">
                    <thead class="thead-light">
                        <tr>
                            <th>Description</th>
                            <th class="text-right" style="width:160px;">Amount</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>
                                {{ optional($booking->service)->service_title ?? 'Service' }}
                                @if (optional($booking->service)->service_duration)
                                    <div class="text-muted small">
                                        Duration: {{ $booking->service->service_duration }}
                                    </div>
                                @endif
                            </td>
                            <td class="text-right">
                                ৳{{ optional($booking->service)->service_price ?? '0' }}
                            </td>
                        </tr>
                    </tbody>
                    <tfoot>
                        <tr>
                            <th class="text-right">Total</th>
                            <th class="text-right">৳{{ optional($booking->service)->service_price ?? '0' }}</th>
                        </tr>
                    </tfoot>
                </table>
            </div>

            <hr>

            <p class="mb-1"><strong>Payment Method:</strong> {{ strtoupper($booking->payment_method) }}</p>
            <p class="mb-1"><strong>Payment Status:</strong> {{ ucfirst($booking->payment_status) }}</p>

            @if ($booking->payment_method === 'bkash')
                <p class="mb-1"><strong>bKash Number:</strong> {{ $booking->bkash_number ?? 'N/A' }}</p>
                <p class="mb-0"><strong>Transaction ID:</strong> {{ $booking->transaction_id ?? 'N/A' }}</p>
            @endif
        </div>
    </div>
@endsection
