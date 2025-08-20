{{-- resources/views/user/profile/edit.blade.php --}}
@extends('user.theme.default')

@section('title', 'Profil Koperasi | ALPUKAT')

@section('content')
<div class="container py-4">
  <div class="d-flex align-items-center justify-content-between mb-2">
    <h2 class="mb-2 fw-bold">Profil Koperasi</h2>
  </div>
  <p class="text-muted mb-4">Profil Koperasi Anda.</p>

  @if (session('status') === 'profile-updated')
    <div class="alert alert-success">Profil berhasil diperbarui.</div>
  @endif

  <div class="row">
    <div class="col-lg-8 mx-auto">
      <form method="POST" action="{{ route('profile.update') }}" enctype="multipart/form-data">
        @csrf
        @method('PATCH')

        {{-- Nama --}}
        <div class="mb-3">
          <label for="name" class="form-label">Nama Koperasi</label>
          <input type="text" id="name" name="name"
                 value="{{ old('name', $user->name) }}"
                 class="form-control @error('name') is-invalid @enderror">
          @error('name') <div class="invalid-feedback">{{ $message }}</div> @enderror
        </div>

        {{-- Email --}}
        <div class="mb-3">
          <label for="email" class="form-label">Email Koperasi</label>
          <input type="email" id="email" name="email"
                 value="{{ old('email', $user->email) }}"
                 class="form-control @error('email') is-invalid @enderror">
          @error('email') <div class="invalid-feedback">{{ $message }}</div> @enderror
          @if (is_null($user->email_verified_at))
            <small class="text-warning d-block mt-1">Email belum terverifikasi.</small>
          @endif
        </div>

        {{-- Alamat --}}
        <div class="mb-3">
          <label for="alamat" class="form-label">Alamat</label>
          <textarea id="alamat" name="alamat" rows="3"
                    class="form-control @error('alamat') is-invalid @enderror">{{ old('alamat', $user->alamat) }}</textarea>
          @error('alamat') <div class="invalid-feedback">{{ $message }}</div> @enderror
        </div>

        {{-- Avatar + Preview --}}
        <div class="mb-3">
          <label for="avatar" class="form-label">Foto Koperasi (Avatar)</label>
          <input type="file" id="avatar" name="avatar" accept="image/*"
                 class="form-control @error('avatar') is-invalid @enderror">
          @error('avatar') <div class="invalid-feedback">{{ $message }}</div> @enderror
          <div class="form-text">Format: jpg, jpeg, png, webp. Maks 2MB.</div>
        </div>

        <div class="mb-4">
          <span class="d-block text-muted mb-2">Pratinjau:</span>
          <img id="avatarPreview"
               src="{{ $user->avatar_url }}"
               data-fallback="{{ asset('front-end/images/default-avatar.png') }}"
               alt="Avatar"
               class="img-thumbnail"
               style="width:96px;height:96px;object-fit:cover;border-radius:.5rem;">
        </div>

        <div class="pt-2">
          <button type="submit" class="btn btn-primary">Simpan Perubahan</button>
        </div>
      </form>
    </div>
  </div>
</div>
@endsection

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function () {
  const input = document.getElementById('avatar');
  const img   = document.getElementById('avatarPreview');
  if (!input || !img) return;

  const originalSrc = img.getAttribute('src') || '';
  const fallbackSrc = img.dataset.fallback || '';

  // fallback bila gambar lama rusak
  img.addEventListener('error', function () {
    if (this.src !== fallbackSrc && fallbackSrc) this.src = fallbackSrc;
  });

  input.addEventListener('change', function () {
    const file = this.files && this.files[0] ? this.files[0] : null;
    if (!file) { img.src = originalSrc || fallbackSrc; return; }

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
    img.onload = function () { URL.revokeObjectURL(url); };
  });
});
</script>
@endpush
