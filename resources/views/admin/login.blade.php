@extends('layouts.app')
@section('title')
<title>Login Admin Page - Fishapp</title>

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
            <form action="{{ route('admin.login') }}" method="POST" class="shadow p-4 rounded bg-white">
                @csrf
                <h1 class="text-center mb-4 custom-title">Login Admin</h1>

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
                
                <div class="form-group form-check mb-3">
                    <input type="checkbox" class="form-check-input" id="remember" name="remember">
                    <label class="form-check-label" for="remember">Ingat Saya</label>
                </div>

                <button type="submit" class="btn btn-primary w-100 mb-3">Login</button>

                <div class="text-center mb-3">
                    <span class="text-muted">atau masuk dengan</span>
                </div>

                <div class="d-flex justify-content-between mb-3">
                    <a href="{{ route('admin.password.request') }}" class="d-block" style="font-size: 0.700rem;">Lupa Kata Sandi?</a>
                    <a href="{{ route('login') }}" class="d-block" style="font-size: 0.700rem;">Masuk Sebagai Pembeli</a>
                    <a href="{{ route('login_nelayan') }}" class="d-block" style="font-size: 0.700rem;">Masuk Sebagai Nelayan</a>
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
</script>
@endsection