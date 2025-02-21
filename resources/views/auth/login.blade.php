@extends('layouts.master2')

@section('title', __('تسجيل الدخول'))

@section('css')
    <!-- Sidemenu-responsive-tabs CSS -->
    <link href="{{ URL::asset('assets/plugins/sidemenu-responsive-tabs/css/sidemenu-responsive-tabs.css') }}"
        rel="stylesheet">
    <style>
        /* Background Styling */
        .login-container {
            min-height: 100vh;
            display: flex;
            justify-content: center;
            align-items: center;
            background: linear-gradient(135deg, #6e8efb, #a777e3);
        }

        /* Card Styling */
        .login-card {
            background: white;
            border-radius: 12px;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.15);
            padding: 40px;
            width: 100%;
            max-width: 400px;
            text-align: center;
        }

        /* Logo Styling */
        .logo {
            height: 50px;
            margin-bottom: 10px;
        }

        /* Heading Styling */
        .login-header h2 {
            font-weight: 700;
            color: #333;
        }

        .login-header h5 {
            font-weight: 500;
            color: #555;
        }

        /* Form Inputs */
        .form-group label {
            font-weight: 600;
            color: #444;
        }

        .form-control {
            border-radius: 8px;
            height: 45px;
        }

        /* Button Styling */
        .btn-main-primary {
            background: linear-gradient(135deg, #6e8efb, #a777e3);
            border: none;
            border-radius: 8px;
            font-weight: bold;
            transition: 0.3s;
            padding: 10px;
        }

        .btn-main-primary:hover {
            background: linear-gradient(135deg, #a777e3, #6e8efb);
            transform: scale(1.05);
        }

        /* Image Styling */
        .login-image {
            max-width: 100%;
            height: auto;
            animation: float 3s ease-in-out infinite;
        }

        /* Floating Animation */
        @keyframes float {

            0%,
            100% {
                transform: translateY(0);
            }

            50% {
                transform: translateY(-10px);
            }
        }

        /* Responsive */
        @media (max-width: 768px) {
            .login-container {
                flex-direction: column;
                padding: 20px;
            }

            .login-card {
                margin-top: 20px;
            }
        }
    </style>
@endsection

@section('content')
    <div class="login-container">
        <div class="login-card">
            <a href="{{ url('/') }}">
                <img src="{{ URL::asset('assets/img/brand/favicon.png') }}" class="logo" alt="logo">
            </a>
            <div class="login-header">
                <h2>{{ __('مرحبًا بك') }}</h2>
                <h5>{{ __('تسجيل الدخول') }}</h5>
            </div>

            <form method="POST" action="{{ route('login') }}">
                @csrf

                <!-- Email Input -->
                <div class="form-group text-right">
                    <label for="email">{{ __('البريد الإلكتروني') }}</label>
                    <input id="email" type="email" class="form-control @error('email') is-invalid @enderror"
                        name="email" value="{{ old('email') }}" required autocomplete="email" autofocus>
                    @error('email')
                        <span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>
                    @enderror
                </div>

                <!-- Password Input -->
                <div class="form-group text-right">
                    <label for="password">{{ __('كلمة المرور') }}</label>
                    <input id="password" type="password" class="form-control @error('password') is-invalid @enderror"
                        name="password" required autocomplete="current-password">
                    @error('password')
                        <span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>
                    @enderror
                </div>


                <!-- Login Button -->
                <button type="submit" class="btn btn-main-primary btn-block">
                    {{ __('تسجيل الدخول') }}
                </button>
            </form>
        </div>
    </div>
@endsection

@section('js')
@endsection
