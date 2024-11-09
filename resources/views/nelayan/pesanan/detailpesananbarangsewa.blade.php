@extends('layouts.app_nelayan')

@section('title')
    <title>Detail Pesanan Barang Sewa</title>
    <style>
        .content-container {
            display: flex;
            justify-content: space-between;
            padding: 10px 20px 10px 0;
        }

        .class-body {
            margin-right: 20px;
        }

        .image-container-img img {
            max-width: 100%;
            height: auto;
            object-fit: cover;
            border-radius: 10px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        }

        .large-font {
            font-size: 20px;
        }

        .card-header {
            display: flex;
            align-items: center;
            justify-content: space-between;
        }

        /* Untuk membuat teks Nomor Resi sejajar dengan Detail Pesanan Seafood */
        .card-header .header-left {
            display: flex;
            align-items: center;
        }

        .card-header .header-right {
            display: flex;
            align-items: center;
            margin-left: auto;
        }

        .resi-container {
            display: flex;
            align-items: center;
            gap: 8px;
            font-size: 16px; /* Menyesuaikan ukuran font */
        }

        /* Styling untuk tabel */
        table {
            width: 100%;
            border-spacing: 0;
        }

        th, td {
            padding: 8px 12px;
            text-align: left;
            vertical-align: middle; /* Memastikan semua teks sejajar secara vertikal */
        }

        th {
            width: 30%; /* Menyesuaikan lebar kolom label */
            white-space: nowrap; /* Menghindari pemotongan teks */
        }

        td {
            width: 70%; /* Menyesuaikan lebar kolom nilai */
        }

        /* Membuat tanda ':' sejajar */
        th:after {
            content: ":";
            margin-left: 5px; /* Menambahkan ruang antara label dan tanda : */
        }
    </style>
@endsection

@section('content')
<div class="container mt-5">
    <div class="card shadow-sm border-0 rounded">
        <div class="card-header bg-primary text-white">
            <h4 class="mb-0">Detail Pesanan Barang Sewa</h4>
            <div class="resi-container">
                <span style="display: flex; justify-content: flex-end;">ID Penyewa: 02479954612</span>
                <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <path d="M14 7V7C14 6.06812 14 5.60218 13.8478 5.23463C13.6448 4.74458 13.2554 4.35523 12.7654 4.15224C12.3978 4 11.9319 4 11 4H8C6.11438 4 5.17157 4 4.58579 4.58579C4 5.17157 4 6.11438 4 8V11C4 11.9319 4 12.3978 4.15224 12.7654C4.35523 13.2554 4.74458 13.6448 5.23463 13.8478C5.60218 14 6.06812 14 7 14V14" stroke="#ffffff" stroke-width="2"/>
                    <rect x="10" y="10" width="10" height="10" rx="2" stroke="#ffffff" stroke-width="2"/>
                </svg>
            </div>
        </div>
        
        <div class="content-container">
            <div class="class-body">
                <table>
                    <tbody>
                        <tr>
                            <th class="large-font">Nama Penyewa</th>
                            <td class="large-font">Pratama Zidan</td>
                        </tr>
                        <tr>
                            <th class="large-font">Jumlah Barang Disewa</th>
                            <td class="large-font">1</td>
                        </tr>
                        <tr>
                            <th class="large-font">Total Harga Sewa</th>
                            <td class="large-font">Rp. 10.000,-</td>
                        </tr>
                        <tr>
                            <th class="large-font">Tanggal Penyewaan</th>
                            <td class="large-font">9-9-2024</td>
                        </tr>
                        <tr>
                            <th class="large-font">Durasi Sewa</th>
                            <td class="large-font">2 Jam</td>
                        </tr>
                        <tr>
                            <th class="large-font">Metode Pembayaran</th>
                            <td class="large-font">COD</td>
                        </tr>
                        <tr>
                            <th class="large-font">Status Pembayaran</th>
                            <td class="large-font">Lunas</td>
                        </tr>
                        <tr>
                            <th class="large-font">Nomor Telpon Penyewa</th>
                            <td class="large-font">08523735995</td>
                        </tr>
                    </tbody>
                </table>
            </div>
            <div class="image-container">
                <img src="{{ asset('storage/fotobarang/5430a9fb-aa19-4db1-8015-6b65944779ec_1731049347_download.jpeg') }}" alt="Foto Seafood" class="rounded img-thumbnail">
            </div>
        </div>
        
        @if ('pending')
            <div class="form-group mb-4">
                <div class="row gx-2">
                    <div class="col-md-6">
                        <button type="button" class="btn btn-success w-100" data-bs-toggle="modal" data-bs-target="#confirmModal">Verifikasi Permintaan</button>
                    </div>
                    <div class="col-md-6">
                        <button type="button" class="btn btn-danger w-100" id="rejectButton">Tolak Permintaan</button>
                    </div>
                </div>
            </div>
        @else
            <div class="col-md-6">
                <a href="{{route('nelayan.dashboard')}}">
                    <button type="button" class="btn btn-secondary w-50">Kembali</button>
                </a>
            </div>                
        @endif
    </div>
</div>
@endsection
