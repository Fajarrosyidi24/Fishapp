{{-- <h1>halo admin</h1>
<a href="{{route('admin.logout')}}">Logout</a>

<table id="datatablesSimple">
    <thead>
        <tr>
            <th>Name</th>
            <th>email</th>
            <th>alamat</th>
            <th>nomer_telepon</th>
            <th>nama_kapal</th>
            <th>jenis_kapal</th>
            <th>jumlah_abk</th>
            <th>foto</th> 
        </tr>
    </thead>
    <tfoot>
        <tr>
            <th>Name</th>
            <th>email</th>
            <th>alamat</th>
            <th>nomer_telepon</th>
            <th>nama_kapal</th>
            <th>jenis_kapal</th>
            <th>jumlah_abk</th>
            <th>foto</th> 
        </tr>
    </tfoot>
    <tbody>
        @foreach($dataNelayan as $nelayan)
        <tr>
            <td>{{ $nelayan->name }}</td>
            <td>{{ $nelayan->email }}</td>
            <td>{{ $nelayan->alamat }}</td>
            <td>{{ $nelayan->nomer_telepon }}</td>
            <td>{{ $nelayan->nama_kapal }}</td>
            <td>{{ $nelayan->jenis_kapal }}</td>
            <td>{{ $nelayan->jumlah_abk }}</td>
            <td><img src="{{ asset('storage/fotonelayan/' . $nelayan->detailProfile->foto) }}" alt="Foto nelayanl"></td>
        </tr>
        @endforeach
    </tbody>
</table> --}}

@extends('layouts.app_admin')
@section('title')
<title>Admin Dashboard Page - Fishapp</title>
@endsection