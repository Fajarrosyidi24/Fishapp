@extends('layouts.app')
@section('title')
    <title>Form Pembelian Seafood {{ $barang->nama_barang }} Page - Fishapp</title>
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
            align-items: center;
            border-left: 1px solid #ccc;
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
            text-align: center;
            font-size: 0.9em;
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
    <div class="product-container mt-3 mb-5">
        <div class="product-image">
            <img src="{{ asset('storage/fotobarang/' . $barang->foto_barang) }}" alt="foto_barang">
        </div>
        <div class="product-details">
            <h1>{{ $barang->nama_barang }} {{ $barang->kondisi }}</h1>
            <p>Sedang Tersedia {{ $barang->jumlah }} Barang untuk saat ini</p>
            <p class="price">Rp {{ number_format($barang->harga->harga, 0, ',', '.') }},-</p>
            <p class="detail">{{ $barang->nama_barang }} yang akan disewakan memiliki Harga
                hitungan /Jam untuk 1 Barang.</p>
        </div>
        <div class="purchase-section">
            <div class="quantity-selector">
                <label for="quantity">Atur Jumlah Penyewaan /Jam</label>
                <div class="quantity-controls">
                    <button class="minus">-</button>
                    <input type="number" id="quantity" name="quantity" value="1" min="1"
                        max="{{ $barang->jumlah }}">
                    <button class="plus">+</button>
                </div>
            </div>
            <div class="subtotal">
                <p>Subtotal</p>
                <p id="subtotal-amount">Rp {{ number_format($barang->harga->harga, 0, ',', '.') }},-</p>
            </div>
            <div class="button-container">
                <button class="add-to-cart" data-id="{{ $barang->kode_barang }}">+ Masukan kedalam Keranjang</button>
            </div>
        </div>
    </div>

    <div class="container">
        <h6 style="color: black; text-align: center;"><------ Produk lainnya ------></h6>
        @php $count = 0; @endphp
        <div class="container mb-3">
            <div class="row row-cols-1 row-cols-md-2 row-cols-lg-4 g-4"> <!-- Grid responsif -->
                @foreach ($produklainnya as $se)
                    <!-- Produk Card -->
                    <div class="col">
                        <div class="card h-100 shadow-sm">
                            <img src="{{ asset('storage/fotobarang/' . $se->foto_barang) }}" class="card-img-top"
                                alt="foto seafood" style="height: 150px; object-fit: cover;">
                            <div class="card-body">
                                <h5 class="card-title fs-6">{{ $se->nama_barang }}</h5>
                                <!-- Total Penjualan -->
                                <div class="mb-2">
                                    <small class="text-muted">
                                        <i class="bi bi-graph-up"></i> 2000 kali terjual
                                    </small>
                                    <div class="progress" style="height: 5px;"> <!-- Ukuran progress bar -->
                                        <div class="progress-bar bg-success" role="progressbar" style="width: 10%;"
                                            aria-valuenow="10" aria-valuemin="0" aria-valuemax="1000">
                                        </div>
                                    </div>
                                </div>
                                <p class="card-text fw-bold mb-1">Rp {{ number_format($se->harga->harga, 0, ',', '.') }}
                                    /Jam</p>
                                <p class="card-text mb-2">Tersedia {{ $se->jumlah }} </p>
                                <!-- Rating Bintang -->
                                <p class="card-text fw-bold mb-1">Rating Penjualan:</p>
                                <div class="mb-2">
                                    <i class="bi bi-star-fill text-warning"></i>
                                    <i class="bi bi-star-half text-warning"></i>
                                    <i class="bi bi-star text-muted"></i>
                                </div>
                                <div class="d-flex gap-2">
                                    <a href="#" data-bs-toggle="modal"
                                        data-bs-target="#productModal{{ $se->kode_barang }}"
                                        class="btn btn-sm btn-primary text-white">
                                        <i class="bi bi-eye"></i> Detail
                                    </a>
                                    <a href="{{ route('sewabarang', ['kode_barang' => $se->kode_barang]) }}"
                                        class="btn btn-sm btn-success text-white">
                                        <i class="bi bi-cart-plus"></i> Sewa
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="modal fade" id="productModal{{ $se->kode_barang }}" tabindex="-1"
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
                                            <label for="namaSeafood" class="form-label">Nama Barang</label>
                                            <input type="text" class="form-control" id="namaSeafood"
                                                value="{{ $se->nama_barang }}" readonly>
                                        </div>
                                        <div class="mb-3">
                                            <label for="hargaSeafood" class="form-label">Harga</label>
                                            <input type="text" class="form-control" id="hargaSeafood"
                                                value="{{ $se->harga->harga }}" readonly>
                                        </div>
                                        <div class="mb-3">
                                            <label for="jenis_seafood" class="form-label">Kondisi</label>
                                            <input type="text" class="form-control" id="jenis_seafood"
                                                value="{{ $se->kondisi }}" readonly>
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
                                    <a href="{{ route('hubungi.penjual.seafood', ['id' => $se->nelayan->detailProfile->id]) }}"
                                        class="btn btn-sm btn-primary text-white">
                                        <i class="bi bi-telephone"></i> Hubungi Penjual
                                    </a>

                                    <a href="{{ route('sewabarang', ['kode_barang' => $se->kode_barang]) }}"
                                        class="btn btn-sm btn-success text-white">
                                        <i class="bi bi-cart-plus"></i> Sewa
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
    @include('components.foot')
@endsection

@section('foot')
    <script>
        document.addEventListener('DOMContentLoaded', (event) => {
            const minusButton = document.querySelector('.minus');
            const plusButton = document.querySelector('.plus');
            const quantityInput = document.getElementById('quantity');
            const subtotalAmount = document.getElementById('subtotal-amount');
            const pricePerKg = {{ $barang->harga->harga }};

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
    </script>

    <script>
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
    </script>

    <script>
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
                    window.location.href =
                        `/user/produk/add-to-cart2/${productId}/${jumlah}/${subtotal}`;
                });
            });
        });
    </script>
@endsection
