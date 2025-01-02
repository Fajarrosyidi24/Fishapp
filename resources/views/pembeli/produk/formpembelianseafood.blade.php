@extends('layouts.app')
@section('title')
    <title>Form Pembelian Seafood {{ $seafood->nama }} Page - Fishapp</title>
    <style>
        .penjual {
            background-color: #fff;
            display: flex;
            border: 1px solid #ccc;
            padding: 5px;
            max-width: 1200px;
            /* Lebar lebih kecil */
            margin: auto;
            color: black;
        }
        .deskripsi {
            padding-top: 10px;
        }
        .purchase-section {
            display: flex;
            flex-direction: column;
            justify-content: space-between;
            align-items: flex-start;
            padding-top: 10px;
            /* Padding lebih kecil */
        }
        .quantity-selector {
            display: flex;
            align-items: center; /* Untuk menyelaraskan elemen secara vertikal */
            gap: 5px; /* Jarak label dan kontrol */
        }

        .quantity-controls {
            display: flex;
            align-items: center; /* Untuk menyelaraskan tombol dan input secara vertikal */
            margin-left: 20px; /* Jarak antara label dan kontrol kuantitas */
        }

        .quantity-controls button {
            width: 30px;
            height: 30px;
            border: 1px solid #ccc;
            background-color:rgb(255, 252, 252);
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

        .subtotal {
            text-align: left;
            font-size: 1em;
            font-weight: bold;
            padding-top: 20px;
        }
        .btn {
            font-size: 0.9em;
        }
        .product-container {
            padding-top: 30px;
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
                                <small class="text-muted"><i class="bi bi-graph-up"></i> 2000 kali terjual</small>
                                <div class="progress" style="height: 5px;"> <!-- Ukuran progress bar -->
                                    <div class="progress-bar bg-success" role="progressbar" style="width: 20%;"
                                        aria-valuenow="200" aria-valuemin="0" aria-valuemax="10000"></div>
                                </div>
                    </div>
                    <p class="card-text fw-bold mb-1 fs-4" style="color:black;">Rp {{ number_format($seafood->harga->harga, 0, ',', '.') }} /KG</p>
                    <div class="product-details">
                        <p>Sedang Tersedia {{ $seafood->jumlah }} KG untuk saat ini</p>
                    </div>
                    <div class="penjual"> 
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
    <div class="product-container">
        <h6 style="color: black; text-align: center;"><------ Produk lainnya ------></h6>
        @php $count = 0; @endphp
        <div class="product-container mb-3">
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
                                        <small class="text-muted"><i class="bi bi-graph-up"></i> 2000 kali terjual</small>
                                        <div class="progress" style="height: 5px;"> <!-- Ukuran progress bar -->
                                            <div class="progress-bar bg-success" role="progressbar" style="width: 20%;"
                                                aria-valuenow="200" aria-valuemin="0" aria-valuemax="10000"></div>
                                        </div>
                                    </div>
                                    <p class="card-text fw-bold mb-1">Rp {{ number_format($se->harga->harga, 0, ',', '.') }} /KG</p>
                                    <p class="card-text mb-2">Tersedia {{ $se->jumlah }} KG</p>
                                    <!-- Rating Bintang -->
                                    <p class="card-text fw-bold mb-1">Rating Penjualan:</p>
                                    <div class="mb-2">
                                        <i class="bi bi-star-fill text-warning"></i>
                                        <i class="bi bi-star-fill text-warning"></i>
                                        <i class="bi bi-star-fill text-warning"></i>
                                        <i class="bi bi-star-fill text-warning"></i>
                                        <i class="bi bi-star text-muted"></i>
                                    </div>
                                </div>
                            </div>
                        </a>
                    </div>
    
                    <div class="modal fade" id="productModal{{ $se->kode_seafood }}" tabindex="-1"
                        aria-labelledby="productModalLabel" aria-hidden="true">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="productModalLabel" style="color: black">
                                        Detail
                                        <button type="button" class="btn-close" data-bs-dismiss="modal"
                                            aria-label="Close"></button>
                                </div>
                                <div class="modal-body">
                                    <form>
                                        @csrf
                                        <div class="mb-3">
                                            <label for="namaSeafood" class="form-label">Nama Seafood</label>
                                            <input type="text" class="form-control" id="namaSeafood"
                                                value="{{ $se->nama }}" readonly>
                                        </div>
                                        <div class="mb-3">
                                            <label for="hargaSeafood" class="form-label">Harga Seafood</label>
                                            <input type="text" class="form-control" id="hargaSeafood"
                                                value="{{ $se->harga->harga }}" readonly>
                                        </div>
                                        <div class="mb-3">
                                            <label for="jenis_seafood" class="form-label">Jenis</label>
                                            <input type="text" class="form-control" id="jenis_seafood"
                                                value="{{ $se->jenis_seafood }}" readonly>
                                        </div>
                                        <div class="mb-3">
                                            <label for="jumlah" class="form-label">Stok</label>
                                            <input type="number" class="form-control" id="jumlah"
                                                value="{{ $se->jumlah }}" readonly>
                                        </div>
                                        <div class="mb-3">
                                            <label for="penjual" class="form-label">Nama Penjual</label>
                                            <input type="text" class="form-control" id="penjual"
                                                value="{{ $se->nelayan->name }}" readonly>
                                        </div>
                                        <div class="mb-3">
                                            <label for="alamat" class="form-label">Alamat Lengkap</label>
                                            <textarea class="form-control" id="alamat" rows="3" readonly>{{ $se->nelayan->detailProfile->alamat_lengkap }}</textarea>
                                        </div>
    
                                        <div class="mb-3">
                                            <label for="tel" class="form-label">Nama Penjual</label>
                                            <input type="tel" class="form-control" id="tel"
                                                value="{{ $se->nelayan->detailProfile->no_telepon }}" readonly>
                                        </div>
                                    </form>
                                </div>

                                <div class="modal-footer">
                                    <button type="button" class="btn btn-sm btn-secondary"
                                        data-bs-dismiss="modal">Close</button>
                                    <a href="{{route('hubungi.penjual.seafood', ['id' =>$se->nelayan->detailProfile->id ])}}" class="btn btn-sm btn-primary text-white">
                                        <i class="bi bi-telephone"></i> Hubungi Penjual
                                    </a>
    
                                    <a href="{{ route('beliseafood', ['kode_seafood' => $se->kode_seafood]) }}" class="btn btn-sm btn-success text-white">
                                        <i class="bi bi-cart-plus"></i> Beli
                                    </a>
                                </div>
                            </div>
                        </div>
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
