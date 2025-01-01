@extends('layouts.app_nelayan')

@section('title')
    <title>Edit Barang {{$barang->nama_barang}} Page - Fishapp</title>
@endsection

@section('content')
    <div class="container mt-4">
        <ol class="breadcrumb">
            <li class="breadcrumb-item active">Edit Data Barang</li>
        </ol>

        <div class="card shadow-sm">
            <div class="card-body">
                <h5 class="card-title">Form Edit Barang</h5>
                <form action="{{route('edit.barang', ['id' => $barang->kode_barang])}}" method="POST" enctype="multipart/form-data">
                    @csrf

                    <div class="mb-3">
                        <label for="name" class="form-label">Nama Barang</label>
                        <input type="text" class="form-control" id="name" name="name" placeholder="Masukkan nama seafood" value="{{$barang->nama_barang}}" required>
                    </div>

                    <div class="mb-3">
                        <label for="type" class="form-label">Kondisi Barang</label>
                        <select class="form-select" id="type" name="type" required>
                            <option value="" disabled {{ !$barang->kondisi ? 'selected' : '' }}>Pilih Kondisi Barang</option>
                            <option value="Baik" {{ $barang->kondisi == 'Baik' ? 'selected' : '' }}>Baik</option>
                            <option value="Kurang Baik" {{ $barang->kondisi == 'Kurang Baik' ? 'selected' : '' }}>Kurang Baik</option>
                            <option value="Rusak" {{ $barang->kondisi == 'Rusak' ? 'selected' : '' }}>Rusak</option>
                        </select>
                    </div>                    

                    <div class="mb-3">
                        <label for="quantity" class="form-label">Jumlah</label>
                        <input type="number" class="form-control" id="quantity" name="quantity" placeholder="Masukkan jumlah"  value="{{$barang->jumlah}}" required>
                        <small class="form-text text-muted">Masukkan jumlah dalam satuan penyewaan /jam (jam).</small>
                    </div>

                    <div class="mb-3">
                        <label for="price" class="form-label">Harga (Rp)</label>
                        <input type="number" class="form-control" id="price" name="price" placeholder="Masukkan harga"  value="{{$barang->harga->harga}}" required min="100">
                        <small class="form-text text-muted">Masukkan harga dalam rupiah.dalam hitungan /jam</small>
                    </div>

                    <div class="mb-3">
                        <label for="photo" class="form-label">Foto Barang:</label>
                        <div class="mb-2">
                            <img src="{{ asset('storage/fotobarang/' . $barang->foto_barang) }}" alt="Foto seafood" style="max-width: 100%; height: auto; border: 1px solid #ddd; padding: 5px; border-radius: 5px;">
                        </div>
                        <label for="photo" class="form-label mt-2">Ubah Foto:</label>
                        <input type="file" class="form-control" id="photo" name="photo" accept="image/*">
                    </div>                    

                    <button type="submit" class="btn btn-primary">Simpan</button>
                    <a href="{{ route('barangsewa.index') }}" class="btn btn-secondary">Kembali</a>
                </form>
            </div>
        </div>
    </div>
@endsection
