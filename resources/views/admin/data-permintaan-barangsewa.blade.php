@extends('layouts.app_admin')

@section('title')
<title>Data Permintaan Penyewaan Alat -Page Fishapp</title>
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
    <li class="breadcrumb-item active">Permintaan Penyewaan Alat</li>
</ol>
<div class="container mt-4">
    <div class="row">

        @forEach($barang as $se)
        <!-- Produk 1 -->
        <div class="col-md-3 mb-4">
            <div class="card shadow-sm">
                <img src="{{asset('storage/fotobarang/'.$se->foto_barang)}}" class="card-img-top" alt="foto seafood" style="height: 150px; object-fit: cover;">
                <div class="card-body p-2">
                    <h5 class="card-title fs-6">{{$se->nama}}</h5>
                    <!-- Presentase Penjualan -->
                    <p class="card-text fw-bold mb-1">Rp {{ number_format($se->harga->harga, 0, ',', '.') }} /Jam</p>
                    <p class="card-text mb-0">Stok Tersedia {{$se->jumlah}} {{$se->nama}}</p>
                    <p class="card-text mb-3" style="color: red">status {{$se->status}}</p>
                    <div class="d-flex gap-1">
                        <a href="{{route('admin.view.detail.permintaan.barang', ['id' => $se->kode_barang])}}">
                            <button class="btn btn-sm btn-primary">Detail</button> 
                        </a>
                        <a href="#">
                            <button class="btn btn-sm btn-success" data-bs-toggle="modal" data-bs-target="#confirmModal{{$se->kode_barang}}">verifikasi</button> 
                        </a>
                        <a href="#">
                            <button class="btn btn-sm btn-danger" data-bs-toggle="modal" data-bs-target="#confirmModal2{{$se->kode_barang}}">Tolak</button> 
                        </a>
                    </div>
                </div>
            </div>
        </div>


        <!-- Modal -->
        <div class="modal fade" id="confirmModal{{$se->kode_barang}}" tabindex="-1" aria-labelledby="confirmModalLabel"
            aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="confirmModalLabel">Konfirmasi Verifikasi</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal"
                            aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        Apakah Anda yakin ingin memverifikasi Barang ini untuk di sewakan?
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                        <form action="{{ route('admin.verifikasi.barang', $se->kode_barang) }}" method="POST"
                            style="display: inline;">
                            @csrf
                            <button type="submit" class="btn btn-success">Verifikasi</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>

        <!-- Modal -->
        <div class="modal fade" id="confirmModal2{{$se->kode_barang}}" tabindex="-1" aria-labelledby="confirmModalLabel"
            aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="confirmModalLabel">Tolak Permintaan</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal"
                            aria-label="Close"></button>
                    </div>
                    <div class="modal-body">

                        <form id="rejectionForm" class="mt-4" class="mb-3 my-4"
                    action="{{route('tolakbarang.admin', ['id' => $se->kode_barang])}}" method="POST">
                    @csrf
                    <h5>Alasan Penolakan Alat</h5>
                    <div class="form-check mb-2">
                        <input class="form-check-input" type="checkbox" name="reason1"
                            value="Dokumen identitas tidak valid atau tidak lengkap.">
                        <label class="form-check-label" for="reason1">Tidak Memenuhi Syarat Untuk DiSewakan</label>
                    </div>
                    <div class="form-check mb-2">
                        <input class="form-check-input" type="checkbox" name="reason2"
                            value="Data pribadi yang disediakan tidak sesuai">
                        <label class="form-check-label" for="reason2">Gambar Bukan Merupakan Barang Sewa yang sesuai</label>
                    </div>
                    <button type="submit" class="btn btn-danger" id="submitButton2" disabled>Tolak Permintaan</button>
                </form>

                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                    </div>
                </div>
            </div>
        </div>
        @endforeach
    </div>
</div>
@endsection

@section('foot')
    <script>
        document.getElementById('rejectButton').addEventListener('click', function() {
            document.getElementById('rejectionForm').style.display = 'block';
        });

        document.getElementById('reasonOther').addEventListener('change', function() {
            if (this.checked) {
                document.getElementById('otherReasonInput').style.display = 'block';
            } else {
                document.getElementById('otherReasonInput').style.display = 'none';
            }
        });
    </script>

    <script>
        // JavaScript to enable or disable the submit button based on checkbox selection
        document.addEventListener('DOMContentLoaded', function() {
            const form = document.getElementById('rejectionForm');
            const checkboxes = form.querySelectorAll('.form-check-input');
            const submitButton = document.getElementById('submitButton2');

            checkboxes.forEach(checkbox => {
                checkbox.addEventListener('change', function() {
                    // Enable the button if at least one checkbox is checked
                    submitButton.disabled = !Array.from(checkboxes).some(cb => cb.checked);
                });
            });
        });
    </script>

    <script>
        // Optional: Enable/disable the submit button based on checkbox selection
        const checkboxes = document.querySelectorAll('#rejectionForm .form-check-input');
        const submitBtn = document.getElementById('submitBtn');

        checkboxes.forEach(checkbox => {
            checkbox.addEventListener('change', () => {
                submitBtn.disabled = !Array.from(checkboxes).some(cb => cb.checked);
            });
        });
    </script>
@endsection