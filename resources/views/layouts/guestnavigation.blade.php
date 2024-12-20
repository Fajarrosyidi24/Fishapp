 <!-- Google Fonts -->
 <link href="https://fonts.googleapis.com/css2?family=Jolly+Lodger&display=swap" rel="stylesheet">

<!-- Navbar Start -->
<nav class="navbar navbar-expand-lg navbar-light shadow sticky-top" style="background-color: #097ABA;">
    <div class="container-fluid px-4">
        <!-- Logo dan Judul -->
        <a href="{{ route('dashboard') }}" class="navbar-brand d-flex align-items-center">
            <img src="{{ asset('img/Fishapp new logo.png') }}" alt="logo" style="width: 100px; height: 90px; margin-right: 10px;"> 
            <span style="
            font-family: 'Jolly Lodger', cursive; 
            font-size: 3rem; 
            font-weight: semi bold; 
            color: white; 
            line-height: 1;">FISHApp </span>
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
                        <input 
                            class="form-control" 
                            type="search" 
                            placeholder="Search for..." 
                            aria-label="Search"
                            aria-describedby="btnNavbarSearch" 
                            id="searchInput"
                        />
                        <button 
                            class="btn btn-primary" 
                            id="btnNavbarSearch" 
                            type="button">
                            <i class="fas fa-search"></i>
                        </button>
                    </div>
                </form>
            </div>
                    
                    <!-- Menu Navigasi -->
                    <ul class="navbar-nav ms-5 mb-2 mb-lg-0">
                                <li class="nav-item">
                                    <a href="{{ route('index') }}" class="nav-item nav-link {{ request()->routeIs('index') ? 'active' : '' }}">Dashboard</a>
                                </li>
                                <li class="nav-item">
                                    <a href="{{route('about')}}" class="nav-item nav-link {{ request()->routeIs('about_information') ? 'active' : '' }} {{ request()->routeIs('about') ? 'active' : '' }}" class="nav-link">About</a>
                                </li>
                                <li class="nav-item dropdown">
                                    <a href="#" class="nav-link dropdown-toggle
                                    {{ request()->routeIs('barangsewa.guest') ? 'active' : '' }}
                                    {{ request()->routeIs('seafood.guest') ? 'active' : '' }}
                                    " data-bs-toggle="dropdown">
                                    Produk
                                </a>
                                <ul class="dropdown-menu">
                                    <li><a href="{{route('barangsewa.guest')}}" class="dropdown-item">Barang Sewa</a></li>
                                    <li><a href="{{route('seafood.guest')}}" class="dropdown-item">Seafoods</a></li>
                                </ul>
                            </li>
                            
                            <li class="nav-item">
                                <a href="{{route('guestarticle')}}" class="nav-item nav-link" class="nav-link">Artikel</a>
                            </li>
                            
                        </ul>
                        
                        <div class="ms-auto">
                            <a href="{{route('login')}}">
                                <button type="button" class="btn btn-outline-dark" style="width:100px">Login</button>
                            </a>
                            <a href="{{route('register')}}">
                                <button type="button" class="btn btn-dark" style="width:100px">Register</button>
                            </a>
                        </div>
                </div>
                
    </div>
</nav>
<!-- Navbar End -->
