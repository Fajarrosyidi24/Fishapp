@extends('layouts.app')

@section('title')
<title>Pusat Bantuan</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #121212;
            color: #ffffff;
            margin: 0;
            padding: 0;
        }
        .faq-container {
            max-width: 800px;
            margin: 20px auto;
            padding: 20px;
            background-color:rgba(255, 255, 255, 0);
            border-radius: 8px;
        }
        h1 {
            font-size: 26px;
            margin-bottom: 20px;
            border-bottom: 2px solid #ffffff;
            padding-bottom: 10px;
        }
        .faq-item {
            margin-bottom: 15px;
            padding: 10px 0;
            border-bottom: 1px dashed #555;
            cursor: pointer;
        }
        .faq-item:last-child {
            border-bottom: none;
        }
        .faq-category {
            color: #097ABA;
            font-weight: bold;
        }
        .faq-question {
            margin: 5px 0;
            color:#000
        }
        .faq-answer {
            margin-top: 10px;
            display: none;
            color:rgb(0, 0, 0);
        }
        .faq-item.active .faq-answer {
            display: block;
        }

        /* Tabel Jawaban */
        p {
            margin-bottom: 20px;
            font-size: 16px;
        }
        th, td {
            border: 1px solid #555;
            padding: 10px;
            text-align: left;
            color:#000
        }
        a {
            color: #097ABA;
            text-decoration: none;
        }
        a:hover {
            text-decoration: underline;
        }

        /* Garis Tabel */
        #datatablesSimple {
            width: 100%;
            border-collapse: collapse; /* Menggabungkan garis ganda menjadi satu */
        }
        #datatablesSimple th, #datatablesSimple td {
            border: 1px solid black; /* Warna garis hitam */
            padding: 10px;
            text-align: left;
        }
    </style>
@endsection

@section('content')
<div class="faq-container">
        <h1 class="faq-item">FAQ</h1>
        <div class="faq-item">
            <div class="faq-category">[Baru di Shopee]</div>
            <div class="faq-question">Mengapa saya tidak bisa mendaftar akun Shopee dengan no. handphone saya?</div>
            <div class="faq-container faq-answer">
                <h1 class="faq-item">[Akun Saya] Mengapa saya tidak bisa login ke akun Shopee saya?</h1>
                <p>Upaya log in yang gagal ke akun Shopee Anda dapat terjadi karena alasan berikut:</p>
                <table id="datatablesSimple" class="table table-striped table-bordered">
                    <thead>
                        <tr style="background-color:#097ABA; color:#000">
                            <th>No.</th>
                            <th>Alasan</th>
                            <th>Solusi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>1</td>
                            <td><i>Password salah</i></td>
                            <td>Periksa kembali apakah Anda telah memasukkan <i>password</i> dengan benar. Jika Anda lupa <i>password</i>, temukan solusi mengenai <a href="#">reset password akun Shopee</a>.</td>
                        </tr>
                        <tr>
                            <td>2</td>
                            <td>Salah no. telepon</td>
                            <td>
                                Periksa kembali apakah Anda sudah memasukkan no. telepon yang terdaftar. Pastikan Anda sudah memasukkan no. telepon yang terdaftar pada akun Shopee.
                            </td>
                        </tr>
                        <tr>
                            <td>3</td>
                            <td>Gagal Verifikasi Wajah</td>
                            <td>
                                <ul>
                                    <li>Verifikasi Wajah dapat dilakukan jika Anda sudah melakukan <a href="#">verifikasi ShopeePay</a>. Sistem Shopee akan melakukan pengecekan apakah wajah Anda sudah sesuai dengan data saat verifikasi ShopeePay.</li>
                                    <li>Ketika melakukan verifikasi, pastikan kondisi lingkungan Anda kondusif (contoh: cahaya terang dan koneksi internet stabil). Pelajari lebih lanjut mengenai <a href="#">cara melakukan verifikasi wajah saat log in</a>.</li>
                                </ul>
                            </td>
                        </tr>
                        <tr>
                            <td>4</td>
                            <td>Kode verifikasi sudah kedaluwarsa</td>
                            <td>
                                <ul>
                                    <li>Pastikan Anda memasukkan kode verifikasi yang sudah dikirimkan melalui WhatsApp atau SMS dalam batas waktu yang sudah ditentukan.</li>
                                    <li>Jika Anda memasukkan kode verifikasi di luar waktu yang sudah ditentukan, silakan minta kembali kode verifikasi baru.</li>
                                </ul>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>

        <div class="faq-item">
            <div class="faq-category">[Akun Saya]</div>
            <div class="faq-question">Mengapa saya tidak bisa login ke akun Shopee saya?</div>
            <div class="faq-answer">Pastikan email atau nomor handphone dan kata sandi yang Anda masukkan sudah benar.</div>
        </div>

        <div class="faq-item">
            <div class="faq-category">[Baru di Shopee]</div>
            <div class="faq-question">Mengapa saya tidak bisa membuat pesanan saat checkout?</div>
            <div class="faq-answer">Cek apakah alamat pengiriman dan metode pembayaran Anda sudah lengkap dan valid.</div>
        </div>

        <div class="faq-item">
            <div class="faq-category">[Bayar di Tempat]</div>
            <div class="faq-question">Mengapa saya tidak bisa membayar menggunakan metode pembayaran COD (Bayar di Tempat)?</div>
            <div class="faq-answer">Metode COD mungkin tidak tersedia untuk wilayah Anda atau produk tertentu.</div>
        </div>

        <script>
        // Tambahkan fungsi klik untuk setiap FAQ item
        document.querySelectorAll('.faq-item').forEach(item => {
            item.addEventListener('click', () => {
                item.classList.toggle('active');
            });
        });
        </script>
    </div>
    @include('components.foot')
@endsection