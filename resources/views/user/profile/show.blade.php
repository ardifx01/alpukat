@extends('user.theme.default')

@section('title', 'Lihat Profil Koperasi | ALPUKAT')

@section('content')
@php
/** @var \App\Models\User $user */
$user = $user ?? auth()->user();
@endphp

{{-- ====== LATAR HALAMAN DI LUAR CARD ====== --}}
<div class="page-surface">
  <div class="container py-4" style="max-width:980px;">
    <div class="card shadow-sm border-0" style="border-radius:18px; overflow:hidden;">

      {{-- ===== Header / Cover ===== --}}
      <div class="position-relative"
        style="min-height:200px;background:linear-gradient(135deg,#1f2a7a 0%, #4456d1 60%, #7e8af0 100%);">
        <span class="position-absolute rounded-circle"
          style="right:-40px;top:-40px;width:180px;height:180px;background:rgba(255,255,255,.08)"></span>
        <span class="position-absolute rounded-circle"
          style="left:-60px;bottom:-60px;width:240px;height:240px;background:rgba(255,255,255,.06)"></span>

        {{-- Aksi cepat: Keamanan --}}
        @if (Route::has('password.change'))
        <div class="position-absolute top-0 end-0 p-3 d-flex gap-2">
          <a href="{{ route('password.change') }}" class="btn btn-light btn-sm border-0">
            <i class="fa fa-lock"></i> Keamanan
          </a>
        </div>
        @endif

        {{-- Avatar + Nama (desktop) --}}
        <div class="d-none d-md-flex align-items-end h-100">
          <div class="d-flex align-items-end w-100">
            <div class="position-relative" style="margin:-30px 30px 35px; transform:translateY(50%);">
              <img
                src="{{ $user->avatar_url }}"
                alt="Foto Profil {{ $user->name }}"
                class="shadow"
                loading="lazy"
                style="width:126px;height:126px;border-radius:50%;object-fit:cover;border:6px solid #fff;">
            </div>
            <div class="text-white ms-5 mb-0" style="min-width:0;">
              <h2 class="mb-1 fw-bold" style="font-size:2.1rem;">{{ $user->name }}</h2>
              <div class="opacity-75" style="font-size:1.05rem;">
                <i class="fa fa-envelope"></i> {{ $user->email }}
              </div>
            </div>
          </div>
        </div>

        {{-- Avatar (mobile) --}}
        <div class="d-md-none position-absolute start-50 translate-middle" style="top:100%;">
          <img
            src="{{ $user->avatar_url }}"
            alt="Foto Profil {{ $user->name }}"
            class="shadow"
            loading="lazy"
            style="width:110px;height:110px;border-radius:50%;object-fit:cover;border:5px solid #fff;">
        </div>
      </div>

      {{-- ===== Body ===== --}}
      <div class="card-body pt-5 pt-md-4">
        {{-- Nama & Email (mobile) --}}
        <div class="text-center d-md-none mt-4">
          <h3 class="mb-1 fw-bold">{{ $user->name }}</h3>
          <div class="text-muted small d-inline-flex align-items-center gap-2">
            <i class="fa fa-envelope"></i> {{ $user->email }}
          </div>
        </div>

        {{-- Meta / Joined --}}
        <div class="mt-3 text-center">
          <span class="badge rounded-pill bg-light text-dark border">
            <i class="fa fa-calendar-o"></i>
            Bergabung {{ optional($user->created_at)->translatedFormat('d M Y') }}
          </span>
        </div>

        {{-- ===== Info Ringkas ===== --}}
        <div class="row g-3 mt-4 row-cols-1 row-cols-md-3">
          <div class="col">
            <div class="p-3 border rounded-3 h-100">
              <div class="d-flex align-items-center gap-3">
                <span class="rounded-3 d-inline-flex align-items-center justify-content-center"
                  style="width:40px;height:40px;background:#eef1ff;color:#23349E;">
                  <i class="fa fa-id-badge"></i>
                </span>
                <div class="min-w-0">
                  <div class="text-muted small">Nama Koperasi</div>
                  <div class="fw-semibold text-truncate" title="{{ $user->name }}">{{ $user->name }}</div>
                </div>
              </div>
            </div>
          </div>

          <div class="col">
            <div class="p-3 border rounded-3 h-100">
              <div class="d-flex align-items-center gap-3">
                <span class="rounded-3 d-inline-flex align-items-center justify-content-center"
                  style="width:40px;height:40px;background:#eef1ff;color:#23349E;">
                  <i class="fa fa-envelope"></i>
                </span>
                <div class="min-w-0">
                  <div class="text-muted small">Email Koperasi</div>
                  <div class="fw-semibold text-break">{{ $user->email }}</div>
                </div>
              </div>
            </div>
          </div>

          {{-- Alamat --}}
          <div class="col">
            <div class="p-3 border rounded-3 h-100">
              <div class="d-flex align-items-start gap-3">
                <span class="rounded-3 d-inline-flex align-items-center justify-content-center"
                  style="width:40px;height:40px;background:#eef1ff;color:#23349E;">
                  <i class="fa fa-map-marker"></i>
                </span>
                <div class="min-w-0">
                  <div class="text-muted small">Alamat Koperasi</div>
                  <div class="fw-semibold">
                    {{ filled($user->alamat) ? $user->alamat : 'Belum diisi' }}
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>

        {{-- ===== Aksi ===== --}}
        <div class="d-flex flex-wrap gap-2 justify-content-center justify-content-md-center mt-4">
          <a href="{{ route('profile.edit') }}" class="btn btn-primary">
            <i class="fa fa-pencil"></i> Edit Profil
          </a>

          @if (Route::has('password.change'))
          <a href="{{ route('password.change') }}" class="btn btn-outline-primary">
            <i class="fa fa-lock"></i> Keamanan Akun
          </a>
          @endif
        </div>

        <p class="text-center text-muted small mt-3 mb-0">
          Pastikan data profil Anda selalu terbaru untuk memperlancar proses pengajuan.
        </p>
      </div>
    </div>
  </div>
</div>

{{-- ===== Styles inline supaya latar pasti aktif ===== --}}
<style>
  /* latar lembut (seragam dengan Pengajuan/Lihat Berkas) */
  .page-surface {
    position: relative;
    padding: 18px 0 36px;
    background:
      radial-gradient(360px 360px at calc(50% + 520px) 140px, rgba(126, 138, 240, .22), transparent 60%),
      radial-gradient(420px 420px at calc(50% - 520px) 560px, rgba(68, 86, 209, .18), transparent 60%),
      linear-gradient(180deg, #f6f8ff 0%, #eef2ff 55%, #eaf6ff 100%);
    min-height: 100%;
  }

  /* .page-surface::before,
  .page-surface::after{
    content:"";
    position:absolute; border-radius:50%; pointer-events:none; opacity:.22;
    background:#c2cdf2; filter: blur(2px);
  } */
  .page-surface::before {
    width: 220px;
    height: 220px;
    left: -70px;
    top: 120px;
  }

  .page-surface::after {
    width: 180px;
    height: 180px;
    right: -60px;
    bottom: 80px;
  }

  /* samakan tone border card dengan latar */
  .card {
    border-color: #e9ecff !important;
  }
</style>
@endsection