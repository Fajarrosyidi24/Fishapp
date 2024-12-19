@extends('layouts.app_nelayan')

@section('title')
    <title>Pesanan Seafood</title>
    <style>
        .text-center {
            text-align: center;
        }

        #datatablesSimple th,
        #datatablesSimple td {
            text-align: center;
            vertical-align: middle;
            border: 1px solid #cccaca;
        }
    </style>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
@endsection

@section('content')
    <ol class="breadcrumb mt-4">
        <li class="breadcrumb-item active">Pesanan Seafood</li>
    </ol>

    <div class="card mb-4">
        <div class="card-header">
            <i class="fas fa-table me-1"></i>
            List Pesanan
        </div>
        <div class="card-body">
            <table id="datatablesSimple" class="table table-striped table-hover table-bordered">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Nama Pembeli</th>
                        <th class="text-center">Status</th>
                        <th class="text-center">Detail</th>
                        <th class="text-center">Gambar Barang</th>
                        <th class="text-center">Aksi</th>
                    </tr>
                </thead>
                <tfoot>
                    <tr>
                        <th>No</th>
                        <th>Nama Pembeli</th>
                        <th class="text-center">Status</th>
                        <th class="text-center">Detail</th>
                        <th class="text-center">Gambar Barang</th>
                        <th class="text-center">Aksi</th>
                    </tr>
                </tfoot>
                <tbody>
                    @foreach ($pesananSeafood as $index => $pesanan)
                        <tr>
                            <!-- Nomor Urut -->
                            <td class="text-center">{{ $index + 1 }}</td>

                            <td>
                                @if ($pesanan->keranjangs->isNotEmpty() && $pesanan->keranjangs->first()->user)
                                    {{ $pesanan->keranjangs->first()->user->name }}
                                @else
                                    Unknown User
                                @endif
                            </td>

                            <td class="text-center">
                                <div class="{{ $pesanan->status == 'success' ? 'badge bg-success' : 'text-dark' }}">
                                    {{ $pesanan->status }}
                                </div>
                            </td>


                            <!-- Tombol Detail -->
                            <td class="text-center">
                                <a href="#" data-bs-toggle="modal" data-bs-target="#productModal{{ $pesanan->id }}">
                                    <button class="btn btn-sm btn-warning">
                                        <i class="fa-solid fa-circle-info"></i> Detail
                                    </button>
                                </a>
                            </td>

                            <!-- Gambar Barang -->
                            <td class="text-center">
                                @if ($pesanan->keranjangs->isNotEmpty())
                                    @foreach ($pesanan->keranjangs as $keranjang)
                                        @if ($keranjang->seafood && $keranjang->seafood->foto)
                                            <img src="{{ asset('storage/fotoseafood/' . $keranjang->seafood->foto) }}"
                                                alt="Foto Seafood" class="rounded img-thumbnail mb-1"
                                                style="width: 80px; height: 80px; object-fit: cover;">
                                        @else
                                            <img src="{{ asset('images/default-seafood.png') }}" alt="Default Foto Seafood"
                                                class="rounded img-thumbnail mb-1"
                                                style="width: 80px; height: 80px; object-fit: cover;">
                                        @endif
                                    @endforeach
                                @else
                                    <span class="text-muted">Tidak ada gambar tersedia</span>
                                @endif
                            </td>

                            <td class="text-center">
                                <a href="#" data-bs-toggle="modal" data-bs-target="#productModal2{{ $pesanan->id }}">
                                    <button type="button" class="btn btn-sm btn-success"
                                        @if ($pesanan->status != 'sedang dikemas') disabled @endif>
                                        <i class="fa-solid fa-truck"></i> Kirim
                                    </button>
                                </a>
                            </td>
                        </tr>


                        <div class="modal fade" id="productModal{{ $pesanan->id }}" tabindex="-1"
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
                                                <label for="namaSeafood" class="form-label">Daftar Nama Seafood yang
                                                    Dipesan:</label>
                                                @foreach ($pesanan->keranjangs as $keranjang)
                                                    @if ($keranjang->seafood)
                                                        <div class="mb-2">
                                                            <input type="text" class="form-control" readonly
                                                                value="{{ $keranjang->seafood->nama }} ({{ $keranjang->jumlah }} KG) (Rp. {{ number_format($keranjang->subtotal, 0, ',', '.') }})">
                                                        </div>
                                                    @endif
                                                @endforeach
                                            </div>
                                            <!-- Subtotal Pesanan -->
                                            <div class="mb-3">
                                                <label for="subtotal" class="form-label">Subtotal Pesanan:</label>
                                                <input type="text" class="form-control" readonly
                                                    value="Rp. {{ number_format($pesanan->subtotal_harga, 0, ',', '.') }}">
                                            </div>
                                            <div class="mb-3">
                                                <label for="ongkir" class="form-label">Ongkos Kirim:</label>
                                                <input type="text" class="form-control" readonly
                                                    value="Rp. {{ number_format($pesanan->ongkir, 0, ',', '.') }}">
                                            </div>
                                            <div class="mb-3">
                                                <label for="total" class="form-label">Total Pesanan:</label>
                                                <input type="text" class="form-control" readonly
                                                    value="Rp. {{ number_format($pesanan->subtotal_harga + $pesanan->ongkir, 0, ',', '.') }}">
                                            </div>
                                            <div class="mb-3">
                                                <label for="total" class="form-label">Status Pembayaran :</label>
                                                <input type="text" class="form-control" readonly
                                                    value="{{ $pesanan->item->first()->pembayaran->status_pembayaran }}">
                                            </div>
                                            @if ($pesanan->item->first()->pembayaran->status_pembayaran == 'PAID')
                                                <div class="mb-3">
                                                    <label for="detailPembayaran" class="form-label">Detail
                                                        Pembayaran:</label>
                                                    <a
                                                        href="{{ route('pembayaran.detail', ['id' => $pesanan->keranjangs->first()->user->id, 'pesanan_id' => $pesanan->id]) }}">
                                                        <button type="button" class="btn btn-sm btn-info">
                                                            <i class="fa-solid fa-info-circle"></i> Detail
                                                        </button>
                                                    </a>
                                                </div>
                                            @endif
                                            <div class="mb-3">
                                                <label for="alamat" class="form-label">Alamat Tujuan Pengiriman</label>
                                                <textarea class="form-control" id="alamat" rows="3" readonly> Dusun {{ $pesanan->keranjangs->first()->user->alamat->dusun }}, RT.{{ $pesanan->keranjangs->first()->user->alamat->rt }}/RW.{{ $pesanan->keranjangs->first()->user->alamat->rw }}, Desa {{ $pesanan->keranjangs->first()->user->alamat->desa }}, Kecamatan {{ $pesanan->keranjangs->first()->user->alamat->kecamatan }}, Kabupaten {{ $pesanan->keranjangs->first()->user->alamat->kabupaten }}, Provinsi {{ $pesanan->keranjangs->first()->user->alamat->provinsi }}, Kode Pos : {{ $pesanan->keranjangs->first()->user->alamat->code_pos }}
                                                </textarea>
                                            </div>

                                            <div class="mb-3">
                                                <label for="nama_pembeli" class="form-label">Nama Pembeli</label>
                                                <input type="text" class="form-control" id="tel"
                                                    value="{{ $pesanan->keranjangs->first()->user->name }}" readonly>
                                            </div>

                                            <div class="mb-3">
                                                <label for="nama_pembeli" class="form-label">Nomor Telepon Pembeli</label>
                                                <input type="tel" class="form-control" id="tel"
                                                    value="{{ $pesanan->keranjangs->first()->user->updateProfile->no_telepon }}"
                                                    readonly>
                                            </div>

                                        </form>
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-sm btn-secondary"
                                            data-bs-dismiss="modal">Close</button>
                                    </div>
                                </div>
                            </div>
                        </div>


                        <div class="modal fade" id="productModal2{{ $pesanan->id }}" tabindex="-1"
                            aria-labelledby="productModalLabel{{ $pesanan->id }}" aria-hidden="true">
                            <div class="modal-dialog">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="productModalLabel{{ $pesanan->id }}"
                                            style="color: black">
                                            Silakan Isi Terlebih Dahulu
                                        </h5>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal"
                                            aria-label="Close"></button>
                                    </div>
                                    <div class="modal-body">
                                        <form method="POST"
                                            action="{{ route('upload.pengiriman.seafood', ['id' => $pesanan->id]) }}"
                                            enctype="multipart/form-data">
                                            @csrf
                                            <div class="mb-3">
                                                <label for="photo" class="form-label">Upload Bukti Pengiriman</label>
                                                <div id="video-container{{ $pesanan->id }}"
                                                    class="video-container d-flex justify-content-center align-items-center my-3"
                                                    style="position: relative; width: 100%; max-width: 400px; aspect-ratio: 4/3; border: 2px solid #ccc; border-radius: 8px; overflow: hidden;">
                                                    <video id="video-webcam{{ $pesanan->id }}" autoplay
                                                        class="w-100 h-100" style="object-fit: cover;">
                                                        Browser tidak mendukung, mohon perbarui terlebih dahulu!!!
                                                    </video>
                                                </div>

                                                <div id="preview-container{{ $pesanan->id }}"
                                                    class="text-center my-3 d-none">
                                                    <img id="preview-img{{ $pesanan->id }}" alt="Preview Foto"
                                                        class="d-flex justify-content-center align-items-center my-3"
                                                        style="position: relative; width: 100%; max-width: 400px; aspect-ratio: 4/3; border: 2px solid #ccc; border-radius: 8px; overflow: hidden;">
                                                    <button type="button" id="retake-photo-btn{{ $pesanan->id }}"
                                                        class="btn btn-warning mt-3"
                                                        onclick="retakePhoto({{ $pesanan->id }})">Ambil Foto
                                                        Ulang</button>
                                                </div>

                                                <div class="text-center my-3">
                                                    <button type="button" onclick="takeSnapshoot({{ $pesanan->id }})"
                                                        class="btn btn-primary">Ambil Foto</button>
                                                        <input type="file" id="file-input{{ $pesanan->id }}"
                                                        accept="image/*" class="form-control my-3 d-none"
                                                        onchange="previewImage(event, {{ $pesanan->id }})">
                                                 
                                                    <button type="button" class="btn btn-secondary"
                                                        onclick="triggerFileInput({{ $pesanan->id }})">Pilih dari
                                                        Penyimpanan</button>
                                                </div>

                                                <input type="hidden" id="photo-input{{ $pesanan->id }}" name="photo"
                                                    required>
                                            </div>
                                            <button type="button" class="btn btn-secondary"
                                                data-bs-dismiss="modal">Close</button>
                                            <button type="submit" class="btn btn-success">Kirim</button>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
@endsection

@section('foot')
    <script>
        function initializeCamera(pesananId) {
            const video = document.querySelector(`#video-webcam${pesananId}`);
            navigator.mediaDevices.getUserMedia({
                    video: true
                })
                .then(stream => {
                    video.srcObject = stream;
                })
                .catch(error => {
                    alert("Izinkan menggunakan webcam untuk demo!");
                });
        }

        function takeSnapshoot(pesananId) {
            const video = document.querySelector(`#video-webcam${pesananId}`);
            const canvas = document.createElement('canvas');
            const context = canvas.getContext('2d');
            const width = video.videoWidth;
            const height = video.videoHeight;

            canvas.width = width;
            canvas.height = height;

            context.drawImage(video, 0, 0, width, height);

            const imgData = canvas.toDataURL('image/png');
            const previewImg = document.querySelector(`#preview-img${pesananId}`);
            const previewContainer = document.querySelector(`#preview-container${pesananId}`);
            const videoContainer = document.querySelector(`#video-container${pesananId}`);
            const photoInput = document.querySelector(`#photo-input${pesananId}`);

            // Tampilkan preview
            previewImg.src = imgData;
            previewContainer.classList.remove('d-none');

            // Sembunyikan video
            videoContainer.classList.add('d-none');

            // Simpan data ke input hidden
            photoInput.value = imgData;
        }

        function triggerFileInput(pesananId) {
            const fileInput = document.querySelector(`#file-input${pesananId}`);
            fileInput.click();
        }

        function previewImage(event, pesananId) {
            const file = event.target.files[0];
            if (file) {
                const reader = new FileReader();
                reader.onload = function(e) {
                    const previewImg = document.querySelector(`#preview-img${pesananId}`);
                    const previewContainer = document.querySelector(`#preview-container${pesananId}`);
                    const videoContainer = document.querySelector(`#video-container${pesananId}`);
                    const photoInput = document.querySelector(`#photo-input${pesananId}`);

                    // Tampilkan preview
                    previewImg.src = e.target.result;
                    previewContainer.classList.remove('d-none');

                    // Sembunyikan video
                    videoContainer.classList.add('d-none');

                    // Simpan data ke input hidden
                    photoInput.value = e.target.result;
                };
                reader.readAsDataURL(file);
            }
        }

        function retakePhoto(pesananId) {
            const videoContainer = document.querySelector(`#video-container${pesananId}`);
            const previewContainer = document.querySelector(`#preview-container${pesananId}`);
            const photoInput = document.querySelector(`#photo-input${pesananId}`);

            // Tampilkan kembali video dan sembunyikan preview
            videoContainer.classList.remove('d-none');
            previewContainer.classList.add('d-none');

            // Kosongkan input hidden
            photoInput.value = "";

            // Inisialisasi ulang kamera
            initializeCamera(pesananId);
        }

        document.addEventListener('DOMContentLoaded', () => {
            const modals = document.querySelectorAll('.modal');

            modals.forEach(modal => {
                modal.addEventListener('shown.bs.modal', event => {
                    const pesananId = modal.id.replace('productModal2', '');
                    initializeCamera(pesananId);
                });

                modal.addEventListener('hidden.bs.modal', event => {
                    const video = modal.querySelector('video');
                    if (video && video.srcObject) {
                        const stream = video.srcObject;
                        const tracks = stream.getTracks();
                        tracks.forEach(track => track.stop());
                        video.srcObject = null;
                    }
                });
            });
        });
    </script>
@endsection
