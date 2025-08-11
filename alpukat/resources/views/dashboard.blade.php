<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
    <title>ALPUKAT - Aplikasi Uji Kelayakan dan Kepatutan</title>
    <link rel="shortcut icon" href="{{ asset('front_end/images/logo_kepri.png') }}" type="image/x-icon">
    <link rel="stylesheet" href="{{ asset('front_end/css/bootstrap.css') }}">
    <link rel="stylesheet" href="{{ asset('front_end/css/style.css') }}">
    <link rel="stylesheet" href="{{ asset('front_end/css/responsive.css') }}">

<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Header ALPUKAT</title>
<style>
    body {
        margin: 0;
        font-family: Arial, sans-serif;
    }

    /* Header Container */
    header {
        background-color: #E6F4FB; /* Warna biru muda */
        display: flex;
        justify-content: space-between;
        align-items: center;
        padding: 10px 40px;
    }

    /* Logo dan Nama */
    .logo-container {
        display: flex;
        align-items: center;
    }

    .logo-container img {
        height: 50px;
        margin-right: 10px;
    }

    .logo-text {
        display: flex;
        flex-direction: column;
    }

    .logo-text h1 {
        font-size: 14px;
        font-weight: bold;
        margin: 0;
    }

    .logo-text p {
        font-size: 12px;
        margin: 0;
    }

    /* Menu Navigation */
    nav {
        display: flex;
        align-items: center;
        gap: 25px;
    }

    nav a {
        text-decoration: none;
        color: black;
        font-size: 14px;
    }

    nav a.active {
        font-weight: bold;
    }

    /* Tombol Login */
    .login-btn {
        background-color: #23349E;
        color: white;
        border: none;
        padding: 8px 16px;
        border-radius: 12px;
        cursor: pointer;
        font-weight: bold;
        text-decoration: none;
    }

    /* Responsif */
    @media (max-width: 768px) {
        header {
            flex-direction: column;
            align-items: flex-start;
        }

        nav {
            margin-top: 10px;
            flex-wrap: wrap;
            gap: 15px;
        }
    }
</style>
</head>
<body>

<header>
    <div class="logo-container">
        <img src="logo.png" alt="Logo Dinas"> <!-- Ganti dengan path logo -->
        <div class="logo-text">
            <h1>Dinas Koperasi, Usaha Kecil dan Menengah</h1>
            <p>Dompak, Kec. Bukit Bestari, Kota Tanjungpinang, Kepulauan Riau</p>
        </div>
    </div>

    <nav>
        <a href="#" class="active">Beranda</a>
        <a href="#">Pengajuan</a>
        <a href="#">Notifikasi</a>
        <a href="#" class="login-btn">Login</a>
    </nav>
</header>

    <!-- Animations -->
    <style>
        @keyframes fadeUp {
            0% { opacity: 0; transform: translateY(30px); }
            100% { opacity: 1; transform: translateY(0); }
        }
        @keyframes fadeLeft {
            0% { opacity: 0; transform: translateX(-30px); }
            100% { opacity: 1; transform: translateX(0); }
        }
        @keyframes fadeRight {
            0% { opacity: 0; transform: translateX(30px); }
            100% { opacity: 1; transform: translateX(0); }
        }

        .animate-up { animation: fadeUp 0.8s ease forwards; }
        .animate-left { animation: fadeLeft 0.8s ease forwards; }
        .animate-right { animation: fadeRight 0.8s ease forwards; }

        .hero-section {
            background: #1f2b7b;
            padding: 80px 0;
            color: white;
        }
        .hero-section h1 {
            font-size: 48px;
            font-weight: bold;
        }
        .hero-section p {
            font-size: 18px;
            margin-bottom: 20px;
        }
        .hero-section .btn-primary {
            background-color: #0071e3;
            border: none;
            padding: 10px 20px;
            font-size: 16px;
            border-radius: 6px;
        }
        .steps-section {
            padding: 60px 0;
            background: #f8f9fa;
            text-align: center;
        }
        .steps-section h2 {
            font-weight: bold;
            margin-bottom: 40px;
        }
        .step-box {
            background: white;
            padding: 20px;
            border-radius: 12px;
            box-shadow: 0 4px 8px rgba(0,0,0,0.1);
            margin-bottom: 20px;
            opacity: 0; /* Hidden before animation */
        }
        .step-number {
            font-size: 22px;
            font-weight: bold;
            background: #000;
            color: #fff;
            width: 40px;
            height: 40px;
            line-height: 40px;
            border-radius: 50%;
            margin: 0 auto 10px;
        }
        .about-section {
            padding: 60px 0;
        }
        .about-section img {
            width: 100%;
            border-radius: 8px;
        }
        footer {
            background: #1f2b7b;
            color: white;
            text-align: center;
            padding: 15px 0;
        }
    </style>
</head>
<body>

{{-- @include('partials.navbar') Navbar tetap sama seperti versi sebelumnya --}}

<!-- Hero -->
<section class="hero-section">
    <div class="container">
        <div class="row align-items-center">
            <div class="col-md-7 animate-up">
                <h1>Selamat Datang di <br>ALPUKAT</h1>
                <p>Aplikasi Uji Kelayakan dan Kepatutan</p>
                <a href="{{ asset('files/juklak_ukk.pdf') }}" class="btn btn-primary mb-2" download>Download Juklak UKK</a>
                @guest
                    <br>
                    <a href="{{ route('login') }}" class="btn btn-light">Login untuk Pengajuan</a>
                @endguest
            </div>
            <div class="col-md-5 animate-right">
                <img src="{{ asset('front_end/images/gambar_login.png') }}" alt="Gedung" class="img-fluid rounded">
            </div>
        </div>
    </div>
</section>

<!-- Steps -->
<section class="steps-section">
    <div class="container">
        <h2 class="animate-up">Tata Cara Pengajuan</h2>
        <div class="row">
            @foreach (['Pendaftaran','Unggah','Verifikasi','Wawancara','Hasil'] as $i => $step)
                <div class="col-md-2 {{ $i == 0 ? 'offset-md-1' : '' }}">
                    <div class="step-box" style="animation: fadeUp 0.6s ease {{ $i * 0.2 }}s forwards;">
                        <div class="step-number">{{ $i+1 }}</div>
                        <p>{{ $step }}</p>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
</section>

<!-- contact section -->

    <section class="contact_section ">
        <div class="container px-0">
            <div class="heading_container ">
                <h2 class="">
                    Contact Us
                </h2>
            </div>
        </div>
        <div class="container container-bg">
            <div class="row">
                <div class="col-lg-7 col-md-6 px-0">
                    <div class="map_container">
                        <div class="map-responsive">
                            <iframe src="https://www.google.com/maps/embed/v1/place?key=AIzaSyA0s1a7phLN0iaD6-UE7m4qP-z21pH0eSc&q=Eiffel+Tower+Paris+France" width="600" height="300" frameborder="0" style="border:0; width: 100%; height:100%" allowfullscreen></iframe>
                        </div>
                    </div>
                </div>
                <div class="col-md-6 col-lg-5 px-0">
                    <form action="#">
                        <div>
                            <input type="text" placeholder="Name" />
                        </div>
                        <div>
                            <input type="email" placeholder="Email" />
                        </div>
                        <div>
                            <input type="text" placeholder="Phone" />
                        </div>
                        <div>
                            <input type="text" class="message-box" placeholder="Message" />
                        </div>
                        <div class="d-flex ">
                            <button>
                                SEND
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </section>

    <br><br><br>

    <!-- end contact section -->



    <!-- info section -->

    <section class="info_section  layout_padding2-top">
        <div class="social_container">
            <div class="social_box">
                <a href="">
                    <i class="fa fa-facebook" aria-hidden="true"></i>
                </a>
                <a href="">
                    <i class="fa fa-twitter" aria-hidden="true"></i>
                </a>
                <a href="">
                    <i class="fa fa-instagram" aria-hidden="true"></i>
                </a>
                <a href="">
                    <i class="fa fa-youtube" aria-hidden="true"></i>
                </a>
            </div>
        </div>
        <div class="info_container ">
            <div class="container">
                <div class="row">
                    <div class="col-md-6 col-lg-3">
                        <h6>
                            ABOUT US
                        </h6>
                        <p>
                            Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed doLorem ipsum dolor sit amet, consectetur adipiscing elit, sed doLorem ipsum dolor sit amet,
                        </p>
                    </div>
                    <div class="col-md-6 col-lg-3">
                        <div class="info_form ">
                            <h5>
                                Newsletter
                            </h5>
                            <form action="#">
                                <input type="email" placeholder="Enter your email">
                                <button>
                                    Subscribe
                                </button>
                            </form>
                        </div>
                    </div>
                    <div class="col-md-6 col-lg-3">
                        <h6>
                            NEED HELP
                        </h6>
                        <p>
                            Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed doLorem ipsum dolor sit amet, consectetur adipiscing elit, sed doLorem ipsum dolor sit amet,
                        </p>
                    </div>
                    <div class="col-md-6 col-lg-3">
                        <h6>
                            CONTACT US
                        </h6>
                        <div class="info_link-box">
                            <a href="">
                                <i class="fa fa-map-marker" aria-hidden="true"></i>
                                <span> Gb road 123 london Uk </span>
                            </a>
                            <a href="">
                                <i class="fa fa-phone" aria-hidden="true"></i>
                                <span>+01 12345678901</span>
                            </a>
                            <a href="">
                                <i class="fa fa-envelope" aria-hidden="true"></i>
                                <span> demo@gmail.com</span>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- footer section -->
        <footer class=" footer_section">
            <div class="container">
                <p>
                    &copy; <span id="displayYear"></span> All Rights Reserved By
                    <a href="https://html.design/">Web Tech Knowledge</a>
                </p>
            </div>
        </footer>
        <!-- footer section -->

    </section>

    <!-- end info section -->


    <script src="front_end/js/jquery-3.4.1.min.js"></script>
    <script src="front_end/js/bootstrap.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.3.4/owl.carousel.min.js">
    </script>
    <script src="front_end/js/custom.js"></script>

</body>

</html>