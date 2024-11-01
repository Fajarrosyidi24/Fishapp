@extends('layouts.app')
@section('title')
<title>Forgot Password - Fishapp</title>

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
            <form action="{{ route('password.email') }}" method="POST" class="shadow p-4 rounded bg-white">
                <h1 class="text-center mb-4">Forgot Password</h1>
                @csrf

                <div class="form-group mb-3">
                    <label for="email">Email</label>
                    <input type="email" class="form-control" id="email" name="email" required placeholder="Enter your email address">
                </div>

                <button type="submit" class="btn btn-primary w-100 mb-3">Send Password Reset Link</button>

                <div class="d-flex justify-content-between mb-3">
                    <a href="{{ route('login') }}" class="d-block" style="font-size: 0.675rem;">Back to Login</a>
                </div>
            </form>
        </div>
    </div>
</div>

@include('components.foot')
@endsection
