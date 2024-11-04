@extends('layouts.app_admin')

@section('title')
    <title>Detail Seafood {{ $seafood->nama }} Page - Fishapp</title>
    <style>
        .card-title {
            font-size: 1.2rem; /* Ukuran judul lebih kecil */
            font-weight: bold;
        }

        /* Custom border style for the table */
        table {
            border: 1px solid black; /* Border untuk seluruh tabel */
            font-size: 0.85rem; /* Ukuran font tabel lebih kecil */
            width: 100%; /* Lebar tabel penuh */
        }

        th, td {
            border: 1px solid black; /* Border untuk header dan sel tabel */
            padding: 0.4rem; /* Padding lebih kecil */
        }

        .btn {
            font-size: 0.75rem; /* Ukuran font tombol lebih kecil */
            padding: 0.25rem 0.5rem; /* Padding tombol lebih kecil */
        }

        h1 {
            font-size: 1.4rem; /* Ukuran judul utama lebih kecil */
        }

        .card-img-top {
            height: 200px; /* Mengatur tinggi gambar */
            width: 100%; /* Lebar gambar penuh */
            object-fit: cover; /* Memastikan gambar tetap proporsional */
        }

        /* Menambahkan margin pada tabel untuk tampilan lebih baik */
        .table {
            margin: 0; /* Menghapus margin default */
        }
    </style>
@endsection

@section('content')
<div class="mt-5">
    <div class="row justify-content-center">
        <div class="col-12">
            <h1 class="mb-4 text-center">{{ $seafood->nama }}</h1>

            <div class="card shadow border-0">
                <img src="{{ asset('storage/fotoseafood/' . $seafood->foto) }}" class="card-img-top" alt="{{ $seafood->nama }}">
                <div class="card-body">
                    <h5 class="card-title text-primary">Detail Seafood</h5>
                    <table class="table table-bordered border-dark">
                        <tbody>
                            <tr>
                                <th scope="row">Nama</th>
                                <td>{{ $seafood->nama }}</td>
                            </tr>
                            <tr>
                                <th scope="row">Jenis</th>
                                <td>{{ $seafood->jenis_seafood }}</td>
                            </tr>
                            <tr>
                                <th scope="row">Jumlah Tersedia</th>
                                <td>{{ $seafood->jumlah }} KG</td>
                            </tr>
                            <tr>
                                <th scope="row">Status</th>
                                <td>{{ $seafood->status }}</td>
                            </tr>
                            <tr>
                                <th scope="row">Harga</th>
                                <td>Rp {{ number_format($seafood->harga->harga, 0, ',', '.') }} /KG</td>
                            </tr>
                            <tr>
                                <th scope="row">Nama Penjual</th>
                                <td>{{$seafood->nelayan->name}}</td>
                            </tr>
                            <tr>
                                <th scope="row">Nomor Penjual</th>
                                <td>{{$seafood->nelayan->detailprofile->no_telepon}}</td>
                            </tr>
                            <tr>
                                <th scope="row">Email Penjual</th>
                                <td>{{$seafood->nelayan->email}}</td>
                            </tr>
                        </tbody>
                    </table>
                    @if($seafood->status === 'siap dijual')
                    <a href="{{route('dataseafood')}}">
                        <button class="btn btn-sm btn-secondary">Kembali</button>
                    </a>
                    @else
                    <a href="{{route('checkpenjualan')}}">
                        <button class="btn btn-sm btn-secondary">Kembali</button>
                    </a>
                    @endif

                    @if($seafood->status === 'siap dijual')
                    @else
                    <a href="#">
                        <button class="btn btn-sm btn-success">Verifikasi Permintaan</button>
                    </a>
                    <a href="#">
                        <button class="btn btn-sm btn-danger">Tolak Permintaan</button>
                    </a>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
