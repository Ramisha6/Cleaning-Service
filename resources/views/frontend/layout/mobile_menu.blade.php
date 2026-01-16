<div class="vs-menu-wrapper">
    <div class="vs-menu-area text-center">
        <button class="vs-menu-toggle">
            <i class="fal fa-times"></i>
        </button>

        {{-- Mobile Logo --}}
        <div class="mobile-logo mb-4">
            <a href="{{ route('index') }}">
                <img src="{{ asset('frontend/assets/img/logo-dark.png') }}" alt="Smart Clean">
            </a>
        </div>

        {{-- Mobile Menu --}}
        <div class="vs-mobile-menu">
            <ul>

                <li>
                    <a href="{{ route('index') }}">Home</a>
                </li>

                <li>
                    <a href="{{ route('about.us') }}">About Us</a>
                </li>

                <li>
                    <a href="{{ route('services') }}">Services</a>
                </li>

                <li>
                    <a href="{{ route('events') }}">Events</a>
                </li>

                <li>
                    <a href="{{ route('contact.us') }}">Contact</a>
                </li>

                {{-- Divider --}}
                <li class="menu-divider"></li>

                {{-- Auth Section --}}
                @auth
                    <li>
                        <a href="{{ auth()->user()->role === 'admin' ? route('admin.dashboard') : route('dashboard') }}">
                            <i class="far fa-user-circle"></i>
                            Dashboard
                        </a>
                    </li>

                    <li>
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <button type="submit" class="mobile-logout-btn">
                                <i class="far fa-sign-out-alt"></i>
                                Logout
                            </button>
                        </form>
                    </li>
                @else
                    <li>
                        <a href="{{ route('login') }}">
                            <i class="far fa-sign-in-alt"></i>
                            Login
                        </a>
                    </li>

                    <li>
                        <a href="{{ route('register') }}">
                            <i class="far fa-user-plus"></i>
                            Register
                        </a>
                    </li>
                @endauth

            </ul>
        </div>
    </div>
</div>

<style>
    .menu-divider {
        height: 1px;
        background: rgba(0, 0, 0, 0.1);
        margin: 15px 0;
    }

    .mobile-logout-btn {
        background: none;
        border: none;
        padding: 12px 20px;
        width: 100%;
        text-align: left;
        color: #333;
        font-size: 16px;
    }
</style>
