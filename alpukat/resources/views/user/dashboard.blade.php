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
    html{box-sizing:border-box}*,*:before,*:after{box-sizing:inherit}
    body{margin:0;font-family:Arial,Helvetica,sans-serif;background:#fff}

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
    .step-panel{position:absolute;inset:0;display:flex;flex-direction:column;align-items:center;justify-content:center;gap:12px;border-left:6px solid #23349E;padding-left:12px;opacity:0;transform:translateY(10px);transition:opacity .25s ease, transform .35s ease;pointer-events:none;background:rgba(255,255,255,.97);text-align:center}
    .step-icon{width:38px;height:38px;border-radius:8px;background:#23349E;color:#fff;display:inline-flex;align-items:center;justify-content:center;font-size:18px;opacity:0;transform:translateX(-6px);transition:opacity .25s ease, transform .35s ease}
    .step-title{margin:0 0 6px 0;font-weight:700;font-size:1.05rem}
    .step-desc{margin:0;color:#333;font-size:.98rem;line-height:1.5}
    .step-main{display:flex;flex-direction:column;align-items:center;justify-content:center;min-height:110px;padding:36px 14px 18px;transition:opacity .2s}
    .step-main-number{font-size:2rem;font-weight:700;color:#23349E;line-height:1}
    .step-main-title{font-size:1.1rem;font-weight:600;margin-top:2px;color:#23349E;line-height:1.2}
    .step-box:hover .step-panel{opacity:1;transform:none;pointer-events:auto}
    .step-box:hover .step-icon{opacity:1;transform:none}
    .step-box:hover .step-main{opacity:0;visibility:hidden}

    /* ===== Tentang Kami ===== */
    .about-section{padding:52px 0}
    .about-card{background:#fff;border-radius:18px;box-shadow:0 10px 30px rgba(0,0,0,.08);padding:26px}
    .about-map{width:100%;height:340px;border:0;border-radius:12px;box-shadow:0 6px 16px rgba(0,0,0,.08)}
    .about-text h3{font-weight:800;margin-bottom:16px}
    .about-text p{font-size:1.05rem;line-height:1.7;color:#333}
    .about-list{margin-top:16px}
    .about-item{display:flex;align-items:center;gap:12px;margin:10px 0;font-size:1rem;color:#222}
    .about-icon{width:38px;height:38px;border-radius:10px;background:#23349E;color:#fff;display:inline-flex;align-items:center;justify-content:center;flex:0 0 38px}

    /* ===== Footer – samakan ukuran dengan header, hilangkan garis putih ===== */
    footer.footer_section{
      background:#1f2b7b;
      color:#fff;
      width:100%;
      padding:10px 40px;        /* sama dengan header */
      min-height:65px;          /* setara header */
      display:flex;
      align-items:center;
      justify-content:center;   /* pusatkan teks */
      border-top:none;          /* hilangkan garis */
      margin:0;                 /* cegah gap putih */
    }
    footer.footer_section p{margin:0;line-height:1.4}

    /* Dropdown profil */
    .profile-dropdown {
      position: relative;
      display: inline-block;
    }
    .profile-btn {
      background: none;
      border: none;
      color: #23349E;
      font-weight: bold;
      display: flex;
      align-items: center;
      gap: 6px;
      cursor: pointer;
      padding: 8px 12px;
      border-radius: 12px;
      transition: background .15s;
    }
    .profile-btn:hover, .profile-btn:focus {
      background: #e6f4fb;
    }
    .profile-menu {
      display: none;
      position: absolute;
      right: 0;
      top: 110%;
      min-width: 160px;
      background: #fff;
      box-shadow: 0 4px 16px rgba(0,0,0,.12);
      border-radius: 10px;
      z-index: 1001;
      padding: 8px 0;
    }
    .profile-menu a, .profile-menu button {
      display: flex;
      align-items: center;
      gap: 8px;
      color: #23349E;
      text-decoration: none;
      padding: 8px 16px;
      background: none;
      border: none;
      width: 100%;
      font-size: 15px;
      transition: background .15s;
    }
    .profile-menu a:hover, .profile-menu button:hover {
      background: #f0f4ff;
    }
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

      @guest
        <a href="{{ route('login') }}" class="login-btn">Login</a>
        <a href="{{ route('register') }}" class="sign-up">Register</a>
      @endguest

      @auth
        <div class="profile-dropdown">
          <button class="profile-btn" id="profileDropdownBtn" type="button">
            <i class="fa fa-user-circle" style="font-size:22px;"></i>
            {{ Auth::user()->name ?? 'Profil' }}
            <i class="fa fa-caret-down"></i>
          </button>
          <div class="profile-menu" id="profileDropdownMenu">
            <a href="{{ route('profile.edit') }}"><i class="fa fa-user"></i> Edit Profil</a>
            <form action="{{ route('logout') }}" method="POST" style="margin:0;">
              @csrf
              <button type="submit" style="background:none;border:none;color:#e74c3c;width:100%;text-align:left;padding:8px 16px;cursor:pointer;">
                <i class="fa fa-sign-out"></i> Logout
              </button>
            </form>
          </div>
        </div>
      @endauth
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
      <h2 class="mb-4" style="font-weight:800">Tata Cara Pengajuan</h2>

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
              <!-- Perbaiki tag <a> agar tidak meluber sampai footer -->
              <div class="about-item">
                <span class="about-icon"><i class="fa fa-envelope"></i></span>
                <a href="mailto:dkukmprovkepri@gmail.com" style="color:#222;text-decoration:none;">dkukmprovkepri@gmail.com</a>
              </div>
              <div class="about-item">
                <span class="about-icon"><i class="fa fa-phone"></i></span>
                <a href="tel:081234567890" style="color:#222;text-decoration:none;">0812-3456-7890</a>
              </div>
              <div class="about-item">
                <span class="about-icon"><i class="fa fa-instagram"></i></span>
                <a href="https://instagram.com/dkukmkepri" target="_blank" rel="noopener" style="color:#222;text-decoration:none;">@dkukmkepri</a>
              </div>
            </div>
          </div>
        </div>
      </div>  
    </div>
  </section>

  {{-- Footer (tinggi setara header, tanpa garis putih) --}}
  <footer class="footer_section">
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

  <script>
    document.addEventListener('DOMContentLoaded', function() {
      const btn = document.getElementById('profileDropdownBtn');
      const menu = document.getElementById('profileDropdownMenu');
      if(btn && menu) {
        btn.addEventListener('click', function(e) {
          e.stopPropagation();
          menu.style.display = menu.style.display === 'block' ? 'none' : 'block';
        });
        document.addEventListener('click', function() {
          menu.style.display = 'none';
        });
      }
    });
  </script>
</body>
</html>
