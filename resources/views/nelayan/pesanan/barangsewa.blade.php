@extends('layouts.app_nelayan')

@section('title')
    <title>Pesanan Barang Sewa</title>
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
        <li class="breadcrumb-item active">Pesanan Barang Sewa</li>
    </ol>
    <div class="card mb-4">
        <div class="card-header">
            <i class="fas fa-table me-1"></i>
            List Pesanan
        </div>
        <div class="card-body">
            <table id="datatablesSimple" class="table table-striped table-hover table-bordered">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Nama Barang</th>
                        <th>Nama Penyewa</th>
                        <th class="text-center"> Status</th>
                        <th class="text-center"> Detail</th>
                        <th class="text-center"> Gambar Barang</th>
                    </tr>
                </thead>
                <tfoot>
                    <tr>
                        <th>No</th>
                        <th>Nama Barang</th>
                        <th>Nama Penyewa</th>
                        <th class="text-center"> Status</th>
                        <th class="text-center"> Detail</th>
                        <th class="text-center"> Gambar Barang</th>
                    </tr>
                </tfoot>
                <tbody>
                    <tr>
                        <td class="text-center">1</td> 
                        <td>Tuna</td>
                        <td>Fajar</td>
                        <td class="text-center">
                        <span class="badge bg-warning">
                            status
                            </span>
                        </td>
                        <td class="text-center">
                        <a href="{{ route('detailpesananbarangsewa.nelayan')}}">
                            <button class="btn btn-sm btn-warning">
                                <i class="fa-solid fa-circle-info"></i> Detail
                            </button>
                        </a>
                        </td>
                        <td class="text-center">
                        <img src="#" alt="Foto Seafood" class="rounded img-thumbnail" style="width: 80px; height: 80px; object-fit: cover;">
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
@endsection