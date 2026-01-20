@extends('cleaner.dashboard')
@section('admin_content')

    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">Dashboard</h1>
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="./">Home</a></li>
            <li class="breadcrumb-item active" aria-current="page">Dashboard</li>
        </ol>
    </div>

    <div class="row mb-3">

        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card h-100">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-uppercase mb-1">Total Booking</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $total_bookings }}</div>
                            <div class="mt-2 mb-0 text-muted text-xs">
                                <a href="{{ route('cleaner.Booking.list') }}">View All</a>
                            </div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-shopping-cart fa-2x text-success"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card h-100">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-uppercase mb-1">Pending Booking</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $pending_bookings }}</div>
                            <div class="mt-2 mb-0 text-muted text-xs">
                                <a href="{{ route('cleaner.Booking.list') }}">View All</a>
                            </div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-comments fa-2x text-warning"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card h-100">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-uppercase mb-1">Completed Booking</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $completed_bookings }}</div>
                            <div class="mt-2 mb-0 text-muted text-xs">
                                <a href="{{ route('cleaner.Booking.list') }}">View All</a>
                            </div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-comments fa-2x text-warning"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card h-100">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-uppercase mb-1">In Progress Booking</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $in_progress_bookings }}</div>
                            <div class="mt-2 mb-0 text-muted text-xs">
                                <a href="{{ route('cleaner.Booking.list') }}">View All</a>
                            </div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-comments fa-2x text-warning"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div>


    {{-- ✅ Today Busy + Free Slots --}}
    <div class="row">

        {{-- Today Busy --}}
        <div class="col-lg-6 mb-4">
            <div class="card h-100">
                <div class="card-header">
                    <strong>Today's Busy Schedule</strong>
                    <div class="text-muted small">Based on assigned jobs</div>
                </div>
                <div class="card-body">
                    @if ($todayBookings->count() == 0)
                        <span class="badge badge-success">No jobs today</span>
                    @else
                        <ul class="list-group">
                            @foreach ($todayBookings as $b)
                                <li class="list-group-item">
                                    <div><strong>{{ $b->invoice_no }}</strong></div>
                                    <div class="text-muted small">
                                        {{ \Carbon\Carbon::parse($b->booking_start_at)->format('h:i A') }}
                                        -
                                        {{ \Carbon\Carbon::parse($b->booking_end_at)->format('h:i A') }}
                                    </div>
                                    <div class="small">Customer: {{ $b->name }} | Phone: {{ $b->phone }}</div>
                                </li>
                            @endforeach
                        </ul>
                    @endif
                </div>
            </div>
        </div>

        {{-- Today Free --}}
        <div class="col-lg-6 mb-4">
            <div class="card h-100">
                <div class="card-header">
                    <strong>Today Free Time</strong>
                    <div class="text-muted small">Working Hour: 9:00 AM - 8:00 PM</div>
                </div>
                <div class="card-body">
                    @if (count($freeSlots) == 0)
                        <span class="badge badge-danger">No Free Slot Today</span>
                    @else
                        <ul class="list-group">
                            @foreach ($freeSlots as $slot)
                                @php
                                    $slotMinutes = $slot['from']->diffInMinutes($slot['to']);
                                @endphp
                                <li class="list-group-item d-flex justify-content-between align-items-center">
                                    <span>
                                        {{ $slot['from']->format('h:i A') }} → {{ $slot['to']->format('h:i A') }}
                                        <small class="text-muted">({{ $slotMinutes }} mins)</small>
                                    </span>
                                    <span class="badge badge-info">Free</span>
                                </li>
                            @endforeach
                        </ul>
                    @endif
                </div>
            </div>
        </div>

    </div>


    {{-- ✅ Next 7 Days Schedule --}}
    <div class="row">
        <div class="col-lg-12 mb-4">
            <div class="card">
                <div class="card-header">
                    <strong>Next 7 Days Schedule</strong>
                </div>
                <div class="card-body">
                    @if ($assignedBookings->count() == 0)
                        <span class="badge badge-success">No upcoming assigned jobs</span>
                    @else
                        <div class="table-responsive">
                            <table class="table table-bordered table-sm">
                                <thead>
                                    <tr>
                                        <th>Invoice</th>
                                        <th>Date</th>
                                        <th>Time</th>
                                        <th>Customer</th>
                                        <th>Phone</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($assignedBookings as $b)
                                        <tr>
                                            <td><strong>{{ $b->invoice_no }}</strong></td>
                                            <td>{{ \Carbon\Carbon::parse($b->booking_start_at)->format('d M Y') }}</td>
                                            <td>
                                                {{ \Carbon\Carbon::parse($b->booking_start_at)->format('h:i A') }}
                                                -
                                                {{ \Carbon\Carbon::parse($b->booking_end_at)->format('h:i A') }}
                                            </td>
                                            <td>{{ $b->name }}</td>
                                            <td>{{ $b->phone }}</td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>


    <!-- Modal Logout (unchanged) -->
    <div class="modal fade" id="logoutModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabelLogout" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabelLogout">Ohh No!</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <p>Are you sure you want to logout?</p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-outline-primary" data-dismiss="modal">Cancel</button>
                    <a href="login.html" class="btn btn-primary">Logout</a>
                </div>
            </div>
        </div>
    </div>

@endsection
