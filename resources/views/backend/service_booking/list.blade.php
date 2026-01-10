@extends('admin.dashboard')
@section('admin_content')
    <!-- jQuery should be loaded BEFORE your custom scripts -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>

    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">Booking List</h1>
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Home</a></li>
            <li class="breadcrumb-item active" aria-current="page">Bookings</li>
        </ol>
    </div>

    <div class="row">
        <div class="col-lg-12">
            <div class="card mb-4">
                <div class="table-responsive p-3">
                    <table class="table align-items-center table-flush table-hover" id="dataTableHover">
                        <thead class="thead-light">
                            <tr>
                                <th>SN</th>
                                <th>Invoice</th>
                                <th>User</th>
                                <th>Service</th>
                                <th>Date</th>
                                <th>Payment</th>
                                <th>Payment Status</th>
                                <th>Progress Status</th>
                                <th>Status</th>
                                <th>Action</th>
                            </tr>
                        </thead>

                        <tbody>
                            @foreach ($booking_list as $key => $booking)
                                <tr>
                                    <td>{{ $key + 1 }}</td>
                                    <td><strong>{{ $booking->invoice_no }}</strong></td>
                                    <td>{{ optional($booking->user)->name ?? 'N/A' }}</td>
                                    <td>{{ optional($booking->service)->service_title ?? 'N/A' }}</td>
                                    <td>{{ optional($booking->booking_date)->format('d M Y') }}</td>

                                    <td>
                                        <span class="badge badge-secondary">
                                            {{ strtoupper($booking->payment_method) }}
                                        </span>
                                    </td>

                                    <td>
                                        @if ($booking->payment_status === 'verified')
                                            <span class="badge badge-success">Verified</span>
                                        @elseif($booking->payment_status === 'unverified')
                                            <span class="badge badge-warning">Unverified</span>
                                        @elseif($booking->payment_status === 'rejected')
                                            <span class="badge badge-danger">Rejected</span>
                                        @else
                                            <span class="badge badge-secondary">{{ ucfirst($booking->payment_status) }}</span>
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

                                            $config = $statusConfig[$booking->progress_status] ?? ['class' => 'badge-secondary', 'label' => ucfirst($booking->progress_status)];
                                        @endphp

                                        <span class="badge {{ $config['class'] }}">{{ $config['label'] }}</span>
                                    </td>

                                    <td>
                                        @if ($booking->status === 'confirmed')
                                            <span class="badge badge-success">Confirmed</span>
                                        @elseif($booking->status === 'cancelled')
                                            <span class="badge badge-danger">Cancelled</span>
                                        @else
                                            <span class="badge badge-warning">Pending</span>
                                        @endif
                                    </td>

                                    <td style="display: block ruby;">
                                        <a href="{{ route('admin.Booking.show', $booking->id) }}" class="btn btn-sm btn-primary" title="Show Booking">
                                            <i class="fas fa-eye"></i>
                                        </a>

                                        <a href="{{ route('admin.Booking.invoice', $booking->id) }}" class="btn btn-sm btn-info" title="Invoice">
                                            <i class="fas fa-print"></i>
                                        </a>

                                        <a href="{{ route('admin.Booking.invoice.download', $booking->id) }}" class="btn btn-sm btn-dark" target="_blank" title="Download">
                                            <i class="fas fa-download"></i>
                                        </a>

                                        {{-- Cleaner Assign --}}
                                        <a href="javascript:void(0)" class="btn btn-sm btn-info assignCleanerBtn" data-id="{{ $booking->id }}" title="Assign Cleaner" data-toggle="modal" data-target="#assignCleanerModal">
                                            <i class="fas fa-user"></i>
                                        </a>

                                    </td>
                                </tr>
                            @endforeach
                        </tbody>

                    </table>
                </div>
            </div>
        </div>
    </div>

    <!-- Assign Cleaner Modal -->
    <div class="modal fade" id="assignCleanerModal" tabindex="-1">
        <div class="modal-dialog">
            <form id="assignCleanerForm">
                @csrf
                <input type="hidden" id="job_id" name="job_id">

                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Assign Cleaner</h5>
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                    </div>

                    <div class="modal-body">
                        <div class="form-group">
                            <label>Select Cleaner</label>
                            <select name="cleaner_id" id="cleaner_id" class="form-control" required>
                                <option value="">-- Select Cleaner --</option>

                                {{-- Example --}}
                                @foreach ($cleaners as $cleaner)
                                    <option value="{{ $cleaner->id }}">
                                        {{ $cleaner->name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                    <div class="modal-footer">
                        <button type="submit" class="btn btn-success">
                            Assign
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>


    <script>
        $(document).on('click', '.assignCleanerBtn', function() {
            let jobId = $(this).data('id');
            $('#job_id').val(jobId);
        });

        // Submit Form
        $('#assignCleanerForm').submit(function(e) {
            e.preventDefault();

            $.ajax({
                url: "{{ route('admin.Booking.cleaner.assign') }}",
                type: "POST",
                data: {
                    _token: "{{ csrf_token() }}",
                    job_id: $('#job_id').val(),
                    cleaner_id: $('#cleaner_id').val(),
                },
                success: function(response) {
                    alert(response.message);

                    $('#assignCleanerModal').modal('hide');

                    $('#assignCleanerForm')[0].reset();

                    location.reload();
                },
                error: function(xhr) {
                    let errorMessage = 'Something went wrong!';

                    if (xhr.responseJSON && xhr.responseJSON.errors) {
                        errorMessage = Object.values(xhr.responseJSON.errors).flat().join('<br>');
                    }

                    alert(errorMessage);
                }
            });
        });

        // Clean up modal backdrop when closed
        $('#assignCleanerModal').on('hidden.bs.modal', function() {
            $('body').removeClass('modal-open');
            $('.modal-backdrop').remove();
        });
    </script>
@endsection
