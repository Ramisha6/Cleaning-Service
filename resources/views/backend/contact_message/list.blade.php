@extends('admin.dashboard')
@section('admin_content')
    {{-- Breadcrumb --}}
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">Contact Message List</h1>
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="./">Home</a></li>
            <li class="breadcrumb-item active" aria-current="page">
                <a href="{{ url()->previous() }}">Back</a>
            </li>
        </ol>
    </div>

    {{-- Main Datatable --}}
    <div class="row">
        <div class="col-lg-12">
            <div class="card mb-4">
                <div class="table-responsive p-3">
                    <table class="table align-items-center table-flush table-hover" id="dataTableHover">
                        <thead class="thead-light">
                            <tr>
                                <th>SN</th>
                                <th>Name</th>
                                <th>Phone</th>
                                <th>Email</th>
                                <th style="width:180px;">Action</th>
                            </tr>
                        </thead>

                        <tbody>
                            @foreach ($contact_message_list as $key => $item)
                                <tr>
                                    <td>{{ $key + 1 }}</td>
                                    <td>{{ $item->name }}</td>
                                    <td>{{ $item->phone }}</td>
                                    <td>{{ $item->email }}</td>
                                    <td>
                                        {{-- ✅ View modal button --}}
                                        <button type="button" class="btn btn-sm btn-info viewMsgBtn" data-toggle="modal" data-target="#viewMessageModal" data-name="{{ $item->name }}" data-email="{{ $item->email }}" data-phone="{{ $item->phone }}" data-subject="{{ e($item->subject) }}" data-message="{{ e($item->message) }}">
                                            View Details
                                        </button>

                                        <a href="{{ route('admin.contact_message.delete', $item->id) }}" class="btn btn-sm btn-danger" onclick="return confirm('Are you sure?')">
                                            Delete
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

    {{-- ✅ View Message Modal --}}
    <div class="modal fade" id="viewMessageModal" tabindex="-1" role="dialog" aria-labelledby="viewMessageModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">

                <div class="modal-header">
                    <h5 class="modal-title" id="viewMessageModalLabel">Contact Message</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>

                <div class="modal-body">

                    <div class="mb-2">
                        <strong>Name:</strong> <span id="m_name"></span>
                    </div>
                    <div class="mb-2">
                        <strong>Email:</strong> <span id="m_email"></span>
                    </div>
                    <div class="mb-3">
                        <strong>Phone:</strong> <span id="m_phone"></span>
                    </div>

                    <hr>

                    <div class="mb-2">
                        <strong>Subject:</strong>
                        <div class="border rounded p-2 bg-light" id="m_subject"></div>
                    </div>

                    <div class="mb-0">
                        <strong>Message:</strong>
                        <div class="border rounded p-2 bg-light" style="min-height:120px; white-space:pre-wrap;" id="m_message"></div>
                    </div>

                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                </div>

            </div>
        </div>
    </div>

    {{-- ✅ Script --}}
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
        $(document).on('click', '.viewMsgBtn', function() {
            $('#m_name').text($(this).data('name') || '');
            $('#m_email').text($(this).data('email') || '');
            $('#m_phone').text($(this).data('phone') || '');
            $('#m_subject').text($(this).data('subject') || '');
            $('#m_message').text($(this).data('message') || '');
        });

        // optional cleanup
        $('#viewMessageModal').on('hidden.bs.modal', function() {
            $('#m_name,#m_email,#m_phone,#m_subject,#m_message').text('');
        });
    </script>
@endsection
