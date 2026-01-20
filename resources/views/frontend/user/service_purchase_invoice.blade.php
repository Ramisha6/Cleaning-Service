@extends('frontend.dashboard')
@section('frontend_title', 'Invoice - ' . $booking->invoice_no)
@section('frontend')

    @php
        $cleanerName = optional(optional($booking->cleanerAssign)->cleaner)->name;

        $dateText = $booking->booking_date ? \Carbon\Carbon::parse($booking->booking_date)->format('d M Y') : 'N/A';

        $timeText = $booking->booking_start_at && $booking->booking_end_at ? \Carbon\Carbon::parse($booking->booking_start_at)->format('h:i A') . ' - ' . \Carbon\Carbon::parse($booking->booking_end_at)->format('h:i A') : 'Time not set yet';

        $progressText = ucfirst(str_replace('_', ' ', $booking->progress_status ?? 'pending'));
    @endphp

    <section>
        <div class="container" style="padding: 60px 0;">
            <div class="row justify-content-center">
                <div class="col-lg-10">

                    <div class="card shadow-sm">
                        <div class="card-body">

                            <div class="d-flex justify-content-between align-items-start flex-wrap gap-2">
                                <div>
                                    <h3 class="mb-1">Invoice</h3>
                                    <div class="text-muted">Invoice No: <strong>{{ $booking->invoice_no }}</strong></div>
                                    <div class="text-muted">Issued: {{ $booking->created_at->format('d M Y') }}</div>
                                </div>

                                <div class="text-end">
                                    <a href="{{ route('user.service.purchase.invoice.print', $booking->id) }}" class="btn btn-outline-dark btn-sm" target="_blank">
                                        Print Invoice
                                    </a>
                                    <a href="{{ route('user.service.purchase.show', $booking->id) }}" class="btn btn-outline-secondary btn-sm">
                                        Back
                                    </a>
                                </div>
                            </div>

                            <hr>

                            <div class="row g-3">
                                <div class="col-md-6">
                                    <h6 class="mb-2">Billed To</h6>
                                    <div><strong>{{ $booking->name }}</strong></div>
                                    <div>{{ $booking->email ?? 'N/A' }}</div>
                                    <div>{{ $booking->phone }}</div>
                                </div>

                                <div class="col-md-6 text-md-end">
                                    <h6 class="mb-2">Service</h6>
                                    <div><strong>{{ optional($booking->service)->service_title ?? 'N/A' }}</strong></div>
                                    <div>Booking Date: {{ $dateText }}</div>
                                    <div>Booking Time: {{ $timeText }}</div>
                                    <div>Cleaner: {{ $cleanerName ?? 'Not assigned yet' }}</div>
                                    <div>Progress: {{ $progressText }}</div>
                                    <div>Status: {{ ucfirst($booking->status) }}</div>
                                </div>
                            </div>

                            <hr>

                            <div class="table-responsive">
                                <table class="table table-bordered align-middle">
                                    <thead>
                                        <tr>
                                            <th>Description</th>
                                            <th class="text-end" style="width:160px;">Amount</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <td>
                                                {{ optional($booking->service)->service_title ?? 'Service' }}
                                                @if (optional($booking->service)->service_duration)
                                                    <div class="text-muted small">Duration: {{ $booking->service->service_duration }}</div>
                                                @endif
                                            </td>
                                            <td class="text-end">
                                                ৳{{ optional($booking->service)->service_price ?? '0' }}
                                            </td>
                                        </tr>
                                    </tbody>
                                    <tfoot>
                                        <tr>
                                            <th class="text-end">Total</th>
                                            <th class="text-end">
                                                ৳{{ optional($booking->service)->service_price ?? '0' }}
                                            </th>
                                        </tr>
                                    </tfoot>
                                </table>
                            </div>

                            <div class="row g-3 mt-3">
                                <div class="col-md-6">
                                    <h6 class="mb-2">Payment</h6>
                                    <div><strong>Method:</strong> {{ strtoupper($booking->payment_method) }}</div>
                                    <div><strong>Status:</strong> {{ ucfirst($booking->payment_status) }}</div>

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

                            <div class="text-muted small">
                                This invoice is generated automatically. If you have any questions, please contact support.
                            </div>

                        </div>
                    </div>

                </div>
            </div>
        </div>
    </section>

@endsection
