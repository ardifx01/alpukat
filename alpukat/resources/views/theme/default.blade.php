<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
    <meta name="description" content="" />
    <meta name="author" content="" />
    <title>Dinas Koperasi dan UKM Provinsi Kepulauan Riau</title>
    <link href="https://cdn.jsdelivr.net/npm/simple-datatables@7.1.2/dist/style.min.css" rel="stylesheet" />
    <link href="{{ asset('theme/css/styles.css') }}" rel="stylesheet" />
    <link rel="shortcut icon" href="{{ asset('theme/assets/img/logo_kepri.png') }}">
    <script src="https://use.fontawesome.com/releases/v6.3.0/js/all.js" crossorigin="anonymous"></script>
</head>
<body class="sb-nav-fixed">
    @include('theme.header')

    <div id="layoutSidenav">
        @include('theme.sidebar')

        <div id="layoutSidenav_content">
            <main>
                @yield('content')
            </main>

            @include('theme.footer')

            <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-...hash..." crossorigin="anonymous"></script>

            <script src="{{ asset('theme/js/scripts.js') }}"></script>
        </div>
    </div>
</body>
</html>