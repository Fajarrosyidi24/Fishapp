@extends('layouts.app')
@section('title')
    <title>Keranjang Page - Fishapp</title>
    <style>
        .cart-item {
            border: 1px solid #ddd;
            padding: 10px;
            margin-bottom: 5px;
            background-color: #fff;
            display: flex;
            align-items: center;
            width: 100%;
            box-sizing: border-box;
            gap: 10px;
        }

        .cart-item .checkbox {
            margin-right: 15px;
        }

        .cart-item .image img {
            max-width: 80px;
            border-radius: 5px;
        }

        .cart-item .details {
            flex-grow: 1;
            margin-left: 10px;
            justify-content: space-between;
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
            padding: 10px;
            text-align: left;
            background-color: #fff;
            max-width: 100%;
            box-sizing: border-box;
            margin-top: 0;
        }

        .cart-summary h5 {
            margin-bottom: 15px;
        }

        .row {
            display: flex;
            justify-content: space-between;
            align-items: flex-start;
        }

        .quantity-controls {
            display: flex;
            align-items: center;
            margin-left: 20px;
        }

        .quantity-controls button {
            width: 30px;
            height: 30px;
            border: 1px solid #ccc;
            background-color: rgb(255, 252, 252);
            font-size: 1em;
            cursor: pointer;
        }

        .quantity-controls input {
            width: 50px;
            height: 30px;
            text-align: center;
            border: 1px solid #ccc;
            font-size: 1em;
        }

        @media (max-width: 768px) {
            .cart-item {
                flex-direction: column;
                align-items: flex-start;
            }

            .cart-item .details {
                flex-direction: column;
                align-items: flex-start;
            }

            .cart-summary {
                margin-top: 20px;
            }

            .quantity-controls {
                margin-left: 0;
            }

            .cart-item .image img {
                max-width: 60px;
            }

            .cart-item .quantity input {
                width: 40px;
            }
        }
    </style>
@endsection

@section('content')
<div class="container mt-5 mb-5 lg-6">
    <div class="row">
        <div class="col-md-7 w-66" style="background-color: white; border: 1px solid #ddd; padding: 20px; width: 66%; box-sizing: border-box;">
            <h1>Keranjang Seafoods</h1>
            <div class="d-flex justify-content-between align-items-start mb-3" 
                style="background-color: white; border: 1px solid #ddd; padding: 10px; width: 100%; box-sizing: border-box;">
                <table style="width: 100%; border-collapse: collapse;">
                    <tr>
                        <td style="white-space: nowrap; vertical-align: top;">
                            <input type="checkbox" id="select-all" style="cursor: pointer;">
                            <label for="select-all">Pilih Semua</label>
                            <span>(<span id="item-count">0</span>)</span>
                        </td>
                        <td style="text-align: end; vertical-align: top; cursor: pointer;">
                            <a href="#" id="delete-selected" class="text-danger"><i class="bi bi-trash"></i>Hapus</a>
                        </td>
                    </tr>
                </table>
            </div>
            
            @foreach ($keranjang as $item)
            <div class="cart-item d-flex" data-id="{{ $item->kode_keranjang }}">
                <div class="checkbox">
                    <input type="checkbox" class="item-checkbox">
                </div>
                <div class="image">
                    <img src="{{ asset('storage/fotoseafood/' . $item->seafood->foto) }}" alt="{{ $item->seafood->nama }}" width="100">
                </div>
                <div class="details d-flex align-items-center ml-3" style="gap: 20px;">
                    <div class="info">
                        <h5>{{ $item->seafood->nama }}</h5>
                        <div class="price mb-0">
                            <p style="color: black;">Rp. <span class="harga-item">{{ number_format($item->subtotal, 0, ',', '.') }}</span></p>
                        </div>
                    </div>
                    <div class="quantity">
                        <input type="text" class="form-control form-control-sm input-jumlah"
                        value="{{ $item->jumlah }}" style="width: 60px;" readonly>
                    </div>
                </div>
            </div>
            @endforeach
        </div>

        <div class="col-md-4">
            <div class="cart-summary">
                <div>
                    <a>Lokasi</a>
                    <form id="shippingAddressForm">
                        @foreach ($alamat as $index => $item)
                        <div class="form-check mb-3">
                            <input class="form-check-input" type="radio" name="selected_address"
                                id="address_{{ $index }}" value="{{ $item->id }}" {{ $loop->first ? 'checked' : '' }}>
                            <label class="form-check-label" for="address_{{ $index }}">
                                <strong>{{ $item->kecamatan }}, Kab.{{ $item->kabupaten }}, {{ $item->provinsi }}</strong><br>
                            </label>
                        </div>
                        @endforeach
                    </form>
                    <hr class="my-3" style="border-top: 1px solid #ddd;">
                </div>
                <h5>Ringkasan Pesanan</h5>
                <div class="subtotal-container" style="display: flex; justify-content: space-between; align-items: center; color: #4B4B4B;">
                    <p style="margin: 0;">Sub Total Harga:</p>
                    <p style="margin: 0; font-weight: bold; color: black;">Rp<span id="total">{{ number_format($total, 0, ',', '.') }}</span></p>
                </div>

                <button id="checkout-button" class="btn btn-primary btn-block w-100">Checkout (0)</button> 
            </div>
        </div>
    </div>
</div>

<form id="checkout-form" action="{{route('checkout.route')}}" method="POST" style="display: none">
    @csrf
    <input type="hidden" id="selected-items" name="selected_items">
    <input type="hidden" id="total-price" name="total_price">
</form>
@include('components.foot')
@endsection

@section('foot')
<script>
    document.addEventListener('DOMContentLoaded', function () {
        const selectAll = document.getElementById('select-all');
        const itemCheckboxes = document.querySelectorAll('.item-checkbox');
        const deleteSelected = document.getElementById('delete-selected');
        const itemCount = document.getElementById('item-count');
        const totalPriceElement = document.getElementById('total');
        const checkoutButton = document.getElementById('checkout-button');
        const selectedItemsInput = document.getElementById('selected-items');
        const totalPriceInput = document.getElementById('total-price');
        const kodeBarangStringInput = document.getElementById('kodeBarangStringInput');
        let originalTotal = parseInt(totalPriceElement.textContent.replace(/\D/g, ''),10);

        function updateItemCount() {
            const checkedItems = document.querySelectorAll('.item-checkbox:checked');
            const checkedCount = checkedItems.length;
            itemCount.textContent = checkedCount;

            let subtotal = 0;
            const selectedItemCodes = [];
            checkedItems.forEach(item => {
                const harga = parseInt(item.closest('.cart-item').querySelector('.harga-item').textContent.replace(/\D/g, ''), 10);
                const kodeSeafood = item.closest('.cart-item').dataset.id;
                selectedItemCodes.push(kodeSeafood);
                subtotal += harga;
            });

            totalPriceElement.textContent = subtotal > 0 ? subtotal.toLocaleString('id-ID') : '0';
            totalPriceInput.value = subtotal;
            selectedItemsInput.value = selectedItemCodes.join(',');
            checkoutButton.textContent = `Checkout (${checkedCount})`;
            selectedItemsInput.value = selectedItemCodes.join(',');
        }

        selectAll.addEventListener('change', function () {
            itemCheckboxes.forEach(checkbox => {
                checkbox.checked = selectAll.checked;
            });
            updateItemCount();
        });

        itemCheckboxes.forEach(checkbox => {
            checkbox.addEventListener('change', function () {
                selectAll.checked = Array.from(itemCheckboxes).every(item => item.checked);
                updateItemCount();
            });
        });

        //event listener untuk tombol hapus
        deleteSelected.addEventListener('click', function (e){
            e.preventDefault(); //Mencegah pengalihan halaman

            if (kodeBarangStringInput.value) {
                //Menenttukan action URL dengan parameter kodeBarangString
                const deleteForm = document.getElementById('delete-selected-form');
                deleteForm.action = `/keranjang/deleteitemkeranjang/${kodeBarangStringInput}`; //Atur action dengan kodeBarangString

                //Kirim Form
                deleteForm.submit();
            } else {
                alert('Pilih setidaknya sat item untuk dihapus');
            }
        });

        checkoutButton.addEventListener('click', function () {
            if (selectedItemsInput.value && parseFloat(totalPriceInput.value) > 0) {
                document.getElementById('checkout-form').submit();
            } else {
                alert('Silakan pilih item untuk checkout!');
            }
            // Lakukan proses lainnya, misalnya arahkan ke halaman checkout
             return view('checkout.route', compact('selectedItems', 'totalPrice'));
        });

        updateItemCount(); //Panggil saat halaman dimuat pertama kali
        updateSelectedItems(); //Panggil untuk memastikan input kodeBarangString kosong saat pertama kali dimuat
    });
</script>
@endsection
