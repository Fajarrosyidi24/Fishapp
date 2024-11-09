@extends('layouts.app')

@section('title')
    <title>Alamat Pengiriman Page - Fishapp</title>
@endsection

@section('content')
<div class="container">

    <!-- Menampilkan alamat jika ada -->
    @if($alamat->isEmpty())
    <!-- Button untuk menambahkan alamat pengiriman -->
    <a href="#" class="btn btn-primary mb-3 mt-5" data-bs-toggle="modal" data-bs-target="#productModalCreate">Tambah Alamat Pengiriman</a>
        <p>Anda belum memiliki data alamat. Harap tambahkan alamat pengiriman terlebih dahulu.</p>
    @else
    <div class="container mt-4">
        <h3 class="mb-4">Daftar Alamat Pengiriman</h3>
        <div class="list-group">
            @foreach($alamat as $item)
                <div class="list-group-item list-group-item-action mb-3 p-3 shadow-sm rounded">
                    <div class="d-flex justify-content-between align-items-center">
                        <h5 class="mb-0"><i class="bi bi-geo-alt-fill"></i> {{ $item->user->name }}</h5>
                        <span class="badge bg-primary">{{ $item->provinsi }}</span>
                    </div>
                    <p class="mt-2">
                        <strong>Alamat Lengkap:</strong><br>
                        {{ $item->dusun }}, RT {{ $item->rt }}, RW {{ $item->rw }}<br>
                        Desa {{ $item->desa }}, Kecamatan {{ $item->kecamatan }}<br>
                        Kabupaten {{ $item->kabupaten }}<br>
                        Kode Pos: {{ $item->code_pos }}
                    </p>
                    <div class="d-flex justify-content-between mt-3">
                        <form action="{{route('delete.alamat.seafood', ['id'=>$item->id])}}" method="POST" class="d-inline">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('Apakah Anda yakin ingin menghapus alamat ini?')">
                                <i class="bi bi-trash-fill"></i> Hapus
                            </button>
                        </form>
                    </div>
                </div>
            @endforeach
        </div>
    </div>    
    @endif
</div>

<div class="modal fade" id="productModalCreate" tabindex="-1"
    aria-labelledby="productModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="productModalLabel" style="color: black">
                    Tambahkan Data Alamat
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form action="{{route('createalamat.pembeli.seafood')}}" method="POST">
                    @csrf
                    <div class="mb-3">
                        <label class="form-label" style="color: black">Provinsi :</label>
                        <div class="col-sm-10">
                            <select class="form-select" id="provinsi" aria-label="provinsi" name="provinsi" required>
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
                            <small class="text-danger" style="display: none;" id="provinsi-error">Provinsi wajib dipilih.</small>
                        </div>
                    </div>
                
                    <div id="prov_select">
                        <div class="mb-3">
                            <label class="form-label" style="color: black">Kabupaten :</label>
                            <div class="col-sm-10">
                                <select class="form-select" id="city" aria-label="city" name="city" required>
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

    @include('components.foot')
@endsection


@section('foot')
<script>
    document.getElementById('provinsi').addEventListener('change', function() {
        var selectedProvinsi = this.value;
        var citySelect = document.getElementById('city');
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