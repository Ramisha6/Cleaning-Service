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

                                                                {{-- ✅ Date + Time --}}
                                                                <th style="width:200px;">Schedule</th>

                                                                {{-- ✅ Assigned Cleaner --}}
                                                                <th style="width:180px;">Cleaner</th>

                                                                {{-- ✅ Progress --}}
                                                                <th style="width:160px;">Progress</th>

                                                                <th class="text-end" style="width:260px;">Action</th>
                                                            </tr>
                                                        </thead>

                                                        <tbody>
                                                            @foreach ($servicePurchases as $key => $booking)
                                                                @php
                                                                    // ✅ progress badge class
                                                                    $progressClass = match ($booking->progress_status) {
                                                                        'completed' => 'tag tag--success',
                                                                        'in_progress' => 'tag tag--info',
                                                                        'rejected' => 'tag tag--danger',
                                                                        default => 'tag tag--warning',
                                                                    };

                                                                    // ✅ cleaner name
                                                                    $assignedCleaner = optional(optional($booking->cleanerAssign)->cleaner)->name;

                                                                    // ✅ schedule date
                                                                    $dateText = $booking->booking_date ? \Carbon\Carbon::parse($booking->booking_date)->format('d M Y') : 'N/A';

                                                                    // ✅ schedule time
                                                                    $timeText = $booking->booking_start_at && $booking->booking_end_at ? \Carbon\Carbon::parse($booking->booking_start_at)->format('h:i A') . ' - ' . \Carbon\Carbon::parse($booking->booking_end_at)->format('h:i A') : 'Time not set';
                                                                @endphp

                                                                <tr>
                                                                    <td class="text-muted">{{ $key + 1 }}</td>

                                                                    <td class="fw-semibold">
                                                                        {{ optional($booking->service)->service_title ?? 'N/A' }}
                                                                    </td>

                                                                    {{-- ✅ Date + Time --}}
                                                                    <td>
                                                                        <div class="fw-semibold">{{ $dateText }}</div>
                                                                        <small class="text-muted">{{ $timeText }}</small>
                                                                    </td>

                                                                    {{-- ✅ Cleaner --}}
                                                                    <td>
                                                                        @if ($assignedCleaner)
                                                                            <strong>{{ $assignedCleaner }}</strong>
                                                                        @else
                                                                            <span class="text-muted">Not assigned yet</span>
                                                                        @endif
                                                                    </td>


                                                                    {{-- ✅ Progress --}}
                                                                    <td>
                                                                        <span class="{{ $progressClass }}">
                                                                            {{ ucfirst(str_replace('_', ' ', $booking->progress_status ?? 'pending')) }}
                                                                        </span>
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
                                                        width: 100%;
                                                        overflow-x: auto;
                                                        -webkit-overflow-scrolling: touch;
                                                    }

                                                    /* Table base */
                                                    .purchases-table {
                                                        border-collapse: separate;
                                                        border-spacing: 0;
                                                        min-width: 860px;
                                                    }

                                                    /* Header */
                                                    .purchases-table thead th {
                                                        background: #f8fafc;
                                                        color: #0f172a;
                                                        font-weight: 800;
                                                        font-size: 13px;
                                                        padding: 14px 14px;
                                                        border-bottom: 1px solid #e9eef5;
                                                        white-space: nowrap;
                                                    }

                                                    /* Rows */
                                                    .purchases-table tbody td {
                                                        padding: 14px 14px;
                                                        border-bottom: 1px solid #eef2f7;
                                                        vertical-align: middle;
                                                        white-space: nowrap;
                                                    }

                                                    .purchases-table tbody tr:last-child td {
                                                        border-bottom: 0;
                                                    }

                                                    .purchases-table tbody tr:hover {
                                                        background: #fbfdff;
                                                    }

                                                    /* Tags */
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

@endsection
