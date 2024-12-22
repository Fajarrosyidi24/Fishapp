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

        /* feedback button */
        .feedback-buttons {
            margin-top: 20px;
        }
        .button {
            background-color: #ffffff; /* Warna latar belakang tombol */
            color: black;
            border: 1px solid #555; /* Warna border */
            padding: 10px 20px;
            margin: 5px;
            font-size: 14px;
            cursor: pointer;
            display: inline-flex;
            align-items: center;
            border-radius: 4px;
        }
        .button span {
            margin-right: 5px; /* Jarak ikon ke teks */
        }
        .button:hover {
            background-color: #097ABA; /* Warna tombol saat hover */
        }
        .green {
            color: green;
        }
        .red {
            color: red !important;
        }
        .active {
            color: green;
            font-weight: bold;
        }
    </style>
@endsection

@section('content')
<link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@24,400,0,0&icon_names=warning" />
<link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined" rel="stylesheet">
<link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">

<div class="faq-container">
        <h1 class="faq-item">FAQ</h1>
        <div class="faq-item">
            <div class="faq-category">[Akun Saya]</div>
            <div class="faq-question">Mengapa saya tidak bisa mendaftar?</div>
            <div class="faq-container faq-answer">
                <h3 class="faq-item">[Akun Saya] Mengapa saya tidak bisa mendaftar?</h3>
                <p>Upaya register yang gagal dapat terjadi karena alasan berikut:</p>
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
                            <td>Email Sudah Terdafrar</td>
                            <td>Periksa kembali email yang anda masukkan. Pastikan bahwa email yang anda masukkan belum terdaftar ke sistem</td>
                        </tr>
                        <tr>
                            <td>2</td>
                            <td>Salah Konfirmasi Password</td>
                            <td>
                                Periksa kembali apakah Anda sudah memasukkan password dengan benar pada kolom konfirmasi password.</td>
                        </tr>
                    </tbody>
                </table>

                <!-- Feedback User -->
                <div class="feedback-section">
                    <h2>Apakah artikel ini berguna?</h2>
                    <div class="feedback-buttons">
                        <button class="button" onclick="handleFeedback('helpfull', this)">
                            <span class="material-icons">thumb_up</span> Ya
                        </button>
                        <button class="button" onclick="handleFeedback('unhelpfull', this)">
                            <span class="material-icons">thumb_down</span> Tidak
                        </button>
                    </div>
                </div>
            </div>
        </div>

        <div class="faq-item">
            <div class="faq-category">[Akun Saya]</div>
            <div class="faq-question">Mengapa saya tidak bisa login?</div>
            <div class="faq-container faq-answer">
                <h3 class="faq-item">[Akun Saya] Mengapa saya tidak bisa login?</h3>
                <p>Upaya login yang gagal dapat terjadi karena alasan sebagai berikut:</p>
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
                            <td>Salah Memasukkan Email</td>
                            <td>Pastikan email yang anda masukkan sudah terdaftar. Pastikan anda memasukkan email yang sesuai dengan akun yang sudah terdaftar pada akun FishApp</td>
                        </tr>
                        <tr>
                            <td>2</td>
                            <td>Salah Memasukkan Password</td>
                            <td>Pastikan password yang anda masukkan sudah terdaftar. Pastikan anda memasukkan password yang sesuai dengan akun yang sudah terdaftar pada akun FishApp.</td>
                        </tr>
                    </tbody>
                </table>

                <!-- Feedback User -->
                <div class="feedback-section">
                    <h2>Apakah artikel ini berguna?</h2>
                    <div class="feedback-buttons">
                        <button class="button" onclick="handleFeedback('helpfull', this)">
                            <span class="material-icons">thumb_up</span> Ya
                        </button>
                        <button class="button" onclick="handleFeedback('unhelpfull', this)">
                            <span class="material-icons">thumb_down</span> Tidak
                        </button>
                    </div>
                </div>
            </div>
        </div>

        <div class="faq-item">
            <div class="faq-category">[Bayar di Tempat]</div>
            <div class="faq-question">Mengapa saya tidak bisa membayar menggunakan metode COD(Cash On Delivery)?</div>
            <div class="faq-container faq-answer">
            <h3 class="faq-item">[Bayar di Tempat] Mengapa saya tidak bisa membayar menggunakan metode COD(Cash On Delivery)?</h3>
                <p>Anda tidak dapat membayar menggunakan metode COD karena alasan berikut:</p>
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
                            <td>Penjual Tidak Menyediakan Metode Pembayaran COD</td>
                            <td>Silahkan menggunakan metode pembayaran lain yang sudah disediakan oleh penjual</td>
                        </tr>
                    </tbody>
                </table>

                <!-- Feedback User -->
                <div class="feedback-section">
                    <h2>Apakah artikel ini berguna?</h2>
                    <div class="feedback-buttons">
                        <button class="button" onclick="handleFeedback('helpfull', this)">
                            <span class="material-icons">thumb_up</span> Ya
                        </button>
                        <button class="button" onclick="handleFeedback('unhelpfull', this)">
                            <span class="material-icons">thumb_down</span> Tidak
                        </button>
                    </div>
                </div>
            </div>
        </div>

        <script>
                document.querySelectorAll('.faq-item').forEach(item => {
            item.addEventListener('click', () => {
                // Hapus kelas 'active' dari semua item kecuali item yang diklik
                document.querySelectorAll('.faq-item').forEach(otherItem => {
                    if (otherItem !== item) {
                        otherItem.classList.remove('active');
                    }
                });

                // Toggle kelas 'active' hanya untuk item yang diklik
                if (!item.classList.contains('active')) {
                    item.classList.add('active');
                }
            });
        });


    function handleFeedback(type, button) {
    // Hanya mengatur kelas aktif pada tombol yang diklik
    const parent = button.parentNode;
    const buttons = parent.querySelectorAll('.button');

    // Reset tombol di grup yang sama
    buttons.forEach(btn => btn.classList.remove('active', 'green', 'red'));

    // Tambahkan kelas 'active' ke tombol yang diklik
    button.classList.add('active');

    if (type === 'helpfull') {
        button.classList.add('green', 'active'); // Hijau untuk "thumb up"
        setTimeout(function() {
                location.reload(); // Refresh halaman
            }, 2000); // 2 detik
    } else if (type === 'unhelpfull') {
        button.classList.add('red', 'active'); // Merah untuk "thumb down"
        setTimeout(function() {
                location.reload(); // Refresh halaman
            }, 2000); // 2 detik
    }
}

        </script>
    </div>
    @include('components.foot')
@endsection
