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
                                    <td>{{ $pembayaran->user->name }}</td>
                                </tr>
                                <tr>
                                    <td><strong>Total Pembayaran</strong></td>
                                    <td>{{ $pembayaran->payment_amount }}</td>
                                </tr>
                                <tr>
                                    <td><strong>Status Pembayaran</strong></td>
                                    <td>{{ $pembayaran->pembayaran->status_pembayaran }}</td>
                                </tr>
                            </tbody>
                        </table>

                        @if($pembayaran->pembayaran->status_pembayaran == 'PAID')
                        <div class="text-center">
                            <p><strong>Silakan klik tombol di bawah untuk Melihat Detail Pembayaran</strong></p>
                            <div class="d-grid gap-2">
                                <button type="button" class="btn btn-success btn-lg" id="DetailpayButton2">
                                    Detail Pembayaran
                                </button>
                            </div>
                        </div>
                        @else
                        <div class="text-center">
                            <p><strong>Silakan klik tombol di bawah untuk melanjutkan pembayaran.</strong></p>
                            <div class="d-grid gap-2">
                                <button type="button" class="btn btn-primary btn-lg" id="payButton">
                                    Mulai Pembayaran
                                </button>
                            </div>
                        </div>
                        @endif
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
                        <button class="btn btn-warning" id="retryButton" style="display:none;" onclick="retryPayment()">Coba
                            Lagi</button>
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
        document.addEventListener('DOMContentLoaded', function() {
            const reference = "{{ $reference }}";
            const payButton = document.getElementById('payButton');
            const retryButton = document.getElementById('retryButton');

            // tombol "Mulai Pembayaran"
            if (payButton) {
                payButton.addEventListener('click', function() {
                    startPayment();
                });
            }

            // tombol "Coba Lagi"
            if (retryButton) {
                retryButton.addEventListener('click', function() {
                    startPayment();
                });
            }

            // Fungsi untuk memulai pembayaran
            function startPayment() {
                document.getElementById('loadingSection').style.display = 'block';
                payButton.disabled = true; // Nonaktifkan tombol setelah diklik

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
                document.getElementById('loadingSection').style.display = 'none';
                const paymentResultSection = document.getElementById('paymentResultSection');
                const paymentMessage = document.getElementById('paymentMessage');

                paymentResultSection.style.display = 'block';

                if (status === 'success') {
                    paymentMessage.innerHTML = `
                    <p>Pesanan Anda telah berhasil diproses</p>
                `;
                    retryButton.style.display = 'none';

                    // Membuat form untuk mengirim data result dan reference
                    const form = document.createElement('form');
                    form.method = 'POST';
                    form.action =
                    '{{ route('update.payment.status') }}'; // Route tujuan untuk update status pembayaran

                    // Menambahkan input untuk CSRF token
                    const csrfToken = document.createElement('input');
                    csrfToken.type = 'hidden';
                    csrfToken.name = '_token';
                    csrfToken.value = '{{ csrf_token() }}'; // Menambahkan token CSRF Laravel

                    // Menambahkan input untuk data result dan reference
                    const inputResult = document.createElement('input');
                    inputResult.type = 'hidden';
                    inputResult.name = 'result';
                    inputResult.value = JSON.stringify(result); // Mengirimkan data result dalam format JSON

                    const inputReference = document.createElement('input');
                    inputReference.type = 'hidden';
                    inputReference.name = 'reference';
                    inputReference.value = reference;

                    // Menambahkan input ke form
                    form.appendChild(csrfToken);
                    form.appendChild(inputResult);
                    form.appendChild(inputReference);

                    // Menambahkan tombol submit
                    const submitButton = document.createElement('button');
                    submitButton.type = 'submit';
                    submitButton.classList.add('btn', 'btn-primary');
                    submitButton.textContent = 'Update Status Pembayaran';
                    form.appendChild(submitButton);

                    // Menambahkan form ke dalam div paymentResultSection
                    paymentResultSection.appendChild(form);

                    // Menyembunyikan tombol submit setelah form ditambahkan
                    submitButton.style.display = 'none';

                    // Otomatis klik tombol submit setelah form ditambahkan ke halaman
                    submitButton.click();
                } else if (status === 'pending') {
                    paymentMessage.innerHTML = `
                    <h4 class="alert-heading text-warning">Menunggu Pembayaran</h4>
                    <p>Silakan selesaikan transaksi anda</p>
                `;
                    retryButton.style.display = 'none'; // Sembunyikan tombol retry jika status pending
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

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const reference = "{{ $reference }}";
            const payButton = document.getElementById('DetailpayButton2');
            const retryButton = document.getElementById('retryButton');

            // tombol "Mulai Pembayaran"
            if (payButton) {
                payButton.addEventListener('click', function() {
                    startPayment();
                });
            }

            // tombol "Coba Lagi"
            if (retryButton) {
                retryButton.addEventListener('click', function() {
                    startPayment();
                });
            }

            // Fungsi untuk memulai pembayaran
            function startPayment() {
                document.getElementById('loadingSection').style.display = 'block';
                // payButton.disabled = true;

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
                document.getElementById('loadingSection').style.display = 'none';
                const paymentResultSection = document.getElementById('paymentResultSection');
                const paymentMessage = document.getElementById('paymentMessage');

                paymentResultSection.style.display = 'block';

                if (status === 'success') {
                    paymentMessage.innerHTML = `
                    <p>Pesanan Anda telah berhasil diproses</p>
                `;
                    retryButton.style.display = 'none';
                } else if (status === 'pending') {
                    paymentMessage.innerHTML = `
                    <h4 class="alert-heading text-warning">Menunggu Pembayaran</h4>
                    <p>Silakan selesaikan transaksi anda</p>
                `;
                    retryButton.style.display = 'none'; // Sembunyikan tombol retry jika status pending
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
