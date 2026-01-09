<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Invoice {{ $booking->invoice_no }}</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/css/bootstrap.min.css" rel="stylesheet">

    <style>
        @page {
            size: A4;
            margin: 12mm;
        }

        body {
            background: #fff;
        }

        .wrap {
            max-width: 820px;
            margin: 0 auto;
        }

        .box {
            border: 1px solid #e9ecef;
            border-radius: 12px;
            padding: 18px;
        }

        .muted {
            color: #6c757d;
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

    <div class="wrap">
        <div class="no-print d-flex gap-2">
            <button class="btn btn-dark btn-sm" onclick="window.print()">Print / Save PDF</button>
        </div>

        <div class="box">
            <div class="d-flex justify-content-between">
                <div>
                    <h3 class="mb-1">Invoice</h3>
                    <div class="muted">Invoice No: <strong>{{ $booking->invoice_no }}</strong></div>
                    <div class="muted">Issued: {{ $booking->created_at->format('d M Y') }}</div>
                </div>
                <div class="text-right">
                    <strong>Customer</strong><br>
                    {{ $booking->name }}<br>
                    <span class="muted">{{ $booking->email ?? 'N/A' }}</span><br>
                    <span class="muted">{{ $booking->phone }}</span>
                </div>
            </div>

            <hr>

            <div class="row">
                <div class="col-6">
                    <strong>Service:</strong> {{ optional($booking->service)->service_title ?? 'N/A' }}<br>
                    <strong>Booking Date:</strong> {{ optional($booking->booking_date)->format('d M Y') }}<br>
                    <strong>Status:</strong> {{ ucfirst($booking->status) }}
                </div>
                <div class="col-6 text-right">
                    <strong>Payment:</strong> {{ strtoupper($booking->payment_method) }}<br>
                    <strong>Payment Status:</strong> {{ ucfirst($booking->payment_status) }}<br>
                    @if ($booking->payment_method === 'bkash')
                        <strong>bKash:</strong> {{ $booking->bkash_number ?? 'N/A' }}<br>
                        <strong>TrxID:</strong> {{ $booking->transaction_id ?? 'N/A' }}
                    @endif
                </div>
            </div>

            <hr>

            <table class="table table-bordered mb-0">
                <thead class="thead-light">
                    <tr>
                        <th>Description</th>
                        <th class="text-right" style="width:180px;">Amount</th>
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
                        <td class="text-right">৳{{ optional($booking->service)->service_price ?? '0' }}</td>
                    </tr>
                </tbody>
                <tfoot>
                    <tr>
                        <th class="text-right">Total</th>
                        <th class="text-right">৳{{ optional($booking->service)->service_price ?? '0' }}</th>
                    </tr>
                </tfoot>
            </table>

            @if ($booking->note)
                <div class="mt-3">
                    <strong>Note:</strong>
                    <div class="muted">{{ $booking->note }}</div>
                </div>
            @endif
        </div>
    </div>

</body>

</html>
