@extends('layouts.app')
@section('title')
    <title>BarangSewa page - Fishapp</title>
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
                                    href="{{ route('pembeli.produk.barangsewa') }}">Barang Sewa</a>
                            </li>
                            <li class="breadcrumb-item text-white active" aria-current="page">Barang Sewa</li>
                        </ol>
                    </nav>
                </div>
            </div>
        </div>
    </div>
    <!-- Header End -->

    <div class="container mb-3">
        <div class="row row-cols-1 row-cols-md-2 row-cols-lg-4 g-4">
            @foreach ($barang as $br)
                <div class="col">
                    <div class="card h-100 shadow-sm">
                        <img src="{{ asset('storage/fotobarang/' . $br->foto_barang) }}" class="card-img-top" alt="foto barang"
                            style="height: 150px; object-fit: cover;">
                        <div class="card-body">
                            <h5 class="card-title fs-6">{{$br->nama_barang}}</h5>
                            <div class="mb-2">
                                <small class="text-muted"><i class="bi bi-graph-up"></i> 2000 kali terjual</small>
                                <div class="progress" style="height: 5px;">
                                    <div class="progress-bar bg-success" role="progressbar" style="width: 20%;"
                                    aria-valuenow="200" aria-valuemin="0" aria-valuemax="10000"></div>
                                </div>
                            </div>
                            <p class="card-text fw-bold mb-1">Rp {{ number_format($br->harga->harga, 0, ',', '.') }} /Jam</p>
                            <p class="card-text mb-2">Tersedia {{ $br->jumlah }} Jam</p>
                             <!-- Rating Bintang -->
                            <p class="card-text fw-bold mb-1">Rating Penyewa:</p>
                            <div class="mb-2">
                                <i class="bi bi-star-fill text-warning"></i>
                                <i class="bi bi-star-fill text-warning"></i>
                                <i class="bi bi-star-fill text-warning"></i>
                                <i class="bi bi-star-fill text-warning"></i>
                                <i class="bi bi-star text-muted"></i>
                            </div>
                            <div class="d-flex gap-2">
                            <a href="#" data-bs-toggle="modal"
                                    data-bs-target="#productModal{{ $br->kode_barang }}"
                                    class="btn btn-sm btn-primary text-white">
                                    <i class="bi bi-eye"></i> Detail
                                </a>
                                <a href="{{ route('sewabarang', ['kode_barang' => $br->kode_barang]) }}" class="btn btn-sm btn-success text-white">
                                    <i class="bi bi-cart-plus"></i> Sewa
                                </a>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="modal fade" id="productModal{{ $br->kode_barang }}" tabindex="-1"
                    aria-labelledby="productModalLabel" aria-hidden="true">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                            <h5 class="modal-title" id="productModalLabel" style="color: black">
                                    Detail
                                    <button type="button" class="btn-close" data-bs-dismiss="modal"
                                        aria-label="Close"></button>
                            </div>
                            <div class="modal-body">
                                <form>
                                @csrf
                                    <div class="mb-3">
                                        <label for="namaSeafood" class="form-label">Nama Barang</label>
                                        <input type="text" class="form-control" id="namaBarang"
                                            value="{{ $br->nama_barang }}" readonly>
                                    </div>
                                    <div class="mb-3">
                                        <label for="hargaSeafood" class="form-label">Harga Sewa</label>
                                        <input type="text" class="form-control" id="hargaBarang"
                                            value="{{ $br->harga->harga }}" readonly>
                                    </div>
                                    <div class="mb-3">
                                        <label for="jenis_seafood" class="form-label">Kondisi Barang</label>
                                        <input type="text" class="form-control" id="kondisi"
                                            value="{{ $br->kondisi }}" readonly>
                                    </div>
                                    <div class="mb-3">
                                        <label for="jumlah" class="form-label">Jumlah barang</label>
                                        <input type="number" class="form-control" id="jumlah"
                                            value="{{ $br->jumlah }}" readonly>
                                    </div>
                                    <div class="mb-3">
                                        <label for="penjual" class="form-label">Nama Pemilik</label>
                                        <input type="text" class="form-control" id="pemilik"
                                            value="{{ $br->nelayan->name }}" readonly>
                                    </div>
                                    <div class="mb-3">
                                        <label for="alamat" class="form-label">Alamat Pemilik</label>
                                        <textarea class="form-control" id="alamat" rows="3" readonly>{{ $br->nelayan->detailProfile->alamat_lengkap }}</textarea>
                                    </div>

                                    <div class="mb-3">
                                        <label for="tel" class="form-label">No. Telpon Pemilik</label>
                                        <input type="tel" class="form-control" id="tel"
                                            value="{{ $br->nelayan->detailProfile->no_telepon }}" readonly>
                                    </div>
                                </form>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-sm btn-secondary"
                                    data-bs-dismiss="modal">Close</button>
                                <a href="{{ route('hubungi.penjual.seafood', ['id' => $br->nelayan->detailProfile->id]) }}" class="btn btn-sm btn-primary text-white">
                                    <i class="bi bi-telephone"></i> Hubungi Penjual
                                </a>

                                <a href="{{ route('sewabarang', ['kode_barang' => $br->kode_barang]) }}" class="btn btn-sm btn-success text-white">
                                    <i class="bi bi-cart-plus"></i> Sewa
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