@extends('layouts.app')

@section('title')
    <title>Penyewaan Alat - FISHApp</title>
    <style>
         body {
            font-family: Arial, sans-serif;
            background-color: #202020;
            color: #ffffff;
            margin: 0;
            padding: 0;
        }

        .navbar-1 {
            background-color: #097ABA;
        }

        .navbar-1 a {
            color: #000000;
            text-decoration: none;
            font-size: 15px;
        }

        .navbar-1 a.active {
            color: #ffffff;
            font-weight: bold;
            font-size: 15px;
        }

        .container {
            padding: 20px;
            width: 100%;
            margin: auto;
        }
    </style>
@endsection

@section('content')
<link rel="stylesheet"
        href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@24,400,0,0&icon_names=local_shipping" />

         <!-- Search Bar -->
        <div class="container mt-2">
            <div class="row justify-content-center">
                <div class="col-md-8 col-12">
                    <div class="input-group">
                        <input class="form-control" type="search" placeholder="Cari produk atau pesanan..." aria-label="Search"
                            id="searchInput" />
                        <button class="btn btn-primary" type="button">
                            <i class="fas fa-search"></i>
                        </button>
                    </div>
                </div>
            </div>
        </div>

         <!-- Navbar dan Penjual Produk -->
        <div class="container mt-1">
            <div class="row">
                <!-- Navbar -->
                <div class="navbar-1 d-flex justify-content-center">
                        <div class="d-flex justify-content-center col-2">
                        <a href="{{ route('penyewaanalat', ['reference' => 1]) }}"
                            class="nav-link {{ request()->routeIs('penyewaanalat') && request('reference') == 1 ? 'active' : '' }}">
                            Semua
                        </a>
                        </div>
                        <div class="d-flex justify-content-center col-2">
                            <a href="{{ route('penyewaanalat', ['reference' => 2]) }}"
                            class="nav-link {{ request()->routeIs('penyewaanalat') && request('reference') == 2 ? 'active' : '' }}">
                            Akan Disewa
                        </a>
                        </div>
                        <div class="d-flex justify-content-center col-3">
                            <a href="{{ route('penyewaanalat', ['reference' => 3]) }}"
                            class="nav-link {{ request()->routeIs('penyewaanalat') && request('reference') == 3 ? 'active' : '' }}">
                            Sedang Disewa
                        </a>
                        </div>
                        <div class="d-flex justify-content-center col-3">
                            <a href="{{ route('penyewaanalat', ['reference' => 4]) }}"
                            class="nav-link {{ request()->routeIs('penyewaanalat') && request('reference') == 4 ? 'active' : '' }}">
                            Telah Dikembalikan
                        </a>
                        </div>
                        <div class="d-flex justify-content-center col-2">
                            <a href="{{ route('penyewaanalat', ['reference' => 5]) }}"
                            class="nav-link {{ request()->routeIs('penyewaanalat') && request('reference') == 5 ? 'active' : '' }}">
                            Denda
                        </a>
                        </div>
                </div>

            </div>
        </div>
    @include('components.foot')
@endsection