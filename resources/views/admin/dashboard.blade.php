@extends('layouts.app_admin')
@section('title')
<title>Admin Dashboard Page - Fishapp</title>
<style>
    .text-center {
    text-align: center;
}

#datatablesSimple th,
#datatablesSimple td {
    text-align: center;
    vertical-align: middle; /* Menjadikan teks vertikal di tengah */
    border: 1px solid #cccaca; /* Menambahkan border */
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
        Daftar Nelayan
    </div>
    <div class="card-body">
        <table id="datatablesSimple" class="table table-striped table-hover table-bordered">
            <thead>
                <tr>
                    <th>No</th> <!-- Kolom nomor -->
                    <th>Name</th>
                    <th>Email</th>
                    <th class="text-center">Status</th>
                    <th class="text-center">Detail</th>
                    <th class="text-center">Foto</th>
                </tr>
            </thead>
            <tfoot>
                <tr>
                    <th>No</th> <!-- Kolom nomor -->
                    <th>Name</th>
                    <th>Email</th>
                    <th class="text-center">Status</th>
                    <th class="text-center">Detail</th>
                    <th class="text-center">Foto</th>
                </tr>
            </tfoot>
            <tbody>
                @foreach($dataNelayan2 as $index => $nelayan)
                <tr>
                    <td class="text-center">{{ $index + 1 }}</td> <!-- Menampilkan nomor urut -->
                    <td>{{ $nelayan->name }}</td>
                    <td>{{ $nelayan->email }}</td>
                    <td class="text-center">
                        <span class="badge {{ $nelayan->status == 'terdaftar' ? 'bg-success' : ($nelayan->status == 'Tidak Aktif' ? 'bg-danger' : 'bg-warning') }}">
                            {{ $nelayan->status }}
                        </span>
                    </td>
                    <td class="text-center">
                        <a href="{{ route('detailpermintaanakunnelayan', ['id' => $nelayan->id]) }}">
                            <button class="btn btn-sm btn-warning">
                                <i class="fa-solid fa-circle-info"></i> Detail
                            </button>
                        </a>                        
                    </td>
                    <td class="text-center">
                        <img src="{{ asset('storage/fotonelayan/' . $nelayan->detailProfile->foto) }}" alt="Foto Nelayan" class="rounded img-thumbnail" style="width: 80px; height: 80px; object-fit: cover;">
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>        
    </div>
</div>
@endsection