@extends('layouts.app')
@section('title')
    <title>Register Page - Fishapp</title>
    <style>
        .custom-title {
            font-size: 2rem; /* Sesuaikan ukuran font sesuai kebutuhan */
            font-weight: bold; /* Opsional: membuat font menjadi tebal */
        }
        
    </style>
@endsection

@section('content')
<div class="container mt-5 mb-5">
    <div class="row justify-content-center">
        <div class="col-md-6 col-lg-4">
            <form action="{{ route('register') }}" method="POST" class="shadow p-4 rounded bg-white">
                <h1 class="text-center mb-4">Register</h1>
                @csrf

                <div class="form-group mb-3">
                    <label for="name">Nama</label>
                    <input type="text" class="form-control" id="name" name="name" required placeholder="Masukkan nama Anda">
                </div>

                <div class="form-group mb-3">
                    <label for="email">Email</label>
                    <input type="email" class="form-control" id="email" name="email" required placeholder="Masukkan email Anda">
                </div>

                <div class="form-group mb-3">
                    <label for="password">Password</label>
                    <div class="input-group">
                        <input type="password" class="form-control" id="password" name="password" required placeholder="Masukkan kata sandi Anda">
                        <div class="input-group-append" id="toggle-password" style="cursor: pointer;">
                            <span class="input-group-text d-flex align-items-center" style="height: 100%;">
                                <i class="bi bi-eye" id="eye-icon"></i>
                            </span>
                        </div>
                    </div>
                </div>


                <div class="form-group mb-3">
                    <label for="confirm_password">Konfirmasi Password</label>
                    <div class="input-group">
                        <input type="password" class="form-control" id="confirm_password" name="password_confirmation" required placeholder="Masukkan kata sandi Anda">
                        <div class="input-group-append" id="toggle-password-confirmation" style="cursor: pointer;">
                            <span class="input-group-text d-flex align-items-center" style="height: 100%;">
                                <i class="bi bi-eye" id="eye-icon-confirm"></i>
                            </span>
                        </div>
                    </div>
                </div>

                <button type="submit" class="btn btn-primary w-100 mb-1">Register</button>

                <div class="text-center mb-3">
                    <span class="text-muted">atau daftar dengan</span>
                </div>

                <div class="container mt-1">
                <div class="row">
                            <div class="col-6">
                                <a href="{{ route('google-auth') }}" class="login-btn google; btn btn-outline-primary"           style="display: flex; align-items: center; text-decoration: none;">
                                <img src="https://developers.google.com/identity/images/g-logo.png" 
                                    alt="Google" 
                                    style="width: 20px; height: auto;">
                                    <span style="font-size: 16px; color: primary;">Google</span>
                                </a>
                            </div>
                            <div class="col-6">
                                <a href="{{ route('facebook-auth') }}" class="login-btn facebook; btn btn-outline-primary" style="display: flex; align-items: center; text-decoration: none;">
                                    <img src="https://upload.wikimedia.org/wikipedia/commons/5/51/Facebook_f_logo_%282019%29.svg" 
                                    alt="Facebook" 
                                    style="width: 20px; height: auto;">
                                    <span style="font-size: 16px; color: primary;">Facebook</span>
                                </a>
                            </div>
                </div>
            </div>

                <div class="d-flex justify-content-between mb-3">
                    <a href="{{ route('login') }}" class="d-block" style="font-size: 0.900rem; margin-top:25px;">Sudah punya akun? Login</a>
                    <a href="{{ route('login_admin') }}" class="d-block" style="font-size: 0.900rem; margin-top:25px;">Masuk sebagai Admin</a>
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
               passwordInput.type = 'text'; // Tampilkan password
               eyeIcon.classList.remove('bi-eye'); // Ganti ikon mata
               eyeIcon.classList.add('bi-eye-slash'); // Ganti ikon mata
           } else {
               passwordInput.type = 'password'; // Sembunyikan password
               eyeIcon.classList.remove('bi-eye-slash'); // Ganti ikon mata
               eyeIcon.classList.add('bi-eye'); // Ganti ikon mata
           }
       });

       document.getElementById('toggle-password-confirmation').addEventListener('click', function() {
           const passwordInput = document.getElementById('confirm_password');
           const eyeIcon = document.getElementById('"eye-icon-confirm');
   
           if (passwordInput.type === 'password') {
               passwordInput.type = 'text'; // Tampilkan password
               eyeIcon.classList.remove('bi-eye'); // Ganti ikon mata
               eyeIcon.classList.add('bi-eye-slash'); // Ganti ikon mata
           } else {
               passwordInput.type = 'password'; // Sembunyikan password
               eyeIcon.classList.remove('bi-eye-slash'); // Ganti ikon mata
               eyeIcon.classList.add('bi-eye'); // Ganti ikon mata
           }
       });
</script>

//jajal
@endsection
