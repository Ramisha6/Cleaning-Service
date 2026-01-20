@extends('cleaner.dashboard')
@section('admin_content')
    <!-- jQuery should be loaded BEFORE your custom scripts -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">My Assigned Bookings</h1>
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('cleaner.dashboard') }}">Home</a></li>
            <li class="breadcrumb-item active" aria-current="page">My Bookings</li>
        </ol>
    </div>

    <div class="row">
        <div class="col-lg-12">
            <div class="card mb-4">
                <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                    <h6 class="m-0 font-weight-bold text-primary">Total Bookings: {{ $booking_list->count() }}</h6>
                </div>
                <div class="table-responsive p-3">
                    <table class="table align-items-center table-flush table-hover" id="dataTableHover">
                        <thead class="thead-light">
                            <tr>
                                <th>SN</th>
                                <th>Invoice</th>
                                <th>Customer</th>
                                <th>Service</th>
                                <th>Date</th>
                                <th>Progress Status</th>
                                <th>Action</th>
                            </tr>
                        </thead>

                        <tbody>
                            @forelse ($booking_list as $key => $booking)
                                <tr>
                                    <td>{{ $key + 1 }}</td>
                                    <td><strong>{{ $booking->booking->invoice_no }}</strong></td>
                                    <td>
                                        <div>
                                            <strong>{{ $booking->booking->name }}</strong><br>
                                            <small>{{ $booking->booking->phone }}</small><br>
                                            <small>{{ $booking->booking->email }}</small>
                                        </div>
                                    </td>
                                    <td>{{ optional($booking->booking->service)->service_title ?? 'N/A' }}</td>
                                    <td>
                                        {{-- Date --}}
                                        <strong>
                                            {{ $booking->booking?->booking_date ? \Carbon\Carbon::parse($booking->booking->booking_date)->format('d M Y') : 'N/A' }}
                                        </strong>
                                        <br>

                                        {{-- Time (admin set) --}}
                                        @if ($booking->booking?->booking_start_at && $booking->booking?->booking_end_at)
                                            <small class="badge badge-dark">
                                                {{ \Carbon\Carbon::parse($booking->booking->booking_start_at)->format('h:i A') }}
                                                -
                                                {{ \Carbon\Carbon::parse($booking->booking->booking_end_at)->format('h:i A') }}
                                            </small>
                                        @else
                                            <small class="badge badge-dark">Time not set yet</small>
                                        @endif
                                    </td>

                                    <td>
                                        @php
                                            $statusConfig = [
                                                'pending' => ['class' => 'badge-warning', 'label' => 'Pending'],
                                                'in_progress' => ['class' => 'badge-primary', 'label' => 'In Progress'],
                                                'completed' => ['class' => 'badge-success', 'label' => 'Completed'],
                                                'rejected' => ['class' => 'badge-danger', 'label' => 'Rejected'],
                                            ];
                                            $config = $statusConfig[$booking->status] ?? ['class' => 'badge-secondary', 'label' => ucfirst($booking->status)];
                                        @endphp
                                        <span class="badge {{ $config['class'] }}">{{ $config['label'] }}</span>
                                    </td>

                                    <td>
                                        <div class="btn-group" role="group">
                                            <a href="{{ route('cleaner.booking.show', $booking->job_id) }}" class="btn btn-sm btn-primary" title="View Details">
                                                <i class="fas fa-eye"></i>
                                            </a> &nbsp;

                                            <a href="javascript:void(0)" class="btn btn-sm btn-info updateStatusBtn" data-id="{{ $booking->id }}" data-status="{{ $booking->status }}" data-toggle="modal" data-target="#statusModal" title="Update Status">
                                                Change Status
                                            </a>
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="10" class="text-center py-4">
                                        <i class="fas fa-inbox fa-3x text-muted mb-3"></i>
                                        <p class="text-muted">No bookings assigned yet</p>
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <!-- Update Status Modal -->
    <div class="modal fade" id="statusModal" tabindex="-1" role="dialog">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Update Job Status</h5>
                    <button type="button" class="close" data-dismiss="modal">
                        <span>&times;</span>
                    </button>
                </div>
                <form id="statusUpdateForm">
                    @csrf
                    <input type="hidden" id="booking_id" name="booking_id">
                    <div class="modal-body">
                        <div class="form-group">
                            <label>Status</label>
                            <select name="status" id="status" class="form-control" required>
                                <option value="pending" disabled>Pending</option>
                                <option value="in_progress">In Progress</option>
                                <option value="completed">Completed</option>
                                <option value="rejected">Rejected</option>
                            </select>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary">Update Status</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script>
        $(document).ready(function() {
            $('.updateStatusBtn').on('click', function() {
                const bookingId = $(this).data('id');
                $('#booking_id').val(bookingId);

                const status = $(this).data('status');
                $('#status').val(status);
            });

            // Modal form submit
            $('#statusUpdateForm').on('submit', function(e) {
                e.preventDefault();

                const bookingId = $('#booking_id').val();
                const status = $('#status').val();

                $.ajax({
                    url: '{{ route('cleaner.booking.update.status') }}',
                    type: 'POST',
                    data: {
                        _token: '{{ csrf_token() }}',
                        booking_id: bookingId,
                        status: status
                    },
                    success: function(response) {
                        if (response.success) {
                            alert(response.message || 'Status updated successfully');
                            $('#statusModal').modal('hide');
                            location.reload();
                        } else {
                            alert(response.message || 'Failed to update status');
                        }
                    },
                    error: function(xhr) {
                        alert('An error occurred');
                        console.error(xhr);
                    }
                });
            });
        });
    </script>
@endsection
