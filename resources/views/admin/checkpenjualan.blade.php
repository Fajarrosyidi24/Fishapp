@extends('layouts.app_admin')
@section('title')
<title>Permintaan Penjualan Seafood Page - Fishapp</title>
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css">
<style>
    .card {
        border: none;
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1), 0 2px 4px rgba(0, 0, 0, 0.08);
        transition: transform 0.2s, box-shadow 0.2s;
    }

    .card:hover {
        transform: translateY(-5px);
        box-shadow: 0 8px 16px rgba(0, 0, 0, 0.15), 0 4px 8px rgba(0, 0, 0, 0.12);
    }

    .card img {
        border-radius: 4px 4px 0 0;
    }
</style>
@endsection

@section('content')
<ol class="breadcrumb mt-4">
    <li class="breadcrumb-item active">Permintaan Penjualan Seafood</li>
</ol>
<div class="container mt-4">
    <div class="row">

        @forEach($seafood as $se)
        <!-- Produk 1 -->
        <div class="col-md-3 mb-4">
            <div class="card shadow-sm">
                <img src="{{asset('storage/fotoseafood/'.$se->foto)}}" class="card-img-top" alt="foto seafood" style="height: 150px; object-fit: cover;">
                <div class="card-body p-2">
                    <h5 class="card-title fs-6">{{$se->nama}}</h5>
                    <!-- Presentase Penjualan -->
                    <p class="card-text fw-bold mb-1">Rp {{ number_format($se->harga->harga, 0, ',', '.') }} /KG</p>
                    <p class="card-text mb-0">Tersedia {{$se->jumlah}} KG</p>
                    <p class="card-text mb-3" style="color: red">status {{$se->status}}</p>
                    <div class="d-flex gap-1">
                        <a href="{{route('admin.view.detail.seafood', ['id' => $se->kode_seafood])}}">
                            <button class="btn btn-sm btn-primary">Detail</button> 
                        </a>
                        <a href="#">
                            <button class="btn btn-sm btn-success" data-bs-toggle="modal" data-bs-target="#confirmModal{{$se->kode_seafood}}">verifikasi</button> 
                        </a>
                        <a href="#">
                            <button class="btn btn-sm btn-danger">Tolak</button> 
                        </a>
                    </div>
                </div>
            </div>
        </div>


        <!-- Modal -->
        <div class="modal fade" id="confirmModal{{$se->kode_seafood}}" tabindex="-1" aria-labelledby="confirmModalLabel"
            aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="confirmModalLabel">Konfirmasi Verifikasi</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal"
                            aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        Apakah Anda yakin ingin memverifikasi Seafood ini?
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                        <form action="{{ route('admin.verifikasi.seafood', $se->kode_seafood) }}" method="POST"
                            style="display: inline;">
                            @csrf
                            <button type="submit" class="btn btn-success">Verifikasi</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        @endforeach

@endsection