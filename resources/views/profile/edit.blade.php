@extends('layouts.app')
@section('title')
    <title>Edit Profile Page - Fishapp</title>
@endsection

@section('content')
    <div class="container rounded bg-white mt-5 mb-5">
        <div class="row">
            <!-- Bagian Profil -->
            <div class="col-md-3 col-sm-12 border-right">
                <div class="d-flex flex-column align-items-center text-center p-3 py-5">
                    @if (optional(Auth::user()->updateProfile)->foto)
                        <img class="rounded-circle mt-5 border p-2" width="150px"
                            src="{{ asset('storage/fotouser/' . Auth::user()->updateProfile->foto) }}">
                    @else
                        <img class="rounded-circle mt-5" width="150px"
                            src="https://st3.depositphotos.com/15648834/17930/v/600/depositphotos_179308454-stock-illustration-unknown-person-silhouette-glasses-profile.jpg">
                    @endif
                    <div class="container-fluid p-0 mt-3">
                        <!-- Dropdown for Editing Profile Picture -->
                        <div class="dropdown">
                            <button class="btn btn-primary dropdown-toggle" type="button" id="dropdownMenuButton"
                                data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor"
                                    class="bi bi-pencil" viewBox="0 0 16 16">
                                    <path
                                        d="M12.146.146a.5.5 0 0 1 .708 0l3 3a.5.5 0 0 1 0 .708l-10 10a.5.5 0 0 1-.168.11l-5 2a.5.5 0 0 1-.65-.65l2-5a.5.5 0 0 1 .11-.168l10-10zM11.207 2.5 13.5 4.793 14.793 3.5 12.5 1.207zm1.586 3L10.5 3.207 4 9.707V10h.5a.5.5 0 0 1 .5.5v.5h.5a.5.5 0 0 1 .5.5v.5h.293zm-9.761 5.175-.106.106-1.528 3.821 3.821-1.528.106-.106A.5.5 0 0 1 5 12.5V12h-.5a.5.5 0 0 1-.5-.5V11h-.5a.5.5 0 0 1-.468-.325z" />
                                </svg>
                            </button>
                            <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                                <form action="{{ route('update.profile.photo') }}" enctype="multipart/form-data"
                                    method="POST">
                                    @csrf
                                    <div class="mb-3">
                                        <input type="file" id="pas_foto" name="pas_foto">
                                    </div>
                                    <button type="submit" class="btn btn-primary">Save</button>
                                </form>
                            </div>
                        </div>

                        <!-- Delete Photo Button -->
                        <a href="#" class="btn btn-link mt-2" id="deletePhotoBtn">
                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor"
                                class="bi bi-trash" viewBox="0 0 16 16">
                                <path
                                    d="M5.5 5.5A.5.5 0 0 1 6 6v6a.5.5 0 0 1-1 0V6a.5.5 0 0 1 .5-.5m2.5 0a.5.5 0 0 1 .5.5v6a.5.5 0 0 1-1 0V6a.5.5 0 0 1 .5-.5m3 .5a.5.5 0 0 0-1 0v6a.5.5 0 0 0 1 0z" />
                                <path
                                    d="M14.5 3a1 1 0 0 1-1 1H13v9a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V4h-.5a1 1 0 0 1-1-1V2a1 1 0 0 1 1-1H6a1 1 0 0 1 1-1h2a1 1 0 0 1 1 1h3.5a1 1 0 0 1 1 1zM4.118 4 4 4.059V13a1 1 0 0 0 1 1h6a1 1 0 0 0 1-1V4.059L11.882 4zM2.5 3h11V2h-11z" />
                            </svg>
                        </a>
                    </div>

                    <span class="text-black-50 mt-3">{{ Auth::user()->name }}</span>
                    <span class="text-black-50">{{ Auth::user()->email }}</span>
                </div>
            </div>

            <!-- Bagian Pengaturan Profil -->
            <div class="col-md-5 col-sm-12 border-right">
                <div class="p-3 py-5">
                    <h4 class="text-right">Profile</h4>
                    <form action="{{ route('profile.update') }}" method="post">
                        @csrf
                        <div class="mb-3">
                            <label for="name" class="form-label" style="color: black">Nama :</label>
                            <input type="text" class="form-control" id="name" name="name"
                                value="{{ Auth::user()->name }}">
                        </div>

                        <div class="form-group mb-3">
                            <label for="tempat_lahir">Tempat Lahir</label>
                            <input type="text" class="form-control" id="tempat_lahir" name="tempat_lahir"
                                value="{{ optional(Auth::user()->updateProfile)->tempat_lahir }}"
                                placeholder="Masukkan tempat lahir Anda">
                        </div>
                        <div class="form-group mb-3">
                            <label for="tanggal_lahir">Tanggal Lahir</label>
                            <input type="date" class="form-control" id="tanggal_lahir" name="tanggal_lahir"
                                value="{{ optional(Auth::user()->updateProfile)->tanggal_lahir }}">
                        </div>

                        <!-- Jenis Kelamin -->
                        <div class="form-group mb-3">
                            <label for="jenis_kelamin">Jenis Kelamin</label>
                            <select class="form-control" id="jenis_kelamin" name="jenis_kelamin">
                                <option value="" disabled
                                    {{ optional(Auth::user()->updateProfile)->jenis_kelamin ? '' : 'selected' }}>Pilih Jenis
                                    Kelamin
                                </option>
                                <option value="Laki-laki"
                                    {{ optional(Auth::user()->updateProfile)->jenis_kelamin === 'Laki-laki' ? 'selected' : '' }}>
                                    Laki-laki
                                </option>
                                <option value="Perempuan"
                                    {{ optional(Auth::user()->updateProfile)->jenis_kelamin === 'Perempuan' ? 'selected' : '' }}>
                                    Perempuan
                                </option>
                            </select>
                        </div>


                        <div class="form-group mb-3">
                            <label for="email">Email</label>
                            <input type="email" class="form-control" id="email" name="email"
                                value="{{ Auth::user()->email }}" readonly>
                        </div>

                        <div class="mb-3">
                            <label for="nomer_telepon" class="form-label" style="color: black">Nomor Telepon :</label>
                            <input type="tel" class="form-control" id="nomer_telepon" name="nomer_telepon"
                                 value="{{ optional(Auth::user()->updateProfile)->no_telepon }}"
                                placeholder="Masukkan Nomor Telepon Anda" pattern="[0-9]{10,14}"
                                title="Masukkan nomor telepon yang valid (minimal 10 digit, maksimal 14 digit)">
                        </div>

                        <div class="form-group mb-3">
                            <label for="alamat">Alamat Lengkap : </label>
                            <div class="row gx-2">
                                <div class="col-md-6 mb-2">
                                    <input type="text" class="form-control" id="provinsi" name="provinsi"
                                    @if (optional(Auth::user()->updateProfile)->provinsi)
                                    value="{{ optional(Auth::user()->updateProfile)->provinsi }}"
                                    @else
                                    value="Jawa Timur"
                                    @endif
                                     readonly>
                                </div>
                                <div class="col-md-6 mb-2">
                                    <select class="form-control" id="district" name="district">
                                        <option value="" disabled {{ optional(Auth::user()->updateProfile)->kabupaten ? '' : 'selected' }}>
                                            Pilih Kabupaten
                                        </option>
                                        @if (optional(Auth::user()->updateProfile)->kabupaten)
                                            <option value="{{ optional(Auth::user()->updateProfile)->kabupaten }}">
                                                {{ optional(Auth::user()->updateProfile)->kabupaten }}
                                            </option>
                                        @else
                                            <option value="KABUPATEN BANYUWANGI">
                                                Kabupaten Banyuwangi
                                            </option>
                                        @endif
                                    </select>
                                </div>                                
                                
                                <div class="col-md-6 mb-2">
                                    <select class="form-control" id="sub_district" name="sub_district">
                                        <option value=""
                                            {{ optional(Auth::user()->updateProfile)->kecamatan ? '' : 'selected' }} disabled>Pilih Kecamatan
                                        </option>
                                        @foreach ($kecamatan as $kec)
                                            <option value="{{ $kec->name }}" data-code="{{ $kec->code }}"
                                                {{ $kec->name === optional(Auth::user()->updateProfile)->kecamatan ? 'selected' : '' }}>
                                                {{ $kec->name }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="col-md-6 mb-2">
                                    <select name="desa" id="desa" class="form-control">
                                        <option value="" disabled
                                            {{ empty(optional(Auth::user()->updateProfile)->desa) ? 'selected' : '' }}>Pilih Desa
                                        </option>
                                        <option value="{{ optional(Auth::user()->updateProfile)->desa }}" selected>
                                            {{ optional(Auth::user()->updateProfile)->desa }}
                                        </option>
                                    </select>
                                </div>
                                
                                <div class="col-md-6 mb-2">
                                    <input type="text" class="form-control" id="dusun" name="dusun"
                                        value="{{ optional(Auth::user()->updateProfile)->dusun }}" placeholder="Dusun">
                                </div>
                                <div class="col-md-6 mb-2">
                                    <input type="text" class="form-control" id="rt" name="rt"
                                        value="{{ optional(Auth::user()->updateProfile)->rt }}" placeholder="RT">
                                </div>
                                <div class="col-md-6 mb-2">
                                    <input type="text" class="form-control" id="rw" name="rw"
                                        value="{{ optional(Auth::user()->updateProfile)->rw }}" placeholder="RW">
                                </div>
                                <div class="col-md-6 mb-2">
                                    <input type="text" class="form-control" id="kode_pos" name="kode_pos"
                                        value="{{ optional(Auth::user()->updateProfile)->code_pos }}" placeholder="Kode Pos">
                                </div>
                                
                            </div>
                        </div>

                        <button type="submit" class="btn btn-primary">Update Profil</button>
                    </form>
                </div>
            </div>
        </div>
    </div>


    @include('components.foot')
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
@endsection
