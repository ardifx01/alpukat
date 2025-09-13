<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="utf-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
  <title>@yield('title', 'ALPUKAT - Aplikasi Uji Kelayakan dan Kepatutan')</title>
  @vite(['resources/css/app.css', 'resources/js/app.js'])
  <link rel="shortcut icon" href="{{ asset('images/logo_kepri.png') }}" type="image/x-icon">

  {{-- CSS vendor --}}
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">

</head>
<body class="d-flex flex-column min-vh-100">
    @include('user.theme.header')

    <main id="main-content" class="flex-grow-1">
      @yield('content')
    </main>
    
    @include('user.theme.footer')

    {{-- JS vendor --}}
    <script src="{{ asset('js/jquery-3.4.1.min.js') }}"></script>

    {{-- JS kustom halaman ini --}}
    <script src="{{ asset('js/alpukat.js') }}"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
    <script src="{{ asset('theme/js/scripts.js') }}"></script>
    @stack('scripts')
    <script>
    const header = document.querySelector('header.site-header');

    function syncBodyPad(){
      document.body.style.paddingTop = (header?.offsetHeight || 0) + 'px';
    }

    // jalankan saat load/resize/orientasi
    window.addEventListener('load', syncBodyPad);
    window.addEventListener('resize', syncBodyPad);
    window.addEventListener('orientationchange', syncBodyPad);

    // amati kalau tinggi header berubah karena wrap / badge, dll
    if (window.ResizeObserver && header) {
      new ResizeObserver(syncBodyPad).observe(header);
    }
  </script>

</body>