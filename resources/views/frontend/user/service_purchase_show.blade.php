@extends('frontend.dashboard')
@section('frontend_title', 'Service Purchase Details')
@section('frontend')

    <section>
        <div class="container" style="padding: 60px 0;">
            <div class="row justify-content-center">
                <div class="col-lg-10">

                    <div class="card shadow-sm">
                        <div class="card-body">

                            <div class="d-flex justify-content-between align-items-start flex-wrap gap-2 mb-3">
                                <div>
                                    <h4 class="mb-1">Service Purchase Details</h4>
                                    <div class="text-muted">Invoice: <strong>{{ $booking->invoice_no }}</strong></div>
                                </div>

                                <div class="d-flex gap-2">
                                    <a href="{{ route('user.service.purchase.invoice', $booking->id) }}" class="btn btn-primary btn-sm">
                                        View Invoice
                                    </a>

                                    <a href="{{ route('user.service.purchase.invoice.print', $booking->id) }}" class="btn btn-outline-dark btn-sm" target="_blank">
                                        Print
                                    </a>

                                    <a href="{{ route('dashboard') }}#orders" class="btn btn-outline-secondary btn-sm">
                                        Back
                                    </a>
                                </div>
                            </div>

                            <hr>

                            <div class="row g-3">
                                <div class="col-md-6">
                                    <h6 class="mb-2">Customer</h6>
                                    <div><strong>Name:</strong> {{ $booking->name }}</div>
                                    <div><strong>Email:</strong> {{ $booking->email ?? 'N/A' }}</div>
                                    <div><strong>Phone:</strong> {{ $booking->phone }}</div>
                                </div>

                                <div class="col-md-6">
                                    <h6 class="mb-2">Booking</h6>
                                    <div><strong>Service:</strong> {{ optional($booking->service)->service_title ?? 'N/A' }}</div>
                                    <div><strong>Date:</strong> {{ optional($booking->booking_date)->format('d M Y') }}</div>
                                    <div><strong>Status:</strong> {{ ucfirst($booking->status) }}</div>
                                </div>

                                <div class="col-md-6">
                                    <h6 class="mb-2">Payment</h6>
                                    <div><strong>Method:</strong> {{ strtoupper($booking->payment_method) }}</div>
                                    <div><strong>Payment Status:</strong> {{ ucfirst($booking->payment_status) }}</div>

                                    @if ($booking->payment_method === 'bkash')
                                        <div><strong>bKash Number:</strong> {{ $booking->bkash_number ?? 'N/A' }}</div>
                                        <div><strong>Transaction ID:</strong> {{ $booking->transaction_id ?? 'N/A' }}</div>
                                    @endif
                                </div>

                                <div class="col-md-6">
                                    <h6 class="mb-2">Note</h6>
                                    <div>{{ $booking->note ?? 'No note' }}</div>
                                </div>
                            </div>

                            <hr>

                            <div class="mt-3">
                                <h6 class="mb-2">Service Price</h6>
                                <div class="d-flex justify-content-between">
                                    <span>{{ optional($booking->service)->service_title ?? 'Service' }}</span>
                                    <strong>৳{{ optional($booking->service)->service_price ?? '0' }}</strong>
                                </div>
                            </div>

                        </div>
                    </div>

                </div>
            </div>
        </div>
    </section>

@endsection
