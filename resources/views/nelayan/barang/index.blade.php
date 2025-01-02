@extends('layouts.app_nelayan')
@section('title')
<title>Nelayan Barangsewa Page - Fishapp</title>
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
    <li class="breadcrumb-item active">Barang Sewa</li>
</ol>
<div class="d-flex justify-content-end mb-4">
    <a href="{{route('create.barangsewa')}}" class="btn btn-success">+ Tambah Data Barangsewa</a>
</div>
<div class="container mt-4">
    <div class="row">

    @if($barangsewa->isEmpty())
    <h6>data tidak ada</h6>
    @endif

        @forEach($barangsewa as $se)
        <div class="col-md-3 mb-4">
            <div class="card shadow-sm">
                <img src="{{asset('storage/fotobarang/'.$se->foto_barang)}}" class="card-img-top" alt="foto barang" style="height: 150px; object-fit: cover;">
                <div class="card-body p-2">
                    <h5 class="card-title fs-6">{{$se->nama_barang}}</h5>
                    <div class="mb-1">
                        <i class="bi bi-graph-up"></i> 20X disewa
                        <div class="progress" style="height: 4px;"> <!-- Mengurangi tinggi progress bar -->
                            <div class="progress-bar" role="progressbar" style="width: 20%;" aria-valuenow="75" aria-valuemin="0" aria-valuemax="100"></div>
                        </div>
                    </div>
                    <p class="card-text fw-bold mb-1">Rp {{ number_format($se->harga->harga, 0, ',', '.') }} /jam</p>
                    <p class="card-text mb-0">Tersedia {{$se->jumlah}} {{$se->nama_barang}}</p>
                    @if ($se->status === 'menunggu di verifikasi admin')
                    <p class="card-text mb-3" style="color: red">belum bisa dijual {{$se->status}}, tunggu hingga 2x/24jam</p>
                    @else
                    <p class="card-text mb-3" style="color: green">status {{$se->status}} <br><br><br><br></p>
                    @endif
                    <p class="card-text fw-bold mb-0">Rating Penyewaan :</p>
                    <div class="mb-1">
                        <i class="bi bi-star-fill text-warning"></i>
                        <i class="bi bi-star-fill text-warning"></i>
                        <i class="bi bi-star-fill text-warning"></i>
                        <i class="bi bi-star-fill text-warning"></i>
                        <i class="bi bi-star text-muted"></i>
                    </div>
                    <div class="d-flex gap-1">
                        <a href="{{ route('barang.detail.nelayan', ['kode_barang' => $se->kode_barang]) }}" class="btn btn-sm btn-primary">
                            <i class="bi bi-eye"></i>
                        </a>
                        <a href="{{ route('barang.edit.nelayan', ['kode_barang' => $se->kode_barang]) }}" class="btn btn-sm btn-warning text-white">
                            <i class="bi bi-pencil-square"></i> 
                        </a>
                        <a href="#" class="btn btn-sm btn-danger" data-bs-toggle="modal" data-bs-target="#productModal3{{ $se->kode_barang }}">
                            <i class="bi bi-trash"></i>
                        </a>
                    </div>
                </div>
            </div>
        </div>
        @endforeach

        @foreach ($barangsewa as $se)
                <div class="modal fade" id="productModal3{{ $se->kode_barang }}" tabindex="-1"
                    aria-labelledby="productModalLabel" aria-hidden="true">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="productModalLabel" style="color: black">
                                    {{ $se->nama_barang }} - Delete</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal"
                                    aria-label="Close"></button>
                            </div>
                            <div class="modal-body">
                                <form action="{{ route('nealayan.deletesBarang', ['kode_barang' => $se->kode_barang]) }}"
                                    method="POST" enctype="multipart/form-data">
                                    @csrf

                                    <p>apakah anda akan menghapus barang ini?</p>
                                    <button type="submit" class="btn btn-danger">iya</button>
                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
</div>
@endsection
