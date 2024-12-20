@extends('layouts.app_nelayan')

@section('title')
    <title>Detail Pembayaran</title>
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
@endsection

@section('content')
    <ol class="breadcrumb mt-4">
        <li class="breadcrumb-item active">Detail Pembayaran</li>
        <p>Data pesanan berikut adalah daftar pesanan yang dibeli oleh pembeli, dimana pembeli biasanya melakukan 1x
            pembayaran untuk banyak pesanan, silahkan sesuaikan dengan preferensi data pesanan yang sesuai dengan milik anda
        </p>
    </ol>

    <div class="card mb-4">
        <div class="card-header">
            <i class="fas fa-table me-1"></i>
            Data Pesanan Pembeli
        </div>
        <div class="card-body">
            <table id="datatablesSimple" class="table table-striped table-hover table-bordered">
                <thead>
                    <tr>
                        <th>Nama Pembeli</th>
                        <th>Nama Penjual</th>
                        <th>Sub Total Pesanan</th>
                        <th>Ongkir</th>
                        <th class="text-center">Gambar Pesanan</th>
                    </tr>
                </thead>
                <tfoot>
                    <tr>
                        <th>Nama Pembeli</th>
                        <th>Nama Penjual</th>
                        <th>Sub Total Pesanan</th>
                        <th>Ongkir</th>
                        <th class="text-center">Gambar Pesanan</th>
                    </tr>
                </tfoot>
                <tbody>
                    @foreach ($pesanan as $pe)
                        @php
                            // Mengecek apakah nama penjual sama dengan nama yang sedang login
                            $isLoggedInSeller =
                                $pe->keranjangs->first()->seafood->nelayan->name == Auth::guard('nelayan')->user()->name;
                        @endphp

                        <tr>
                            <td>
                                @if ($pe->keranjangs->isNotEmpty() && $pe->keranjangs->first()->user)
                                    {{ $pe->keranjangs->first()->user->name }}
                                @else
                                    Unknown User
                                @endif
                            </td>

                            <td class="{{ $isLoggedInSeller ? 'bg-info text-white' : '' }}">
                                {{ $pe->keranjangs->first()->seafood->nelayan->name }}
                                @if ($pe->keranjangs->first()->seafood->nelayan->name == Auth::guard('nelayan')->user()->name)
                                    (ini adalah data pesanan milik anda)
                                @endif
                            </td>

                            <td>
                               Rp. {{ number_format($pe->subtotal_harga, 0, ',', '.') }}
                            </td>
                            <td>
                                Rp. {{ number_format($pe->ongkir, 0, ',', '.') }}
                            </td>

                            <!-- Gambar Barang -->
                            <td class="text-center">
                                @if ($pe->keranjangs->isNotEmpty())
                                    @foreach ($pe->keranjangs as $keranjang)
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
                        </tr>
                    @endforeach
                    <tr>
                        <td>--</td>
                        <td><strong>Sub Total</strong></td>
                        <td>Rp. {{ number_format($pesanan->sum('subtotal_harga'), 0, ',', '.') }}</td>
                        <td>Rp. {{ number_format($pesanan->sum('ongkir'), 0, ',', '.') }}</td>
                        <td>--</td>
                    </tr>
                </tbody>
            </table>

            <div class="mt-4">
                <p><strong>Jumlah Pesanan Pembeli:</strong> {{ $pesanan->count() }}</p>
                <p><strong>Subtotal Pesanan:</strong> Rp. {{ number_format($pesanan->sum('subtotal_harga'), 0, ',', '.') }}
                </p>
                <p><strong>Subtotal Ongkir:</strong> Rp. {{ number_format($pesanan->sum('ongkir'), 0, ',', '.') }}</p>
                <p><strong>Biaya Admin:</strong> Rp. 5,000</p>

                <!-- Total Pembayaran -->
                <p><strong>TOTAL:</strong>
                    Rp.
                    {{ number_format($pesanan->first()->item->first()->payment_amount, 0, ',', '.') }}
                </p>

                <!-- Tombol Lihat Bukti Pembayaran -->
                <button type="button" class="btn btn-primary btn-sm" id="payButton">
                    <i class="fas fa-file-eye"></i> Lihat Bukti Pembayaran
                </button>
            </div>
        </div>
    </div>
@endsection

@section('foot')
    <script src="https://app-sandbox.duitku.com/lib/js/duitku.js"></script>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const reference = "{{ $reference }}";
            const payButton = document.getElementById('payButton');
            const retryButton = document.getElementById('retryButton');
            const loadingSection = document.getElementById('loadingSection');
            const paymentResultSection = document.getElementById('paymentResultSection');
            const paymentMessage = document.getElementById('paymentMessage');

            // Tombol "Mulai Pembayaran"
            if (payButton) {
                payButton.addEventListener('click', function() {
                    startPayment();
                });
            }

            // Tombol "Coba Lagi"
            if (retryButton) {
                retryButton.addEventListener('click', function() {
                    startPayment();
                });
            }

            // Fungsi untuk memulai pembayaran
            function startPayment() {
                if (loadingSection) {
                    loadingSection.style.display = 'block';
                }

                // Proses pembayaran
                checkout.process(reference, {
                    defaultLanguage: "id", // Bahasa default
                    successEvent: function(result) {
                        showPaymentResult('success', result);
                    },
                    pendingEvent: function(result) {
                        showPaymentResult('pending', result);
                    },
                    errorEvent: function(result) {
                        showPaymentResult('error', result);
                    },
                    closeEvent: function(result) {
                        showPaymentResult('closed', result);
                    }
                });
            }

            // Tampilkan hasil pembayaran di halaman
            function showPaymentResult(status, result) {
                if (loadingSection) {
                    loadingSection.style.display = 'none';
                }
                if (paymentResultSection) {
                    paymentResultSection.style.display = 'block';
                }

                if (status === 'success') {
                    if (paymentMessage) {
                        paymentMessage.innerHTML = `
                            <h4 class="alert-heading text-success">Pembayaran Berhasil!</h4>
                            <p>Pesanan Anda telah berhasil diproses. Terima kasih atas pembayaran Anda.</p>
                        `;
                    }
                    if (retryButton) {
                        retryButton.style.display = 'none';
                    }
                } else if (status === 'pending') {
                    if (paymentMessage) {
                        paymentMessage.innerHTML = `
                            <h4 class="alert-heading text-warning">Menunggu Pembayaran</h4>
                            <p>Silakan selesaikan transaksi anda</p>
                        `;
                    }
                    if (retryButton) {
                        retryButton.style.display = 'none'; // Sembunyikan tombol retry jika status pending
                    }
                } else if (status === 'error') {
                    if (paymentMessage) {
                        paymentMessage.innerHTML = `
                            <h4 class="alert-heading text-danger">Terjadi Kesalahan Dalam Pembayaran</h4>
                            <p>Maaf, terjadi masalah saat memproses pembayaran Anda. Silakan coba lagi.</p>
                        `;
                    }
                    if (retryButton) {
                        retryButton.style.display = 'inline-block'; // Menampilkan tombol retry
                    }
                } else if (status === 'closed') {
                    if (paymentMessage) {
                        paymentMessage.innerHTML = `
                            <h4 class="alert-heading text-info">Popup Ditutup</h4>
                            <p>Anda menutup popup tanpa menyelesaikan pembayaran. Silakan lanjutkan pembayaran untuk menyelesaikan transaksi.</p>
                        `;
                    }
                    if (retryButton) {
                        retryButton.style.display = 'inline-block'; // Menampilkan tombol retry
                    }
                }
            }
        });
    </script>
@endsection
