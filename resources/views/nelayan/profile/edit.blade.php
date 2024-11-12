@extends('layouts.app_nelayan')
@section('title')
<title>Nelayan Profile Page - Fishapp</title>
@endsection

@section('content')
<ol class="breadcrumb mt-4">
    <li class="breadcrumb-item active">Profile</li>
</ol>

<div class="container rounded bg-white mt-5 mb-5">
    <div class="row">
        <div class="col-md-4 border-right">
            <div class="d-flex flex-column align-items-center text-center p-3 py-5">
                @if (Auth::guard('nelayan')->user()->detailProfile->foto)
                    <img class="rounded-circle mt-5 border rounded-circle p-2" width="150px"
                        src="{{ asset('storage/fotonelayan/' . Auth::guard('nelayan')->user()->detailProfile->foto) }}">
                @else
                    <img class="rounded-circle mt-5" width="150px"
                        src="https://st3.depositphotos.com/15648834/17930/v/600/depositphotos_179308454-stock-illustration-unknown-person-silhouette-glasses-profile.jpg">
                @endif
                <div class="container-fluid p-4 d-flex justify-content-center align-items-center">
                    <div class="row align-items-center">
                        <div class="col-auto me-2">
                            <div class="dropdown">
                                <button class="btn btn-primary dropdown-toggle" type="button" id="dropdownMenuButton" data-bs-toggle="dropdown" aria-expanded="false">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-pencil" viewBox="0 0 16 16">
                                        <path d="M12.146.146a.5.5 0 0 1 .708 0l3 3a.5.5 0 0 1 0 .708l-10 10a.5.5 0 0 1-.168.11l-5 2a.5.5 0 0 1-.65-.65l2-5a.5.5 0 0 1 .11-.168l10-10zM11.207 2.5 13.5 4.793 14.793 3.5 12.5 1.207zm1.586 3L10.5 3.207 4 9.707V10h.5a.5.5 0 0 1 .5.5v.5h.5a.5.5 0 0 1 .5.5v.5h.293zm-9.761 5.175-.106.106-1.528 3.821 3.821-1.528.106-.106A.5.5 0 0 1 5 12.5V12h-.5a.5.5 0 0 1-.5-.5V11h-.5a.5.5 0 0 1-.468-.325z" />
                                    </svg>
                                </button>
                                <div class="dropdown-menu p-6" aria-labelledby="dropdownMenuButton">
                                    <form action="{{ route('update.profile.photo.nelayan') }}" enctype="multipart/form-data" method="POST">
                                        @csrf
                                        <div class="mb-3">
                                            <label for="foto" class="form-label">Update Profile Photo</label>
                                            <input type="file" class="form-control" id="foto" name="foto" required>
                                        </div>
                                        <button type="submit" class="btn btn-primary w-100">Save</button>
                                    </form>
                                </div>
                            </div>
                        </div>
                        
                        <!-- Tempat Sampah untuk Menghapus Foto -->
                        <div class="col-auto">
                            <a href="#" class="btn btn-danger" id="deletePhotoBtn">
                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-trash" viewBox="0 0 16 16">
                                    <path d="M5.5 5.5A.5.5 0 0 1 6 6v6a.5.5 0 0 1-1 0V6a.5.5 0 0 1 .5-.5m2.5 0a.5.5 0 0 1 .5.5v6a.5.5 0 0 1-1 0V6a.5.5 0 0 1 .5-.5m3 .5a.5.5 0 0 0-1 0v6a.5.5 0 0 0 1 0z" />
                                    <path d="M14.5 3a1 1 0 0 1-1 1H13v9a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V4h-.5a1 1 0 0 1-1-1V2a1 1 0 0 1 1-1H6a1 1 0 0 1 1-1h2a1 1 0 0 1 1 1h3.5a1 1 0 0 1 1 1zM4.118 4 4 4.059V13a1 1 0 0 0 1 1h6a1 1 0 0 0 1-1V4.059L11.882 4zM2.5 3h11V2h-11z" />
                                </svg>
                            </a>
                        </div>
                    </div>
                </div>
                           
                
                <span class="text-black-50">{{ Auth::guard('nelayan')->user()->name }}</span>
                <span class="text-black-50">{{ Auth::guard('nelayan')->user()->email }}</span>
                <span> </span>
            </div>
        </div>
        <div class="col-md-8 border-right">
            <div class="p-3 py-5">
                <div class="d-flex justify-content-between align-items-center mb-3">
                    <h4 class="text-right">Profile-Nelayan Settings</h4>
                </div>
                <div class="row mt-3">
                    <form action="{{ route('nelayan.profile.update') }}" method="post">
                        @csrf

                        <!-- Kolom Nama -->
                        <div class="mb-3" style="color: black">
                            <label for="nama" class="form-label">Nama :</label>
                            <input type="text" class="form-control" id="nama" name="name"
                                value="{{$nelayan->name}}">
                        </div>

                        <div class="mb-3 row" style="color: black;">
                            <label for="tempattanggallahir" class="form-label">Tempat&tanggal Lahir :</label>
                            <div class="col-sm-6">
                                <input type="text" class="form-control" id="tempat_lahir" name="tempat_lahir" value="{{$nelayan->detailprofile->tempat_lahir}}">
                            </div>
                            <div class="col-sm-6">
                                <input type="date" class="form-control" id="tanggal_lahir" name="tanggal_lahir" value="{{$nelayan->detailprofile->tanggal_lahir}}">
                            </div>
                        </div>

                        <div class="mb-3" style="color: black">
                            <label for="jenis_kelamin">Jenis Kelamin</label>
                            <select class="form-control" id="jenis_kelamin" name="jenis_kelamin" required>
                                <option value="" disabled {{ $nelayan->detailprofile->jenis_kelamin ? '' : 'selected' }}>Pilih Jenis Kelamin</option>
                                <option value="Laki-laki" {{ $nelayan->detailprofile->jenis_kelamin === 'Laki-laki' ? 'selected' : '' }}>Laki-laki</option>
                                <option value="Perempuan" {{ $nelayan->detailprofile->jenis_kelamin === 'Perempuan' ? 'selected' : '' }}>Perempuan</option>
                            </select>
                        </div>

                        <div class="mb-3" style="color: black">
                            <label for="email" class="form-label">Email</label>
                            <input type="email" class="form-control" id="email"
                                name="email"
                                value="{{$nelayan->email}}" readonly>
                        </div>
                       
                        <div class="mb-3" style="color: black">
                            <label for="nomer_telepon" class="form-label">Nomer Telepon :</label>
                            <input type="tel" class="form-control" id="nomer_telepon"
                                name="nomer_telepon"
                                value="{{$nelayan->detailprofile->no_telepon}}"
                                pattern="[0-9]{10,14}"
                                title="Masukkan nomor telepon yang valid (minimal 10 digit, maksimal 14 digit)">
                        </div>

                        <div class="mb-3 row" style="color: black;">
                            <label for="alamat" class="form-label">Alamat Lengkap :</label>
                            <div class="col-sm-6">
                                <label for="provinsi" class="form-label">Provinsi</label>
                                <input type="text" class="form-control" id="provinsi" name="provinsi" value="{{$nelayan->detailprofile->provinsi}}" readonly>
                            </div>
                            <div class="col-sm-6">
                                <label for="kabupaten" class="form-label">Kabupaten</label>
                                <select class="form-control" id="district" name="district" readonly>
                                    <option value="" disabled {{ $nelayan->detailprofile->kabupaten ? '' : 'selected' }}>Pilih Kabupaten</option>
                                    <option value="{{$nelayan->detailprofile->kabupaten}}">{{$nelayan->detailprofile->kabupaten}}</option>
                                </select>
                            </div>
                            <div class="col-sm-6 mt-2">
                                <label for="kecamatan" class="form-label">Kecamatan</label>
                                <select class="form-control" id="sub_district" name="sub_district" required>
                                    <option value="" disabled {{ empty($nelayan->detailprofile->kecamatan) ? 'selected' : '' }}>Pilih Kecamatan</option>
                                    @foreach ($kecamatan as $kec)
                                        <option value="{{ $kec->name }}" data-code="{{ $kec->code }}" 
                                            {{ $kec->name === $nelayan->detailprofile->kecamatan ? 'selected' : '' }}>
                                            {{ $kec->name }}
                                        </option>
                                    @endforeach
                                </select>
                                
                            </div>
                            <div class="col-sm-6 mt-2">
                                <label for="desa" class="form-label">Desa</label>
                                <select name="desa" id="desa" class="form-control" required>
                                    <option value="" disabled {{ empty($nelayan->detailprofile->desa) ? 'selected' : '' }}>Pilih Desa</option>
                                    <option value="{{ $nelayan->detailprofile->desa }}" selected>
                                        {{ $nelayan->detailprofile->desa }}
                                    </option>
                                </select>
                            </div>
                            <div class="col-sm-12 mt-2">
                                <label for="dusun" class="form-label">Dusun</label>
                                <input type="text" class="form-control" id="dusun" name="dusun" value="{{$nelayan->detailprofile->dusun}}">
                            </div>
                            <div class="col-sm-4 mt-2">
                                <label for="rt" class="form-label">RT</label>
                                <input type="text" class="form-control" id="rt" name="rt" value="{{$nelayan->detailprofile->rt}}">
                            </div>
                            <div class="col-sm-4 mt-2">
                                <label for="rw" class="form-label">RW</label>
                                <input type="text" class="form-control" id="rw" name="rw" value="{{$nelayan->detailprofile->rw}}">
                            </div>
                            <div class="col-sm-4 mt-2">
                                <label for="code_pos" class="form-label">Kode Pos</label>
                                <input type="text" class="form-control" id="code_pos" name="code_pos" value="{{$nelayan->detailprofile->code_pos}}">
                            </div>
                        </div>
                        <!-- Informasi Kapal -->
                    <div class="form-group mb-3 mt-2">
                        <h5>Informasi Kapal dan ABK</h5>
                        <label for="nama_kapal">Nama Kapal</label>
                        <input type="text" class="form-control" id="nama_kapal" name="nama_kapal" value="{{$nelayan->detailprofile->nama_kapal}}">
                    </div>

                    <div class="form-group mb-3">
                        <label for="jenis_kapal">Jenis Kapal</label>
                        <input type="text" class="form-control" id="jenis_kapal" name="jenis_kapal"
                        value="{{$nelayan->detailprofile->jenis_kapal}}">
                    </div>
                    <div class="form-group mb-3">
                        <label for="jumlah_abk">Jumlah ABK</label>
                        <input type="number" class="form-control" id="jumlah_abk" name="jumlah_abk" min="1"
                        value="{{$nelayan->detailprofile->jumlah_abk}}">
                    </div>

                        <!-- Tombol Submit -->
                        <button type="submit" class="btn btn-primary">Update Profil</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<ol class="breadcrumb mb-4">
    <li class="breadcrumb-item active">Akun Rekening Bank</li>
</ol>

<div class="container rounded bg-white mb-5">
    @if ($bank->isEmpty())
        <p>Anda Belum Memiliki Akun Bank</p>
    @else
        @foreach ($bank as $bi)
            @php
                $nama = '';
                if ($bi->jenis_rekening === 'DANA') {
                    $nama = 'img/bankdana.jpg';
                } elseif ($bi->jenis_rekening === 'BANK BRI') {
                    $nama = 'img/bankbri.jpg';
                } elseif ($bi->jenis_rekening === 'BANK BNI') {
                    $nama = 'img/bankbni.jpg';
                } elseif ($bi->jenis_rekening === 'BANK MANDIRI') {
                    $nama = 'img/bankmandiri.jpg';
                }
            @endphp
            <div class="card mb-3">
                <img class="card-img-top" src="{{ asset($nama) }}" alt="Card image cap">
                <div class="card-body">
                    <h5 class="card-title">{{ $bi->jenis_rekening }}</h5>
                    <div class="row mb-2">
                        <div class="col-sm-4"><strong>Nomor Rekening</strong></div>
                        <div class="col-sm-8">: {{ $bi->nomor_rekening }}</div>
                    </div>
                    <div class="row mb-2">
                        <div class="col-sm-4">A.N</div>
                        <div class="col-sm-8">: {{ $bi->nama_akun_rekening }}</div>
                    </div>
                    <div class="row mb-2">
                        <div class="col-sm-4">Tanggal Ditambahkan</div>
                        <div class="col-sm-8"><small class="text-muted">:
                                {{ $bi->created_at }}</small></div>
                    </div>
                    <div class="row mb-2">
                        <div class="col-sm-4">Tanggal Diperbarui</div>
                        <div class="col-sm-8"><small class="text-muted">:
                                {{ $bi->updated_at }}</small></div>
                    </div>
                    <div class="btn-group" role="group" aria-label="Basic example">
                        <button type="button" class="btn btn-primary" data-bs-toggle="modal"
                            data-bs-target="#productModal1{{ $bi->kode_rekening }}">Update</button>
                        <button type="button" class="btn btn-danger" data-bs-toggle="modal"
                            data-bs-target="#productModal2{{ $bi->kode_rekening }}">Delete</button>
                    </div>
                </div>
            </div>
        @endforeach
    @endif
    <div class="card-footer">
        <button type="button" class="btn btn-success" data-bs-toggle="modal"
            data-bs-target="#productModal">tambahkan akun bank</button>
    </div>

    @foreach ($bank as $bi)
        @php $id = Crypt::encrypt($bi->kode_rekening); @endphp
        <div class="modal fade" id="productModal1{{ $bi->kode_rekening }}" tabindex="-1"
            aria-labelledby="productModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="productModalLabel" style="color: black">
                            {{ $bi->jenis_rekening }} --Update</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal"
                            aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <form action="{{ route('nelayan.profile.update.bank', ['id' => $id]) }}"
                            method="post">
                            @csrf
                            <div class="mb-3" style="color: black">
                                <label for="jenis_rekening" class="form-label">Jenis Rekening
                                    Pembayaran :</label>
                                <select name="jenis_rekening" id="jenis_rekening"
                                    class="form-control" aria-label="jenis_rekening">
                                    <option selected disabled>Pilih</option>
                                    <option value="BANK BNI"
                                        @if ($bi->jenis_rekening == 'BANK BNI') selected @endif>BANK BNI
                                    </option>
                                    <option value="BANK BRI"
                                        @if ($bi->jenis_rekening == 'BANK BRI') selected @endif>BANK BRI
                                    </option>
                                    <option value="BANK MANDIRI"
                                        @if ($bi->jenis_rekening == 'BANK MANDIRI') selected @endif>BANK MANDIRI
                                    </option>
                                    <option value="DANA"
                                        @if ($bi->jenis_rekening == 'DANA') selected @endif>DANA</option>
                                </select>
                            </div>

                            <div class="mb-3" style="color: black">
                                <label for="name_akun_bank" class="form-label">Atas Nama Akun
                                    Bank</label>
                                <input type="text" class="form-control" id="name_akun_bank"
                                    name="name_akun_bank" value="{{ $bi->nama_akun_rekening }}">
                            </div>

                            <div class="mb-3" style="color: black">
                                <label for="nomor_rekening" class="form-label">Nomor Rekening</label>
                                <input type="text" class="form-control" id="nomor_rekening"
                                    name="nomor_rekening" value="{{ $bi->nomor_rekening }}">
                            </div>
                            <button type="submit" class="btn btn-success">Update</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>


        <div class="modal fade" id="productModal2{{ $bi->kode_rekening }}" tabindex="-1"
            aria-labelledby="productModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="productModalLabel" style="color: black">
                            {{ $bi->jenis_rekening }} --Delete</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal"
                            aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <form action="{{ route('nelayan.profile.delete.bank', ['id' => $id]) }}"
                            method="post">
                            @csrf
                            <p>apakah anda yakin ingin menghapus</p>
                            <button type="submit" class="btn btn-danger">iya</button>
                            <button type="button" class="btn btn-secondary"
                                data-bs-dismiss="modal">Close</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    @endforeach


    <div class="modal fade" id="productModal" tabindex="-1" aria-labelledby="productModalLabel"
        aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="productModalLabel" style="color: black">Tambahkan
                        Akun Bank Anda</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"
                        aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form action="{{ route('nelayan.profile.create.bank') }}" method="post">
                        @csrf
                        <div class="mb-3" style="color: black">
                            <label for="jenis_rekening" class="form-label">Jenis Rekening Pembayaran
                                :</label>
                            <select name="jenis_rekening" id="jenis_rekening" class="form-control"
                                aria-label="jenis_rekening">
                                <option selected disabled>Pilih</option>
                                <option>BANK BNI</option>
                                <option>BANK BRI</option>
                                <option>BANK MANDIRI</option>
                                <option>DANA</option>
                            </select>
                        </div>

                        <div class="mb-3" style="color: black">
                            <label for="name_akun_bank" class="form-label">Atas Nama Akun Bank</label>
                            <input type="text" class="form-control" id="name_akun_bank"
                                name="name_akun_bank">
                        </div>

                        <div class="mb-3" style="color: black">
                            <label for="nomor_rekening" class="form-label">Nomor Rekening</label>
                            <input type="text" class="form-control" id="nomor_rekening"
                                name="nomor_rekening">
                        </div>
                        <button type="submit" class="btn btn-success">Tambahkan</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@include('alamat.nelayan.alamat')
@endsection

@section('foot')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const selectKecamatan = document.getElementById('sub_district');
            const selectDesa = document.getElementById('desa');

            selectKecamatan.addEventListener('change', function() {
                const selectedOption = selectKecamatan.options[selectKecamatan.selectedIndex];
                const selectedCode = selectedOption.getAttribute('data-code');

                // Kosongkan pilihan desa sebelumnya
                selectDesa.innerHTML = '<option selected disabled>Pilih Desa</option>';

                if (selectedCode) {
                    // Ambil data desa berdasarkan kecamatan yang dipilih
                    fetch(`/api/villages?district_code=${selectedCode}`)
                        .then(response => response.json())
                        .then(data => {
                            // Tambahkan desa ke dropdown
                            data.forEach(village => {
                                const option = document.createElement('option');
                                option.value = village.name;
                                option.textContent = village.name;
                                selectDesa.appendChild(option);
                            });
                        })
                        .catch(error => console.error('Error fetching villages:', error));
                }
            });
        });
    </script>

<script>
    document.getElementById('deletePhotoBtn').addEventListener('click', function(event) {
        event.preventDefault(); // Mencegah aksi bawaan dari tautan
        if (confirm('Anda yakin ingin menghapus foto profil?')) {
            // Mengirim permintaan DELETE menggunakan Fetch API
            fetch('{{ route('delete.profile.photo.nelayan') }}', {
                    method: 'DELETE',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    },
                })
                .then(() => {
                    // Setelah konfirmasi penghapusan, reload halaman
                    location.reload(); // Refresh halaman
                })
                .catch(error => {
                    // Handle error
                    console.error('Error:', error);
                    alert('Terjadi kesalahan saat menghapus foto profil.'); // Pesan error
                });
        }
    });
</script>

<script>
    document.getElementById('provinsiseafood').addEventListener('change', function() {
        var selectedProvinsi = this.value;
        var citySelect = document.getElementById('cityseafood');
        var cityData = @json($api);

        citySelect.innerHTML = '';

        var defaultOption = document.createElement('option');
        defaultOption.text = 'Pilih';
        defaultOption.disabled = true;
        defaultOption.selected = true;
        citySelect.appendChild(defaultOption);

        var shownCities = new Set();

        cityData.forEach(function(ci) {
            if (ci['province_id'] === selectedProvinsi && !shownCities.has(ci['city_name'])) {
                var option = document.createElement('option');
                option.value = ci['city_id'];
                option.text = ci['city_name'];
                citySelect.appendChild(option);
                shownCities.add(ci['city_name']);
            }
        });
    });
</script>

<script>
    document.getElementById('provinsiseafood2').addEventListener('change', function() {
        var selectedProvinsi = this.value;
        var citySelect = document.getElementById('cityseafood2');
        var cityData = @json($api);

        citySelect.innerHTML = '';

        var defaultOption = document.createElement('option');
        defaultOption.text = 'Pilih';
        defaultOption.disabled = true;
        defaultOption.selected = true;
        citySelect.appendChild(defaultOption);

        var shownCities = new Set();

        cityData.forEach(function(ci) {
            if (ci['province_id'] === selectedProvinsi && !shownCities.has(ci['city_name'])) {
                var option = document.createElement('option');
                option.value = ci['city_id'];
                option.text = ci['city_name'];
                citySelect.appendChild(option);
                shownCities.add(ci['city_name']);
            }
        });
    });
</script>
@endsection