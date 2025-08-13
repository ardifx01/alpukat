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
  <!-- Font Awesome -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">

  <style>
    body{margin:0;font-family:Arial,Helvetica,sans-serif}
    /* Header */
    header{
      background:#E6F4FB;display:flex;justify-content:space-between;align-items:center;
      padding:10px 40px;position:fixed;top:0;left:0;width:100%;z-index:1000
    }
    body{padding-top:65px}
    .logo-container{display:flex;align-items:center}
    .logo-container img{height:50px;margin-right:10px}
    .logo-text{display:flex;flex-direction:column}
    .logo-text h1{font-size:14px;font-weight:bold;margin:0}
    .logo-text p{font-size:12px;margin:0}
    nav{display:flex;align-items:center;gap:25px}
    nav a{text-decoration:none;color:#000;font-size:14px}
    nav a.active{font-weight:bold}
    .login-btn,.sign-up{background:#23349E;color:#fff;border:none;padding:8px 16px;border-radius:12px;cursor:pointer;font-weight:bold;text-decoration:none}
    @media (max-width:768px){header{flex-direction:column;align-items:flex-start}nav{margin-top:10px;flex-wrap:wrap;gap:15px}}

    /* Animations */
    @keyframes fadeUp{0%{opacity:0;transform:translateY(30px)}100%{opacity:1;transform:translateY(0)}}
    @keyframes fadeLeft{0%{opacity:0;transform:translateX(-30px)}100%{opacity:1;transform:translateX(0)}}
    @keyframes fadeRight{0%{opacity:0;transform:translateX(30px)}100%{opacity:1;transform:translateX(0)}}
    .animate-up{animation:fadeUp .8s ease forwards}
    .animate-left{animation:fadeLeft .8s ease forwards}
    .animate-right{animation:fadeRight .8s ease forwards}

    /* HERO */
    .hero-section{
      background:url('../front_end/images/gambar_login.png') no-repeat center center/cover;
      padding:60px 0;color:#fff;position:relative;overflow:hidden
    }
    .hero-section::before{content:"";position:absolute;inset:0;background:rgba(26,35,126,.65);z-index:1}
    .hero-section .container{position:relative;z-index:2}
    .hero-img{display:block;width:100%;max-width:460px;height:auto;margin-left:auto;border-radius:12px}
    .hero-title{font-size:2.2rem;font-weight:bold;margin-bottom:.5rem}
    .hero-brand{font-size:3.2rem;font-weight:bold;letter-spacing:2px;margin-bottom:1rem}
    .hero-desc{font-size:1.5rem;margin-bottom:1.2rem;font-weight:500}
    @media (max-width:991.98px){.hero-section{padding:40px 0}.hero-img{max-width:360px;margin:24px auto 0}}
    @media (max-width:575.98px){.hero-section{padding:28px 0}.hero-img{max-width:300px}}
    .hero-section .btn-primary{background:#0071e3;border:none;padding:10px 20px;font-size:16px;border-radius:6px}

    /* ===== STEPS (latar batik + grid + hover) ===== */
    .steps-section{
      padding:56px 0;
      background:
        linear-gradient(rgba(255,255,255,.40), rgba(255,255,255,.40)),
        url('{{ asset('front_end/images/bg-batik-kepri.png') }}') repeat center center;
      background-size:auto;
      text-align:center;
      color:#000;
    }
    /* persempit area konten steps */
    .steps-section .container{max-width:1100px}
    @media (max-width:576px){.steps-section{background-size:cover,280px}}

    .steps-section h2{font-weight:bold;margin-bottom:34px}

    .steps-grid{display:grid;grid-template-columns:repeat(5,minmax(180px,1fr));gap:24px}
    @media (max-width:992px){.steps-grid{grid-template-columns:repeat(3,minmax(180px,1fr))}}
    @media (max-width:576px){.steps-grid{grid-template-columns:repeat(2,minmax(150px,1fr))}}

    .step-box{
      position:relative;background:#fff;border-radius:14px;box-shadow:0 4px 12px rgba(0,0,0,.08);
      transition:box-shadow .2s ease, transform .2s ease;overflow:hidden;
      min-height:250px;display:flex;align-items:center;justify-content:center
    }
    .step-box:hover{transform:translateY(-2px);box-shadow:0 8px 20px rgba(0,0,0,.12)}

    .step-panel{
      position:absolute;inset:0;display:flex;flex-direction:column;align-items:center;justify-content:center;gap:12px;
      border-left:6px solid #23349E;padding-left:12px;opacity:0;transform:translateY(10px);
      transition:opacity .25s ease, transform .35s ease;pointer-events:none;background:rgba(255,255,255,.97);text-align:center
    }
    .step-icon{width:38px;height:38px;border-radius:8px;background:#23349E;color:#fff;display:inline-flex;align-items:center;justify-content:center;font-size:18px;opacity:0;transform:translateX(-6px);transition:opacity .25s ease, transform .35s ease}
    .step-title{margin:0 0 6px 0;font-weight:700;font-size:1.05rem}
    .step-desc{margin:0;color:#333;font-size:.98rem;line-height:1.5}
    .step-main{display:flex;flex-direction:column;align-items:center;justify-content:center;min-height:110px;padding:36px 14px 18px;transition:opacity .2s}
    .step-main-number{font-size:2rem;font-weight:700;color:#23349E;line-height:1}
    .step-main-title{font-size:1.1rem;font-weight:600;margin-top:2px;color:#23349E;line-height:1.2}
    .step-box:hover .step-panel{opacity:1;transform:none;pointer-events:auto}
    .step-box:hover .step-icon{opacity:1;transform:none}
    .step-box:hover .step-main{opacity:0;visibility:hidden}

    /* ===== Tentang Kami (sesuai gambar) ===== */
    .about-section{padding:52px 0}
    .about-card{
      background:#fff;border-radius:18px;box-shadow:0 10px 30px rgba(0,0,0,.08);
      padding:26px
    }
    .about-map{
      width:100%;height:340px;border:0;border-radius:12px;box-shadow:0 6px 16px rgba(0,0,0,.08)
    }
    .about-text h3{font-weight:800;margin-bottom:16px}
    .about-text p{font-size:1.05rem;line-height:1.7;color:#333}
    .about-list{margin-top:16px}
    .about-item{display:flex;align-items:center;gap:12px;margin:10px 0;font-size:1rem;color:#222}
    .about-icon{
      width:38px;height:38px;border-radius:10px;background:#23349E;color:#fff;display:inline-flex;align-items:center;justify-content:center
    }

    /* ===== Contact – kartu elegan di tengah ===== */
    .contact_section{
      padding:72px 0;
      background:
        radial-gradient(24px 24px at 20% 15%, rgba(35,52,158,.05) 0 40%, rgba(0,0,0,0) 41%),
        radial-gradient(24px 24px at 80% 85%, rgba(35,52,158,.05) 0 40%, rgba(0,0,0,0) 41%),
        linear-gradient(180deg, #f7f9ff 0%, #f1f3ff 100%);
    }
    .contact-card{
      max-width: 860px;
      margin: 0 auto;
      background:#fff;
      border-radius: 18px;
      box-shadow: 0 18px 40px rgba(35,52,158,.12);
      padding: 28px 26px;
    }
    @media (min-width:768px){
      .contact-card{ padding: 36px 40px; }
    }
    .contact-heading{ text-align:center; margin-bottom: 22px; }
    .contact-heading h2{ font-weight: 800; margin: 0 0 6px; }
    .contact-heading p{ margin: 0; color:#5b6475; font-size: .98rem; }

    .input-grid{ display:grid; grid-template-columns:1fr; gap:16px; }
    @media (min-width:768px){ .input-grid{ grid-template-columns:1fr 1fr; } }
    .input-wrap{ position:relative; }
    .input-wrap i{
      position:absolute; left:12px; top:50%; transform:translateY(-50%);
      font-size:16px; color:#9aa3b2; pointer-events:none;
    }
    .input-wrap input, .input-wrap textarea{
      width:100%; border:1px solid #e3e7ef; border-radius:12px;
      padding:12px 14px 12px 38px; font-size:15px; outline:none;
      transition:border-color .2s, box-shadow .2s, transform .08s; background:#fbfcff;
    }
    .input-wrap textarea{ min-height:120px; resize:vertical; padding-left:38px; }
    .input-wrap input:focus, .input-wrap textarea:focus{
      border-color:#23349E; box-shadow:0 0 0 4px rgba(35,52,158,.10); background:#fff;
    }
    .send-row{ margin-top: 8px; }
    .contact-btn{
      width:100%; background:#23349E; color:#fff; border:none; border-radius:12px;
      padding:12px 18px; font-weight:700; letter-spacing:.3px;
      transition: transform .08s ease, box-shadow .2s ease, background .2s ease;
    }
    .contact-btn:hover{ box-shadow:0 12px 24px rgba(35,52,158,.20); background:#1f2b7b; }
    .contact-btn:active{ transform: translateY(1px); }
    .small-note{ text-align:center; margin-top:10px; color:#7a8496; font-size:.9rem; }

    /* Footer simple */
    footer.footer_section{background:#1f2b7b;color:#fff;text-align:center;padding:20px 0}
    footer .social_box a {color:#fff;margin:0 12px;font-size:22px;}
  </style>
</head>
<body>

  <header>
    <div class="logo-container">
      <img src="{{ asset('front_end/images/logo_kepri.png') }}" alt="Logo Dinas">
      <div class="logo-text">
        <h1>Dinas Koperasi, Usaha Kecil dan Menengah</h1>
        <p>Dompak, Kec. Bukit Bestari, Kota Tanjungpinang, Kepulauan Riau</p>
      </div>
    </div>

    <nav>
      <a href="#" class="active">Beranda</a>
      <a href="{{ route('user.create') }}">Pengajuan</a>
      <a href="{{ route('user.lihat_berkas') }}">Lihat Berkas</a>
      @php
          $jumlahNotif = 0;
          if(auth()->check()) {
              $jumlahNotif = auth()->user()->notifikasi()->where('dibaca', false)->count();
          }
      @endphp
      <a href="{{ route('user.notifikasi') }}">
        Notifikasi
        @if($jumlahNotif > 0)
          <span class="badge bg-danger">{{ $jumlahNotif }}</span>
        @endif
      </a>
      <a href="#" class="login-btn">Login</a>
      <a href="#" class="sign-up">Register</a>
    </nav>
  </header>

  {{-- Hero --}}
  <section class="hero-section">
    <div class="container">
      <div class="row align-items-center">
        <div class="col-md-7 animate-up">
          <h3 class="hero-title"><strong>Selamat Datang di </strong></h3>
          <h1 class="hero-brand"><strong>ALPUKAT</strong></h1>
          <p class="hero-desc">Aplikasi Uji Kelayakan dan Kepatutan</p>
          <a href="{{ asset('files/juklak_ukk.pdf') }}" class="btn btn-primary mb-2" download>Download Juklak UKK</a>
          @guest
          <br>
          <a href="{{ route('login') }}" class="btn btn-light">Login untuk Pengajuan</a>
          @endguest
        </div>
        <div class="col-md-5 animate-right">
          <img src="{{ asset('front_end/images/profile DKUKM.jpeg') }}"
               alt="Dinas Koperasi Usaha Kecil & Menengah Kepulauan Riau"
               class="img-fluid rounded hero-img">
        </div>
      </div>
    </div>
  </section>

  {{-- Steps --}}
  <section class="steps-section">
    <div class="container">
      <h2 class="animate-up">Tata Cara Pengajuan</h2>

      @php
        $steps = [
          ['title'=>'Pendaftaran','desc'=>'Masuk/daftar akun. Unduh Juklak UKK untuk menyiapkan berkas.','icon'=>'fa-user-plus'],
          ['title'=>'Unggah','desc'=>'Isi formulir dan unggah seluruh berkas persyaratan sesuai juklak.','icon'=>'fa-upload'],
          ['title'=>'Verifikasi','desc'=>'Tim memeriksa kelengkapan dan keabsahan berkas. Lengkapi jika ada catatan.','icon'=>'fa-check-square'],
          ['title'=>'Wawancara','desc'=>'Ikuti wawancara sesuai jadwal. Siapkan dokumen asli bila diminta.','icon'=>'fa-comments'],
          ['title'=>'Hasil','desc'=>'Lihat keputusan UKK (Lulus/Tidak Lulus) di dashboard/email. Unduh berita acara.','icon'=>'fa-flag-checkered'],
        ];
      @endphp

      <div class="steps-grid">
        @foreach ($steps as $i => $s)
          <div class="step-box" style="animation: fadeUp 0.6s ease {{ $i * 0.2 }}s forwards;">
            <div class="step-main">
              <div class="step-main-number">{{ $i+1 }}.</div>
              <div class="step-main-title">{{ $s['title'] }}</div>
            </div>

            <div class="step-panel">
              <span class="step-icon"><i class="fa {{ $s['icon'] }}" aria-hidden="true"></i></span>
              <div>
                <div class="step-title">{{ $s['title'] }}</div>
                <p class="step-desc mb-0">{{ $s['desc'] }}</p>
              </div>
            </div>
          </div>
        @endforeach
      </div>
    </div>
  </section>

  {{-- Tentang Kami --}}
  <section class="about-section">
    <div class="container">
      <h2 class="mb-4" style="font-weight:800">Tentang Kami</h2>
      <div class="about-card">
        <div class="row align-items-start g-4">
          <div class="col-lg-7">
            <iframe
              class="about-map"
              src="https://www.google.com/maps/embed/v1/place?key=AIzaSyA0s1a7phLN0iaD6-UE7m4qP-z21pH0eSc&q=Dinas+Koperasi+Usaha+Kecil+dan+Menengah+Kepulauan+Riau"
              allowfullscreen>
            </iframe>
          </div>
          <div class="col-lg-5 about-text">
            <p>
              Dinas Koperasi dan UMKM Kepri adalah instansi pemerintah daerah yang bertanggung jawab
              dalam pembinaan, pengembangan, dan pemberdayaan Koperasi dan Usaha Mikro, Kecil, dan Menengah (UMKM)
              di wilayah kerjanya.
            </p>

            <div class="about-list">
              <div class="about-item">
                <span class="about-icon"><i class="fa fa-envelope"></i></span>
                dkukmprovkepri@gmail.com
              </div>
              <div class="about-item">
                <span class="about-icon"><i class="fa fa-phone"></i></span>
                0812-3456-7890
              </div>
              <div class="about-item">
                <span class="about-icon"><i class="fa fa-instagram"></i></span>
                @dkukmkepri
              </div>
            </div>
          </div>
        </div>
      </div>  
    </div>
  </section>

   {{-- Footer simple --}}
  <footer class="footer_section">
    <div class="social_box">
      <a href="mailto:dkukmprovkepri@gmail.com">
        <i class="fa fa-envelope" aria-hidden="true"></i>
      </a>
      <a href="tel:081234567890">
        <i class="fa fa-phone" aria-hidden="true"></i>
      </a>
      <a href="https://instagram.com/dkukmkepri" target="_blank">
        <i class="fa fa-instagram" aria-hidden="true"></i>
      </a>
    </div>
    <p>&copy; <span id="displayYear"></span> Dinas Koperasi Usaha Kecil dan Menengah. All Rights Reserved</p>
  </footer>


  <script>
    // tahun otomatis
    document.getElementById('displayYear').textContent = new Date().getFullYear();
  </script>

  <script src="front_end/js/jquery-3.4.1.min.js"></script>
  <script src="front_end/js/bootstrap.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.3.4/owl.carousel.min.js"></script>
  <script src="front_end/js/custom.js"></script>
</body>
</html>
