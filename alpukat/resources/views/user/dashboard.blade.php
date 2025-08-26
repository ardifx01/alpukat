@extends('user.theme.default')

@section('title', 'Dashboard | ALPUKAT')

@section('content')
{{-- Hero --}}
<section class="hero-section py-5">
  <div class="container">
    <div class="row align-items-center">
      
      {{-- Kiri: Teks --}}
      <div class="col-md-7 animate-up">
        <h3 class="hero-title"><strong>Selamat Datang di</strong></h3>
        <h1 class="hero-brand"><strong>ALPUKAT</strong></h1>
        <p class="hero-desc">Aplikasi Uji Kelayakan dan Kepatutan</p>
        
        <a href="{{ asset('files/juklak_ukk.pdf') }}" 
           class="btn btn-primary mb-2" download>
          Download Juklak UKK
        </a>
        
        @guest
          <br>
          <a href="{{ route('login') }}" class="btn btn-light">Login untuk Pengajuan</a>
        @endguest
      </div>

      {{-- Kanan: Animasi Koperasi --}}
      <div class="col-md-5 animate-right">
        <div class="hero-anim-pro" aria-hidden="true">
          <!-- orbs latar -->
          <span class="orb2 orb-a"></span>
          <span class="orb2 orb-b"></span>

          <!-- SVG Gedung Koperasi -->
          <svg class="coop-svg" viewBox="0 0 240 180" role="img" aria-label="Gedung Koperasi">
            <ellipse cx="120" cy="160" rx="90" ry="12" class="land"></ellipse>
            <g class="building">
              <rect x="60" y="60" width="120" height="80" rx="10" class="b-body"/>
              <rect x="88" y="82" width="64" height="36" rx="6" class="b-door"/>
              <rect x="64" y="64" width="112" height="10" rx="5" class="b-top"/>
              <text x="120" y="56" text-anchor="middle" class="b-title">KOPERASI</text>
              <rect x="70" y="96" width="12" height="18" rx="3" class="win"/>
              <rect x="158" y="96" width="12" height="18" rx="3" class="win"/>
            </g>
            <g class="sparkles">
              <circle cx="30" cy="40" r="2" class="sp"></circle>
              <circle cx="210" cy="36" r="2" class="sp"></circle>
              <circle cx="194" cy="120" r="2" class="sp"></circle>
              <circle cx="26" cy="118" r="2" class="sp"></circle>
            </g>
          </svg>

          <!-- Orbit avatar pengurus -->
          <div class="orbit-pro">
            <span class="avatar chip"><i class="fa fa-user-tie"></i></span>
            <span class="avatar chip"><i class="fa fa-user-check"></i></span>
            <span class="avatar chip"><i class="fa fa-user-shield"></i></span>
          </div>
        </div>
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
    ['title'=>'Hasil','desc'=>'Lihat keputusan UKK (Lulus/Tidak Lulus) di notifikasi. Unduh berita acara.','icon'=>'fa-flag-checkered'],
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
            title="Lokasi Dinas Koperasi, Usaha Kecil dan Menengah Kepulauan Riau"
            loading="lazy"
            src="https://www.google.com/maps/embed/v1/place?key=AIzaSyA0s1a7phLN0iaD6-UE7m4qP-z21pH0eSc&q=Dinas+Koperasi+Usaha+Kecil+dan+Menengah+Kepulauan+Riau"
            allowfullscreen>
          </iframe>
        </div>
        <div class="col-lg-5 about-text">
          <p>
            Dinas Koperasi, Usaha Kecil dan Menengah Provinsi Kepulauan Riau adalah instansi pemerintah daerah yang bertanggung jawab
            dalam pembinaan, pengembangan, dan pemberdayaan Koperasi dan Usaha Kecil dan Menengah (UKM)
            di wilayah Kepulauan Riau.
          </p>

          <div class="about-list">
            <div class="about-item">
              <span class="about-icon"><i class="fa fa-envelope"></i></span>
              <a href="mailto:diskop.kelembagaan@gmail.com" style="color:#222;text-decoration:none;">diskop.kelembagaan@gmail.com</a>
            </div>
              <div class="about-item">
                <span class="about-icon"><i class="fa fa-phone"></i></span>
                <a href="https://wa.me/628121645651" style="color:#222;text-decoration:none;">08121645651 (Rizky)</a>
              </div>
              <div class="about-item">
                <span class="about-icon"><i class="fa fa-phone"></i></span>
                <a href="https://wa.me/6281266009800" style="color:#222;text-decoration:none;">081266009800 (Awang)</a>
              </div>
              <div class="about-item">
                <span class="about-icon"><i class="fa fa-phone"></i></span>
                <a href="https://wa.me/62881266686289" style="color:#222;text-decoration:none;">081266686289 (Firmansyah)</a>
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
@endsection