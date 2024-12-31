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
                                    <strong>Nomor Invoice: </strong>{{ $pe->item->first()->merchant_order_id }}
                                </span>


                                <!-- Data Produk -->
                                <div class="d-flex flex-column">
                                    @foreach ($pe->keranjangs as $keranjang)
                                        <div class="d-flex mb-3 align-items-center">
                                            <!-- Gambar Produk -->
                                            <img src="{{ asset('storage/fotoseafood/' . $keranjang->seafood->foto) }}"
                                                alt="Produk" class="product-img">

                                            <!-- Deskripsi Produk -->
                                            <div class="order-details ms-3 w-75">
                                                <h4>Nama : {{ $keranjang->seafood->nama }}</h4>
                                                <span>Jumlah Pesanan : {{ $keranjang->jumlah }}</span>
                                            </div>
                                        </div>
                                    @endforeach

                                    <!-- Status Pesanan -->
                                    {{-- <span>Total : Rp {{ number_format($pe->item->first()->payment_amount, 0, ',', '.') }}</span> --}}
                                    <span>Status Pembayaran : {{ $pe->status }}</span>
                                    <div class="status mt-3">
                                        @if ($pe->status == 'sedang dikemas')
                                            <span class="material-symbols-outlined">local_shipping</span>
                                            <span>Pesanan Anda Sedang Dikemas oleh Penjual</span>
                                            <div class="tooltip-icon">
                                                <i class="fas fa-question-circle"></i>
                                                <div class="tooltip-text">Terakhir di-update pada <br>{{ $pe->updated_at }}
                                                </div>
                                            </div>
                                            <span class="text-warning">Pending</span>
                                            {{-- <a href="#" class="btn btn-sm btn-danger">Batalkan Pesanan</a> --}}
                                        @elseif($pe->status == 'menunggu pembayaran')
                                            <a href="{{ route('halamanpembayaranseafood', ['reference' => $pe->item->first()->merchant->reference, 'idpembayaran' => $pe->item->first()->id]) }}"
                                                class="btn btn-sm btn-warning"> Bayar Sekarang</a>
                                        @elseif($pe->status == 'dikirim')
                                            <span class="material-symbols-outlined">local_shipping</span>
                                            <span>Pesanan Anda Sedang dalam perjalanan menuju ke alamat anda</span>
                                            <div class="tooltip-icon">
                                                <i class="fas fa-question-circle"></i>
                                                <div class="tooltip-text">Terakhir di-update pada <br>{{ $pe->updated_at }}
                                                </div>
                                            </div>
                                            <span class="text-warning">Estimasi Pesanan Sampai : {{ $pe->etd }}</span>
                                            <a href="#" class="btn btn-sm btn-success" data-bs-toggle="modal"
                                                data-bs-target="#productModal{{ $pe->id }}">Konfirmasi Pesanan Telah
                                                Sampai</a>
                                        @elseif($pe->status == 'selesai')
                                        @php
                                        // Pastikan keranjang ada
                                        $firstKeranjang = $pe->keranjangs->first();
                                        $existingRating = null;
                                        
                                        if ($firstKeranjang && $firstKeranjang->seafood && $firstKeranjang->seafood->rating) {
                                            // Ambil rating jika ada
                                            $existingRating = $firstKeranjang->seafood->rating->first();
                                        }
                                        @endphp

                                            @if (!$existingRating)
                                                <!-- Tampilkan tombol untuk memasukkan rating jika belum ada rating -->
                                                <button class="btn btn-sm btn-warning"
                                                    onclick="openRatingModal({{ $pe->id }})">
                                                    <i class="bi bi-star"></i> Masukan Rating
                                                </button>
                                            @else
                                                <!-- Tampilkan rating jika sudah ada -->
                                                <p class="card-text fw-bold mb-1">Rating Penjualan:</p>
                                                <div class="mb-2">
                                                    @for ($i = 1; $i <= 5; $i++)
                                                        <i
                                                            class="bi bi-star{{ $i <= $existingRating->rating ? '-fill text-warning' : ' text-muted' }}"></i>
                                                    @endfor
                                                </div>
                                                <!-- Menampilkan ulasan jika ada -->
                                                @if ($existingRating->review)
                                                    <p class="card-text text-muted mt-2">Ulasan:
                                                        {{ $existingRating->review }}</p>
                                                @else
                                                @endif
                                            @endif
                                        @endif

                                        <a href="{{ route('detail.pesanan.pembeli.seafood', ['id' => $pe->id]) }}"
                                            class="btn btn-sm btn-primary"> Detail</a>
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
                                        <strong
                                            class="text-primary">{{ $pe->item->first()->merchant_order_id ?? '-' }}</strong>
                                        telah diterima?
                                    </p>

                                    <!-- Upload Foto -->
                                    <label for="photo" class="form-label">Upload Bukti oenerimaan pesanan:</label>
                                    <div class="d-flex flex-column align-items-center">
                                        <input type="file" id="photo-input{{ $pe->id }}" name="photo" required>
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


                <div class="modal fade" id="ratingModal" tabindex="-1" aria-labelledby="ratingModalLabel"
                    aria-hidden="true">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="ratingModalLabel">Input Rating</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal"
                                    aria-label="Close"></button>
                            </div>
                            <div class="modal-body">
                                <form id="ratingForm" action="{{ route('rating.store', ['seafood' => $pe->id]) }}"
                                    method="POST">
                                    @csrf
                                    <input type="hidden" name="pesanan_id" id="pesananId">
                                    <div class="mb-3">
                                        <label for="rating" class="form-label">Rating</label>
                                        <select class="form-select" name="rating" id="rating" required>
                                            <option value="" disabled selected>Pilih Rating</option>
                                            <option value="1">1 - Sangat Buruk
                                                <span class="text-warning">&#9733;</span>
                                            </option>
                                            <option value="2">2 - Buruk
                                                <span class="text-warning">&#9733;&#9733;</span>
                                            </option>
                                            <option value="3">3 - Cukup
                                                <span class="text-warning">&#9733;&#9733;&#9733;</span>
                                            </option>
                                            <option value="4">4 - Baik
                                                <span class="text-warning">&#9733;&#9733;&#9733;&#9733;</span>
                                            </option>
                                            <option value="5">5 - Sangat Baik
                                                <span class="text-warning">&#9733;&#9733;&#9733;&#9733;&#9733;</span>
                                            </option>
                                        </select>


                                    </div>
                                    <div class="mb-3">
                                        <label for="ulasan" class="form-label">Ulasan</label>
                                        <textarea class="form-control" name="ulasan" id="ulasan" rows="3"
                                            placeholder="Tulis ulasan Anda (opsional)"></textarea>
                                    </div>
                                    <button type="submit" class="btn btn-primary">Kirim</button>
                                </form>
                            </div>
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
        function openRatingModal(pesananId) {
            // Set pesanan ID di input form
            document.getElementById('pesananId').value = pesananId;
            // Tampilkan modal
            new bootstrap.Modal(document.getElementById('ratingModal')).show();
        }
    </script>
@endsection
