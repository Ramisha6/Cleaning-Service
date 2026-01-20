<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Invoice {{ $booking->invoice_no }}</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

    <style>
        @page {
            size: A4;
            margin: 12mm;
        }

        body {
            background: #fff;
        }

        .inv-wrap {
            max-width: 820px;
            margin: 0 auto;
        }

        .inv-head {
            display: flex;
            justify-content: space-between;
            gap: 16px;
            align-items: flex-start;
        }

        .muted {
            color: #6c757d;
        }

        .inv-box {
            border: 1px solid #e9ecef;
            border-radius: 12px;
            padding: 18px;
        }

        .inv-table th,
        .inv-table td {
            padding: 10px 12px;
        }

        .inv-table tfoot th {
            background: #f8f9fa;
        }

        .no-print {
            margin: 12px 0 16px;
        }

        @media print {
            .no-print {
                display: none !important;
            }
        }
    </style>
</head>

<body>

    @php
        $cleanerName = optional(optional($booking->cleanerAssign)->cleaner)->name;

        $dateText = $booking->booking_date ? \Carbon\Carbon::parse($booking->booking_date)->format('d M Y') : 'N/A';

        $timeText = $booking->booking_start_at && $booking->booking_end_at ? \Carbon\Carbon::parse($booking->booking_start_at)->format('h:i A') . ' - ' . \Carbon\Carbon::parse($booking->booking_end_at)->format('h:i A') : 'Time not set yet';

        $progressText = ucfirst(str_replace('_', ' ', $booking->progress_status ?? 'pending'));
    @endphp

    <div class="inv-wrap">
        <div class="no-print d-flex gap-2">
            <button class="btn btn-dark btn-sm" onclick="window.print()">Print</button>
            <a class="btn btn-outline-secondary btn-sm" href="{{ route('user.service.purchase.invoice', $booking->id) }}">Back</a>
        </div>

        <div class="inv-box">
            <div class="inv-head mb-3">
                <div>
                    <h2 class="mb-1">Invoice</h2>
                    <div class="muted">Invoice No: <strong>{{ $booking->invoice_no }}</strong></div>
                    <div class="muted">Issued: {{ $booking->created_at->format('d M Y') }}</div>
                </div>
                <div class="text-end">
                    <div><strong>Customer</strong></div>
                    <div>{{ $booking->name }}</div>
                    <div class="muted">{{ $booking->email ?? 'N/A' }}</div>
                    <div class="muted">{{ $booking->phone }}</div>
                </div>
            </div>

            <hr>

            <div class="row g-3 mb-3">
                <div class="col-6">
                    <div><strong>Service:</strong> {{ optional($booking->service)->service_title ?? 'N/A' }}</div>
                    <div><strong>Date:</strong> {{ $dateText }}</div>
                    <div><strong>Time:</strong> {{ $timeText }}</div>
                    <div><strong>Cleaner:</strong> {{ $cleanerName ?? 'Not assigned yet' }}</div>
                    <div><strong>Progress:</strong> {{ $progressText }}</div>
                    <div><strong>Booking Status:</strong> {{ ucfirst($booking->status) }}</div>
                </div>

                <div class="col-6 text-end">
                    <div><strong>Payment Method:</strong> {{ strtoupper($booking->payment_method) }}</div>
                    <div><strong>Payment Status:</strong> {{ ucfirst($booking->payment_status) }}</div>
                    @if ($booking->payment_method === 'bkash')
                        <div><strong>bKash:</strong> {{ $booking->bkash_number ?? 'N/A' }}</div>
                        <div><strong>TrxID:</strong> {{ $booking->transaction_id ?? 'N/A' }}</div>
                    @endif
                </div>
            </div>

            <div class="table-responsive">
                <table class="table table-bordered inv-table align-middle mb-0">
                    <thead>
                        <tr>
                            <th>Description</th>
                            <th class="text-end" style="width:180px;">Amount</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>
                                {{ optional($booking->service)->service_title ?? 'Service' }}
                                @if (optional($booking->service)->service_duration)
                                    <div class="muted small">Duration: {{ $booking->service->service_duration }}</div>
                                @endif
                            </td>
                            <td class="text-end">৳{{ optional($booking->service)->service_price ?? '0' }}</td>
                        </tr>
                    </tbody>
                    <tfoot>
                        <tr>
                            <th class="text-end">Total</th>
                            <th class="text-end">৳{{ optional($booking->service)->service_price ?? '0' }}</th>
                        </tr>
                    </tfoot>
                </table>
            </div>

            @if ($booking->note)
                <div class="mt-3">
                    <strong>Note:</strong>
                    <div class="muted">{{ $booking->note }}</div>
                </div>
            @endif

            <div class="mt-3 muted small">
                This invoice is generated automatically.
            </div>
        </div>
    </div>

</body>

</html>
