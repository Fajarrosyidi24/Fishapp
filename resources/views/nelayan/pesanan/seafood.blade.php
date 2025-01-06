@extends('layouts.app_nelayan')

@section('title')
    <title>Pesanan Seafood</title>
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
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
@endsection

@section('content')
    <ol class="breadcrumb mt-4">
        <li class="breadcrumb-item active">Pesanan Seafood</li>
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
                        {{-- <th>No</th> --}}
                        <th>Nama Pembeli</th>
                        <th class="text-center">Status</th>
                        <th class="text-center">Detail</th>
                        <th class="text-center">Gambar Barang</th>
                        <th class="text-center">Aksi</th>
                    </tr>
                </thead>
                <tfoot>
                    <tr>
                        {{-- <th>No</th> --}}
                        <th>Nama Pembeli</th>
                        <th class="text-center">Status</th>
                        <th class="text-center">Detail</th>
                        <th class="text-center">Gambar Barang</th>
                        <th class="text-center">Aksi</th>
                    </tr>
                </tfoot>
                <tbody>
                    @foreach ($pesananSeafood as $index => $pesanan)
                        <tr>
                            <!-- Nomor Urut -->
                            {{-- <td class="text-center">{{ $index + 1 }}</td> --}}

                            <td>
                                @if ($pesanan->keranjangs->isNotEmpty() && $pesanan->keranjangs->first()->user)
                                    {{ $pesanan->keranjangs->first()->user->name }}
                                @else
                                    Unknown User
                                @endif
                            </td>

                            <td class="text-center">
                                <div class="{{ $pesanan->status == 'success' ? 'badge bg-success' : 'text-dark' }}">
                                    {{ $pesanan->status }}
                                </div>
                            </td>


                            <!-- Tombol Detail -->
                            <td class="text-center">
                                <a href="#" data-bs-toggle="modal" data-bs-target="#productModal{{ $pesanan->id }}">
                                    <button class="btn btn-sm btn-warning">
                                        <i class="fa-solid fa-circle-info"></i> Detail
                                    </button>
                                </a>
                            </td>

                            <!-- Gambar Barang -->
                            <td class="text-center">
                                @if ($pesanan->keranjangs->isNotEmpty())
                                    @foreach ($pesanan->keranjangs as $keranjang)
                                        @if ($keranjang->seafood && $keranjang->seafood->foto)
                                            <img src="{{ asset('storage/fotoseafood/' . $keranjang->seafood->foto) }}"
                                                alt="Foto Seafood" class="rounded img-thumbnail mb-1"
                                                style="width: 80px; height: 80px; object-fit: cover;">
                                        @else
                                            <img src="{{ asset('images/default-seafood.png') }}" alt="Default Foto Seafood"
                                                class="rounded img-thumbnail mb-1"
                                                style="width: 80px; height: 80px; object-fit: cover;">
                                        @endif
                                    @endforeach
                                @else
                                    <span class="text-muted">Tidak ada gambar tersedia</span>
                                @endif
                            </td>

                            <td class="text-center">
                                <a href="#" data-bs-toggle="modal" data-bs-target="#productModal2{{ $pesanan->id }}">
                                    <button type="button" class="btn btn-sm btn-success"
                                        @if ($pesanan->status != 'sedang dikemas') disabled hidden @endif>
                                        <i class="fa-solid fa-truck"></i> Kirim
                                    </button>
                                </a>
                            </td>
                        </tr>


                        <div class="modal fade" id="productModal{{ $pesanan->id }}" tabindex="-1"
                            aria-labelledby="productModalLabel" aria-hidden="true">
                            <div class="modal-dialog">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="productModalLabel" style="color: black">
                                            Detail
                                            <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                aria-label="Close"></button>
                                    </div>
                                    <div class="modal-body">
                                        <form>
                                            @csrf
                                            <div class="mb-3">
                                                <label for="namaSeafood" class="form-label">Daftar Nama Seafood yang
                                                    Dipesan:</label>
                                                @foreach ($pesanan->keranjangs as $keranjang)
                                                    @if ($keranjang->seafood)
                                                        <div class="mb-2">
                                                            <input type="text" class="form-control" readonly
                                                                value="{{ $keranjang->seafood->nama }} ({{ $keranjang->jumlah }} KG) (Rp. {{ number_format($keranjang->subtotal, 0, ',', '.') }})">
                                                        </div>
                                                    @endif
                                                @endforeach
                                            </div>
                                            <!-- Subtotal Pesanan -->
                                            <div class="mb-3">
                                                <label for="subtotal" class="form-label">Subtotal Pesanan:</label>
                                                <input type="text" class="form-control" readonly
                                                    value="Rp. {{ number_format($pesanan->subtotal_harga, 0, ',', '.') }}">
                                            </div>
                                            <div class="mb-3">
                                                <label for="ongkir" class="form-label">Ongkos Kirim:</label>
                                                <input type="text" class="form-control" readonly
                                                    value="Rp. {{ number_format($pesanan->ongkir, 0, ',', '.') }}">
                                            </div>
                                            <div class="mb-3">
                                                <label for="total" class="form-label">Total Pesanan:</label>
                                                <input type="text" class="form-control" readonly
                                                    value="Rp. {{ number_format($pesanan->subtotal_harga + $pesanan->ongkir, 0, ',', '.') }}">
                                            </div>
                                            <div class="mb-3">
                                                <label for="total" class="form-label">Status Pembayaran :</label>
                                                <input type="text" class="form-control" readonly
                                                    value="{{ $pesanan->item->first()->pembayaran->status_pembayaran }}">
                                            </div>
                                            @if ($pesanan->item->first()->pembayaran->status_pembayaran == 'PAID')
                                                <div class="mb-3">
                                                    <label for="detailPembayaran" class="form-label">Detail
                                                        Pembayaran:</label>
                                                    <a
                                                        href="{{ route('pembayaran.detail', ['id' => $pesanan->keranjangs->first()->user->id, 'pesanan_id' => $pesanan->id]) }}">
                                                        <button type="button" class="btn btn-sm btn-info">
                                                            <i class="fa-solid fa-info-circle"></i> Detail
                                                        </button>
                                                    </a>
                                                </div>
                                            @endif
                                            <div class="mb-3">
                                                <label for="alamat" class="form-label">Alamat Tujuan Pengiriman</label>
                                                <textarea class="form-control" id="alamat" rows="3" readonly> Dusun {{ $pesanan->keranjangs->first()->user->alamat->dusun }}, RT.{{ $pesanan->keranjangs->first()->user->alamat->rt }}/RW.{{ $pesanan->keranjangs->first()->user->alamat->rw }}, Desa {{ $pesanan->keranjangs->first()->user->alamat->desa }}, Kecamatan {{ $pesanan->keranjangs->first()->user->alamat->kecamatan }}, Kabupaten {{ $pesanan->keranjangs->first()->user->alamat->kabupaten }}, Provinsi {{ $pesanan->keranjangs->first()->user->alamat->provinsi }}, Kode Pos : {{ $pesanan->keranjangs->first()->user->alamat->code_pos }}
                                                </textarea>
                                            </div>

                                            <div class="mb-3">
                                                <label for="nama_pembeli" class="form-label">Nama Pembeli</label>
                                                <input type="text" class="form-control" id="tel"
                                                    value="{{ $pesanan->keranjangs->first()->user->name }}" readonly>
                                            </div>

                                            <div class="mb-3">
                                                <label for="nama_pembeli" class="form-label">Nomor Telepon Pembeli</label>
                                                <input type="tel" class="form-control" id="tel"
                                                    value="{{ $pesanan->keranjangs->first()->user->updateProfile->no_telepon }}"
                                                    readonly>
                                            </div>

                                        </form>
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-sm btn-secondary"
                                            data-bs-dismiss="modal">Close</button>
                                    </div>
                                </div>
                            </div>
                        </div>


                        <div class="modal fade" id="productModal2{{ $pesanan->id }}" tabindex="-1"
                            aria-labelledby="productModalLabel{{ $pesanan->id }}" aria-hidden="true">
                            <div class="modal-dialog">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="productModalLabel{{ $pesanan->id }}"
                                            style="color: black">
                                            Silakan Isi Terlebih Dahulu
                                        </h5>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal"
                                            aria-label="Close"></button>
                                    </div>
                                    <div class="modal-body">
                                        <form method="POST"
                                            action="{{ route('upload.pengiriman.seafood', ['id' => $pesanan->id]) }}"
                                            enctype="multipart/form-data">
                                            @csrf
                                            <div class="mb-3">
                                                <label for="photo" class="form-label">Upload Bukti Pengiriman</label>
                                                <input type="file" id="photo-input{{ $pesanan->id }}" name="photo" required>
                                            </div>
                                            <button type="button" class="btn btn-secondary"
                                                data-bs-dismiss="modal">Close</button>
                                            <button type="submit" class="btn btn-success">Kirim</button>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
@endsection