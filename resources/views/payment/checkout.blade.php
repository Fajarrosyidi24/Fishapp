@extends('layouts.app')

@section('title')
    <title>Halaman Pembayaran</title>
@endsection

@section('content')
<div class="container py-5">
    <!-- Heading Section -->
    <div class="row mb-4 text-center">
        <div class="col">
            <h2 class="display-4">Pembayaran Pesanan Anda</h2>
            <p class="lead">Silakan selesaikan pembayaran untuk melanjutkan pemesanan.</p>
        </div>
    </div>

    <!-- Payment Information Table -->
    <div class="row justify-content-center mb-5">
        <div class="col-md-8">
            <div class="card shadow-lg">
                <div class="card-header bg-primary text-white text-center">
                    <h5 class="mb-0">Rincian Pembayaran</h5>
                </div>
                <div class="card-body">
                    <table class="table table-bordered">
                        <thead>
                            <tr>
                                <th>Detail</th>
                                <th>Informasi</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td><strong>Nama Pemesan</strong></td>
                                <td>edhcuied</td>
                            </tr>
                            <tr>
                                <td><strong>Total Pembayaran</strong></td>
                                <td>ceucheic</td>
                            </tr>
                            <tr>
                                <td><strong>Metode Pembayaran</strong></td>
                                <td>Transfer Bank / Kredit</td>
                            </tr>
                        </tbody>
                    </table>
                    
                    <div class="text-center">
                        <p><strong>Silakan klik tombol di bawah untuk melanjutkan pembayaran.</strong></p>
                        <div class="d-grid gap-2">
                            <button type="button" class="btn btn-primary btn-lg" id="payButton">
                                Mulai Pembayaran
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Loading Spinner Section (Hidden Initially) -->
<div class="container mt-5" id="loadingSection" style="display:none;">
    <div class="card shadow-lg border-0 mx-auto" style="max-width: 600px;">
        <div class="card-body text-center">
            <div class="spinner-border text-primary" role="status">
                <span class="visually-hidden">Loading...</span>
            </div>
            <p class="mt-3">Sedang memproses pembayaran...</p>
        </div>
    </div>
</div>

<!-- Payment Result Section -->
<div class="container mt-5" id="paymentResultSection" style="display:none;">
    <div class="card shadow-lg border-0 mx-auto" style="max-width: 600px;">
        <div class="card-body text-center">
            <div id="paymentMessage" class="alert alert-info">
                <h4 class="alert-heading">Status Pembayaran</h4>
                <p>Menunggu status pembayaran Anda...</p>
            </div>
            <div class="d-grid gap-2 mt-3">
                <button class="btn btn-warning" id="retryButton" style="display:none;" onclick="retryPayment()">Coba Lagi</button>
            </div>
        </div>
    </div>
</div>
</div>
@include('components.foot')
@endsection

@section('foot')
<script src="https://app-sandbox.duitku.com/lib/js/duitku.js"></script>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        const reference = "{{ $reference }}";
        const payButton = document.getElementById('payButton');
        const retryButton = document.getElementById('retryButton');

        // Event listener untuk tombol "Mulai Pembayaran"
        if (payButton) {
            payButton.addEventListener('click', function() {
                startPayment();
            });
        }

        // Event listener untuk tombol "Coba Lagi"
        if (retryButton) {
            retryButton.addEventListener('click', function() {
                startPayment();
            });
        }

        // Fungsi untuk memulai pembayaran
        function startPayment() {
            document.getElementById('loadingSection').style.display = 'block';
            payButton.disabled = true;  // Nonaktifkan tombol setelah diklik

            // Proses pembayaran
            checkout.process(reference, {
                defaultLanguage: "id",  // Bahasa default
                successEvent: function (result) {
                    showPaymentResult('success', result);
                },
                pendingEvent: function (result) {
                    showPaymentResult('pending', result);
                },
                errorEvent: function (result) {
                    showPaymentResult('error', result);
                },
                closeEvent: function (result) {
                    showPaymentResult('closed', result);
                }
            });
        }

        // Tampilkan hasil pembayaran di halaman
        function showPaymentResult(status, result) {
            document.getElementById('loadingSection').style.display = 'none';
            const paymentResultSection = document.getElementById('paymentResultSection');
            const paymentMessage = document.getElementById('paymentMessage');

            paymentResultSection.style.display = 'block';

            if (status === 'success') {
                paymentMessage.innerHTML = `
                    <h4 class="alert-heading text-success">Pembayaran Berhasil!</h4>
                    <p>Pesanan Anda telah berhasil diproses. Terima kasih atas pembayaran Anda.</p>
                `;
                retryButton.style.display = 'none';  // Sembunyikan tombol retry setelah berhasil
            } else if (status === 'pending') {
                paymentMessage.innerHTML = `
                    <h4 class="alert-heading text-warning">Pembayaran Sedang Diproses</h4>
                    <p>Silakan tunggu sementara kami memproses pembayaran Anda.</p>
                `;
                retryButton.style.display = 'none';  // Sembunyikan tombol retry jika status pending
            } else if (status === 'error') {
                paymentMessage.innerHTML = `
                    <h4 class="alert-heading text-danger">Terjadi Kesalahan Dalam Pembayaran</h4>
                    <p>Maaf, terjadi masalah saat memproses pembayaran Anda. Silakan coba lagi.</p>
                `;
                retryButton.style.display = 'inline-block'; // Menampilkan tombol retry
            } else if (status === 'closed') {
                paymentMessage.innerHTML = `
                    <h4 class="alert-heading text-info">Popup Ditutup</h4>
                    <p>Anda menutup popup tanpa menyelesaikan pembayaran. Silakan lanjutkan pembayaran untuk menyelesaikan transaksi.</p>
                `;
                retryButton.style.display = 'inline-block'; // Menampilkan tombol retry
            }
        }
    });
</script>
@endsection