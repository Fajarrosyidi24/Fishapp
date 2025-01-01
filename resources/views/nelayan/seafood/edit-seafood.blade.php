@extends('layouts.app_nelayan')

@section('title')
    <title>Edit Seafood {{$seafood->nama}} Page - Fishapp</title>
@endsection

@section('content')
    <div class="container mt-4">
        <ol class="breadcrumb">
            <li class="breadcrumb-item active">Edit Data Seafood</li>
        </ol>

        <div class="card shadow-sm">
            <div class="card-body">
                <h5 class="card-title">Form Edit Seafood</h5>
                <form action="{{route('edit.seafood', ['id' => $seafood->kode_seafood])}}" method="POST" enctype="multipart/form-data">
                    @csrf

                    <div class="mb-3">
                        <label for="name" class="form-label">Nama Seafood</label>
                        <input type="text" class="form-control" id="name" name="name" placeholder="Masukkan nama seafood" value="{{$seafood->nama}}" required>
                    </div>

                    <div class="mb-3">
                        <label for="type" class="form-label">Jenis Seafood</label>
                        <select class="form-select" id="type" name="type" required>
                            <option value="" disabled {{ !$seafood->jenis_seafood ? 'selected' : '' }}>Pilih jenis seafood</option>
                            <option value="ikan" {{ $seafood->jenis_seafood == 'ikan' ? 'selected' : '' }}>Ikan</option>
                            <option value="udang" {{ $seafood->jenis_seafood == 'udang' ? 'selected' : '' }}>Udang</option>
                            <option value="cumi" {{ $seafood->jenis_seafood == 'cumi' ? 'selected' : '' }}>Cumi-cumi</option>
                            <option value="kepiting" {{ $seafood->jenis_seafood == 'kepiting' ? 'selected' : '' }}>Kepiting</option>
                        </select>
                    </div>                    

                    <div class="mb-3">
                        <label for="quantity" class="form-label">Jumlah</label>
                        <input type="number" class="form-control" id="quantity" name="quantity" placeholder="Masukkan jumlah"  value="{{$seafood->jumlah}}" required>
                        <small class="form-text text-muted">Masukkan jumlah dalam satuan kilogram (kg).</small>
                    </div>

                    <div class="mb-3">
                        <label for="price" class="form-label">Harga (Rp)</label>
                        <input type="number" class="form-control" id="price" name="price" placeholder="Masukkan harga"  value="{{$seafood->harga->harga}}" required min="100">
                        <small class="form-text text-muted">Masukkan harga dalam rupiah.dalam hitungan /kg</small>
                    </div>

                    <div class="mb-3">
                        <label for="photo" class="form-label">Foto Seafood:</label>
                        <div class="mb-2">
                            <img src="{{ asset('storage/fotoseafood/' . $seafood->foto) }}" alt="Foto seafood" style="max-width: 100%; height: auto; border: 1px solid #ddd; padding: 5px; border-radius: 5px;">
                        </div>
                        <label for="photo" class="form-label mt-2">Ubah Foto:</label>
                        <input type="file" class="form-control" id="photo" name="photo" accept="image/*">
                    </div>                    

                    <button type="submit" class="btn btn-primary">Simpan</button>
                    <a href="{{ route('sefood.index') }}" class="btn btn-secondary">Kembali</a>
                </form>
            </div>
        </div>
    </div>
@endsection
