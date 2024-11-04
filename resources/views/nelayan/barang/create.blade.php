@extends('layouts.app_nelayan')

@section('title')
    <title>Create Barangsewa Page - Fishapp</title>
@endsection

@section('content')
    <div class="container mt-4">
        <ol class="breadcrumb">
            <li class="breadcrumb-item active">Tambahkan Data Barangsewa</li>
        </ol>
        <div class="card shadow-sm">
            <div class="card-body">
                <h5 class="card-title">Form Tambah Barangsewa</h5>
                <form action="{{ route('barang.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="mb-3">
                        <label for="name" class="form-label">Nama Barang</label>
                        <input type="text" class="form-control" id="name" name="name" placeholder="Masukkan nama Barang Sewa" required>
                    </div>

                    <div class="mb-3">
                        <label for="type" class="form-label">Kondisi Barang</label>
                        <select class="form-select" id="type" name="type" required>
                            <option value="" disabled selected>Pilih Kondisi Barang Saat Ini</option>
                            <option value="Baik">Baik</option>
                            <option value="Kurang Baik">Kurang Baik</option>
                            <option value="Rusak">Rusak</option>
                        </select>
                    </div>

                    <div class="mb-3">
                        <label for="quantity" class="form-label">Jumlah Barang</label>
                        <input type="number" class="form-control" id="quantity" name="quantity" placeholder="Masukkan jumlah" required>
                        <small class="form-text text-muted">Masukkan jumlah stok Barang yang akan disewakan</small>
                    </div>

                    <div class="mb-3">
                        <label for="price" class="form-label">Harga (Rp)</label>
                        <input type="number" class="form-control" id="price" name="price" placeholder="Masukkan harga" required min="1000">
                        <small class="form-text text-muted">Masukkan harga barang dalam rupiah.dalam hitungan /jam Sewa</small>
                    </div>

                    <div class="mb-3">
                        <label for="photo" class="form-label">Foto Barang</label>
                        <input type="file" class="form-control" id="photo" name="photo" accept="image/*">
                    </div>

                    <button type="submit" class="btn btn-primary">Simpan</button>
                    <a href="{{ route('barangsewa.index') }}" class="btn btn-secondary">Kembali</a>
                </form>
            </div>
        </div>
    </div>
@endsection
