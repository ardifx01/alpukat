@extends('user.theme.default')

@section('title', 'Dashboard | ALPUKAT')

@section('content')
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
          <img src="{{ asset('front_end/images/profile DKUKM.jpeg') }}" alt="Dinas Koperasi Usaha Kecil & Menengah Kepulauan Riau" class="img-fluid rounded hero-img" loading="lazy">
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
            title="Lokasi Dinas Koperasi, Usaha Kecil dan Menengah Kepulauan Riau"
            loading="lazy"
            src="https://www.google.com/maps/embed/v1/place?key=AIzaSyA0s1a7phLN0iaD6-UE7m4qP-z21pH0eSc&q=Dinas+Koperasi+Usaha+Kecil+dan+Menengah+Kepulauan+Riau"
            allowfullscreen>
          </iframe>
        </div>
        <div class="col-lg-5 about-text">
          <p>
            Dinas Koperasi dan UMKM Kepri adalah instansi pemerintah daerah yang bertanggung jawab
            dalam pembinaan, pengembangan, dan pemberdayaan Koperasi dan Usaha Mikro, Kecil, dan Menengah (UMKM)
            di wilayah Kepulauan Riau.
          </p>

          <div class="about-list">
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
@endsection

