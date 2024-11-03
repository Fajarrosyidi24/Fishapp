@extends('layouts.app')
@section('title')
    <title>Seafood Page - Fishapp</title>
@endsection

@section('content')
    <!-- Header Start -->
    <div class="container-fluid bg-primary py-5 mb-5 page-header">
        <div class="container py-5">
            <div class="row justify-content-center">
                <div class="col-lg-10 text-center">
                    <h1 class="display-3 text-white animated slideInDown">Produk</h1>
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb justify-content-center">
                            <li class="breadcrumb-item"><a class="text-white" href="{{ route('seafood.guest') }}">Seafood</a>
                            </li>
                            <li class="breadcrumb-item text-white active" aria-current="page">Seafood</li>
                        </ol>
                    </nav>
                </div>
            </div>
        </div>
    </div>
    <!-- Header End -->

    <div class="container mb-3">
        <div class="row row-cols-1 row-cols-md-2 row-cols-lg-4 g-4"> <!-- Grid responsif -->
            @foreach ($seafood as $se)
                <!-- Produk Card -->
                <div class="col">
                    <div class="card h-100 shadow-sm">
                        <img src="{{ asset('storage/fotoseafood/' . $se->foto) }}" class="card-img-top" alt="foto seafood"
                            style="height: 150px; object-fit: cover;">
                        <div class="card-body">
                            <h5 class="card-title fs-6">{{ $se->nama }}</h5>
                            <!-- Total Penjualan -->
                            <div class="mb-2">
                                <small class="text-muted"><i class="bi bi-graph-up"></i> 2000 kali terjual</small>
                                <div class="progress" style="height: 5px;"> <!-- Ukuran progress bar -->
                                    <div class="progress-bar bg-success" role="progressbar" style="width: 20%;" aria-valuenow="200" aria-valuemin="0" aria-valuemax="10000"></div>
                                </div>
                            </div>
                            <p class="card-text fw-bold mb-1">Rp {{ number_format($se->harga->harga, 0, ',', '.') }} /KG</p>
                            <p class="card-text mb-2">Tersedia {{ $se->jumlah }} KG</p>
                            <!-- Rating Bintang -->
                            <p class="card-text fw-bold mb-1">Rating Penjualan:</p>
                            <div class="mb-2">
                                <i class="bi bi-star-fill text-warning"></i>
                                <i class="bi bi-star-fill text-warning"></i>
                                <i class="bi bi-star-fill text-warning"></i>
                                <i class="bi bi-star-fill text-warning"></i>
                                <i class="bi bi-star text-muted"></i>
                            </div>
                            <div class="d-flex gap-2">
                                <a href="#"
                                   class="btn btn-sm btn-primary text-white">
                                    <i class="bi bi-eye"></i> Detail
                                </a>
                                <a href="#"
                                   class="btn btn-sm btn-success text-white">
                                    <i class="bi bi-cart-plus"></i> Beli
                                </a>
                            </div>                                                      
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>

    @include('components.foot')
@endsection
