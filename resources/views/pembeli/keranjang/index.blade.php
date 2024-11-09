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

        <form id="checkout-form" action="{{route('checkout.route')}}" method="POST" style="display: none">
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
         let selectedItemCodes = [];  // Menyimpan kode item yang dipilih
         checkedItems.forEach(item => {
             const harga = parseInt(item.closest('.cart-item').querySelector('.harga-item').textContent.replace(/\D/g, ''), 10);
             const kodeSeafood = item.closest('.cart-item').dataset.id;  // Ambil kode_seafood dari data-id
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
                 const kodeSeafood = checkbox.closest('.cart-item').dataset.id; // Ambil kode_seafood dari data-id
                 selectedItems.push(kodeSeafood);
             }
         });
         // Masukkan kode_seafood yang dipilih ke dalam input
         kodeBarangStringInput.value = selectedItems.join(',');
     }
 
     // Event listener untuk select all
     selectAll.addEventListener('change', function () {
         itemCheckboxes.forEach(checkbox => {
             checkbox.checked = selectAll.checked;
         });
         updateItemCount();
         updateSelectedItems(); // Update input kodeBarangString setelah select all
     });
 
     // Event listener untuk setiap checkbox item
     itemCheckboxes.forEach(checkbox => {
         checkbox.addEventListener('change', function () {
             selectAll.checked = Array.from(itemCheckboxes).every(item => item.checked);
             updateItemCount();
             updateSelectedItems(); // Update input kodeBarangString setiap ada checkbox yang berubah
         });
     });
 
     // Event listener untuk tombol hapus
     deleteSelected.addEventListener('click', function (e) {
         e.preventDefault(); // Mencegah pengalihan halaman
 
         if (kodeBarangStringInput.value) {
             // Menentukan action URL dengan parameter kodeBarangString
             const deleteForm = document.getElementById('delete-selected-form');
             deleteForm.action = `/keranjang/deleteitemkeranjang/${kodeBarangStringInput.value}`; // Atur action dengan kodeBarangString
 
             // Kirim form
             deleteForm.submit();
         } else {
             alert('Pilih setidaknya satu item untuk dihapus');
         }
     });
 
     // Event listener untuk tombol checkout
     checkoutButton.addEventListener('click', function () {
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
     updateSelectedItems(); // Panggil untuk memastikan input kodeBarangString kosong saat pertama kali dimuat
 });
 </script>
 
@endsection