<ul class="navbar-nav sidebar sidebar-light accordion" id="accordionSidebar">

    <a class="sidebar-brand d-flex align-items-center justify-content-center" href="index.html">
        <div class="sidebar-brand-icon">
        </div>
        <div class="sidebar-brand-text mx-3">Admin Dashboard </div>
    </a>

    <hr class="sidebar-divider my-0">

    <li class="nav-item active">
        <a class="nav-link" href="{{ url('/admin/dashboard') }}">
            <i class="fas fa-fw fa-tachometer-alt"></i>
            <span>Dashboard</span></a>
    </li>

    <hr class="sidebar-divider">

    @php
        $servicesOpen = request()->routeIs('admin.Service.*');
    @endphp

    <li class="nav-item {{ $servicesOpen ? 'active' : '' }}">
        <a class="nav-link {{ $servicesOpen ? '' : 'collapsed' }} {{ $servicesOpen ? 'active' : '' }}" href="#" data-toggle="collapse" data-target="#collapseServices" aria-expanded="{{ $servicesOpen ? 'true' : 'false' }}" aria-controls="collapseServices">
            <i class="fas fa-fw fa-table"></i>
            <span>Services</span>
        </a>

        <div id="collapseServices" class="collapse {{ $servicesOpen ? 'show' : '' }}" aria-labelledby="headingTable" data-parent="#accordionSidebar">
            <div class="bg-white py-2 collapse-inner rounded">
                <a class="collapse-item {{ request()->routeIs('admin.Service.list') ? 'active' : '' }}" href="{{ route('admin.Service.list') }}">
                    Service List
                </a>

                <a class="collapse-item {{ request()->routeIs('admin.Service.add') ? 'active' : '' }}" href="{{ route('admin.Service.add') }}">
                    Add Service
                </a>
            </div>
        </div>
    </li>

    @php
        $bookingOpen = request()->routeIs('admin.Booking.*');
    @endphp

    <li class="nav-item {{ $bookingOpen ? 'active' : '' }}">
        <a class="nav-link {{ $bookingOpen ? '' : 'collapsed' }} {{ $bookingOpen ? 'active' : '' }}" href="#" data-toggle="collapse" data-target="#collapseBookings" aria-expanded="{{ $bookingOpen ? 'true' : 'false' }}" aria-controls="collapseBookings">
            <i class="fas fa-fw fa-receipt"></i>
            <span>Bookings</span>
        </a>

        <div id="collapseBookings" class="collapse {{ $bookingOpen ? 'show' : '' }}" data-parent="#accordionSidebar">
            <div class="bg-white py-2 collapse-inner rounded">
                <a class="collapse-item {{ request()->routeIs('admin.Booking.list') ? 'active' : '' }}" href="{{ route('admin.Booking.list') }}">
                    Booking List
                </a>
            </div>
        </div>
    </li>

</ul>
