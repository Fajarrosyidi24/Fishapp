@extends('layouts.app')
@section('title')
    <title>Form-Registrasi Page - Fishapp</title>

    <style>
        .custom-title {
            font-size: 2rem;
            /* Sesuaikan ukuran font sesuai kebutuhan */
            font-weight: bold;
            /* Opsional: membuat font menjadi tebal */
        }
    </style>
@endsection

@section('content')
    <div class="container mt-5 mb-5">
        <div class="row justify-content-center">
            <div class="col-md-8 col-lg-6">
                <form action="{{ route('post_form_pendaftaran_nelayan') }}" method="POST" class="shadow p-4 rounded bg-white"
                    enctype="multipart/form-data">
                    <h1 class="text-center mb-4">Formulir Pendaftaran Nelayan</h1>
                    @csrf

                    <!-- Nama Lengkap -->
                    <div class="form-group mb-3">
                        <label for="nama">Nama Lengkap</label>
                        <input type="text" class="form-control" id="nama" name="name" required
                            placeholder="Masukkan nama lengkap Anda">
                    </div>

                    <!-- Jenis Kelamin -->
                    <div class="form-group mb-3">
                        <label for="jenis_kelamin">Jenis Kelamin</label>
                        <select class="form-control" id="jenis_kelamin" name="jenis_kelamin" required>
                            <option value="" disabled selected>Pilih Jenis Kelamin</option>
                            <option value="Laki-laki">Laki-laki</option>
                            <option value="Perempuan">Perempuan</option>
                        </select>
                    </div>

                    <!-- Tempat dan Tanggal Lahir -->
                    <div class="form-group mb-3">
                        <label for="tempat_lahir">Tempat Lahir</label>
                        <input type="text" class="form-control" id="tempat_lahir" name="tempat_lahir" required
                            placeholder="Masukkan tempat lahir Anda">
                    </div>
                    <div class="form-group mb-3">
                        <label for="tanggal_lahir">Tanggal Lahir</label>
                        <input type="date" class="form-control" id="tanggal_lahir" name="tanggal_lahir" required>
                    </div>

                    <!-- Alamat Lengkap -->
                    <div class="form-group mb-3">
                        <label for="alamat">Alamat Lengkap</label>
                        <div class="row gx-2">
                            <div class="col-md-6 mb-2">
                                <select class="form-control" id="district" name="district" required>
                                    <option value="" disabled selected>Pilih Kabupaten</option>
                                    <option value="Banyuwangi">Banyuwangi</option>
                                </select>
                            </div>
                            <div class="col-md-6 mb-2">
                                <select class="form-control" id="sub_district" name="sub_district" required>
                                    <option value="" disabled selected>Pilih Kecamatan</option>
                                    @foreach ($kecamatan as $kec)
                                        <option value="{{ $kec->name }}" data-code="{{ $kec->code }}">
                                            {{ $kec->name }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-md-6 mb-2">
                                <select name="desa" id="desa" class="form-control" required>
                                    <option value="" disabled selected>Pilih Desa</option>
                                </select>
                            </div>
                            <div class="col-md-6 mb-2">
                                <input type="text" class="form-control" id="dusun" name="dusun" placeholder="Dusun"
                                    required>
                            </div>
                            <div class="col-md-6 mb-2">
                                <input type="text" class="form-control" id="rt" name="rt" placeholder="RT"
                                    required>
                            </div>
                            <div class="col-md-6 mb-2">
                                <input type="text" class="form-control" id="rw" name="rw" placeholder="RW"
                                    required>
                            </div>
                            <div class="col-md-12 mb-2">
                                <input type="text" class="form-control" id="kode_pos" name="kode_pos"
                                    placeholder="Kode Pos" required>
                            </div>
                        </div>
                    </div>

                    <!-- Kontak: Email dan Nomor Telepon -->
                    <div class="form-group mb-3">
                        <label for="email">Email</label>
                        <input type="email" class="form-control" id="email" name="email" required
                            placeholder="Masukkan email Anda">
                    </div>
                    <div class="form-group mb-3">
                        <label for="no_telepon">Nomor Telepon</label>
                        <input type="tel" class="form-control" id="no_telepon" name="no_telepon" required
                            placeholder="Masukkan nomor telepon Anda">
                    </div>

                    <!-- Informasi Kapal -->
                    <div class="form-group mb-3">
                        <h5>Informasi Kapal dan ABK</h5>
                        <label for="nama_kapal">Nama Kapal</label>
                        <input type="text" class="form-control" id="nama_kapal" name="nama_kapal" required
                            placeholder="Masukkan nama kapal">
                    </div>
                    <div class="form-group mb-3">
                        <label for="jenis_kapal">Jenis Kapal</label>
                        <input type="text" class="form-control" id="jenis_kapal" name="jenis_kapal" required
                            placeholder="Masukkan jenis kapal">
                    </div>
                    <div class="form-group mb-3">
                        <label for="jumlah_abk">Jumlah ABK</label>
                        <input type="number" class="form-control" id="jumlah_abk" name="jumlah_abk" min="0"
                            required placeholder="Masukkan jumlah ABK">
                    </div>

                    <!-- Upload Pas Foto -->
                    <div class="form-group mb-3">
                        <label for="pas_foto">Upload Pas Foto (JPG/PNG)</label>
                        <input type="file" class="form-control" id="pas_foto" name="pas_foto"
                            accept=".jpg, .jpeg, .png" required>
                    </div>

                    <!-- Pernyataan Data -->
                    <div class="form-group form-check mb-3">
                        <input type="checkbox" class="form-check-input" id="data_confirmation" required>
                        <label class="form-check-label" for="data_confirmation" style="font-size: 0.85rem;">
                            Dengan ini, saya menyatakan bahwa data yang saya inputkan adalah benar, akurat, dan sesuai
                            dengan keadaan yang sebenarnya.
                            Saya bertanggung jawab sepenuhnya atas informasi yang saya berikan dan menyadari bahwa informasi
                            yang tidak benar dapat berakibat pada penolakan pendaftaran saya.
                            Dengan mengklik tombol ini, saya menyetujui atas persyaratan yang ada.
                        </label>
                    </div>

                    <button type="submit" class="btn btn-primary w-100 mt-3" id="submitButton" disabled>Daftar</button>
                </form>
            </div>
        </div>
    </div>


    {{-- composer require laravolt/indonesia  
php artisan vendor:publish --provider="Laravolt\Indonesia\ServiceProvider"     
php artisan laravolt:indonesia:seed --}}


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
        // Ambil elemen checkbox dan tombol submit
        const checkbox = document.getElementById('data_confirmation');
        const submitButton = document.getElementById('submitButton');

        // Tambahkan event listener untuk checkbox
        checkbox.addEventListener('change', function() {
            // Aktifkan tombol jika checkbox dicentang, nonaktifkan jika tidak
            submitButton.disabled = !checkbox.checked;
        });
    </script>
@endsection
