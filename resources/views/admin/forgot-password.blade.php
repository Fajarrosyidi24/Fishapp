@extends('layouts.app')
@section('title')
<title>Forgot Password Admin Page - Fishapp</title>

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
            <form action="{{ route('admin.password.email') }}" method="POST" class="shadow p-4 rounded bg-white">
                @csrf
                <h1 class="text-center mb-4 custom-title">Admin Forgot Password</h1>

                <div class="form-group mb-3">
                    <label for="email">Email</label>
                    <input type="email" class="form-control" id="email" name="email" required placeholder="Masukkan email Anda">
                </div>

                <button type="submit" class="btn btn-primary w-100 mb-3">Send Password Reset Link</button>        
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