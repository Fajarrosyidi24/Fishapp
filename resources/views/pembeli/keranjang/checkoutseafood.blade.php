@extends('layouts.app')
@section('title')
    <title>Checkout Page - Fishapp</title>
    <style>
        .harga {
            font-weight: bold;
            color: black;
        }
    </style>
@endsection


@section('content')
<div class="container my-5">
    <div class="row justify-content-start">
        <!-- Shipping Address Section -->
        <div class="col-lg-8 mb-4">
            <div class="card p-4 shadow-sm border-0">
                <div class="d-flex justify-content-between align-items-center mb-3">
                    <h6 class="mb-0 text-muted">Alamat Pengiriman</h6>
                    <a href="{{ route('alamat.pengiriman.pembeli') }}" class="text-danger fw-bold">Ubah alamat</a>
                </div>
                <hr style="border: 0; border-top: 2px solid #ddd; margin: 0 0 10px;">
                <form id="shippingAddressForm">
                    @foreach ($alamat as $index => $item)
                    <div class="form-check mb-3">
                        <input class="form-check-input" type="radio" name="selected_address"
                            id="address_{{ $index }}" value="{{ $item->id }}" {{ $loop->first ? 'checked' : '' }}>
                            <label class="form-check-label" for="address_{{ $index }}">
                                <div>
                                    <strong>{{ Auth::user()->name }} <span style="margin-left:10px;">{{ (Auth::user()->updateProfile)->no_telepon }}</span></strong>
                                </div>
                                <div>
                                    {{ $item->kecamatan }}, {{ $item->kabupaten }}, {{ $item->provinsi }}
                                </div>
                                <div>
                                    Desa {{ $item->desa }}, Dusun {{ $item->dusun }},  RT {{ $item->rt }} / RW {{ $item->rw }}, Kode Pos: {{ $item->code_pos }}
                                </div>
                            </label>
                        </div>
                        @endforeach
                    </form>
                </div>
            </div>

        <!-- Checkout Section -->
        <div class="col-lg-8">
            @if (!empty($groupedCosts) && count($groupedCosts) > 0)
            @foreach ($groupedCosts as $group)
            <div class="card p-4 mb-4 shadow-sm border-0">
                <div class="mb-3" style="text-align: right;">
                    <h6 class="mb-0 text-muted" style="font-size: 12px;">Dikemas oleh <span style="font-weight: bold; font-size: 16px; color: black;">{{ $group['keranjangs'][0]->seafood->nelayan->name }}</span></h6>
                <!-- <a href="{{ route('hubungi.penjual.seafood', ['id' => $group['keranjangs'][0]->seafood->nelayan->detailProfile->no_telepon]) }}"
                        class="text-success fw-bold">
                        Hubungi Penjual
                    </a> -->
                </div>
                <hr style="border: 0; border-top: 2px solid #ddd; margin: 0 0 10px;">
                @foreach ($group['keranjangs'] as $item)
                <div class="d-flex align-items-center mb-3">
                    <img src="{{ asset('storage/fotoseafood/' . $item->seafood->foto) }}"
                        alt="{{ $item->seafood->nama }}" width="100" class="rounded me-3">
                        <div style="display: flex; justify-content: space-between; align-items: center; flex-wrap: wrap;">
                            <div style="flex: 1; min-width: 300px;">
                                <h5 class="mb-1" style="font-size: 26px;" data-kode-seafood="{{ $item->kode_keranjang }}">
                                    {{ $item->seafood->nama }}
                                </h5>
                                <p class="mb-1 text-muted" style="font-size: 14px;">
                                    <td>Jumlah Pesanan:</td> {{ $item['jumlah'] }} KG
                                </p>
                            </div>
                            <p class="mb-1" style="margin: 0; font-size: 20px; color: #097ABA; font-weight: bold; text-align: right;">
                                {{ number_format($item->seafood->harga->harga, 0, ',', '.') }}
                            </p>
                        </div>
                        <!-- <p class="mb-0 text-muted" style="text-align: end;">
                            <strong>Sub Total:</strong> RP
                            <span id="itemTotalPrice_{{ $group['nelayan_id'] }}">
                                {{ number_format($item['subtotal'], 0, ',', '.') }}
                            </span>
                        </p> -->
                </div>
                @endforeach
                <hr style="border: 0; border-top: 2px solid #ddd; margin: 0 0 15px 0;">
                <!-- opsi pengiriman -->
                 <!-- tampilan lama -->
                <div>
                    <label for="shippingOption_{{ $group['nelayan_id'] }}" class="fw-bold">Pilih Opsi Pengiriman:</label>
                    <select class="form-select" name="shippingOption" id="shippingOption_{{ $group['nelayan_id'] }}">
                        <option selected disabled>Pilih Opsi Pengiriman</option>
                        @foreach ($group['shipping_options'] as $index => $option)
                        <option value="{{ $option['cost'] }}" data-cost="{{ $option['cost'] }}">
                            {{ $option['service'] }} - {{ $option['courier'] }} - Biaya: RP
                            {{ number_format($option['cost'], 0, ',', '.') }} - ({{$option['etd']}} Hari)
                        </option>
                        @endforeach
                    </select>
                </div>
                <!-- Tampilan Baru -->
                <!-- <div class="card">
                <div class="card-body">
                    <label for="shippingOption_{{ $group['nelayan_id'] }}" class="fw-bold">Pilih Opsi Pengiriman:</label>
                    <div class="row">
                    @foreach ($group['shipping_options'] as $index => $option)
                        <div class="col-md-6 mb-3">
                        <div class="card">
                            <div class="card-body">
                            <div class="form-check">
                                <input class="form-check-input" type="radio" name="shippingOption_{{ $group['nelayan_id'] }}" id="shippingOption_{{ $group['nelayan_id'] }}_{{ $index }}" 
                                value="{{ $option['cost'] }}" data-cost="{{ $option['cost'] }}">
                                <label class="form-check-label" for="shippingOption_{{ $group['nelayan_id'] }}_{{ $index }}">
                                {{ $option['service'] }} - {{ $option['courier'] }} - Biaya: RP {{ number_format($option['cost'], 0, ',', '.') }} - ({{$option['etd']}} Hari)
                                </label>
                            </div>
                            </div>
                        </div>
                        </div>
                    @endforeach
                    </div>
                </div>
                </div> -->
            </div>
            @endforeach
            @else
            <p>Data tidak tersedia.</p>
            @endif
        </div>

         <!-- Detail Pesanan Section -->
         <div class="card p-4 col-lg-4">
                <div class="row justify-content-end">

                    <form action="{{ route('pesanan.submit') }}" method="POST" id="submitke2">
                        @csrf
                        <input type="hidden" name="grouppesanan" id="grouppesanan" style="display: none">
                        <h5 class="fw-bold text-start">Detail Pesanan</h5> 
                        <!-- tampilan lama -->
                        <div class="mb-3">
                            <label for="subtotalProduk" class="d-block text-end">Sub Total (0 Produk) 
                                <span id="itemTotalPrice_{{ $group['nelayan_id'] }}">
                                    {{ number_format($item['subtotal'], 0, ',', '.') }}
                                </span>
                            </label>
                            <input type="text" id="subtotalProduk" class="form-control text-end" readonly name="subtotalProduk">
                            
                        </div>
                        <div class="mb-3">
                            <label for="totalShipping" class="d-block text-end">Sub Total Pengiriman:</label>
                            <input type="text" id="totalShipping" class="form-control text-end" readonly name="totalShipping">
                        </div>
                        <div class="mb-3">
                            <label for="adminFee" class="d-block text-end">Biaya Admin:</label>
                            <input type="text" id="adminFee" class="form-control text-end" value="RP 5000" readonly name="adminFee">
                        </div>
                        <div class="mb-3">
                            <label for="totalPayment" class="d-block text-end">Total Pembayaran:</label>
                            <input type="text" id="totalPayment" class="form-control text-end" readonly name="totalPayment">
                        </div>
                        
                        <!-- tampilan baru -->
                        <!-- <div class="invoice-summary">
                            <div class="row">
                                <div class="col-md-6">
                                    <p>Subtotal (1 produk)</p>
                                </div>
                                <div class="harga col-md-6 text-end">
                                    <p>Rp26.086</p>
                                </div>
                            </div>
                            <div class="row">
                                <div class=" col-md-6">
                                    <p>Ongkir</p>
                                </div>
                                <div class="harga col-md-6 text-end">
                                    <p>Rp23.000</p>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <p>Biaya Layanan</p>
                                </div>
                                <div class="harga col-md-6 text-end">
                                    <p>Rp1.000</p>
                                </div>
                            </div>
                            <hr style="border: 0; border-top: 2px solid #ddd; margin: 0 0 15px 0;">
                            <div class="row">
                                <div class="col-md-6">
                                    <p style="color: black; font-weight: bold;">Total :</p>
                                </div>
                                <div class="harga col-md-6 text-end">
                                    <p style="color: #097ABA;">Rp1.000</p>
                                </div>
                            </div> -->
                    </div>
                    
                    <div class="text-center">
                        <p class="fw-bold" style="font-size:12px;">
                            Dengan melanjutkan, Saya setuju dengan
                            <a href="#" class="text-decoration-none text-primary">Syarat & Ketentuan</a> yang berlaku.
                        </p>
                    </div>
                    <div class="d-grid mt-3">
                        <button type="submit" class="btn btn-success fw-bold" id="submitOrderButton" disabled> Buat Pesanan</button>
                    </div>
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
            let subtotalProduk = 0;
            document.querySelectorAll('[id^="itemTotalPrice_"]').forEach(function(element) {
                const subtotal = parseInt(element.innerText.replace(/\D/g, ''));
                if (!isNaN(subtotal)) {
                    subtotalProduk += subtotal;
                }
            });
            const formattedSubtotal = new Intl.NumberFormat('id-ID', {
                style: 'currency',
                currency: 'IDR',
                minimumFractionDigits: 0
            }).format(subtotalProduk);
            document.getElementById('subtotalProduk').value = formattedSubtotal;
        });
    </script>
    <script>
        document.addEventListener("DOMContentLoaded", () => {
            // Get all shipping option dropdowns
            const shippingDropdowns = document.querySelectorAll("select[name='shippingOption']");
            const totalShippingInput = document.getElementById("totalShipping");

            let totalShippingCost = 0;

            // Function to update total shipping cost
            const updateTotalShipping = () => {
                totalShippingCost = 0; // Reset total cost
                shippingDropdowns.forEach((dropdown) => {
                    const selectedOption = dropdown.options[dropdown.selectedIndex];
                    if (selectedOption && selectedOption.dataset.cost) {
                        totalShippingCost += parseInt(selectedOption.dataset.cost, 10);
                    }
                });
                totalShippingInput.value = `RP ${totalShippingCost.toLocaleString('id-ID')}`;
            };

            // Add event listeners to each dropdown
            shippingDropdowns.forEach((dropdown) => {
                dropdown.addEventListener("change", updateTotalShipping);
            });
            // Initialize the total shipping cost on page load
            updateTotalShipping();
        });
    </script>
    <script>
        document.addEventListener("DOMContentLoaded", () => {
            // Ambil elemen input
            const subtotalPaymentInput = document.getElementById("subtotalProduk");
            const totalShippingInputs = document.querySelectorAll('[id^="shippingOption_"]');
            const adminFeeInput = document.getElementById("adminFee"); // Input untuk Biaya Admin
            const totalPaymentInput = document.getElementById("totalPayment");

            // Function untuk menghitung total biaya pengiriman
            const calculateTotalShipping = () => {
                let totalShipping = 0;
                totalShippingInputs.forEach((select) => {
                    const selectedOption = select.options[select.selectedIndex];
                    if (selectedOption && selectedOption.dataset.cost) {
                        totalShipping += parseInt(selectedOption.dataset.cost, 10) || 0;
                    }
                });
                return totalShipping;
            };

            // Function untuk menghitung total pembayaran
            const updateTotalPayment = () => {
                const subtotal = parseInt(subtotalPaymentInput.value.replace(/\D/g, ""), 10) || 0;
                const totalShipping = calculateTotalShipping();
                const adminFee = parseInt(adminFeeInput.value.replace(/\D/g, ""), 10) || 0;

                const totalPayment = subtotal + totalShipping + adminFee;

                totalPaymentInput.value = `RP ${totalPayment.toLocaleString("id-ID")}`;
            };

            // Event listener untuk perubahan pada shipping options
            totalShippingInputs.forEach((select) => {
                select.addEventListener("change", updateTotalPayment);
            });

            // Event listener untuk perubahan pada admin fee atau subtotal (jika diperlukan)
            [subtotalPaymentInput, adminFeeInput].forEach((input) => {
                input.addEventListener("input", updateTotalPayment);
            });

            // Inisialisasi awal
            updateTotalPayment();
        });
    </script>
    <script>
        document.addEventListener("DOMContentLoaded", () => {
            const totalShippingInputs = document.querySelectorAll('[id^="shippingOption_"]');
            const submitOrderButton = document.getElementById("submitOrderButton");

            // Fungsi untuk memeriksa apakah semua shipping option sudah dipilih
            const areAllShippingOptionsSelected = () => {
                return Array.from(totalShippingInputs).every((select) => {
                    const selectedOption = select.options[select.selectedIndex];
                    return selectedOption && selectedOption.dataset.cost;
                });
            };

            // Fungsi untuk memperbarui status tombol
            const updateButtonState = () => {
                if (areAllShippingOptionsSelected()) {
                    submitOrderButton.removeAttribute("disabled");
                } else {
                    submitOrderButton.setAttribute("disabled", "true");
                }
            };

            // Event listener untuk perubahan pada shipping options
            totalShippingInputs.forEach((select) => {
                select.addEventListener("change", updateButtonState);
            });

            // Event listener untuk perubahan pada opsi pembayaran
            paymentOption.addEventListener("change", updateButtonState);

            // Inisialisasi awal
            updateButtonState();
        });
    </script>

<script>
    document.addEventListener("DOMContentLoaded", () => {
        // Ambil elemen input grouppesanan
        const grouppesananInput = document.getElementById("grouppesanan");

        // Ambil semua elemen select untuk opsi pengiriman
        const shippingSelects = document.querySelectorAll('[id^="shippingOption_"]');

        // Function untuk mengumpulkan data opsi pengiriman yang dipilih
        const updateGroupPesanan = () => {
            let selectedShippingOptions = {};

            // Loop melalui setiap select shippingOption_
            shippingSelects.forEach((select) => {
                const selectedOption = select.options[select.selectedIndex];
                if (selectedOption && selectedOption.value) {
                    // Ambil data dari ID select (menggunakan bagian terakhir dari ID sebagai nelayan_id)
                    const nelayanId = select.id.split("_")[1];
                    const cost = selectedOption.dataset.cost || "0";
                    const text = selectedOption.textContent.trim();

                    // Ambil container card terdekat
                    const cardElement = select.closest(".card");

                    // Ambil nama seafood dan kode_seafood terkait
                    const seafoodData = Array.from(
                        cardElement.querySelectorAll("[data-kode-seafood]")
                    ).map((element) => {
                        const name = element.textContent.trim();
                        const kode = element.dataset.kodeSeafood; // Ambil kode_seafood dari atribut data
                        return `${name} = ${kode}`;
                    });

                    // Simpan data ke dalam object dengan tambahan nama seafood dan kode_seafood
                    selectedShippingOptions[nelayanId] = `${text} - Biaya: RP ${parseInt(cost, 10).toLocaleString("id-ID")} - [${seafoodData.join(", ")}]`;
                }
            });

            // Konversi data ke format teks yang dapat dikirimkan
            const result = Object.entries(selectedShippingOptions)
                .map(([nelayanId, option]) => `[${nelayanId}] -> ${option};`)
                .join("\n");

            // Masukkan data ke input grouppesanan
            grouppesananInput.value = result;
        };

        // Tambahkan event listener untuk mendeteksi perubahan pada opsi pengiriman
        shippingSelects.forEach((select) => {
            select.addEventListener("change", updateGroupPesanan);
        });

        // Inisialisasi awal untuk mengisi input jika ada opsi yang sudah dipilih
        updateGroupPesanan();
    });
</script>
@endsection
