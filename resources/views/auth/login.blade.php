@extends('frontend.dashboard')
@section('frontend_title', 'Login')
@section('frontend')

    <section class="register-section" style="padding: 40px 0;">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-lg-5 col-md-8">
                    <div class="package-style1 p-5 bg-white shadow-lg rounded">
                        <div class="text-center mb-4">
                            <img src="{{ asset('frontend/assets/img/logo-dark.png') }}" alt="logo" class="mb-3">
                        </div>
                        <form method="POST" action="{{ route('login') }}" class="form-group">
                            @csrf
                            <div class="mb-3">
                                <label>Email Address</label>
                                <input type="email" class="form-control border-theme" name="email" placeholder="Enter Email" required>
                            </div>
                            <div class="mb-3">
                                <label>Password</label>
                                <input type="password" class="form-control border-theme" name="password" placeholder="Password" required>
                            </div>
                            <div class="d-flex justify-content-between mb-4">
                                <div>
                                    <input type="checkbox" id="remember"> <label for="remember">Remember Me</label>
                                </div>
                                <a href="#" class="text-theme">Forgot Password?</a>
                            </div>
                            <button type="submit" class="vs-btn2 w-100 p-2">Login Now</button>
                        </form>
                        <p class="text-center mt-4">Don't have an account? <a href="/register" class="text-theme">Register Here</a></p>
                    </div>
                </div>
            </div>
        </div>
    </section>

@endsection
