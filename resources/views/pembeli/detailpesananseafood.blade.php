@extends('layouts.app')

@section('title')
    <title>Detail Pesanan Seafood - Fishapp</title>
@endsection

@section('content')
    <div class="container mt-5">
        <h3 class="mb-4">Detail Pesanan Seafood</h3>

        <div class="card p-4 mb-4 shadow-lg" style="background-color: white; border-radius: 8px;">

            <!-- Nomor Invoice & Status Pembayaran -->
            <div class="d-flex justify-content-between">
                <h5><strong>Nomor Invoice:</strong> {{ $pesanan->item->first()->merchant_order_id }}</h5>
                <span class="text-primary font-weight-bold">
                    <strong>Status Pembayaran:</strong> {{ $pesanan->status }}
                </span>
            </div>

            <!-- Penjual dan Tombol Hubungi -->
            <div class="d-flex justify-content-between align-items-center mt-3">
                <span><strong>Penjual:</strong> {{ $pesanan->keranjangs->first()->seafood->nelayan->name }}</span>
                <a href="{{ route('hubungi.penjual.seafood', ['id' => $pesanan->keranjangs->first()->seafood->nelayan->id]) }}"
                    class="btn btn-sm btn-primary text-white">
                    <i class="bi bi-telephone"></i> Hubungi Penjual
                </a>
            </div>

            <!-- Detail Pengiriman -->
            <div class="mt-4">
                <h5>Info Pengiriman:</h5>
                <p><strong>Alamat Pengiriman:</strong> {{ $pesanan->alamat_pengiriman }}</p>
                <p><strong>Nama Penerima:</strong> {{ $pesanan->keranjangs->first()->user->name }}</p>
                <p><strong>Jasa Pengiriman:</strong> {{ $pesanan->opsi_pengiriman }}</p>
            </div>

            <!-- Rincian Produk -->
            <div class="mt-4">
                <h5>Rincian Produk:</h5>
                @foreach ($pesanan->keranjangs as $keranjang)
                    <div class="d-flex mb-4 align-items-center">
                        <img src="{{ asset('storage/fotoseafood/' . $keranjang->seafood->foto) }}" alt="Produk"
                            class="product-img" style="width: 120px; height: 120px; object-fit: cover; border-radius: 8px;">

                        <div class="ms-4 w-75">
                            <h6><strong>Nama Produk :</strong> {{ $keranjang->seafood->nama }}</h6>
                            <h6><strong>Jumlah Pesanan :</strong> {{ $keranjang->jumlah }} KG</h6>
                            <span><strong>Harga per Unit:</strong> Rp
                                {{ number_format($keranjang->seafood->harga->harga, 0, ',', '.') }}</span><br>
                            <span><strong>Sub Total Pesanan :</strong> Rp
                                {{ number_format($keranjang->jumlah * $keranjang->seafood->harga->harga, 0, ',', '.') }}</span>
                        </div>
                    </div>
                @endforeach
            </div>

            <!-- Total Harga Pesanan -->
            <div class="mt-4">
                <p><strong>Total Harga Pesanan:</strong> Rp {{ number_format($pesanan->subtotal_harga, 0, ',', '.') }}</p>
                <p><strong>Ongkir:</strong> Rp {{ number_format($pesanan->ongkir, 0, ',', '.') }}</p>
                <p><strong>Total Pembayaran:</strong> Rp
                    {{ number_format($pesanan->total_keseluruhan_harga, 0, ',', '.') }}</p>
            </div>

            <!-- Status Pesanan -->
            <div class="mt-4">
                <h5>Status Pesanan:</h5>
                @if ($pesanan->status == 'sedang dikemas')
                    <p>Pesanan Anda Sedang Dikemas oleh Penjual.</p>
                    <span class="text-warning">Pending</span>
                    {{-- <a href="#" class="btn btn-sm btn-danger">Batalkan Pesanan</a> --}}
                @elseif($pesanan->status == 'menunggu pembayaran')
                    <p><span class="material-symbols-outlined">payment</span> Anda belum melakukan pembayaran.</p>
                    <a href="{{ route('halamanpembayaranseafood', ['reference' => $pesanan->item->first()->merchant->reference, 'idpembayaran' => $pesanan->item->first()->id]) }}"
                        class="btn btn-sm btn-warning">Bayar Sekarang</a>
                @elseif($pesanan->status == 'dikirim')
                    <p>Pesanan Anda Sedang dalam perjalanan menuju ke alamat Anda.</p>
                    <span class="text-warning">Estimasi Pesanan Sampai : {{ $pesanan->etd }}</span>
                    <a href="#" data-bs-toggle="modal" data-bs-target="#productModal{{ $pesanan->id }}"
                        class="btn btn-sm btn-success">Konfirmasi Pesanan Telah Sampai</a>
                @elseif($pesanan->status == 'selesai')
                    <p>Terimakasih telah melakukan pemesanan di Fishapp, pesanan telah diterima</p>
                @endif
            </div>

            <!-- Detail Pembayaran -->
            <div class="mt-4">
                <h5>Detail Pembayaran:</h5>
                <p><strong>Metode Pembayaran:</strong> {{ $pesanan->metode_pembayaran }}</p>
                <p><strong>Status Pembayaran:</strong> {{ $pesanan->item->first()->pembayaran->status_pembayaran }}</p>
            </div>
        </div>
    </div>


    <!-- Modal -->
    <div class="modal fade" id="productModal{{ $pesanan->id }}" tabindex="-1"
        aria-labelledby="productModalLabel{{ $pesanan->id }}" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <!-- Modal Header -->
                <div class="modal-header bg-primary text-white">
                    <h5 class="modal-title" id="productModalLabel{{ $pesanan->id }}">Konfirmasi Pesanan</h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"
                        aria-label="Close"></button>
                </div>

                <!-- Modal Body -->
                <form action="{{ route('upload.penerimaan.seafood', ['id' => $pesanan->id]) }}" method="post"
                    enctype="multipart/form-data">
                    @csrf
                    @method('POST')
                    <div class="modal-body">
                        <!-- Pesanan Info -->
                        <p>
                            Apakah Anda yakin pesanan dengan nomor invoice
                            <strong class="text-primary">{{ $pesanan->item->first()->merchant_order_id ?? '-' }}</strong>
                            telah diterima?
                        </p>

                        <!-- Upload Foto -->
                        <label for="photo" class="form-label">Upload Bukti oenerimaan pesanan:</label>
                        <div class="d-flex flex-column align-items-center">
                            <!-- Hidden Photo Input -->
                            <input type="file" id="photo-input{{ $pesanan->id }}" name="photo" required>
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
@endsection
