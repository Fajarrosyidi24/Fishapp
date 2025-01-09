@extends('layouts.app')
@section('title')
    <title>Form Pembelian Seafood {{ $seafood->nama }} Page - Fishapp</title>
    <style>
        .product-container {
            display: flex;
            border: 1px solid #ccc;
            padding: 10px;
            max-width: 1200px;
            /* Lebar lebih kecil */
            margin: auto;
            color: black;
        }

        .product-image img {
            width: 150px;
            /* Ukuran gambar lebih kecil */
            height: auto;
            border-radius: 6px;
        }

        .product-details {
            flex: 1;
            padding: 0 15px;
            /* Padding lebih kecil */
        }

        .product-details h1 {
            font-size: 1.2em;
            /* Ukuran font lebih kecil */
            margin: 0;
        }

        .product-details p {
            margin: 3px 0;
            font-size: 0.9em;
            /* Font yang lebih kecil */
        }

        .price {
            font-size: 1.2em;
            color: green;
        }

        .detail {
            font-size: 0.8em;
            color: #555;
        }

        .purchase-section {
            display: flex;
            flex-direction: column;
            justify-content: space-between;
            align-items: start;
            padding-left: 10px;
            /* Padding lebih kecil */
        }

        .quantity-selector {
            text-align: center;
        }

        .quantity-controls {
            display: flex;
            align-items: center;
            margin: 5px 0;
            /* Margin lebih kecil */
        }

        .quantity-controls button {
            width: 25px;
            /* Lebar tombol lebih kecil */
            height: 25px;
            border: 1px solid #ccc;
            background-color: #fff;
            font-size: 1em;
        }

        .quantity-controls input {
            width: 40px;
            /* Lebar input lebih kecil */
            text-align: center;
            border: 1px solid #ccc;
            margin: 0 5px;
            /* Margin lebih kecil */
        }

        .subtotal {
            text-align: start;
            font-size: 1.5em;
            padding : 5px;
            /* Font subtotal lebih kecil */
        }

        .button-container {
            display: flex;
            gap: 5px;
            /* Jarak lebih kecil antara tombol */
        }

        .add-to-cart,
        .buy-now {
            padding: 5px 15px;
            /* Padding tombol lebih kecil */
            border: none;
            color: #fff;
            cursor: pointer;
            text-align: center;
            font-size: 0.9em;
            /* Ukuran font tombol lebih kecil */
        }

        .add-to-cart {
            background-color: #007bff;
        }

        .buy-now {
            background-color: #28a745;
        }
    </style>
@endsection

@section('content')
<div class="container mt-5 mb-3">
        <div class="row g-4 align-items-start">
            
            
            <!-- Gambar Produk -->
            <div class="col-12 col-lg-6 text-center">
                <img src="{{ asset('storage/fotoseafood/' . $seafood->foto) }}" class="img-fluid rounded w-50 w-lg-100" alt="foto seafood">
            </div>
            
            <!-- Detail Produk -->
            <div class="col-12 col-lg-6">
                <h1 class="card-title fs-1">{{ $seafood->nama }}</h1>
                
                 <!-- Total Penjualan -->
                 <div class="mb-2">
                        <small class="text-muted">
                            <i class="bi bi-graph-up"></i> {{ $seafood->jumlah_terjual }} kali terjual
                        </small>
                        <div class="progress" style="height: 5px;"> <!-- Ukuran progress bar -->
                            @php
                                // Menghitung persentase jumlah terjual dibandingkan dengan stok
                                $percentage = ($seafood->jumlah_terjual / $seafood->jumlah) * 100;
                                $percentage = min($percentage, 100); // Membatasi agar tidak melebihi 100%
                            @endphp
                            <div class="progress-bar bg-success" role="progressbar" style="width: {{ $percentage }}%;"
                                aria-valuenow="{{ $seafood->jumlah_terjual }}" aria-valuemin="0" aria-valuemax="{{ $seafood->jumlah }}">
                            </div>
                        </div>
                    </div>
                
                <p class="card-text fw-bold mb-1 fs-4" style="color:black;">Rp {{ number_format($seafood->harga->harga, 0, ',', '.') }} /KG</p>
                <div class="product-details">
                    <p>Sedang Tersedia {{ $seafood->jumlah }} KG untuk saat ini</p>
                </div>
                <!-- Penjual -->
                <div class="d-flex justify-content-between align-items-start mb-3" 
                    style="background-color: white; border: 1px solid #ddd; padding: 10px; width: 100%; box-sizing: border-box; border-radius: 8px;">
                    <div style="display: flex; align-items: center; gap: 10px;">
                        <img src="{{ asset('storage/fotonelayan/' . $seafood->nelayan->detailProfile->foto) }}" 
                            alt="Foto Nelayan" 
                            class="rounded img-thumbnail" 
                            style="width: 60px; height: 60px; object-fit: cover; border-radius: 50% !important; border: none;">
                        <span style="font-weight: bold;">{{ $seafood->nelayan->name }}</span>
                    </div>
                    <a href="#" class="btn btn-sm text-white d-flex align-items-center"
                        style="background-color: #25D366; border-color: #25D366; align-self: center; font-size: 14px;" 
                        ><i class="bi bi-chat"></i>Hubungi Penjual</a>
                </div>

                    <p class="deskripsi"> <h4>Deskripsi Produk</h4>
                    {{ $seafood->nama }} yang dijual selalu dalam kondisi fresh baru ditangkap. Harga hitungan per 1 kg.
                    </p>
                <div class="purchase-section">
                    <div class="quantity-selector">
                        <label for="quantity">Kuantitas /KG</label>
                        <div class="quantity-controls">
                            <button class="minus">-</button>
                            <input type="number" id="quantity" name="quantity" value="1" min="1"
                            max="{{ $seafood->jumlah }}">
                            <button class="plus">+</button>
                        </div>
                    </div>
                    <div class="subtotal">
                        <p class="label fw-bold mb-0">Subtotal</p>
                        <p class="amount mb-0 ms-0" id="subtotal-amount">Rp {{ number_format($seafood->harga->harga, 0, ',', '.') }},-</p>
                    </div>
                </div>
                <div class="d-flex gap-2">
                    <button class="btn btn-sm btn-primary text-white add-to-cart" data-id="{{ $seafood->kode_seafood }}"><i class="bi bi-cart-plus"></i>Masukkan Keranjang</button>
                    <button class="btn btn-sm btn-success text-white">Beli Sekarang</button>
                </div>
            </div>
            
        </div>

    {{-- produk lainnya --}}
    <div class="container">
        <h6 style="color: black; text-align: center; padding: 50px;"><------ Produk lainnya ------></h6>
        @php $count = 0; @endphp
        <div class="container mb-3">
            <div class="row row-cols-1 row-cols-md-2 row-cols-lg-4 g-4"> <!-- Grid responsif -->
                @foreach ($produklainnya as $se)
                    <!-- Produk Card -->
                    <div class="col">
                    <a href="{{ route('beliseafood', ['kode_seafood' => $se->kode_seafood]) }}" class="text-decoration-none text-dark">
                        <div class="card h-100 shadow-sm">
                            <img src="{{ asset('storage/fotoseafood/' . $se->foto) }}" class="card-img-top" alt="foto seafood"
                                style="height: 150px; object-fit: cover;">
                            <div class="card-body">
                                <h5 class="card-title fs-6">{{ $se->nama }}</h5>
                                <!-- Total Penjualan -->
                               <div class="mb-2">
                        <small class="text-muted">
                            <i class="bi bi-graph-up"></i> {{ $se->jumlah_terjual }} kali terjual
                        </small>
                        <div class="progress" style="height: 5px;"> <!-- Ukuran progress bar -->
                            @php
                                // Menghitung persentase jumlah terjual dibandingkan dengan stok
                                $percentage = ($se->jumlah_terjual / $se->jumlah) * 100;
                                $percentage = min($percentage, 100); // Membatasi agar tidak melebihi 100%
                            @endphp
                            <div class="progress-bar bg-success" role="progressbar" style="width: {{ $percentage }}%;"
                                aria-valuenow="{{ $se->jumlah_terjual }}" aria-valuemin="0" aria-valuemax="{{ $se->jumlah }}">
                            </div>
                        </div>
                    </div>
                                <p class="card-text fw-bold mb-1">Rp {{ number_format($se->harga->harga, 0, ',', '.') }} /KG</p>
                                <p class="card-text mb-2">Tersedia {{ $se->jumlah }} KG</p>
                                <!-- Rating Bintang -->
                                <p class="card-text fw-bold mb-1">Rating Penjualan:</p>
                                <div class="mb-2">
                      @php
    // Inisialisasi rating
    $rating = 0;
    $fullStars = 0;
    $halfStar = false;

    // Pastikan relasi rating ada sebelum menghitung rata-rata
    if ($se->rating && $se->rating->count() > 0) {
        $rating = $se->rating->avg('rating'); // Menghitung rata-rata rating
        $fullStars = floor($rating); // Mengambil nilai bintang penuh
        $halfStar = $rating - $fullStars >= 0.5; // Mengecek apakah ada bintang setengah
    }
@endphp
                        <!-- Menampilkan bintang penuh -->
                        @for ($i = 1; $i <= $fullStars; $i++)
                            <i class="bi bi-star-fill text-warning"></i>
                        @endfor
                        <!-- Menampilkan bintang setengah jika ada -->
                        @if ($halfStar)
                            <i class="bi bi-star-half text-warning"></i>
                        @endif
                        <!-- Menampilkan bintang kosong -->
                        @for ($i = $fullStars + ($halfStar ? 1 : 0); $i < 5; $i++)
                            <i class="bi bi-star text-muted"></i>
                        @endfor
                    </div>
                                
                            </div>
                        </div>
                    </a>
                    </div>
                    @php $count++; @endphp
                @endforeach
            </div>
        </div>

        <!-- Tombol "Tampilkan Lebih Banyak" -->
        <div class="text-center mt-3 mb-3">
            <button class="btn btn-primary show-more-button">Tampilkan Lebih Banyak</button>
        </div>
    </div>
    <script>
            document.addEventListener('DOMContentLoaded', (event) => {
                const minusButton = document.querySelector('.minus');
                const plusButton = document.querySelector('.plus');
                const quantityInput = document.getElementById('quantity');
                const subtotalAmount = document.getElementById('subtotal-amount');
                const pricePerKg = {{ $seafood->harga->harga }};
    
                minusButton.addEventListener('click', () => {
                    let currentValue = parseInt(quantityInput.value);
                    if (currentValue > 1) {
                        quantityInput.value = currentValue - 1;
                        updateSubtotal();
                    }
                });
    
                plusButton.addEventListener('click', () => {
                    let currentValue = parseInt(quantityInput.value);
                    if (currentValue < parseInt(quantityInput.max)) {
                        quantityInput.value = currentValue + 1;
                        updateSubtotal();
                    }
                });
    
                quantityInput.addEventListener('change', () => {
                    let currentValue = parseInt(quantityInput.value);
                    if (currentValue < 1) {
                        quantityInput.value = 1;
                    } else if (currentValue > parseInt(quantityInput.max)) {
                        quantityInput.value = quantityInput.max;
                    }
                    updateSubtotal();
                });
    
                function updateSubtotal() {
                    let currentValue = parseInt(quantityInput.value);
                    let newSubtotal = pricePerKg * currentValue;
                    subtotalAmount.textContent = 'Rp ' + newSubtotal.toLocaleString('id-ID') + ',-';
                }
                updateSubtotal();
            });
    
        document.addEventListener('DOMContentLoaded', function() {
            const showMoreButton = document.querySelector('.show-more-button');
            const products = document.querySelectorAll('.col');
            const initialProductsToShow = 4; // Jumlah produk yang ditampilkan awalnya
            let visibleProducts = initialProductsToShow;
    
            // Sembunyikan produk yang tidak pertama kali
            for (let i = 0; i < products.length; i++) {
                if (i >= initialProductsToShow) {
                    products[i].style.display = 'none';
                }
            }
    
            // Tampilkan lebih banyak produk saat tombol "Tampilkan Lebih Banyak" diklik
            showMoreButton.addEventListener('click', function() {
                for (let i = 0; i < products.length; i++) {
                    if (i >= visibleProducts) {
                        products[i].style.display = 'block';
                    }
                }
    
                visibleProducts += initialProductsToShow;
                if (visibleProducts >= products.length) {
                    showMoreButton.style.display = 'none';
                }
            });
        });
    
        document.addEventListener('DOMContentLoaded', () => {
            // Find all elements with class 'add-to-cart'
            const addToCartButtons = document.querySelectorAll('.add-to-cart');
    
            // Add click event listener to each button
            addToCartButtons.forEach(button => {
                button.addEventListener('click', () => {
                    const productId = button.getAttribute(
                    'data-id'); // Get product ID from data-id attribute
                    const jumlah = document.getElementById('quantity')
                    .value; // Get quantity from input field
                    const subtotal = document.getElementById('subtotal-amount').textContent.replace(
                        /[^\d]/g, ''); // Get subtotal from element text
    
                    // Redirect to the add-to-cart route with parameters
                    window.location.href = `/user/produk/add-to-cart/${productId}/${jumlah}/${subtotal}`;
                });
            });
        });
    </script>
    @include('components.foot')
@endsection
