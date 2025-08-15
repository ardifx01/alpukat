<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="utf-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
  <title>@yield('title', 'ALPUKAT - Aplikasi Uji Kelayakan dan Kepatutan')</title>

  <link rel="shortcut icon" href="{{ asset('front_end/images/logo_kepri.png') }}" type="image/x-icon">

  {{-- CSS vendor --}}
  <link rel="stylesheet" href="{{ asset('front_end/css/bootstrap.css') }}">
  <link rel="stylesheet" href="{{ asset('front_end/css/style.css') }}">
  <link rel="stylesheet" href="{{ asset('front_end/css/responsive.css') }}">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">

  {{-- CSS kustom halaman ini --}}
  <link rel="stylesheet" href="{{ asset('front_end/css/alpukat.css') }}">
</head>
<body class="d-flex flex-column min-vh-100">
    @include('user.theme.header')

    <main id="main-content" class="flex-grow-1">
      @yield('content')
    </main>
    
    @include('user.theme.footer')

    {{-- JS vendor --}}
    <script src="{{ asset('front_end/js/jquery-3.4.1.min.js') }}"></script>

    {{-- JS kustom halaman ini --}}
    <script src="{{ asset('front_end/js/alpukat.js') }}"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
    <script src="{{ asset('theme/js/scripts.js') }}"></script>
</body>