<header class="vs-header header-layout1 style2">
    <div class="header-top style2">
        <div class="main-container2">
            <div class="row justify-content-md-between justify-content-center align-items-center">
                <div class="col-auto d-md-block d-none">
                    <div class="header-links">
                        <ul>
                            <li><i class="far fa-envelope"></i><a href="mailto:info@example.com">smartclean@gmail.com</a>
                            </li>
                            <li class="d-lg-inline d-none"><i class="far fa-clock"></i>Satday - Thrusday 8:00 AM - 6:00 PM
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
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="sticky-wrapper style2">
        <div class="sticky-active">
            <div class="menu-area">
                <div class="main-container2">
                    <div class="row align-items-center justify-content-between">
                        <div class="col-auto">
                            <div class="header-logo">
                                <a href="/">
                                    <img src="{{ asset('frontend/assets/img/logo-dark.png') }}" alt="logo">
                                </a>
                            </div>
                        </div>
                        <div class="col">
                            <nav class="main-menu menu-style2 d-none d-lg-block">
                                <ul>
                                    <li class="menu-item-has-children">
                                        <a href="/">Home</a>
                                    </li>
                                    <li>
                                        <a href="">About Us</a>
                                    </li>
                                    <li class="menu-item-has-children">
                                        <a href="">Service</a>
                                    </li>
                                    <li>
                                        <a href="">Contact</a>
                                    </li>
                                </ul>
                            </nav>
                        </div>
                        <div class="col-auto d-lg-none">
                            <button class="vs-menu-toggle d-inline-block">
                                <i class="fal fa-bars"></i>
                            </button>
                        </div>
                        <div class="col-auto d-lg-block d-none">
                            <div class="header-inner">
                                <div class="contact-content d-flex">
                                    @php
                                        $user = Auth::user();
                                    @endphp

                                    @if ($user)
                                        <h6 class="contact-title">
                                            <form method="POST" action="{{ route('logout') }}">
                                                @csrf
                                                <button type="submit" class="text-theme">Logout</button>
                                            </form>

                                        </h6>
                                    @else
                                        <h6 class="contact-title"><a href="/login">Login</a> | </h6>
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
