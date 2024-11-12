<div class="container mb-4">

    <!-- Menampilkan alamat jika ada -->
    @if (!$alamat)
        <!-- Button untuk menambahkan alamat pengiriman -->
        <a href="#" class="btn btn-primary mb-3 mt-5" data-bs-toggle="modal"
            data-bs-target="#productModalCreate">Tambah Alamat Pengiriman</a>
        <p>Anda belum memiliki data alamat. Harap tambahkan alamat pengiriman terlebih dahulu.</p>
    @else
        <div class="container mt-4">
            <h3 class="mb-4">Alamat Pengiriman</h3>
            <div class="list-group">
                <div class="list-group-item list-group-item-action mb-3 p-3 shadow-sm rounded">
                    <div class="d-flex justify-content-between align-items-center">
                        <h5 class="mb-0"><i class="bi bi-geo-alt-fill"></i> {{ $alamat->nelayan->name }}</h5>
                        <span class="badge bg-primary">{{ $alamat->provinsi }}</span>
                    </div>
                    <p class="mt-2">
                        <strong>Alamat Lengkap:</strong><br>
                        {{ $alamat->dusun }}, RT {{ $alamat->rt }}, RW {{ $alamat->rw }}<br>
                        Desa {{ $alamat->desa }}, Kecamatan {{ $alamat->kecamatan }}<br>
                        Kabupaten {{ $alamat->kabupaten }}<br>
                        Kode Pos: {{ $alamat->code_pos }}
                    </p>
                    <div class="d-flex justify-content-between mt-3">
                        <a href="#" class="btn btn-sm btn-warning" data-bs-toggle="modal"
                            data-bs-target="#productModalEdit">Edit</a>
                    </div>
                </div>
            </div>
        </div>
    @endif
</div>

<div class="modal fade" id="productModalCreate" tabindex="-1" aria-labelledby="productModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="productModalLabel" style="color: black">
                    Tambahkan Data Alamat
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form action="{{ route('createalamat.nelayan.seafood') }}" method="POST">
                    @csrf
                    <div class="mb-3">
                        <label class="form-label" style="color: black">Provinsi :</label>
                        <div class="col-sm-10">
                            <select class="form-select" id="provinsiseafood" aria-label="provinsi" name="provinsi" required>
                                <option selected disabled>Pilih</option>
                                @php
                                    $shownProvinces = [];
                                @endphp
                                @foreach ($api as $ci)
                                    @if (!in_array($ci['province'], $shownProvinces))
                                        <option value="{{ $ci['province_id'] }}">{{ $ci['province'] }}</option>
                                        @php
                                            $shownProvinces[] = $ci['province'];
                                        @endphp
                                    @endif
                                @endforeach
                            </select>
                            <small class="text-danger" style="display: none;" id="provinsi-error">Provinsi wajib
                                dipilih.</small>
                        </div>
                    </div>

                    <div id="prov_select">
                        <div class="mb-3">
                            <label class="form-label" style="color: black">Kabupaten :</label>
                            <div class="col-sm-10">
                                <select class="form-select" id="cityseafood" aria-label="city" name="city" required>
                                    <option selected disabled>Pilih</option>
                                </select>
                            </div>
                        </div>
                    </div>

                    <div class="mb-3">
                        <label class="form-label" style="color: black">Kecamatan :</label>
                        <input type="text" class="form-control" name="kecamatan" required>
                    </div>

                    <div class="mb-3">
                        <label class="form-label" style="color: black">Desa :</label>
                        <input type="text" class="form-control" name="desa" required>
                    </div>

                    <div class="mb-3">
                        <label class="form-label" style="color: black">Dusun :</label>
                        <input type="text" class="form-control" name="dusun" required>
                    </div>

                    <div class="mb-3">
                        <label class="form-label" style="color: black">RT :</label>
                        <input type="text" class="form-control" name="rt" pattern="\d+" required>
                    </div>

                    <div class="mb-3">
                        <label class="form-label" style="color: black">RW :</label>
                        <input type="text" class="form-control" name="rw" pattern="\d+" required>
                    </div>

                    <div class="mb-3">
                        <label class="form-label" style="color: black">Kode Pos :</label>
                        <input type="text" class="form-control" name="code_pos" pattern="\d{5}" required>
                    </div>

                    <button type="submit" class="btn btn-sm btn-success">Simpan</button>
                    <a href="#" class="btn btn-sm btn-secondary" data-bs-dismiss="modal">Close</a>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- Modal Edit Alamat -->
<div class="modal fade" id="productModalEdit" tabindex="-1" aria-labelledby="productModalLabel"
    aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="productModalLabel" style="color: black">
                    Edit Data Alamat
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </h5>
            </div>
            <div class="modal-body">
                @if ($alamat)
                    <form action="{{ route('update.data.alamat.pengiriman', ['id' => $alamat->id]) }}"method="POST">
                    @else
                        <p>Alamat tidak ditemukan.</p>
                @endif
                @csrf
                @method('PUT') <!-- Method untuk update data -->

                <div class="mb-3">
                    <label class="form-label" style="color: black">Provinsi :</label>
                    <div class="col-sm-10">
                        <select class="form-select" id="provinsiseafood2" aria-label="provinsi" name="provinsi"
                            required>
                            <option disabled>Pilih</option>
                            @php
                                $shownProvinces = [];
                            @endphp
                            @foreach ($api as $ci)
                                @if (!in_array($ci['province'], $shownProvinces))
                                    <option value="{{ $ci['province_id'] }}"
                                        @if (isset($alamat) && $alamat->provid == $ci['province_id']) selected @endif>
                                        {{ $ci['province'] }}
                                    </option>
                                    @php
                                        $shownProvinces[] = $ci['province'];
                                    @endphp
                                @endif
                            @endforeach
                        </select>
                    </div>
                </div>

                <div id="prov_select">
                    <div class="mb-3">
                        <label class="form-label" style="color: black">Kabupaten :</label>
                        <div class="col-sm-10">
                            <select class="form-select" id="cityseafood2" aria-label="city" name="city" required>
                                <option disabled>Pilih</option>
                                @if (isset($alamat))
                                    <option value="{{ $alamat->kabupaten }}" selected>{{ $alamat->kabupaten }}
                                    </option>
                                @else
                                    <option selected disabled>Pilih Kabupaten</option>
                                @endif
                                </option>
                            </select>
                        </div>
                    </div>
                </div>

                <div class="mb-3">
                    <label class="form-label" style="color: black">Kecamatan :</label>
                    <input type="text" class="form-control" name="kecamatan"
                        value="{{ $alamat->kecamatan ?? '' }}" required>
                </div>

                <div class="mb-3">
                    <label class="form-label" style="color: black">Desa :</label>
                    <input type="text" class="form-control" name="desa" value="{{ $alamat->desa ?? '' }}"
                        required>
                </div>

                <div class="mb-3">
                    <label class="form-label" style="color: black">Dusun :</label>
                    <input type="text" class="form-control" name="dusun" value="{{ $alamat->dusun ?? '' }}"
                        required>
                </div>

                <div class="mb-3">
                    <label class="form-label" style="color: black">RT :</label>
                    <input type="text" class="form-control" name="rt" pattern="\d+"
                        value="{{ $alamat->rt ?? '' }}" required>
                </div>

                <div class="mb-3">
                    <label class="form-label" style="color: black">RW :</label>
                    <input type="text" class="form-control" name="rw" pattern="\d+"
                        value="{{ $alamat->rw ?? '' }}" required>
                </div>

                <div class="mb-3">
                    <label class="form-label" style="color: black">Kode Pos :</label>
                    <input type="text" class="form-control" name="code_pos" pattern="\d{5}"
                        value="{{ $alamat->code_pos ?? '' }}" required>
                </div>


                <button type="submit" class="btn btn-sm btn-success">Simpan</button>
                <a href="#" class="btn btn-sm btn-secondary" data-bs-dismiss="modal">Close</a>
                </form>
            </div>
        </div>
    </div>
</div>
