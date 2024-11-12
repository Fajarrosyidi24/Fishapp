@extends('layouts.app_admin')

@section('title')
    <title>Detail Barang Sewa {{ $barang->nama }} Page - Fishapp</title>
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
            <h1 class="mb-4 text-center">{{ $barang->nama_barang }}</h1>

            <div class="card shadow border-0">
                <img src="{{ asset('storage/fotobarang/' . $barang->foto_barang) }}" class="card-img-top" alt="{{ $barang->nama }}">
                <div class="card-body">
                    <h5 class="card-title text-primary">Detail Barang Sewa</h5>
                    <table class="table table-bordered border-dark">
                        <tbody>
                            <tr>
                                <th scope="row">Nama</th>
                                <td>{{ $barang->nama_barang }}</td>
                            </tr>
                            <tr>
                                <th scope="row">Kondisi</th>
                                <td>{{ $barang->kondisi }}</td>
                            </tr>
                            <tr>
                                <th scope="row">Jumlah Tersedia</th>
                                <td>{{ $barang->jumlah }}</td>
                            </tr>
                            <tr>
                                <th scope="row">Status</th>
                                <td>{{ $barang->status }}</td>
                            </tr>
                            <tr>
                                <th scope="row">Harga</th>
                                <td>Rp {{ number_format($barang->harga->harga, 0, ',', '.') }} /KG</td>
                            </tr>
                            <tr>
                                <th scope="row">Nama Penjual</th>
                                <td>{{$barang->nelayan->name}}</td>
                            </tr>
                            <tr>
                                <th scope="row">Nomor Penjual</th>
                                <td>{{$barang->nelayan->detailprofile->no_telepon}}</td>
                            </tr>
                            <tr>
                                <th scope="row">Email Penjual</th>
                                <td>{{$barang->nelayan->email}}</td>
                            </tr>
                        </tbody>
                    </table>
                    @if($barang->status === 'siap dijual')
                    <a href="{{route('checkpenyewaanalat.nelayan')}}">
                        <button class="btn btn-sm btn-secondary">Kembali</button>
                    </a>
                    @else
                    <a href="{{route('checkpenyewaanalat.nelayan')}}">
                        <button class="btn btn-sm btn-secondary">Kembali</button>
                    </a>
                    @endif

                    @if($barang->status === 'siap dijual')
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