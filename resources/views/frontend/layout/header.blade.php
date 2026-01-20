<header class="vs-header header-layout1 style2">

    {{-- Top Header --}}
    <div class="header-top style2">
        <div class="main-container2">
            <div class="row justify-content-md-between justify-content-center align-items-center">
                <div class="col-auto d-md-block d-none">
                    <div class="header-links">
                        <ul>
                            <li><i class="far fa-envelope"></i><a href="mailto:info@example.com">smartclean@gmail.com</a>
                            </li>
                            <li class="d-lg-inline d-none"><i class="far fa-clock"></i>Saturday - Thrusday 8:00 AM - 6:00
                                PM
                            </li>
                        </ul>
                    </div>
                </div>
                <div class="col-auto">
                    <div class="social-style1">
                        <span class="social-title">Follow Us On :</span>
                        <div class="social-icon">
                            <a href="#"><i class="fab fa-facebook-f"></i></a>
                            <a href="#"><i class="fab fa-linkedin-in"></i></a>
                            <a href="#"><i class="fab fa-instagram"></i></a>
                            <a href="#"><i class="fab fa-youtube"></i></a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- Main Header --}}
    <div class="sticky-wrapper style2">

        <div class="sticky-active">

            <div class="menu-area">

                <div class="main-container2">

                    <div class="row align-items-center justify-content-between">

                        {{-- Site Logo --}}
                        <div class="col-auto">
                            <div class="header-logo">
                                <a href="{{ route('index') }}">
                                    <img src="{{ asset('frontend/assets/img/logo-dark.png') }}" alt="logo">
                                </a>
                            </div>
                        </div>

                        {{-- Main Menu --}}
                        <div class="col">
                            <nav class="main-menu menu-style2 d-none d-lg-block">
                                <ul>
                                    <li class="{{ request()->routeIs('index') ? 'active' : '' }}">
                                        <a href="{{ route('index') }}">Home</a>
                                    </li>

                                    <li class="{{ request()->routeIs('about.us') ? 'active' : '' }}">
                                        <a href="{{ route('about.us') }}">About Us</a>
                                    </li>

                                    <li class="{{ request()->routeIs('services') ? 'active' : '' }}">
                                        <a href="{{ route('services') }}">Services</a>
                                    </li>

                                    <li class="{{ request()->routeIs('events') ? 'active' : '' }}">
                                        <a href="{{ route('events') }}">Events</a>
                                    </li>

                                    <li class="{{ request()->routeIs('contact.us') ? 'active' : '' }}">
                                        <a href="{{ route('contact.us') }}">Contact</a>
                                    </li>
                                </ul>
                            </nav>

                        </div>

                        {{-- Mobile Menu Toggle Button --}}
                        <div class="col-auto d-lg-none">
                            <button class="vs-menu-toggle d-inline-block">
                                <i class="fal fa-bars"></i>
                            </button>
                        </div>

                        {{-- Login & Register Button --}}
                        <div class="col-auto d-lg-block d-none">
                            <div class="header-inner">
                                <div class="contact-content d-flex">
                                    @php
                                        $user = Auth::user();
                                    @endphp

                                    @if ($user)
                                        <div class="user-dropdown">
                                            <div class="user-toggle">
                                                <img src="{{ asset('upload/avatar.png') }}" alt="User Avatar">
                                                <span>{{ $user->name }}</span>
                                                <i class="far fa-chevron-down"></i>
                                            </div>

                                            <div class="user-menu">
                                                <a
                                                    href="{{ $user->role === 'admin' ? route('admin.dashboard') : route('dashboard') }}">
                                                    <i class="far fa-user-circle"></i> Dashboard
                                                </a>


                                                <form method="POST" action="{{ route('logout') }}">
                                                    @csrf
                                                    <button type="submit">
                                                        <i class="far fa-sign-out-alt"></i> Logout
                                                    </button>
                                                </form>
                                            </div>
                                        </div>
                                    @else
                                        <h6 class="contact-title"><a href="/login">Login</a></h6>
                                        <h6 class="contact-title px-2">|</h6>
                                        <h6 class="contact-title"><a href="/register">Register</a></h6>
                                    @endif

                                </div>
                            </div>
                        </div>

                    </div>

                </div>

            </div>

        </div>

    </div>

</header>
