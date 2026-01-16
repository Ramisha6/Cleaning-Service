@extends('frontend.dashboard')
@section('frontend_title', 'Register')
@section('frontend')

    <section class="register-section" style="padding: 40px 0;">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-lg-9">
                    <div class="package-style1 p-5 bg-white shadow-lg rounded">

                        <div class="text-center mb-4">
                            <h2 class="sec-title h3">Create Account</h2>
                        </div>

                        {{-- Validation Errors --}}
                        @if ($errors->any())
                            <div class="alert alert-danger mb-4">
                                <ul class="mb-0">
                                    @foreach ($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif

                        <form method="POST" action="{{ route('register') }}">
                            @csrf

                            <div class="row">
                                {{-- Name --}}
                                <div class="col-md-6 mb-3">
                                    <label>Name</label>
                                    <input type="text" class="form-control border-theme @error('name') is-invalid @enderror" name="name" value="{{ old('name') }}" placeholder="Name" required>
                                </div>

                                {{-- Phone --}}
                                <div class="col-md-6 mb-3">
                                    <label>Phone</label>
                                    <input type="tel" class="form-control border-theme @error('phone') is-invalid @enderror" name="phone" value="{{ old('phone') }}" placeholder="Phone Number">
                                </div>
                            </div>

                            {{-- Email --}}
                            <div class="mb-3">
                                <label>Email Address</label>
                                <input type="email" class="form-control border-theme @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" placeholder="Enter Email" required>
                            </div>

                            {{-- Password --}}
                            <div class="mb-3">
                                <label>Password</label>
                                <input type="password" class="form-control border-theme @error('password') is-invalid @enderror" name="password" placeholder="Password" required>
                            </div>

                            {{-- Password Confirmation --}}
                            <div class="mb-3">
                                <label>Password Confirmation</label>
                                <input type="password" class="form-control border-theme" name="password_confirmation" placeholder="Confirm Password" required>
                            </div>

                            <button type="submit" class="vs-btn2 w-100 p-2">
                                Sign Up Now
                            </button>
                        </form>

                        <p class="text-center mt-4">
                            Already a member?
                            <a href="{{ route('login') }}" class="text-theme">Login Here</a>
                        </p>

                    </div>
                </div>
            </div>
        </div>
    </section>

@endsection
