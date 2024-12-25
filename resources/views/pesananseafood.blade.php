@extends('layouts.app')

@section('title')
    <title>Pesanan Seafood - Fishapp</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #202020;
            color: #ffffff;
            margin: 0;
            padding: 0;
        }

        .navbar-1 {
            display: flex;
            background-color: #097ABA;
        }

        .navbar-1 a {
            color: #000000;
            text-decoration: none;
            font-size: 15px;
            align-items: center
        }

        .navbar-1 a.active {
            color: #ffffff;
            font-weight: bold;
            font-size: 15px;
            align-items: center
        }

        .container {
            padding: 20px;
            width: 100%;
            margin: auto;
        }

        .header {
            display: flex;
            align-items: center;
            justify-content: space-between;
            margin-bottom: 20px;
        }

        .header .star {
            color: #000000;
            font-weight: bold;
        }

        .header .chat-btn,
        .header .store-btn {
            background-color: #09AFBA;
            color: #ffffff;
            padding: 5px 10px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
        }

        .order {
            background-color: #F7F7F7;
            padding: 15px;
            border-radius: 8px;
            box-shadow: 0px 4px 10px rgba(0, 0, 0, 0.1);
        }

        .order img {
            width: 100px;
            border-radius: 5px;
        }

        .order-content {
            display: flex;
            gap: 15px;
            align-items: center;
        }

        .order-details {
            flex: 1;
            color: #000000;
        }

        .order-details h3 {
            margin: 0 0 10px;
            font-size: 16px;
        }

        .price {
            display: flex;
            justify-content: flex-end;
            align-items: center;
            gap: 10px;
        }

        .price .discount {
            text-decoration: line-through;
            color: #979797;
        }

        .price .final-price {
            color: #097ABA;
            font-weight: bold;
        }

        /* Container utama */
        .status {
            display: flex;
            justify-content: end;
            align-items: center;
            gap: 10px;
            font-size: 14px;
            color: #36d399;
        }

        /* Ikon tooltip */
        .tooltip-icon {
            position: relative;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            width: 15px;
            height: 15px;
            border: 1px solid #000000;
            border-radius: 50%;
            color: #000000;
            background-color: transparent;
            font-size: 12px;
            cursor: pointer;
        }

        /* Tooltip teks */
        .tooltip-icon .tooltip-text {
            position: absolute;
            bottom: 25px;
            left: 50%;
            transform: translateX(-50%);
            background-color: #252525;
            color: #ffffff;
            padding: 8px 12px;
            border-radius: 6px;
            font-size: 12px;
            box-shadow: 0px 4px 10px rgba(0, 0, 0, 0.2);
            white-space: nowrap;
            visibility: hidden;
            opacity: 0;
            transition: opacity 0.2s ease, visibility 0.2s ease;
            z-index: 10;
        }

        /* Segitiga kecil di tooltip */
        .tooltip-icon .tooltip-text::after {
            content: '';
            position: absolute;
            top: 100%;
            left: 50%;
            transform: translateX(-50%);
            border-width: 6px;
            border-style: solid;
            border-color: #252525 transparent transparent transparent;
        }

        /* Tampilkan tooltip saat hover */
        .tooltip-icon:hover .tooltip-text {
            visibility: visible;
            opacity: 1;
        }

        /* Teks "SELESAI" */
        .completed {
            color: #097ABA;
            font-weight: bold;
        }

        .product-img {
            width: 100px;
            /* Tentukan lebar gambar */
            height: 100px;
            /* Tentukan tinggi gambar */
            object-fit: cover;
            /* Memastikan gambar tetap proporsional */
            border-radius: 8px;
            /* Menambahkan sudut melengkung untuk estetika */
        }
    </style>
@endsection

@section('content')
    <link rel="stylesheet"
        href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@24,400,0,0&icon_names=local_shipping" />

    <!-- Search Bar -->
    <div class="container mt-2">
        <div class="row justify-content-center">
            <div class="col-md-8 col-12">
                <div class="input-group">
                    <input class="form-control" type="search" placeholder="Cari produk atau pesanan..." aria-label="Search"
                        id="searchInput" />
                    <button class="btn btn-primary" type="button">
                        <i class="fas fa-search"></i>
                    </button>
                </div>
            </div>
        </div>
    </div>

    <!-- Navbar dan Penjual Produk -->
    <div class="container mt-1">
        <div class="row">
            <!-- Navbar -->
            <div class="navbar-1 d-flex justify-content-between">
                    <div class="d-flex justify-content-center col-2">
                    <a href="{{ route('pesananseafood', ['reference' => 1]) }}"
                        class="nav-link {{ request()->routeIs('pesananseafood') && request('reference') == 1 ? 'active' : '' }}">
                        Semua
                    </a>
                    </div>
                    <div class="d-flex justify-content-center col-2">
                        <a href="{{ route('pesananseafood', ['reference' => 2]) }}"
                        class="nav-link {{ request()->routeIs('pesananseafood') && request('reference') == 2 ? 'active' : '' }}">
                        Belum Bayar
                    </a>
                    </div>
                    <div class="d-flex justify-content-center col-2">
                        <a href="{{ route('pesananseafood', ['reference' => 3]) }}"
                        class="nav-link {{ request()->routeIs('pesananseafood') && request('reference') == 3 ? 'active' : '' }}">
                        Sedang Dikemas
                    </a>
                    </div>
                    <div class="d-flex justify-content-center col-2">
                        <a href="{{ route('pesananseafood', ['reference' => 4]) }}"
                        class="nav-link {{ request()->routeIs('pesananseafood') && request('reference') == 4 ? 'active' : '' }}">
                        Sedang Dikirim
                    </a>
                    </div>
                    <div class="d-flex justify-content-center col-2">
                        <a href="{{ route('pesananseafood', ['reference' => 5]) }}"
                        class="nav-link {{ request()->routeIs('pesananseafood') && request('reference') == 5 ? 'active' : '' }}">
                        Selesai
                    </a>
                    </div>
                    {{-- <div class="d-flex justify-content-center col-2">
                        <a href="{{ route('pesananseafood', ['reference' => 6]) }}"
                        class="nav-link {{ request()->routeIs('pesananseafood') && request('reference') == 6 ? 'active' : '' }}">
                        Dibatalkan
                    </a>
                    </div> --}}
            </div>
            @foreach ($pesanan as $pe)
                <div class="container">
                    <div class="row">
                        <div class="col-12">
                            <!-- Kotak Utama untuk Penjual dan Produk -->
                            <div class="card p-3 shadow-sm">
                                <!-- Bagian Penjual dengan Tombol Hubungi -->
                                <div class="d-flex justify-content-between align-items-center mb-3">
                                    <span class="star">Penjual:
                                        {{ $pe->keranjangs->first()->seafood->nelayan->name }}</span>
                                    <a href="{{ route('hubungi.penjual.seafood', ['id' => $pe->keranjangs->first()->seafood->nelayan->id]) }}"
                                        class="btn btn-sm btn-primary text-white">
                                        <i class="bi bi-telephone"></i> Hubungi Penjual
                                    </a>
                                </div>
                                <span class="text-primary font-weight-bold">
                                    <strong>Nomor Invoice: </strong>{{$pe->item->first()->merchant_order_id}}
                                </span>
                                

                                <!-- Data Produk -->
                                <div class="d-flex flex-column">
                                    @foreach ($pe->keranjangs as $keranjang)
                                        <div class="d-flex mb-3 align-items-center">
                                            <!-- Gambar Produk -->
                                            <img src="{{ asset('storage/fotoseafood/' . $keranjang->seafood->foto) }}" alt="Produk" class="product-img">

                                            <!-- Deskripsi Produk -->
                                            <div class="order-details ms-3 w-75">
                                                <h4>Nama : {{ $keranjang->seafood->nama }}</h4>
                                                <span>Jumlah Pesanan : {{ $keranjang->jumlah }}</span>
                                            </div>
                                        </div>
                                    @endforeach

                                    <!-- Status Pesanan -->
                                    {{-- <span>Total : Rp {{ number_format($pe->item->first()->payment_amount, 0, ',', '.') }}</span> --}}
                                    <span>Status Pembayaran : {{$pe->status}}</span>
                                    <div class="status mt-3">
                                        @if($pe->status == 'sedang dikemas')
                                        <span class="material-symbols-outlined">local_shipping</span>
                                        <span>Pesanan Anda Sedang Dikemas oleh Penjual</span>
                                        <div class="tooltip-icon">
                                            <i class="fas fa-question-circle"></i>
                                            <div class="tooltip-text">Terakhir di-update pada <br>{{$pe->updated_at}}</div>
                                        </div>
                                        <span class="text-warning">Pending</span>
                                        {{-- <a href="#" class="btn btn-sm btn-danger">Batalkan Pesanan</a> --}}
                                        @elseif($pe->status == 'menunggu pembayaran')
                                        <a href="{{route('halamanpembayaranseafood', ['reference' => $pe->item->first()->merchant->reference, 'idpembayaran' => $pe->item->first()->id])}}" class="btn btn-sm btn-warning"> Bayar Sekarang</a>
                                        @elseif($pe->status == 'dikirim')
                                        <span class="material-symbols-outlined">local_shipping</span>
                                        <span>Pesanan Anda Sedang dalam perjalanan menuju ke alamat anda</span>
                                        <div class="tooltip-icon">
                                            <i class="fas fa-question-circle"></i>
                                            <div class="tooltip-text">Terakhir di-update pada <br>{{$pe->updated_at}}</div>
                                        </div>
                                        <span class="text-warning">Estimasi Pesanan Sampai : {{$pe->etd}}</span>
                                        <a href="#" class="btn btn-sm btn-success" data-bs-toggle="modal" data-bs-target="#productModal{{ $pe->id }}">Konfirmasi Pesanan Telah Sampai</a>
                                        @endif
                                        <a href="{{route('detail.pesanan.pembeli.seafood', ['id' => $pe->id])}}" class="btn btn-sm btn-primary"> Detail</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                
                
                <!-- Modal -->
    <div class="modal fade" id="productModal{{ $pe->id }}" tabindex="-1"
        aria-labelledby="productModalLabel{{ $pe->id }}" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <!-- Modal Header -->
                <div class="modal-header bg-primary text-white">
                    <h5 class="modal-title" id="productModalLabel{{ $pe->id }}">Konfirmasi Pesanan</h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"
                        aria-label="Close"></button>
                </div>

                <!-- Modal Body -->
                <form action="{{ route('upload.penerimaan.seafood', ['id' => $pe->id]) }}" method="post"
                    enctype="multipart/form-data">
                    @csrf
                    @method('POST')
                    <div class="modal-body">
                        <!-- Pesanan Info -->
                        <p>
                            Apakah Anda yakin pesanan dengan nomor invoice
                            <strong class="text-primary">{{ $pe->item->first()->merchant_order_id ?? '-' }}</strong>
                            telah diterima?
                        </p>

                        <!-- Upload Foto -->
                        <label for="photo" class="form-label">Upload Bukti oenerimaan pesanan:</label>
                        <div class="d-flex flex-column align-items-center">
                            <!-- Video Container -->
                            <div id="video-container{{ $pe->id }}" class="video-container border rounded mb-3">
                                <video id="video-webcam{{ $pe->id }}" autoplay class="rounded"
                                    style="width: 100%; max-width: 400px; object-fit: cover;">
                                    Browser tidak mendukung video. Mohon perbarui browser Anda.
                                </video>
                            </div>

                            <!-- Preview Container -->
                            <div id="preview-container{{ $pe->id }}" class="text-center mb-3 d-none">
                                <img id="preview-img{{ $pe->id }}" alt="Preview Foto"
                                    class="img-fluid border rounded" style="max-width: 400px;">
                                <button type="button" id="retake-photo-btn{{ $pe->id }}"
                                    class="btn btn-warning mt-3" onclick="retakePhoto({{ $pe->id }})">
                                    Ambil Foto Ulang
                                </button>
                            </div>

                            <!-- Foto Input Controls -->
                            <div class="text-center">
                                <button type="button" onclick="takeSnapshoot({{ $pe->id }})"
                                    class="btn btn-primary me-2">Ambil Foto</button>
                                <input type="file" id="file-input{{ $pe->id }}" accept="image/*"
                                    class="form-control d-none" onchange="previewImage(event, {{ $pe->id }})">
                                <button type="button" class="btn btn-secondary"
                                    onclick="triggerFileInput({{ $pe->id }})">Pilih dari Penyimpanan</button>
                            </div>

                            <!-- Hidden Photo Input -->
                            <input type="hidden" id="photo-input{{ $pe->id }}" name="photo" required>
                        </div>

                        <!-- Submit Button -->
                        <div class="text-center mt-4">
                            <button type="submit" class="btn btn-success w-100">Konfirmasi</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
            @endforeach
        </div>
    </div>

    <div class="alert alert-info mt-3">
        <h5 class="mb-2"><strong>Catatan Penting:</strong></h5>
        <p>
            Jika terdapat beberapa produk dengan nomor invoice yang sama, 
            maka saat pembayaran dilakukan untuk salah satu pesanan, maka
            pesanan lain dengan nomor invoice tersebut akan secara otomatis 
            dianggap telah dibayar.
        </p>
    </div>
    
    @include('components.foot')
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
