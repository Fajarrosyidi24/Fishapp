@extends('layouts.app_admin')
@section('title')
<title>Permintaan Pendaftaran Akun Page - Fishapp</title>
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
    <li class="breadcrumb-item active">Permintaan Pendaftaran Akun</li>
</ol>

<div class="card mb-4">
    <div class="card-header">
        <i class="fas fa-table me-1"></i>
        Akun Terdaftar
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
                @foreach($dataNelayan as $index => $nelayan)
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