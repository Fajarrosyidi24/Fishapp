@extends('layouts.app')

@section('title')
    <title>Login Page - Fishapp</title>
@endsection

@section('head')
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <style>
        .custom-title {
            font-size: 2rem;
            font-weight: bold;
        }

        body {
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            background-color: #121212;
            margin: 0;
            font-family: Arial, sans-serif;
        }

        .login-btn {
            display: flex;
            align-items: center;
            justify-content: center;
            width: 150px;
            height: 50px;
            color: #ffff;
            background-color: #333;
            border: 1px solid #444;
            border-radius: 5px;
            text-decoration: none;
            font-size: 16px;
            transition: background-color 0.3s;
            
        }

        .login-btn:hover {
            background-color: #555;
            
        }

        .login-btn img {
            margin-right: 10px;
        }
    </style>
@endsection

@section('content')
<div class="container mt-5 mb-5">
    <div class="row justify-content-center">
        <div class="col-md-6 col-lg-4">
            <form action="{{ route('login') }}" method="POST" class="shadow p-4 rounded bg-white">
                <h1 class="text-center mb-4">Login</h1>
                @csrf

                <div class="form-group mb-3">
                    <label for="email">Email</label>
                    <input type="email" class="form-control" id="email" name="email" required placeholder="Masukkan email Anda">
                </div>
                
                <div class="form-group mb-3">
                    <label for="password">Password</label>
                    <div class="input-group">
                        <input type="password" class="form-control" id="password" name="password" required placeholder="Masukkan kata sandi Anda">
                        <div class="input-group-append" id="toggle-password" style="cursor: pointer;">
                            <span class="input-group-text d-flex align-items-center">
                                <i class="bi bi-eye" id="eye-icon"></i>
                            </span>
                        </div>
                    </div>
                </div>
                
                <div class="form-group form-check mb-3">
                    <input type="checkbox" class="form-check-input" id="remember" name="remember">
                    <label class="form-check-label" for="remember">Ingat Saya</label>
                </div>

                <button type="submit" class="btn btn-primary w-100 mb-3">Login</button>

                <div class="text-center mb-3">
                    <span class="text-muted">atau masuk dengan</span>
                </div>
            
            <div class="container mt-1">
                <div class="row">
                            <div class="col-6">
                                <a href="{{ route('google-auth') }}" class="login-btn google; btn btn-outline-primary"           style="display: flex; align-items: center; text-decoration: none;">
                                <img src="https://developers.google.com/identity/images/g-logo.png" 
                                    alt="Google" 
                                    style="width: 25px; height: auto;">
                                    <span style="font-size: 16px; color: primary;">Google</span>
                                </a>
                            </div>
                            <div class="col-6">
                                <a href="{{ route('facebook-auth') }}" class="login-btn facebook; btn btn-outline-primary" style="display: flex; align-items: center; text-decoration: none;">
                                    <img src="https://upload.wikimedia.org/wikipedia/commons/5/51/Facebook_f_logo_%282019%29.svg" 
                                    alt="Facebook" 
                                    style="width: 25px; height: auto;">
                                    <span style="font-size: 16px; color: primary;">Facebook</span>
                                </a>
                            </div>
                </div>
            </div>

                <div class="d-flex justify-content-between mb-3">
                    <a href="{{ route('password.request') }}" style="font-size: 0.900rem; margin-top:25px;">Lupa Kata Sandi?</a>
                    <a href="{{ route('login_nelayan') }}" style="font-size: 0.900rem; margin-top:25px;">Masuk sebagai nelayan</a>
                </div>
            </form>
        </div>
    </div>
</div>

@include('components.foot')
@endsection

@section('foot')
<script>
    document.getElementById('toggle-password').addEventListener('click', function() {
        const passwordInput = document.getElementById('password');
        const eyeIcon = document.getElementById('eye-icon');

        if (passwordInput.type === 'password') {
            passwordInput.type = 'text';
            eyeIcon.classList.remove('bi-eye');
            eyeIcon.classList.add('bi-eye-slash');
        } else {
            passwordInput.type = 'password';
            eyeIcon.classList.remove('bi-eye-slash');
            eyeIcon.classList.add('bi-eye');
        }
    });
</script>
@endsection
