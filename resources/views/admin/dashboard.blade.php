@extends('layouts.app_admin')
@section('title')
<title>Admin Dashboard Page - Fishapp</title>
<style>
    .img-crop {
    width: 80px; /* Atur lebar sesuai kebutuhan */
    height: 80px; /* Atur tinggi sesuai kebutuhan */
    object-fit: cover; /* Memastikan gambar mengisi kotak tanpa merusak proporsi */
    align-items: center; /* Memusatkan secara vertikal */
    display: flex; /* Menggunakan flexbox untuk memudahkan pemusatan */
    justify-content: center; /* Memusatkan secara horizontal */
}
</style>
@endsection

@section('content')
<ol class="breadcrumb mt-4">
    <li class="breadcrumb-item active">Dashboard Admin</li>
</ol>
<div class="row">
    <!-- Data Nelayan -->
    <div class="col-xl-3 col-md-6">
        <div class="card text-white mb-4" style="background-color: #3498db;">
            <div class="card-body">
                <i class="fas fa-user mr-2"></i> Data Nelayan
            </div>
            <div class="card-footer d-flex align-items-center justify-content-between">
                <a class="small text-white stretched-link" href="#">View Details</a>
                <div class="small text-white"><i class="fas fa-angle-right"></i></div>
            </div>
        </div>
    </div>

    <!-- Data Pembeli -->
    <div class="col-xl-3 col-md-6">
        <div class="card text-white mb-4" style="background-color: #f39c12;">
            <div class="card-body">
                <i class="fas fa-user mr-2"></i> Data Pembeli
            </div>
            <div class="card-footer d-flex align-items-center justify-content-between">
                <a class="small text-white stretched-link" href="#">View Details</a>
                <div class="small text-white"><i class="fas fa-angle-right"></i></div>
            </div>
        </div>
    </div>

    <!-- Data Barang Sewa -->
    <div class="col-xl-3 col-md-6">
        <div class="card text-white mb-4" style="background-color: #28a745;">
            <div class="card-body">
                <i class="fas fa-box mr-2"></i> Data Barang Sewa
            </div>
            <div class="card-footer d-flex align-items-center justify-content-between">
                <a class="small text-white stretched-link" href="#">View Details</a>
                <div class="small text-white"><i class="fas fa-angle-right"></i></div>
            </div>
        </div>
    </div>

    <!-- Data Seafood -->
    <div class="col-xl-3 col-md-6">
        <div class="card text-white mb-4" style="background-color: #e74c3c;">
            <div class="card-body">
                <i class="fas fa-fish mr-2"></i> Data Seafood
            </div>
            <div class="card-footer d-flex align-items-center justify-content-between">
                <a class="small text-white stretched-link" href="#">View Details</a>
                <div class="small text-white"><i class="fas fa-angle-right"></i></div>
            </div>
        </div>
    </div>
</div>


<div class="row">
    <div class="col-xl-6">
        <div class="card mb-4">
            <div class="card-header">
                <i class="fas fa-chart-area me-1"></i>
                Statistik Data Penyewaan
            </div>
            <div class="card-body"><canvas id="myAreaChart" width="100%" height="40"></canvas></div>
        </div>
    </div>
    <div class="col-xl-6">
        <div class="card mb-4">
            <div class="card-header">
                <i class="fas fa-chart-bar me-1"></i>
                Statistik Data Penjualan Seafood
            </div>
            <div class="card-body"><canvas id="myBarChart" width="100%" height="40"></canvas></div>
        </div>
    </div>
</div>

<div class="card mb-4">
    <div class="card-header">
        <i class="fas fa-table me-1"></i>
        Permintaan Pendaftaran Akun Nelayan
    </div>
    <div class="card-body">
        <table id="datatablesSimple">
            <thead>
                <tr>
                    <th>Name</th>
                    <th>email</th>
                    <th>foto</th>
                </tr>
            </thead>
            <tfoot>
                <tr>
                    <th>Name</th>
                    <th>email</th>
                    <th>foto</th>
                </tr>
            </tfoot>
            <tbody>
                @foreach($dataNelayan as $nelayan)
                <tr>
                    <td>{{ $nelayan->name }}</td>
                    <td>{{ $nelayan->email }}</td>
                    <td>
                        <img src="{{ asset('storage/fotonelayan/' . $nelayan->detailProfile->foto) }}" alt="Foto Kapal" class="img-crop">
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>

@endsection