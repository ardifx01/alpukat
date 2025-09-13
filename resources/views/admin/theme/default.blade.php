<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
    <meta name="description" content="" />
    <meta name="author" content="" />
    <title>Dinas Koperasi dan UKM Provinsi Kepulauan Riau</title>
    <link rel="stylesheet"
        href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css"
        integrity="sha384-..." crossorigin="anonymous">
    <link href="https://cdn.jsdelivr.net/npm/simple-datatables@7.1.2/dist/style.min.css" rel="stylesheet" />
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">
    <link rel="stylesheet" href="{{ asset('css_admin/admin.css') }}">
    <link rel="stylesheet" href="{{ asset('css_admin/styles.css') }}">
    <link rel="shortcut icon" href="{{ asset('images/logo_kepri.png') }}">
    <script src="https://use.fontawesome.com/releases/v6.3.0/js/all.js" crossorigin="anonymous"></script>
</head>

<body class="sb-nav-fixed">
    @include('admin.theme.header')

    <div id="layoutSidenav">
        @include('admin.theme.sidebar')

        <div id="layoutSidenav_content">
            <main>
                {{-- Flash message global --}}
                @foreach (['success', 'error', 'warning', 'info'] as $msg)
                @if(session($msg))
                <div class="alert alert-{{ $msg === 'error' ? 'danger' : $msg }} 
                                    alert-dismissible fade show mt-3 mx-3" role="alert">
                    {{ session($msg) }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
                @endif
                @endforeach
                {{-- Akhir flash message global --}}

                @yield('content')
            </main>

            @include('admin.theme.footer')

            <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-...hash..." crossorigin="anonymous"></script>

            <script src="{{ asset('js_admin/scripts.js') }}"></script>

            {{-- Script animasi flash message --}}
            <style>
                /* Efek muncul slide dari atas */
                .alert {
                    transform: translateY(-20px);
                    opacity: 0;
                    transition: all 0.5s ease;
                }

                .alert.showing {
                    transform: translateY(0);
                    opacity: 1;
                }
            </style>

            <script>
                document.addEventListener('DOMContentLoaded', function() {
                    const alerts = document.querySelectorAll('.alert');

                    alerts.forEach(function(alert) {
                        // Tambah kelas untuk animasi muncul
                        setTimeout(() => alert.classList.add('showing'), 50);

                        // Setelah 3 detik, fade out
                        setTimeout(function() {
                            // Tambahkan efek fade out
                            alert.style.opacity = '0';
                            alert.style.transform = 'translateY(-20px)';
                            setTimeout(() => alert.remove(), 500); // hapus setelah animasi selesai
                        }, 5000);
                    });
                });
            </script>
        </div>
    </div>
</body>

</html>