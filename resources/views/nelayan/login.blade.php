<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="utf-8">
    <meta content="width=device-width, initial-scale=1.0" name="viewport">
    <meta content="" name="keywords">
    <meta content="" name="description">

    <title>Login Nelayan Page - Fishapp</title>

    <!-- Favicon -->
    <link href="{{ asset('img/logo (1).svg') }}" rel="icon">

    <!-- Google Web Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link
        href="https://fonts.googleapis.com/css2?family=Heebo:wght@400;500;600&family=Nunito:wght@600;700;800&display=swap"
        rel="stylesheet">

    <!-- Icon Font Stylesheet -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.10.0/css/all.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.4.1/font/bootstrap-icons.css" rel="stylesheet">

    <!-- Libraries Stylesheet -->
    <link href="{{ asset('lib/animate/animate.min.css') }}" rel="stylesheet">
    <link href="{{ asset('lib/owlcarousel/assets/owl.carousel.min.css') }}" rel="stylesheet">

    <!-- Customized Bootstrap Stylesheet -->
    <link href="{{ asset('css/bootstrap.min.css') }}" rel="stylesheet">

    <link href="{{ asset('css/style.css') }}" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/sweetalert2@11.14.3/dist/sweetalert2.min.css" rel="stylesheet">

    {{-- @vite(['resources/css/app.css', 'resources/js/app.js']) --}}

    <style>
        body {
            background-size: cover;
            background-repeat: no-repeat;
            margin: 0;
            background-attachment: fixed;
            background-image: url('img/bg.svg');
        }

        .custom-title {
            font-size: 2rem;
            font-weight: bold;
        }
    </style>
</head>

<body class="font-sans antialiased min-h-screen dark:bg-gray-900">
    @include('components.spiner')
    @include('layouts.guestnavigation')

    <div class="container mt-5 mb-5">
        <div class="row justify-content-center">
            <div class="col-md-6 col-lg-4">
                <form action="{{ route('nelayan.login') }}" method="POST" class="shadow p-4 rounded bg-white">
                    @csrf
                    <h1 class="text-center mb-4 custom-title">Login Nelayan</h1>

                    <div class="form-group mb-3">
                        <label for="email">Email</label>
                        <input type="email" class="form-control" id="email" name="email" required
                            placeholder="Masukkan email Anda">
                    </div>

                    <div class="form-group mb-3">
                        <label for="password">Password</label>
                        <div class="input-group">
                            <input type="password" class="form-control" id="password" name="password" required
                                placeholder="Masukkan kata sandi Anda">
                            <div class="input-group-append" id="toggle-password" style="cursor: pointer;">
                                <span class="input-group-text d-flex align-items-center" style="height: 100%;">
                                    <i class="bi bi-eye" id="eye-icon"></i>
                                </span>
                            </div>
                        </div>
                    </div>
                   
                    <div class="form-group form-check mb-3">
                        <input type="checkbox" class="form-check-input" id="remember" name="remember">
                        <label class="form-check-label" for="remember">Ingat Saya</label>
                    </div>
    
                    <button type="submit" class="btn btn-primary w-100 mb-3">Login</button>
    
                    <div class="text-center mb-3">
                        <span class="text-muted">atau masuk dengan</span>
                    </div>
    
                    <div class="d-flex justify-content-between mb-3">
                        <a href="{{ route('nelayan.password.request') }}" class="d-block" style="font-size: 0.850rem;">Lupa Kata Sandi?</a>
                        <a href="{{ route('login') }}" class="d-block" style="font-size: 0.850rem;">Masuk Sebagai Pembeli</a>
                    </div>
                </div>            
            </form>
        </div>
    </div>

    <!-- Back to Top -->
    <a href="#" class="btn btn-lg btn-primary btn-lg-square back-to-top">
        <i class="bi bi-arrow-up"></i>
    </a>

    <!-- JavaScript Libraries -->
    <script src="https://code.jquery.com/jquery-3.4.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="{{ asset('lib/wow/wow.min.js') }}"></script>
    <script src="{{ asset('lib/easing/easing.min.js') }}"></script>
    <script src="{{ asset('lib/waypoints/waypoints.min.js') }}"></script>
    <script src="{{ asset('lib/owlcarousel/owl.carousel.min.js') }}"></script>

    <!-- Template Javascript -->
    <script src="{{ asset('js/main.js') }}"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11.14.3/dist/sweetalert2.all.min.js"></script>

    <script>
        @if ($errors->any())
            Swal.fire({
                icon: "error",
                title: "Oops...",
                html: `{!! implode('<br>', $errors->all()) !!}`, // Gabungkan semua error menjadi string.
            });
        @endif
    </script>

    <script>
        @if (session('success'))
            Swal.fire({
                icon: 'success',
                title: 'Berhasil',
                html: `{!! session('success') !!}`, // Menggunakan 'html' agar bisa menampilkan HTML/teks langsung.
            });
        @elseif (session('status'))
            Swal.fire({
                icon: 'info',
                title: 'Status',
                html: `{!! session('status') !!}`,
            });
        @elseif (session('gagal'))
            Swal.fire({
                icon: 'error',
                title: 'Oops...',
                html: `{!! session('gagal') !!}`,
            });
        @endif
    </script>

    <script>
        function toggleDarkMode() {
            document.documentElement.classList.toggle('dark');
        }
    </script>

<script>
    document.getElementById('toggle-password').addEventListener('click', function() {
           const passwordInput = document.getElementById('password');
           const eyeIcon = document.getElementById('eye-icon');
   
           if (passwordInput.type === 'password') {
               passwordInput.type = 'text'; // Tampilkan password
               eyeIcon.classList.remove('bi-eye'); // Ganti ikon mata
               eyeIcon.classList.add('bi-eye-slash'); // Ganti ikon mata
           } else {
               passwordInput.type = 'password'; // Sembunyikan password
               eyeIcon.classList.remove('bi-eye-slash'); // Ganti ikon mata
               eyeIcon.classList.add('bi-eye'); // Ganti ikon mata
           }
       });
</script>
</body>
</html>

{{-- token api  biteship --}}
{{-- biteship_live.eyJhbGciOiJIUzI1NiIsInR5cCI6IkpXVCJ9.eyJuYW1lIjoiRmlzaGFwcCIsInVzZXJJZCI6IjY3MzZhZGVhMTRlOWFhMDAxMWIzYTc4YyIsImlhdCI6MTczMTYzNzIyNX0.rko4V7bBeL_Fool_V-kf6xKmujFdf06eWhI3OcFRPOc --}}


{{-- testing --}}
{{-- biteship_test.eyJhbGciOiJIUzI1NiIsInR5cCI6IkpXVCJ9.eyJuYW1lIjoiRmlzaGFwcF9UZXN0aW5nIiwidXNlcklkIjoiNjczNmFkZWExNGU5YWEwMDExYjNhNzhjIiwiaWF0IjoxNzMxNjM3NTAwfQ.W-8nzQwRRVG7Pi5OJPv2hrTUH0Nxh6lJbvKIPEN_nQ4 --}}