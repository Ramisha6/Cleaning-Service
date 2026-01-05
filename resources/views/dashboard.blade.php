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
                                            <i class="far fa-shopping-bag"></i> Orders
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
                                                <div class="col-md-6 mb-3">
                                                    <label>Name</label>
                                                    <input type="text" class="form-control" value="{{ Auth::user()->name }}" disabled>
                                                </div>

                                                <div class="col-md-6 mb-3">
                                                    <label>Email</label>
                                                    <input type="email" class="form-control" value="{{ Auth::user()->email }}" disabled>
                                                </div>
                                            </div>

                                            <div class="row">
                                                <div class="col-md-6 mb-3">
                                                    <label>Joined</label>
                                                    <input type="text" class="form-control" value="{{ Auth::user()->created_at->format('d M Y') }}" disabled>
                                                </div>
                                            </div>
                                        </div>

                                        <!-- ORDERS TAB -->
                                        <div class="tab-pane fade" id="orders" role="tabpanel">
                                            <h5 class="mb-3">My Orders</h5>

                                            @if (isset($orders) && count($orders) > 0)
                                                <div class="table-responsive">
                                                    <table class="table table-bordered">
                                                        <thead>
                                                            <tr>
                                                                <th>#</th>
                                                                <th>Order No</th>
                                                                <th>Date</th>
                                                                <th>Status</th>
                                                                <th>Total</th>
                                                            </tr>
                                                        </thead>
                                                        <tbody>
                                                            @foreach ($orders as $key => $order)
                                                                <tr>
                                                                    <td>{{ $key + 1 }}</td>
                                                                    <td>{{ $order->order_number }}</td>
                                                                    <td>{{ $order->created_at->format('d M Y') }}</td>
                                                                    <td>
                                                                        <span class="badge bg-success">
                                                                            {{ ucfirst($order->status) }}
                                                                        </span>
                                                                    </td>
                                                                    <td>{{ $order->total_amount }}</td>
                                                                </tr>
                                                            @endforeach
                                                        </tbody>
                                                    </table>
                                                </div>
                                            @else
                                                <p>No orders found.</p>
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
