@extends('layouts.app')
@section('title')
    <title>Checkout Page - Fishapp</title>
@endsection

@section('content')
<div class="container my-5">
    <div class="row justify-content-center">
        <!-- Shipping Address Section -->
        <div class="col-lg-8 mb-4">
            <h4 class="mb-3">Alamat Pengiriman</h4>
            <div class="card p-4 shadow-sm">
                <div class="d-flex justify-content-between align-items-center mb-3">
                    <h6>Alamat Pengiriman</h6>
                    <a href="{{ route('alamat.pengiriman.pembeli') }}" class="text-danger">Ubah/tambahkan alamat pengiriman</a>
                </div>
                @foreach ($alamat as $index => $item)
                    <div class="form-check mb-3">
                        <input class="form-check-input" type="radio" name="selected_address" id="address{{ $index }}" value="{{ $item->id }}" {{ $loop->first ? 'checked' : '' }}>
                        <label class="form-check-label" for="address{{ $index }}">
                            <strong>Alamat Pengiriman:</strong><br>
                            {{ $item->provinsi }}, {{ $item->kabupaten }}, {{ $item->kecamatan }}, {{ $item->desa }}<br>
                            RT {{ $item->rt }} / RW {{ $item->rw }}, Kode Pos: {{ $item->code_pos }}
                        </label>
                    </div>
                @endforeach
            </div>
        </div>

        <!-- Checkout Section -->
        <div class="col-lg-8">
            <h4 class="mb-3">Checkout Seafood</h4>
            @foreach ($groupedCosts as $group)
                <div class="card p-4 mb-3 shadow-sm">
                    <div class="d-flex justify-content-between align-items-center mb-3">
                        <h6>Penjual: {{ $group['keranjangs'][0]->seafood->nelayan->name }}</h6>
                        <a href="{{ route('hubungi.penjual.seafood', ['id' => $group['keranjangs'][0]->seafood->nelayan->detailProfile->no_telepon]) }}" class="text-success">Hubungi Penjual</a>
                    </div>

                    @foreach ($group['keranjangs'] as $item)
                        <div class="d-flex mb-3">
                            <div class="m-4">
                                <img src="{{ asset('storage/fotoseafood/' . $item->seafood->foto) }}" alt="{{ $item->seafood->nama }}" width="100" class="rounded">
                            </div>
                            <div class="flex-grow-1 ml-3">
                                <h5>{{ $item->seafood->nama }}</h5>
                                <p class="mb-2"><strong>Harga Satuan:</strong> RP {{ number_format($item->seafood->harga->harga, 0, ',', '.') }}</p>
                                <p class="mb-2"><strong>Jumlah Pesanan:</strong> {{ $item['jumlah'] }} KG</p>
                                <p class="mb-2"><strong>Total Harga:</strong> RP <span id="itemTotalPrice{{ $group['nelayan_id'] }}">{{ number_format($item['subtotal'], 0, ',', '.') }}</span></p>
                            </div>
                        </div>
                    @endforeach

                    <div class="mb-3">
                        <label for="opsipengiriman{{ $group['nelayan_id'] }}">Pilih Opsi Pengiriman:</label>
                        <select class="form-select" name="opsipengiriman" id="opsipengiriman{{ $group['nelayan_id'] }}">
                            <option selected disabled>Pilih Opsi Pengiriman</option>
                            @foreach ($group['shipping_options'] as $index => $option)
                                <option value="{{ $option['cost'] }}" data-cost="{{ $option['cost'] }}">
                                    {{ $option['service'] }} - {{ $option['courier'] }} - Biaya: RP {{ number_format($option['cost'], 0, ',', '.') }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <!-- Payment Method Selection -->
                    <div class="mb-3">
                        <label for="paymentMethod">Pilih Metode Pembayaran:</label>
                        <select class="form-select" name="paymentMethod" id="paymentMethod">
                            <option selected disabled>Pilih Metode Pembayaran</option>
                            <option value="bank_transfer">Transfer Bank</option>
                            <option value="cod">COD</option>
                        </select>
                    </div>

                    <!-- Total Payment Calculation -->
                    <div class="mb-3">
                        <label for="ongkosKirim{{ $group['nelayan_id'] }}">Ongkos Kirim:</label>
                        <input type="text" id="ongkosKirim{{ $group['nelayan_id'] }}" class="form-control" readonly value="RP 0">
                    </div>
                    <div class="mb-3">
                        <label for="biayaAdmin{{ $group['nelayan_id'] }}">Biaya Admin:</label>
                        <input type="text" id="biayaAdmin{{ $group['nelayan_id'] }}" class="form-control" readonly value="RP 1000">
                    </div>
                    <div class="mb-3">
                        <label for="totalHarga{{ $group['nelayan_id'] }}">Sub Total Harga yang Harus Dibayarkan:</label>
                        <input type="text" id="totalHarga{{ $group['nelayan_id'] }}" class="form-control" readonly value="RP 1000">
                    </div>
                </div>
            @endforeach
        </div>

        <!-- Total Pesanan Form -->
        <div class="col-lg-8">
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title">Detail Pesanan</h5>

                    <!-- Form untuk Total Pesanan dan Button -->
                </div>
            </div>
        </div>
    </div>
</div>

    @include('components.foot')
@endsection

@section('foot')
<script>
    // Mengupdate nilai totalPesananSeafood dengan akumulasi subtotal dari semua pengiriman
document.querySelectorAll('select[id^="opsipengiriman"]').forEach(select => {
    select.addEventListener('change', function () {
        let grandTotal = 0;

        const nelayanId = this.id.replace('opsipengiriman', '');  // Ambil id nelayan dari id select

        // Ambil ongkos kirim dari opsi yang dipilih
        const selectedOption = this.options[this.selectedIndex];
        const shippingCost = parseInt(selectedOption.getAttribute('data-cost'));

        // Biaya Admin tetap (misalnya RP 1000)
        const biayaAdmin = 1000;

        // Menghitung total harga dari semua item dalam grup ini
        let totalItemPrice = 0;
        const itemTotalPriceElements = document.querySelectorAll(`#itemTotalPrice${nelayanId}`);
        
        itemTotalPriceElements.forEach(itemTotalPriceElement => {
            const itemPrice = parseInt(itemTotalPriceElement.textContent.replace('RP', '').replace(/\./g, '').trim()); // Mengambil harga item dan menghapus 'RP' dan titik
            totalItemPrice += itemPrice; // Menambahkan harga item ke total
        });

        // Hitung Sub Total Harga yang Harus Dibayarkan (Total Harga + Ongkir + Admin)
        const subTotalHarga = totalItemPrice + shippingCost + biayaAdmin;

        // Update Sub Total Harga yang Harus Dibayarkan
        const totalHargaInput = document.getElementById(`totalHarga${nelayanId}`);
        totalHargaInput.value = new Intl.NumberFormat('id-ID', { style: 'currency', currency: 'IDR' }).format(subTotalHarga);
    });
});

// Trigger perubahan saat halaman dimuat
document.addEventListener('DOMContentLoaded', function () {
    document.querySelectorAll('select[id^="opsipengiriman"]').forEach(select => {
        select.dispatchEvent(new Event('change'));  // Trigger 'change' event untuk update harga saat halaman dimuat
    });
});

</script>
@endsection
