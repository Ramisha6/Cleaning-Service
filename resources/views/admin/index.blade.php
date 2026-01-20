@extends('admin.dashboard')
@section('admin_content')
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">Dashboard</h1>
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="./">Home</a></li>
            <li class="breadcrumb-item active" aria-current="page">Dashboard</li>
        </ol>
    </div>

    <div class="row mb-3">
        <!-- Booking Card Example -->
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card h-100">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-uppercase mb-1">Total Booking</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $total_bookings }}</div>
                            <div class="mt-2 mb-0 text-muted text-xs">
                                <a href="{{ route('admin.Booking.list') }}">View All</a>
                            </div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-shopping-cart fa-2x text-success"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Pending Requests Card Example -->
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card h-100">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-uppercase mb-1">Pending Booking
                            </div>
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
                            <div class="text-xs font-weight-bold text-uppercase mb-1">Completed Booking
                            </div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $completed_bookings }}</div>
                            <div class="mt-2 mb-0 text-muted text-xs">
                                <a href="{{ route('admin.Booking.list') }}">View All</a>
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
                            <div class="text-xs font-weight-bold text-uppercase mb-1">In Progress Booking
                            </div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $in_progress_bookings }}</div>
                            <div class="mt-2 mb-0 text-muted text-xs">
                                <a href="{{ route('admin.Booking.list') }}">View All</a>
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

    {{-- Monthly Sales Chart + Tables --}}
    <div class="row">

        {{-- Chart --}}
        <div class="col-xl-8 col-lg-7 mb-4">
            <div class="card h-100">
                <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                    <h6 class="m-0 font-weight-bold text-primary">Monthly Sales Report</h6>
                </div>
                <div class="card-body">
                    <canvas id="monthlySalesChart" height="120"></canvas>
                </div>
            </div>
        </div>

        {{-- Monthly Sales Table --}}
        <div class="col-xl-4 col-lg-5 mb-4">
            <div class="card h-100">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">Monthly Summary</h6>
                </div>
                <div class="card-body">
                    <div class="table-responsive" style="max-height: 320px; overflow:auto;">
                        <table class="table table-sm table-bordered mb-0">
                            <thead>
                                <tr>
                                    <th>Month</th>
                                    <th class="text-center">Orders</th>
                                    <th class="text-right">Sales (৳)</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($monthlySales as $row)
                                    <tr>
                                        <td>{{ $row->month }}</td>
                                        <td class="text-center">{{ $row->total_orders }}</td>
                                        <td class="text-right">{{ number_format($row->total_sales, 2) }}</td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="3" class="text-center">No data found</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>

    </div>

    {{-- Latest Bookings Table --}}
    <div class="row">
        <div class="col-12 mb-4">
            <div class="card">
                <div class="card-header py-3 d-flex justify-content-between align-items-center">
                    <h6 class="m-0 font-weight-bold text-primary">Latest Bookings</h6>
                    <a href="{{ route('admin.Booking.list') }}" class="btn btn-sm btn-primary">View All</a>
                </div>

                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-bordered table-striped">
                            <thead>
                                <tr>
                                    <th>Invoice</th>
                                    <th>Customer</th>
                                    <th>Service</th>
                                    <th>Date</th>
                                    <th class="text-right">Price (৳)</th>
                                    <th>Payment</th>
                                    <th>Status</th>
                                    <th>Progress</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($latestBookings as $b)
                                    <tr>
                                        <td>{{ $b->invoice_no }}</td>
                                        <td>
                                            {{ $b->name }} <br>
                                            <small class="text-muted">{{ $b->phone }}</small>
                                        </td>
                                        <td>{{ $b->service_title }}</td>
                                        <td>{{ \Carbon\Carbon::parse($b->booking_date)->format('d M, Y') }}</td>
                                        <td class="text-right">{{ number_format($b->service_price, 2) }}</td>
                                        <td>
                                            {{ strtoupper($b->payment_method) }} <br>
                                            @if ($b->payment_status === 'verified')
                                                <span class="badge badge-success">Verified</span>
                                            @elseif($b->payment_status === 'unverified')
                                                <span class="badge badge-warning">Unverified</span>
                                            @elseif($b->payment_status === 'rejected')
                                                <span class="badge badge-danger">Rejected</span>
                                            @else
                                                <span
                                                    class="badge badge-secondary">{{ ucfirst($b->payment_status) }}</span>
                                            @endif

                                        </td>
                                        <td>
                                            @if ($b->status === 'confirmed')
                                                <span class="badge badge-success">Confirmed</span>
                                            @elseif($b->status === 'cancelled')
                                                <span class="badge badge-danger">Cancelled</span>
                                            @else
                                                <span class="badge badge-warning">Pending</span>
                                            @endif
                                        </td>
                                        <td>
                                            @if ($b->progress_status === 'completed')
                                                <span class="badge badge-success">Completed</span>
                                            @elseif($b->progress_status === 'in_progress')
                                                <span class="badge badge-info">In Progress</span>
                                            @elseif($b->progress_status === 'rejected')
                                                <span class="badge badge-danger">Rejected</span>
                                            @else
                                                <span class="badge badge-secondary">Pending</span>
                                            @endif
                                        </td>
                                        <td>
                                            <a href="{{ route('admin.Booking.show', $b->id) }}"
                                                class="btn btn-sm btn-info">
                                                View
                                            </a>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="9" class="text-center">No bookings found</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>

            </div>
        </div>
    </div>

    {{-- Chart.js --}}
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        const labels = @json($chartLabels);
        const salesData = @json($chartData);

        const ctx = document.getElementById('monthlySalesChart').getContext('2d');

        new Chart(ctx, {
            type: 'line',
            data: {
                labels: labels,
                datasets: [{
                    label: 'Monthly Sales (৳)',
                    data: salesData,
                    tension: 0.3,
                    fill: false
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: {
                        display: true
                    }
                },
                scales: {
                    y: {
                        beginAtZero: true,
                        ticks: {
                            callback: function(value) {
                                return '৳ ' + value;
                            }
                        }
                    }
                }
            }
        });
    </script>


    <!-- Modal Logout -->
    <div class="modal fade" id="logoutModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabelLogout"
        aria-hidden="true">
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
