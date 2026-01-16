@extends('frontend.dashboard')
@section('frontend_title', 'User Dashboard')
@section('frontend')

    <section>
        <div class="container" style="padding: 60px 0;">
            <div class="row justify-content-center">
                <div class="col-lg-11">

                    <div class="card shadow-sm">
                        <div class="card-body">

                            <h3 class="text-center mb-4">
                                Welcome, {{ Auth::user()->name }}
                            </h3>

                            <div class="row">

                                <!-- LEFT VERTICAL TABS -->
                                <div class="col-md-3">
                                    <div class="nav flex-column nav-pills" role="tablist">

                                        <a class="nav-link active mb-2" data-bs-toggle="pill" href="#profile" role="tab">
                                            <i class="far fa-user"></i> Profile
                                        </a>

                                        <a class="nav-link mb-2" data-bs-toggle="pill" href="#orders" role="tab">
                                            <i class="far fa-shopping-bag"></i> Service Purchases
                                        </a>

                                        <a class="nav-link mb-2" data-bs-toggle="pill" href="#password" role="tab">
                                            <i class="far fa-lock"></i> Change Password
                                        </a>

                                        <a class="nav-link text-danger" data-bs-toggle="pill" href="#logout" role="tab">
                                            <i class="far fa-sign-out-alt"></i> Logout
                                        </a>

                                    </div>
                                </div>

                                <!-- RIGHT CONTENT -->
                                <div class="col-md-9">
                                    <div class="tab-content">

                                        <!-- PROFILE TAB -->
                                        <div class="tab-pane fade show active" id="profile" role="tabpanel">
                                            <h5 class="mb-3">Profile Information</h5>

                                            <div class="row">
                                                <div class="col-md-12 mb-3">
                                                    <label>Name</label>
                                                    <input type="text" class="form-control" value="{{ Auth::user()->name }}" disabled>
                                                </div>

                                                <div class="col-md-12 mb-3">
                                                    <label>Email</label>
                                                    <input type="email" class="form-control" value="{{ Auth::user()->email }}" disabled>
                                                </div>

                                                <div class="col-md-12 mb-3">
                                                    <label>Phone</label>
                                                    <input type="text" class="form-control" value="{{ Auth::user()->phone }}" disabled>
                                                </div>

                                            </div>

                                            <div class="row">
                                                <div class="col-md-12 mb-3">
                                                    <label>Joined</label>
                                                    <input type="text" class="form-control" value="{{ Auth::user()->created_at->format('d M Y') }}" disabled>
                                                </div>
                                            </div>
                                        </div>

                                        <!-- ORDERS TAB -->
                                        <div class="tab-pane fade" id="orders" role="tabpanel">
                                            <h5 class="mb-3">Service Purchases</h5>

                                            @if (isset($servicePurchases) && $servicePurchases->count() > 0)
                                                <div class="table-responsive purchases-table-wrap">
                                                    <table class="table align-middle purchases-table mb-0">
                                                        <thead>
                                                            <tr>
                                                                <th style="width:60px;">#</th>
                                                                <th>Service</th>
                                                                <th style="width:120px;">Date</th>
                                                                <th style="width:110px;">Payment</th>
                                                                <th style="width:150px;">Payment Status</th>
                                                                <th style="width:140px;">Booking Status</th>
                                                                <th class="text-end" style="width:260px;">Action</th>
                                                            </tr>
                                                        </thead>

                                                        <tbody>
                                                            @foreach ($servicePurchases as $key => $booking)
                                                                @php
                                                                    $payClass = match ($booking->payment_status) {
                                                                        'verified' => 'tag tag--success',
                                                                        'unverified' => 'tag tag--warning',
                                                                        'rejected' => 'tag tag--danger',
                                                                        default => 'tag tag--muted',
                                                                    };

                                                                    $statusClass = match ($booking->status) {
                                                                        'confirmed' => 'tag tag--success',
                                                                        'cancelled' => 'tag tag--danger',
                                                                        default => 'tag tag--warning',
                                                                    };

                                                                    $methodClass = $booking->payment_method === 'bkash' ? 'tag tag--info' : 'tag tag--muted';
                                                                @endphp

                                                                <tr>
                                                                    <td class="text-muted">{{ $key + 1 }}</td>

                                                                    <td class="fw-semibold">
                                                                        {{ optional($booking->service)->service_title ?? 'N/A' }}
                                                                    </td>

                                                                    <td>{{ optional($booking->booking_date)->format('d M Y') }}</td>

                                                                    <td>
                                                                        <span class="{{ $methodClass }}">{{ strtoupper($booking->payment_method) }}</span>
                                                                    </td>

                                                                    <td>
                                                                        <span class="{{ $payClass }}">{{ ucfirst($booking->payment_status) }}</span>
                                                                    </td>

                                                                    <td>
                                                                        <span class="{{ $statusClass }}">{{ ucfirst($booking->status) }}</span>
                                                                    </td>

                                                                    <td class="text-end">
                                                                        <div class="action-btns">
                                                                            <a href="{{ route('user.service.purchase.show', $booking->id) }}" class="btn btn-sm btn-outline-primary" target="_blank">
                                                                                View
                                                                            </a>

                                                                            <a href="{{ route('user.service.purchase.invoice', $booking->id) }}" class="btn btn-sm btn-outline-secondary" target="_blank">
                                                                                Invoice
                                                                            </a>

                                                                            <a href="{{ route('user.service.purchase.invoice.print', $booking->id) }}" class="btn btn-sm btn-dark" target="_blank" rel="noopener">
                                                                                Download
                                                                            </a>
                                                                        </div>
                                                                    </td>
                                                                </tr>
                                                            @endforeach
                                                        </tbody>
                                                    </table>
                                                </div>

                                                <style>
                                                    /* Wrapper */
                                                    .purchases-table-wrap {
                                                        border: 1px solid #e9eef5;
                                                        border-radius: 14px;
                                                        overflow: hidden;
                                                        background: #fff;
                                                    }

                                                    /* Table base */
                                                    .purchases-table {
                                                        border-collapse: separate;
                                                        border-spacing: 0;
                                                    }

                                                    /* Header (soft) */
                                                    .purchases-table thead th {
                                                        background: #f8fafc;
                                                        color: #0f172a;
                                                        font-weight: 800;
                                                        font-size: 13px;
                                                        padding: 14px 14px;
                                                        border-bottom: 1px solid #e9eef5;
                                                        white-space: nowrap;
                                                    }

                                                    /* Rows (clean separators, not full grid) */
                                                    .purchases-table tbody td {
                                                        padding: 14px 14px;
                                                        border-bottom: 1px solid #eef2f7;
                                                        vertical-align: middle;
                                                    }

                                                    .purchases-table tbody tr:last-child td {
                                                        border-bottom: 0;
                                                    }

                                                    .purchases-table tbody tr:hover {
                                                        background: #fbfdff;
                                                    }

                                                    /* Tags (better than bootstrap badges here) */
                                                    .tag {
                                                        display: inline-flex;
                                                        align-items: center;
                                                        padding: 6px 10px;
                                                        border-radius: 999px;
                                                        font-weight: 800;
                                                        font-size: 12px;
                                                        border: 1px solid transparent;
                                                        white-space: nowrap;
                                                    }

                                                    .tag--success {
                                                        background: rgba(22, 163, 74, .12);
                                                        color: #166534;
                                                        border-color: rgba(22, 163, 74, .22);
                                                    }

                                                    .tag--warning {
                                                        background: rgba(245, 158, 11, .14);
                                                        color: #92400e;
                                                        border-color: rgba(245, 158, 11, .26);
                                                    }

                                                    .tag--danger {
                                                        background: rgba(220, 53, 69, .12);
                                                        color: #991b1b;
                                                        border-color: rgba(220, 53, 69, .22);
                                                    }

                                                    .tag--info {
                                                        background: rgba(13, 110, 253, .12);
                                                        color: #1e40af;
                                                        border-color: rgba(13, 110, 253, .22);
                                                    }

                                                    .tag--muted {
                                                        background: rgba(100, 116, 139, .12);
                                                        color: #334155;
                                                        border-color: rgba(100, 116, 139, .22);
                                                    }

                                                    /* Actions */
                                                    .action-btns {
                                                        display: block;
                                                        gap: 8px;
                                                        flex-wrap: wrap;
                                                        justify-content: flex-end;
                                                    }

                                                    .action-btns .btn {
                                                        border-radius: 10px;
                                                        padding: 7px 10px;
                                                        font-weight: 700;
                                                    }
                                                </style>
                                            @else
                                                <p>No service purchases found.</p>
                                            @endif
                                        </div>

                                        <!-- CHANGE PASSWORD TAB -->
                                        <div class="tab-pane fade" id="password" role="tabpanel">
                                            <h5 class="mb-3">Change Password</h5>

                                            <form method="POST" action="{{ route('password.update') }}">
                                                @csrf
                                                @method('PUT')

                                                <div class="mb-3">
                                                    <label>Current Password</label>
                                                    <input type="password" name="current_password" class="form-control" required>
                                                </div>

                                                <div class="mb-3">
                                                    <label>New Password</label>
                                                    <input type="password" name="password" class="form-control" required>
                                                </div>

                                                <div class="mb-3">
                                                    <label>Confirm New Password</label>
                                                    <input type="password" name="password_confirmation" class="form-control" required>
                                                </div>

                                                <button type="submit" class="vs-btn">
                                                    Update Password
                                                </button>
                                            </form>
                                        </div>

                                        <!-- LOGOUT TAB -->
                                        <div class="tab-pane fade" id="logout" role="tabpanel">
                                            <div class="text-center mt-4">
                                                <p class="mb-4">Are you sure you want to logout?</p>

                                                <form method="POST" action="{{ route('logout') }}">
                                                    @csrf
                                                    <button type="submit" class="vs-btn style3">
                                                        Logout
                                                    </button>
                                                </form>
                                            </div>
                                        </div>

                                    </div>
                                </div>

                            </div><!-- row -->

                        </div>
                    </div>

                </div>
            </div>
        </div>
    </section>

    <style>
        /* Horizontal scroll container */
        .purchases-table-wrap {
            width: 100%;
            overflow-x: auto;
            -webkit-overflow-scrolling: touch;
        }

        /* Force table to be wider than small screens so it scrolls */
        .purchases-table {
            min-width: 980px;
            /* increase if you add more columns */
        }

        /* Keep cells from wrapping badly */
        .purchases-table thead th,
        .purchases-table tbody td {
            white-space: nowrap;
        }

        /* Allow long service title to wrap (optional) */
        .purchases-table td:nth-child(3) {
            white-space: normal;
            min-width: 220px;
        }
    </style>

@endsection
