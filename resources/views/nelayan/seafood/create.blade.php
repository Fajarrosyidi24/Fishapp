@extends('layouts.app_nelayan')

@section('title')
    <title>Create Seafood Page - Fishapp</title>
@endsection

@section('content')
    <div class="container mt-4">
        <ol class="breadcrumb">
            <li class="breadcrumb-item active">Tambahkan Data Seafood</li>
        </ol>

        <div class="card shadow-sm">
            <div class="card-body">
                <h5 class="card-title">Form Tambah Seafood</h5>
                <form action="{{ route('sefood.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf

                    <div class="mb-3">
                        <label for="name" class="form-label">Nama Seafood</label>
                        <input type="text" class="form-control" id="name" name="name" placeholder="Masukkan nama seafood" required>
                    </div>

                    <div class="mb-3">
                        <label for="type" class="form-label">Jenis Seafood</label>
                        <select class="form-select" id="type" name="type" required>
                            <option value="" disabled selected>Pilih jenis seafood</option>
                            <option value="ikan">Ikan</option>
                            <option value="udang">Udang</option>
                            <option value="cumi">Cumi-cumi</option>
                            <option value="kepiting">Kepiting</option>
                            <!-- Tambahkan jenis seafood lainnya jika perlu -->
                        </select>
                    </div>

                    <div class="mb-3">
                        <label for="quantity" class="form-label">Jumlah</label>
                        <input type="number" class="form-control" id="quantity" name="quantity" placeholder="Masukkan jumlah" required>
                        <small class="form-text text-muted">Masukkan jumlah dalam satuan kilogram (kg).</small>
                    </div>

                    <div class="mb-3">
                        <label for="price" class="form-label">Harga (Rp)</label>
                        <input type="number" class="form-control" id="price" name="price" placeholder="Masukkan harga" required min="100">
                        <small class="form-text text-muted">Masukkan harga dalam rupiah.dalam hitungan /kg</small>
                    </div>

                    <div class="mb-3">
                        <label for="photo" class="form-label">Foto Seafood</label>
                        <input type="file" class="form-control" id="photo" name="photo" accept="image/*">
                    </div>

                    <button type="submit" class="btn btn-primary">Simpan</button>
                    <a href="{{ route('sefood.index') }}" class="btn btn-secondary">Kembali</a>
                </form>
            </div>
        </div>
    </div>
@endsection
