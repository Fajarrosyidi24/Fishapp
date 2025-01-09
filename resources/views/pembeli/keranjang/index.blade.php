@extends('layouts.app')
@section('title')
    <title>Keranjang Page - Fishapp</title>
    <style>
        .cart-item {
            border: 1px solid #ddd;
            padding: 15px;
            margin-bottom: 10px;
            border-radius: 5px;
            background-color: #fff;
            display: flex;
            align-items: center;
        }

        .cart-item .checkbox {
            margin-right: 15px;
        }

        .cart-item .image img {
            max-width: 100px;
            border-radius: 5px;
        }

        .cart-item .details {
            flex-grow: 1;
        }

        .cart-item .quantity {
            display: flex;
            align-items: center;
        }

        .cart-item .quantity input {
            width: 50px;
            text-align: center;
        }

        .cart-item .quantity button {
            width: 30px;
            height: 30px;
            line-height: 1;
            padding: 0;
        }

        .cart-summary {
            border: 1px solid #ddd;
            padding: 15px;
            border-radius: 5px;
            text-align: right;
            background-color: #fff;
        }

        .cart-summary h5 {
            margin-bottom: 15px;
        }

        .col-md-8 {
            background-color: #fff;
            border: 1px solid #ddd;
        }
    </style>
@endsection

@section('content')
    <div class="container mt-5 mb-5">
        <div class="row">
            <div class="col-md-8">
                <h1>Keranjang Seafoods</h1>
                <div class="d-flex justify-content-between align-items-center mb-3"
                    style="background-color: white; border: 1px solid #ddd;">
                    <div>
                        <input type="checkbox" id="select-all" style="cursor: pointer;">
                        <label for="select-all">Pilih Semua</label>
                        <span>(<span id="item-count">0</span>)</span>
                    </div>
                    <div style="cursor: pointer;">
                        <a href="#" id="delete-selected" class="text-danger">Hapus</a>
                    </div>
                </div>

                @foreach ($keranjang as $item)
                    <div class="cart-item d-flex" data-id="{{ $item->kode_keranjang }}">
                        <div class="checkbox">
                            <input type="checkbox" class="item-checkbox">
                        </div>
                        <div class="image">
                            <img src="{{ asset('storage/fotoseafood/' . $item->seafood->foto) }}"
                                alt="{{ $item->seafood->nama }}" width="100">
                        </div>
                        <div class="details flex-grow-1 ml-3" style="margin-left: 20px;">
                            <h5>{{ $item->seafood->nama }}</h5>
                            <p>Rp. <span class="harga-item">{{ number_format($item->subtotal, 0, ',', '.') }}</span></p>
                            <div class="quantity d-flex align-items-center">
                                <label for="item">jumlah(KG) :</label>
                                <input type="text" class="form-control form-control-sm mx-2 input-jumlah"
                                    value="{{ $item->jumlah }}" style="width: 50px;" readonly>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>

            <div class="col-md-4">
                <div class="cart-summary">
                    <h5>Ringkasan Pembelian Seafoods</h5>
                    <p>Sub Total Harga: Rp. <span id="total">{{ number_format($total, 0, ',', '.') }}</span></p>
                    <button id="checkout-button" class="btn btn-primary btn-block">Checkout (0)</button>
                </div>
            </div>

            <form id="checkout-form" action="{{ route('checkout.route') }}" method="POST" style="display: none">
                @csrf
                <input type="hiden" name="items" id="selected-items">
                <input type="hiden" name="total" id="total-price">
            </form>

            <form id="delete-selected-form" action="#" method="POST" style="display: none">
                @csrf
                <input type="hiden" name="kodeBarangString" id="kodeBarangStringInput" value="">
            </form>
        </div>
    </div>


    <div class="container mt-5 mb-5">
        <div class="row">
            <div class="col-md-8">
                <h1>Keranjang Barang Sewa</h1>
                <div class="d-flex justify-content-between align-items-center mb-3"
                    style="background-color: white; border: 1px solid #ddd;">
                    <div>
                        <input type="checkbox" id="select-all-sewa" style="cursor: pointer;">
                        <label for="select-all-sewa">Pilih Semua</label>
                        <span>(<span id="item-count-sewa">0</span>)</span>
                    </div>
                    <div style="cursor: pointer;">
                        <a href="#" id="delete-selected-sewa" class="text-danger">Hapus</a>
                    </div>
                </div>

                @foreach ($keranjang2 as $item)
                    <div class="cart-item d-flex" data-id="{{ $item->kode_keranjang_sewa }}">
                        <div class="checkbox">
                            <input type="checkbox" class="item-checkbox-sewa">
                        </div>
                        <div class="image">
                            <img src="{{ asset('storage/fotobarang/' . $item->barang->foto_barang) }}"
                                alt="{{ $item->barang->nama_barang }}" width="100">
                        </div>
                        <div class="details flex-grow-1 ml-3" style="margin-left: 20px;">
                            <h5>{{ $item->barang->nama_barang }}</h5>
                            <p>Rp. <span class="harga-item-sewa">{{ number_format($item->subtotal, 0, ',', '.') }}</span>
                            </p>
                            <div class="quantity d-flex align-items-center">
                                <label for="item">jumlah :</label>
                                <input type="text" class="form-control form-control-sm mx-2 input-jumlah-sewa"
                                    value="{{ $item->jumlah }}" style="width: 50px;" readonly>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>

            <div class="col-md-4">
                <div class="cart-summary">
                    <h5>Ringkasan Penyewaan Barang</h5>
                    <p>Sub Total Harga: Rp. <span id="total-sewa">{{ number_format($total2, 0, ',', '.') }}</span></p>
                    <div class="form-group mt-3">
                        <label for="time">Berapa Jam akan menyewa:</label>
                        <input type="number" name="time" id="time" class="form-control"
                            placeholder="Masukkan jumlah jam">
                    </div>
                    <button id="checkout-button-sewa" class="btn btn-primary btn-block mt-3">Checkout (0)</button>
                </div>
            </div>


            <form id="checkout-form-sewa" action="{{ route('checkout.route2') }}" method="POST" style="display: none">
                @csrf
                <input type="hiden" name="items" id="selected-items-sewa">
                <input type="hiden" name="total" id="total-price-sewa">
                <input type="hiden" name="time" id="time-hidden">
            </form>

            <form id="delete-selected-form-sewa" action="#" method="POST" style="display: none">
                @csrf
                <input type="hiden" name="kodeBarangString" id="kodeBarangStringInput-sewa" value="">
            </form>
        </div>
    </div>


    @include('components.foot')
@endsection

@section('foot')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const selectAll = document.getElementById('select-all');
            const itemCheckboxes = document.querySelectorAll('.item-checkbox');
            const deleteSelected = document.getElementById('delete-selected');
            const itemCount = document.getElementById('item-count');
            const totalPriceElement = document.getElementById('total');
            const checkoutButton = document.getElementById('checkout-button');
            const selectedItemsInput = document.getElementById('selected-items');
            const totalPriceInput = document.getElementById('total-price');
            const kodeBarangStringInput = document.getElementById('kodeBarangStringInput');
            let originalTotal = parseInt(totalPriceElement.textContent.replace(/\D/g, ''), 10);

            // Fungsi untuk mengupdate jumlah item yang dipilih
            function updateItemCount() {
                const checkedItems = document.querySelectorAll('.item-checkbox:checked');
                const checkedCount = checkedItems.length;
                itemCount.textContent = checkedCount;
                deleteSelected.style.pointerEvents = checkedCount > 0 ? 'auto' : 'none';
                deleteSelected.style.color = checkedCount > 0 ? '#dc3545' : '#ccc';

                // Menghitung ulang subtotal jika ada item yang dicentang
                let subtotal = 0;
                let selectedItemCodes = []; // Menyimpan kode item yang dipilih
                checkedItems.forEach(item => {
                    const harga = parseInt(item.closest('.cart-item').querySelector('.harga-item')
                        .textContent.replace(/\D/g, ''), 10);
                    const kodeSeafood = item.closest('.cart-item').dataset
                        .id; // Ambil kode_seafood dari data-id
                    selectedItemCodes.push(kodeSeafood);
                    subtotal += harga;
                });

                // Update total harga di elemen HTML
                totalPriceElement.textContent = checkedCount > 0 ? subtotal.toLocaleString('id-ID') : '0';

                // Update nilai total harga pada input total
                totalPriceInput.value = checkedCount > 0 ? subtotal.toString() : '0';

                // Update jumlah item yang dipilih di tombol checkout
                checkoutButton.textContent = `Checkout (${checkedCount})`;

                // Masukkan kode_seafood yang dipilih ke dalam input selected-items untuk formulir checkout
                selectedItemsInput.value = selectedItemCodes.join(','); // Menggabungkan kode item yang dipilih
            }

            // Fungsi untuk mengupdate input kodeBarangString berdasarkan item yang dipilih
            function updateSelectedItems() {
                const selectedItems = [];
                itemCheckboxes.forEach(checkbox => {
                    if (checkbox.checked) {
                        const kodeSeafood = checkbox.closest('.cart-item').dataset
                            .id; // Ambil kode_seafood dari data-id
                        selectedItems.push(kodeSeafood);
                    }
                });
                // Masukkan kode_seafood yang dipilih ke dalam input
                kodeBarangStringInput.value = selectedItems.join(',');
            }

            // Event listener untuk select all
            selectAll.addEventListener('change', function() {
                itemCheckboxes.forEach(checkbox => {
                    checkbox.checked = selectAll.checked;
                });
                updateItemCount();
                updateSelectedItems(); // Update input kodeBarangString setelah select all
            });

            // Event listener untuk setiap checkbox item
            itemCheckboxes.forEach(checkbox => {
                checkbox.addEventListener('change', function() {
                    selectAll.checked = Array.from(itemCheckboxes).every(item => item.checked);
                    updateItemCount();
                    updateSelectedItems
                        (); // Update input kodeBarangString setiap ada checkbox yang berubah
                });
            });

            // Event listener untuk tombol hapus
            deleteSelected.addEventListener('click', function(e) {
                e.preventDefault(); // Mencegah pengalihan halaman

                if (kodeBarangStringInput.value) {
                    // Menentukan action URL dengan parameter kodeBarangString
                    const deleteForm = document.getElementById('delete-selected-form');
                    deleteForm.action =
                        `/keranjang/deleteitemkeranjang/${kodeBarangStringInput.value}`; // Atur action dengan kodeBarangString

                    // Kirim form
                    deleteForm.submit();
                } else {
                    alert('Pilih setidaknya satu item untuk dihapus');
                }
            });

            // Event listener untuk tombol checkout
            checkoutButton.addEventListener('click', function() {
                const selectedItems = selectedItemsInput.value;
                const totalPrice = totalPriceInput.value;

                if (selectedItems && totalPrice > 0) {
                    // Kirimkan formulir checkout
                    document.getElementById('checkout-form').submit();
                } else {
                    alert('Silakan pilih item untuk checkout!');
                }
            });

            updateItemCount(); // Panggil saat halaman dimuat pertama kali
            updateSelectedItems
                (); // Panggil untuk memastikan input kodeBarangString kosong saat pertama kali dimuat
        });
    </script>





<script>
    document.addEventListener('DOMContentLoaded', function () {
        const timeInput = document.getElementById('time');
        const timeHiddenInput = document.getElementById('time-hidden'); // Input hidden untuk waktu
        const selectAllSewa = document.getElementById('select-all-sewa');
        const itemCheckboxesSewa = document.querySelectorAll('.item-checkbox-sewa');
        const deleteSelectedSewa = document.getElementById('delete-selected-sewa');
        const itemCountSewa = document.getElementById('item-count-sewa');
        const totalPriceElementSewa = document.getElementById('total-sewa');
        const checkoutButtonSewa = document.getElementById('checkout-button-sewa');
        const selectedItemsInputSewa = document.getElementById('selected-items-sewa');
        const totalPriceInputSewa = document.getElementById('total-price-sewa');
        const kodeBarangStringInputSewa = document.getElementById('kodeBarangStringInput-sewa');
        let originalTotalSewa = parseInt(totalPriceElementSewa.textContent.replace(/\D/g, ''), 10);

        // Fungsi untuk memperbarui input hidden waktu
        function updateHiddenTime() {
            timeHiddenInput.value = timeInput.value;
        }

        // Validasi tombol checkout
        function validateCheckoutButton() {
            const timeValue = timeInput.value;
            const selectedItems = selectedItemsInputSewa.value;
            const totalPrice = totalPriceInputSewa.value;

            checkoutButtonSewa.disabled = !timeValue || !selectedItems || totalPrice <= 0;
        }

        // Fungsi untuk memperbarui jumlah item dan subtotal
        function updateItemCountSewa() {
            const checkedItemsSewa = document.querySelectorAll('.item-checkbox-sewa:checked');
            const checkedCountSewa = checkedItemsSewa.length;
            itemCountSewa.textContent = checkedCountSewa;

            deleteSelectedSewa.style.pointerEvents = checkedCountSewa > 0 ? 'auto' : 'none';
            deleteSelectedSewa.style.color = checkedCountSewa > 0 ? '#dc3545' : '#ccc';

            let subtotalSewa = 0;
            let selectedItemCodesSewa = []; // Menyimpan kode item yang dipilih
            checkedItemsSewa.forEach(item => {
                const hargaSewa = parseInt(
                    item.closest('.cart-item').querySelector('.harga-item-sewa').textContent.replace(/\D/g, ''),
                    10
                );
                const kodeSewa = item.closest('.cart-item').dataset.id; // Ambil kode dari data-id
                selectedItemCodesSewa.push(kodeSewa);
                subtotalSewa += hargaSewa;
            });

            // Update total harga di elemen HTML
            totalPriceElementSewa.textContent = checkedCountSewa > 0 ? subtotalSewa.toLocaleString('id-ID') : '0';

            // Update nilai total harga pada input total
            totalPriceInputSewa.value = checkedCountSewa > 0 ? subtotalSewa.toString() : '0';

            // Update jumlah item yang dipilih di tombol checkout
            checkoutButtonSewa.textContent = `Checkout (${checkedCountSewa})`;

            // Masukkan kode barang yang dipilih ke dalam input hidden
            selectedItemsInputSewa.value = selectedItemCodesSewa.join(',');
        }

        // Event listener untuk waktu sewa
        timeInput.addEventListener('input', function () {
            updateHiddenTime();
            validateCheckoutButton();
        });

        // Event listener untuk tombol select all
        selectAllSewa.addEventListener('change', function () {
            itemCheckboxesSewa.forEach(checkbox => {
                checkbox.checked = selectAllSewa.checked;
            });
            updateItemCountSewa();
        });

        // Event listener untuk setiap checkbox item
        itemCheckboxesSewa.forEach(checkbox => {
            checkbox.addEventListener('change', function () {
                selectAllSewa.checked = Array.from(itemCheckboxesSewa).every(item => item.checked);
                updateItemCountSewa();
                validateCheckoutButton();
            });
        });

        // Event listener untuk tombol hapus
deleteSelectedSewa.addEventListener('click', function (e) {
    e.preventDefault();

    // Perbarui nilai kodeBarangStringInputSewa berdasarkan checkbox yang dicentang
    const selectedItems = Array.from(itemCheckboxesSewa)
        .filter(checkbox => checkbox.checked)
        .map(checkbox => checkbox.closest('.cart-item').dataset.id);

    kodeBarangStringInputSewa.value = selectedItems.join(',');

    if (selectedItems.length > 0) {
        const deleteFormSewa = document.getElementById('delete-selected-form-sewa');
        deleteFormSewa.action = `/keranjang/deleteitemsewa/${kodeBarangStringInputSewa.value}`;
        deleteFormSewa.submit();
    } else {
        alert('Pilih setidaknya satu item untuk dihapus');
    }
});


        // Event listener untuk tombol checkout
        checkoutButtonSewa.addEventListener('click', function (e) {
            e.preventDefault();

            if (timeInput.value && selectedItemsInputSewa.value && totalPriceInputSewa.value > 0) {
                document.getElementById('checkout-form-sewa').submit();
            } else {
                alert('Silakan pilih item dan masukkan waktu sewa sebelum checkout!');
            }
        });

        // Panggil fungsi validasi dan update saat halaman dimuat
        validateCheckoutButton();
        updateItemCountSewa();
    });
</script>

@endsection
