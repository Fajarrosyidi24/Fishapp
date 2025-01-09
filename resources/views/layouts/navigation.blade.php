 <!-- Google Fonts -->
 <link href="https://fonts.googleapis.com/css2?family=Jolly+Lodger&display=swap" rel="stylesheet">

 <!-- Navbar Start -->
 <nav class="navbar navbar-expand-lg navbar-light shadow sticky-top" style="background-color: #097ABA;">
     <div class="container-fluid px-4">
         <!-- Logo dan Judul -->
         <a href="{{ route('dashboard') }}" class="navbar-brand d-flex align-items-center">
             <img src="{{ asset('img/Fishapp new logo.png') }}" alt="logo"
                 style="width: 100px; height: 90px; margin-right: 10px;">
             <span
                 style="
            font-family: 'Jolly Lodger', cursive; 
            font-size: 3rem; 
            font-weight: semi bold; 
            color: white; 
            line-height: 1;">FISHApp
             </span>
         </a>

         <!-- Button Toggler (Mobile) -->
         <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarCollapse"
             aria-controls="navbarCollapse" aria-expanded="false" aria-label="Toggle navigation">
             <span class="navbar-toggler-icon"></span>
         </button>

         <!-- Navbar Links dan Search Form -->
         <div class="collapse navbar-collapse" id="navbarCollapse">
             <div class="ms-auto p-4 p-lg-0">
                 <form class="d-flex ms-auto" id="searchForm" role="search">
                     <div class="input-group" style="max-width: 300px; width: 100%;">
                         <input class="form-control" type="search" placeholder="Search for..." aria-label="Search"
                             aria-describedby="btnNavbarSearch" id="searchInput" />
                         <button class="btn btn-primary" id="btnNavbarSearch" type="button">
                             <i class="fas fa-search"></i>
                         </button>
                     </div>
                 </form>
             </div>

             <!-- Menu Navigasi -->
             <ul class="navbar-nav ms-5 mb-2 mb-lg-0">
                 <li class="nav-item">
                     <a href="{{ route('dashboard') }}"
                         class="nav-item nav-link {{ request()->routeIs('dashboard') ? 'active' : '' }}  {{ request()->routeIs('index') ? 'active' : '' }}">Dashboard</a>
                 </li>
                 <li class="nav-item">
                     <a href="{{ route('about2') }}"
                         class="nav-item nav-link {{ request()->routeIs('about_information2') ? 'active' : '' }} {{ request()->routeIs('about2') ? 'active' : '' }}">About</a>
                 </li>
                 <li class="nav-item dropdown">
                     <a href="#"
                         class="nav-link 
                    {{ request()->routeIs('pembeli.produk.seafood') ? 'active' : '' }}
                     {{ request()->routeIs('beliseafood') ? 'active' : '' }}
                     dropdown-toggle"
                         data-bs-toggle="dropdown">
                         Produk
                     </a>
                     <ul class="dropdown-menu">
                         <li><a href="{{ route('pembeli.produk.barangsewa') }}" class="dropdown-item">Barang Sewa</a>
                         </li>
                         <li><a href="{{ route('pembeli.produk.seafood') }}" class="dropdown-item">Seafoods</a></li>
                     </ul>
                 </li>
                 <!-- <li class="nav-item">
                    <a href="#" class="nav-item nav-link">Article</a>
                </li> -->

                 <!-- Ikon Keranjang -->
                 <li class="nav-item">
                     <a href="{{ route('keranjang.pembeli') }}"
                         class="nav-link 
                    {{ request()->routeIs('keranjang.pembeli') ? 'active' : '' }}
                     {{ request()->routeIs('checkout.route') ? 'active' : '' }}
                    position-relative">

                         @php
                             $jumlahseafood = \App\Models\Keranjang::where('user_id', Auth::user()->id)
                                 ->where('status', 'dimasukan dalam keranjang')
                                 ->count();

                                 $jumlahBarang = \App\Models\KeranjangBarangSewa::where('user_id', Auth::user()->id)
                                 ->where('status', 'dimasukan dalam keranjang')
                                 ->count();

                             $jumlahTabel = $jumlahseafood + $jumlahBarang;
                         @endphp

                         <svg xmlns="http://www.w3.org/2000/svg" width="25" height="25" fill="currentColor"
                             class="bi bi-cart4" viewBox="0 0 16 16">
                             <path
                                 d="M0 2.5A.5.5 0 0 1 .5 2H2a.5.5 0 0 1 .485.379L2.89 4H14.5a.5.5 0 0 1 .485.621l-1.5 6A.5.5 0 0 1 13 11H4a.5.5 0 0 1-.485-.379L1.61 3H.5a.5.5 0 0 1-.5-.5M3.14 5l.5 2H5V5zM6 5v2h2V5zm3 0v2h2V5zm3 0v2h1.36l.5-2zm1.11 3H12v2h.61zM11 8H9v2h2zM8 8H6v2h2zM5 8H3.89l.5 2H5zm0 5a1 1 0 1 0 0 2 1 1 0 0 0 0-2m-2 1a2 2 0 1 1 4 0 2 2 0 0 1-4 0m9-1a1 1 0 1 0 0 2 1 1 0 0 0 0-2m-2 1a2 2 0 1 1 4 0 2 2 0 0 1-4 0" />
                         </svg>
                         @if ($jumlahTabel === 0)
                         @else
                             <span class="position-absolute start-100 translate-middle badge rounded-pill bg-danger">
                                 {{ $jumlahTabel }}
                             </span>
                         @endif
                     </a>
                 </li>

             </ul>

             <!-- Kondisi untuk Login atau Logout -->
             <div class="ms-auto d-flex align-items-center">
                 <ul class="navbar-nav">
                     <li class="nav-item dropdown">
                         <a href="#"
                             class="nav-link 
                            {{ request()->routeIs('profile.edit') ? 'active' : '' }}
                             {{ request()->routeIs('alamat.pengiriman.pembeli') ? 'active' : '' }}  
                             dropdown-toggle d-flex align-items-center"
                             data-bs-toggle="dropdown">
                             @if (optional(Auth::user()->updateProfile)->foto)
                                 <img class="border rounded-circle p-2"
                                     src="{{ asset('storage/fotouser/' . Auth::user()->updateProfile->foto) }}"
                                     style="width: 45px; height: 45px;">
                             @else
                                 <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20"
                                     fill="currentColor" class="bi bi-person-fill me-1" viewBox="0 0 16 16">
                                     <path
                                         d="M3 14s-1 0-1-1 1-4 6-4 6 3 6 4-1 1-1 1zm5-6a3 3 0 1 0 0-6 3 3 0 0 0 0 6" />
                                 </svg>
                             @endif
                             <span> {{ Auth::user()->name }}</span>
                         </a>
                         <ul class="dropdown-menu dropdown-menu-end">
                             <li><a href="{{ route('profile.edit') }}" class="dropdown-item">Profile</a></li>
                             <li><a href="{{ route('pesananseafood') }}"
                                     class="dropdown-item {{ request()->routeIs('pesananseafood') ? 'active' : '' }}"
                                     class="dropdown-item">Pesanan Seafood</a></li>

                             <li><a href="{{ route('penyewaanalat') }}"
                                     class="dropdown-item {{ request()->routeIs('penyewaanalat') ? 'active' : '' }}"
                                     class="dropdown-item">Penyewaan Alat</a></li>
                             <li><a href="{{ route('alamat.pengiriman.pembeli') }}" class="dropdown-item">Alamat
                                     Pengiriman</a></li>
                             <li><a href="{{ route('guestarticle') }}" class="dropdown-item">Artikel</a></li>
                             <li><a href="{{ route('bantuan') }}"
                                     class="dropdown-item {{ request()->routeIs('bantuan') ? 'active' : '' }}">Bantuan</a>
                             </li>
                             <li class="mt-1">
                                 <form action="{{ route('logout') }}" method="POST" class="dropdown-item p-0">
                                     @csrf
                                     <button type="submit" class="btn btn-danger w-100"
                                         style="font-size: 0.75rem; padding: 5px;">
                                         {{ __('Log Out') }}
                                     </button>
                                 </form>
                             </li>
                         </ul>
                     </li>
                 </ul>
             </div>
         </div>
     </div>
 </nav>
 <!-- Navbar End -->
