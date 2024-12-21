@extends('layouts.app')
@section('title')
<title>About - Fishapp</title>
@endsection

@section('content')
 <!-- Header Start -->
 <div class="container-fluid bg-primary py-5 mb-5 page-header">
    <div class="container py-5">
        <div class="row justify-content-center">
            <div class="col-lg-10 text-center">
                <h1 class="display-3 text-white animated slideInDown">About</h1>
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb justify-content-center">
                        <li class="breadcrumb-item"><a class="text-white" href="#">Dashboard</a></li>
                        <li class="breadcrumb-item text-white active" aria-current="page">About</li>
                    </ol>
                </nav>
            </div>
        </div>
    </div>
</div>
<!-- Header End -->
@include('components.service')
<!-- About Start -->
<div class="container-xxl py-5">
    <div class="container">
        <div class="row g-5">
            <div class="col-lg-6 wow fadeInUp" data-wow-delay="0.1s" style="min-height: 400px;">
                <div class="position-relative h-100">
                    <img class="img-fluid position-absolute w-100 h-100" src="img/Ikan-Tuna-Sirip-Kuning.jpg"
                        alt="" style="object-fit: cover;">
                </div>
            </div>
            <div class="col-lg-6 wow fadeInUp" data-wow-delay="0.3s">
                <h6 class="section-title bg-white text-start pe-3" style="color: #097ABA">Tentang Kami</h6>
                <h1 class="mb-4">Selamat Datang di FishApp</h1>
                <p class="mb-4" style="color: black">FishApp bukan hanya sekadar aplikasi, kami adalah platform inovatif yang menghubungkan nelayan dengan pelanggan yang mencari hasil laut segar. Kami hadir untuk memberdayakan nelayan dan meningkatkan aksesibilitas produk perikanan melalui teknologi yang efisien.</p>
                <p class="mb-4" style="color: black">Dengan sistem pemesanan online yang mudah dan jaringan pengiriman yang luas, FishApp memastikan Anda mendapatkan hasil tangkapan terbaik dari nelayan lokal, langsung ke pintu Anda.</p>
                <div class="row gy-2 gx-4 mb-4">
                    <div class="col-sm-6">
                        <p class="mb-0" style="color: black"><i class="fa fa-arrow-right text-primary me-2"></i>Hasil Laut Segar dan Berkualitas</p>
                    </div>
                    <div class="col-sm-6">
                        <p class="mb-0" style="color: black"><i class="fa fa-arrow-right text-primary me-2"></i>Pemesanan Mudah dan Cepat</p>
                    </div>
                    <div class="col-sm-6">
                        <p class="mb-0" style="color: black"><i class="fa fa-arrow-right text-primary me-2"></i>Pembayaran Aman dan Terpercaya</p>
                    </div>
                    <div class="col-sm-6">
                        <p class="mb-0" style="color: black"><i class="fa fa-arrow-right text-primary me-2"></i>Pengiriman Cepat ke Lokasi Anda</p>
                    </div>
                    <div class="col-sm-6">
                        <p class="mb-0" style="color: black"><i class="fa fa-arrow-right text-primary me-2"></i>Tim Layanan Pelanggan Siap Membantu</p>
                    </div>
                </div>
                <a class="btn btn-warning py-3 px-5 mt-2" href="{{ route('about_information2') }}">Selengkapnya</a>
            </div>
        </div>
    </div>
</div>
<!-- About End -->

{{-- @include('components.team') --}}
@include('components.foot')
@endsection
