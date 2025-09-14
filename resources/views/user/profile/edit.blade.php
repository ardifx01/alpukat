@extends('user.theme.default')

@section('title', 'Edit Profil Koperasi | ALPUKAT')

@section('content')
{{-- ====== WRAPPER LATAR HALAMAN ====== --}}
<div class="profile-surface">
  <div class="container py-4" style="max-width:1040px;">

    {{-- ===== Header / Cover ===== --}}
    <div class="card shadow-sm border-0 mb-4" style="border-radius:18px; overflow:hidden;">
      <div class="position-relative"
        style="min-height:220px;padding:56px 0 28px;background:linear-gradient(135deg,#1f2a7a 0%, #4456d1 60%, #7e8af0 100%);">
        <span class="position-absolute rounded-circle"
          style="right:-40px;top:-40px;width:180px;height:180px;background:rgba(255,255,255,.08)"></span>
        <span class="position-absolute rounded-circle"
          style="left:-60px;bottom:-60px;width:240px;height:240px;background:rgba(255,255,255,.06)"></span>

        <div class="container text-white">
          <h2 class="mb-1 fw-bold" style="font-size:2rem;">Edit Profil Koperasi</h2>
          <div class="opacity-85">Perbarui data profil koperasi Anda di bawah ini.</div>
        </div>
      </div>
    </div>

    {{-- ===== Alert sukses ===== --}}
    @if (session('status') === 'profile-updated')
    <div class="alert alert-success border-0 shadow-sm rounded-3 mb-3">
      Profil berhasil diperbarui.
    </div>
    @endif

    {{-- ===== FORM ===== --}}
    <div class="card shadow-sm border-0" style="border-radius:18px;">
      <div class="card-body p-4">
        <form method="POST" action="{{ route('profile.update') }}" enctype="multipart/form-data">
          @csrf
          @method('PATCH')

          {{-- Nama --}}
          <div class="mb-3">
            <label for="name" class="form-label fw-semibold">Nama Koperasi</label>
            <input type="text" id="name" name="name"
              value="{{ old('name', $user->name) }}"
              class="form-control @error('name') is-invalid @enderror">
            @error('name') <div class="invalid-feedback">{{ $message }}</div> @enderror
          </div>

          {{-- Email --}}
          <div class="mb-3">
            <label for="email" class="form-label fw-semibold">Email Koperasi</label>
            <input type="email" id="email" name="email"
              value="{{ old('email', $user->email) }}"
              class="form-control @error('email') is-invalid @enderror">
            @error('email') <div class="invalid-feedback">{{ $message }}</div> @enderror
            <!-- @if (is_null($user->email_verified_at))
              <small class="text-warning d-block mt-1">Email belum terverifikasi.</small>
            @endif -->
          </div>

          {{-- Alamat --}}
          <div class="mb-3">
            <label for="alamat" class="form-label fw-semibold">Alamat Koperasi</label>
            <textarea id="alamat" name="alamat" rows="3"
              class="form-control @error('alamat') is-invalid @enderror">{{ old('alamat', $user->alamat) }}</textarea>
            @error('alamat') <div class="invalid-feedback">{{ $message }}</div> @enderror
          </div>

          {{-- Avatar + Preview --}}
          <div class="mb-3">
            <label for="avatar" class="form-label fw-semibold">Foto Koperasi</label>
            <input type="file" id="avatar" name="avatar" accept="image/*"
              class="form-control @error('avatar') is-invalid @enderror">
            @error('avatar') <div class="invalid-feedback">{{ $message }}</div> @enderror
            <div class="form-text">Format: jpg, jpeg, png, webp. Maks 2MB.</div>
          </div>

          <div class="mb-4">
            <span class="d-block text-muted mb-2">Pratinjau:</span>
            <img id="avatarPreview"
              src="{{ $user->avatar_url }}"
              data-fallback="{{ asset('front-end/images/logo-koperasi.png') }}"
              alt="Avatar"
              class="shadow-sm border"
              style="width:96px;height:96px;object-fit:cover;border-radius:.75rem;">
          </div>

          <div class="pt-2">
            <button type="submit" class="btn btn-primary px-4">
              <i class="fa fa-save me-1"></i> Simpan Perubahan
            </button>
          </div>
        </form>
      </div>
    </div>

  </div>
</div>
@endsection

@push('styles')
<style>
  /* ====== LATAR HALAMAN (seragam dengan pengajuan/berkas) ====== */
  .profile-surface {
    position: relative;
    padding: 18px 0 36px;
    background:
      radial-gradient(360px 360px at calc(50% + 420px) 120px, rgba(126, 138, 240, .22), transparent 60%),
      radial-gradient(420px 420px at calc(50% - 480px) 560px, rgba(68, 86, 209, .18), transparent 60%),
      linear-gradient(180deg, #f6f8ff 0%, #eef2ff 55%, #eaf6ff 100%);
    min-height: 100%;
  }

  .profile-surface::before,
  .profile-surface::after {
    content: "";
    position: absolute;
    border-radius: 50%;
    pointer-events: none;
    background: #c2cdf2;
    filter: blur(2px);
    opacity: .22;
  }

  .profile-surface::before {
    width: 220px;
    height: 220px;
    left: -70px;
    top: 120px;
  }

  .profile-surface::after {
    width: 180px;
    height: 180px;
    right: -60px;
    bottom: 80px;
  }

  .card {
    border-color: #e9ecff !important;
  }

  .form-label {
    font-weight: 600;
  }
</style>
@endpush

@push('scripts')
<script>
  document.addEventListener('DOMContentLoaded', function() {
    const input = document.getElementById('avatar');
    const img = document.getElementById('avatarPreview');
    if (!input || !img) return;

    const originalSrc = img.getAttribute('src') || '';
    const fallbackSrc = img.dataset.fallback || '';

    img.addEventListener('error', function() {
      if (this.src !== fallbackSrc && fallbackSrc) this.src = fallbackSrc;
    });

    input.addEventListener('change', function() {
      const file = this.files && this.files[0] ? this.files[0] : null;
      if (!file) {
        img.src = originalSrc || fallbackSrc;
        return;
      }

      if (!file.type.startsWith('image/')) {
        alert('File harus berupa gambar.');
        this.value = '';
        img.src = originalSrc || fallbackSrc;
        return;
      }

      const MAX_MB = 2;
      if (file.size > MAX_MB * 1024 * 1024) {
        alert('Ukuran gambar maksimal ' + MAX_MB + 'MB.');
        this.value = '';
        img.src = originalSrc || fallbackSrc;
        return;
      }

      const url = URL.createObjectURL(file);
      img.src = url;
      img.onload = function() {
        URL.revokeObjectURL(url);
      };
    });
  });
</script>
@endpush