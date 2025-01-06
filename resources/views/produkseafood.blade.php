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
                            <li class="breadcrumb-item"><a class="text-white"
                                    href="{{ route('pembeli.produk.seafood') }}">Seafood</a>
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
        <a href="{{ route('beliseafood', ['kode_seafood' => $se->kode_seafood]) }}" class="text-decoration-none text-dark">
            <div class="card h-100 shadow-sm">
                <img src="{{ asset('storage/fotoseafood/' . $se->foto) }}" class="card-img-top" alt="foto seafood"
                    style="height: 150px; object-fit: cover;">
                <div class="card-body">
                    <h5 class="card-title fs-6">{{ $se->nama }}</h5>
                    <!-- Total Penjualan -->
                    <div class="mb-2">
                        <small class="text-muted">
                            <i class="bi bi-graph-up"></i> {{ $se->jumlah_terjual }} kali terjual
                        </small>
                        <div class="progress" style="height: 5px;"> <!-- Ukuran progress bar -->
                            @php
                                // Menghitung persentase jumlah terjual dibandingkan dengan stok
                                $percentage = ($se->jumlah_terjual / $se->jumlah) * 100;
                                $percentage = min($percentage, 100); // Membatasi agar tidak melebihi 100%
                            @endphp
                            <div class="progress-bar bg-success" role="progressbar" style="width: {{ $percentage }}%;"
                                aria-valuenow="{{ $se->jumlah_terjual }}" aria-valuemin="0" aria-valuemax="{{ $se->jumlah }}">
                            </div>
                        </div>
                    </div>
                    <p class="card-text fw-bold mb-1">Rp {{ number_format($se->harga->harga, 0, ',', '.') }} /KG</p>
                    <p class="card-text mb-2">Tersedia {{ $se->jumlah }} KG</p>
                    <!-- Rating Bintang -->
                    <p class="card-text fw-bold mb-1">Rating Penjualan:</p>
                    <div class="mb-2">
                      @php
    // Inisialisasi rating
    $rating = 0;
    $fullStars = 0;
    $halfStar = false;

    // Pastikan relasi rating ada sebelum menghitung rata-rata
    if ($se->rating && $se->rating->count() > 0) {
        $rating = $se->rating->avg('rating'); // Menghitung rata-rata rating
        $fullStars = floor($rating); // Mengambil nilai bintang penuh
        $halfStar = $rating - $fullStars >= 0.5; // Mengecek apakah ada bintang setengah
    }
@endphp
                        <!-- Menampilkan bintang penuh -->
                        @for ($i = 1; $i <= $fullStars; $i++)
                            <i class="bi bi-star-fill text-warning"></i>
                        @endfor
                        <!-- Menampilkan bintang setengah jika ada -->
                        @if ($halfStar)
                            <i class="bi bi-star-half text-warning"></i>
                        @endif
                        <!-- Menampilkan bintang kosong -->
                        @for ($i = $fullStars + ($halfStar ? 1 : 0); $i < 5; $i++)
                            <i class="bi bi-star text-muted"></i>
                        @endfor
                    </div>
                    <div class="d-flex gap-2">
                        <a href="#" data-bs-toggle="modal" data-bs-target="#productModal{{ $se->kode_seafood }}"
                            class="btn btn-sm btn-primary text-white">
                            <i class="bi bi-eye"></i> Detail
                        </a>
                        <a href="{{ route('beliseafood', ['kode_seafood' => $se->kode_seafood]) }}"
                            class="btn btn-sm btn-success text-white">
                            <i class="bi bi-cart-plus"></i> Beli
                        </a>
                    </div>
                </div>
            </div>
        </a>
    </div>
    
   <div class="modal fade" id="productModal{{ $se->kode_seafood }}" tabindex="-1" aria-labelledby="productModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="productModalLabel" style="color: black">
                    Detail Produk
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form>
                    @csrf
                    <!-- Nama Seafood -->
                    <div class="mb-3">
                        <label for="namaSeafood" class="form-label">Nama Seafood</label>
                        <input type="text" class="form-control" id="namaSeafood" value="{{ $se->nama }}" readonly>
                    </div>
                    <!-- Jenis Seafood -->
                    <div class="mb-3">
                        <label for="jenisSeafood" class="form-label">Jenis Seafood</label>
                        <input type="text" class="form-control" id="jenisSeafood" value="{{ $se->jenis_seafood }}" readonly>
                    </div>
                    <!-- Jumlah -->
                    <div class="mb-3">
                        <label for="jumlahSeafood" class="form-label">Jumlah Tersedia</label>
                        <input type="text" class="form-control" id="jumlahSeafood" value="{{ $se->jumlah }} KG" readonly>
                    </div>
                    <!-- Harga -->
                    <div class="mb-3">
                        <label for="hargaSeafood" class="form-label">Harga Seafood</label>
                        <input type="text" class="form-control" id="hargaSeafood" value="Rp {{ number_format($se->harga->harga, 0, ',', '.') }}" readonly>
                    </div>
                    <!-- Nama Penjual -->
                    <div class="mb-3">
                        <label for="namaPenjual" class="form-label">Nama Penjual</label>
                        <input type="text" class="form-control" id="namaPenjual" value="{{ $se->nelayan->name }}" readonly>
                    </div>
                    <div class="mb-3">
                                            <label for="alamat" class="form-label">Alamat Lengkap</label>
                                            <textarea class="form-control" id="alamat" rows="3" readonly>{{ $se->nelayan->detailProfile->alamat_lengkap }}</textarea>
                                        </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                <a href="{{route('hubungi.penjual.seafood', ['id' =>$se->nelayan->detailProfile->id ])}}" class="btn btn-sm btn-primary text-white">
                                        <i class="bi bi-telephone"></i> Hubungi Penjual
                                    </a>
    
                                    <a href="{{ route('beliseafood', ['kode_seafood' => $se->kode_seafood]) }}" class="btn btn-sm btn-success text-white">
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
