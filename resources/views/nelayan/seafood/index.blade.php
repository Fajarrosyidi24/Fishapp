@extends('layouts.app_nelayan')
@section('title')
<title>Nelayan Seafood Page - Fishapp</title>
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
    <li class="breadcrumb-item active">Seafood</li>
</ol>
<div class="d-flex justify-content-end mb-4">
    <a href="{{route('create.seafood')}}" class="btn btn-success">+ Tambah Data Seafood</a>
</div>
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
                    <div class="mb-1">
                        <i class="bi bi-graph-up"></i> 20% terjual
                        <div class="progress" style="height: 4px;"> <!-- Mengurangi tinggi progress bar -->
                            <div class="progress-bar" role="progressbar" style="width: 20%;" aria-valuenow="75" aria-valuemin="0" aria-valuemax="100"></div>
                        </div>
                    </div>
                    <p class="card-text fw-bold mb-1">Rp {{ number_format($se->harga->harga, 0, ',', '.') }} /KG</p>
                    <p class="card-text mb-0">Tersedia {{$se->jumlah}} KG</p>
                    @if ($se->status === 'menunggu di verifikasi admin')
                    <p class="card-text mb-3" style="color: red">belum bisa dijual {{$se->status}}, tunggu hingga 2x/24jam</p>
                    @else
                    <p class="card-text mb-3" style="color: green">status {{$se->status}} <br><br><br><br></p>
                    @endif
                    <!-- Rating Bintang -->
                    <p class="card-text fw-bold mb-0">Rating Penjualan :</p>
                    <div class="mb-1">
                        <i class="bi bi-star-fill text-warning"></i>
                        <i class="bi bi-star-fill text-warning"></i>
                        <i class="bi bi-star-fill text-warning"></i>
                        <i class="bi bi-star-fill text-warning"></i>
                        <i class="bi bi-star text-muted"></i>
                    </div>
                    <div class="d-flex gap-1">
                        <a href="{{ route('seafood.detail.nelayan', ['kode_seafood' => $se->kode_seafood]) }}" class="btn btn-sm btn-primary">
                            <i class="bi bi-eye"></i> <!-- Ikon mata untuk detail -->
                        </a>
                        <a href="{{ route('seafood.edit.nelayan', ['kode_seafood' => $se->kode_seafood]) }}" class="btn btn-sm btn-warning text-white">
                            <i class="bi bi-pencil-square"></i> <!-- Ikon pensil untuk edit -->
                        </a>
                        <a href="#" class="btn btn-sm btn-danger" data-bs-toggle="modal" data-bs-target="#productModal3{{ $se->kode_seafood }}">
                            <i class="bi bi-trash"></i> <!-- Ikon tempat sampah untuk hapus -->
                        </a>

                    </div>
                </div>
            </div>
        </div>
        @endforeach

        @foreach($seafood as $se)
        <div class="modal fade" id="productModal3{{ $se->kode_seafood }}" tabindex="-1"
            aria-labelledby="productModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="productModalLabel" style="color: black">
                            {{ $se->nama }} - Delete</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal"
                            aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <form
                            action="{{ route('nealayan.deleteseafood', ['kode_seafood' => $se->kode_seafood]) }}"
                            method="POST" enctype="multipart/form-data">
                            @csrf

                            <p>apakah anda akan menghapus barang ini?</p>
                            <button type="submit" class="btn btn-danger">iya</button>
                            <button type="button" class="btn btn-secondary"
                                data-bs-dismiss="modal">Close</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        @endforeach
    </div>
</div>

@endsection
