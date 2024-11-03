<!DOCTYPE html>
<html lang="id">

<head>
    @yield('title')

    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
    <meta name="description" content="" />
    <meta name="author" content="" />
    <link href="https://cdn.jsdelivr.net/npm/simple-datatables@7.1.2/dist/style.min.css" rel="stylesheet" />
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="{{ asset('css/styles.css') }}">
    <script src="https://use.fontawesome.com/releases/v6.3.0/js/all.js" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/css/bootstrap.min.css"
        integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">

    <!-- Favicon -->
    <link href="{{ asset('img/logo (1).svg') }}" rel="icon">
    <link href="https://cdn.jsdelivr.net/npm/sweetalert2@11.14.3/dist/sweetalert2.min.css" rel="stylesheet">
</head>

<body class="sb-nav-fixed" style="{{ asset('img/bg.svg') }}">
    @include('layouts.navbarnelayan')

    <!-- Main Content -->
    <div id="layoutSidenav_content">
        <main>
            <div class="container-fluid px-4">
                @yield('content')
            </div>
            <main>
    </div>

    @yield('foot')

    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11.14.3/dist/sweetalert2.all.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js" crossorigin="anonymous">
    </script>
    <script src="{{ asset('js/scripts.js') }}"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.8.0/Chart.min.js" crossorigin="anonymous"></script>
    <script src="{{ asset('js/chart-area-demo.js') }}"></script>
    <script src="{{ asset('js/chart-bar-demo.js') }}"></script>
    <script src="https://cdn.jsdelivr.net/npm/simple-datatables@7.1.2/dist/umd/simple-datatables.min.js"
        crossorigin="anonymous"></script>
    <script src="{{ asset('js/datatables-simple-demo.js') }}"></script>

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
    function searchSeafood() {
        // Ambil nilai input pencarian
        const query = document.getElementById('searchInput').value;

        // Cek apakah query tidak kosong
        if (query.trim() !== '') {
            // Redirect ke route sefood.index dengan parameter pencarian
            window.location.href = '{{ route("sefood.index") }}?search=' + encodeURIComponent(query);
        } else {
            alert('Silakan masukkan kata kunci pencarian.');
        }
    }
</script>
</body>

</html>
