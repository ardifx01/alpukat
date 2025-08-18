@extends('layouts.app')

@section('content')
@php
  /** @var \App\Models\User $user */
  $user   = Auth::user();
  $avatar = $user->avatar_url ?: asset('front_end/images/default-avatar.png');
@endphp

<div class="container py-4" style="max-width: 700px;">
  <h2 class="mb-4 fw-bold text-primary">Edit Profil</h2>

  @if (session('status'))
    <div class="alert alert-success alert-dismissible fade show" role="alert">
      {{ session('status') }}
      <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
  @endif

  @if ($errors->any())
    <div class="alert alert-danger">
      <strong>Periksa kembali input Anda:</strong>
      <ul class="mb-0">
        @foreach ($errors->all() as $err)
          <li>{{ $err }}</li>
        @endforeach
      </ul>
    </div>
  @endif

  <div class="card shadow border-0" style="border-radius:16px;">
    <div class="card-body p-4">
      <form id="profileForm" action="{{ route('profile.update') }}" method="POST" enctype="multipart/form-data" novalidate>
        @csrf
        @method('PATCH')

        {{-- Foto Profil --}}
        <div class="mb-4">
          <label class="form-label fw-semibold text-secondary">Foto Profil</label>
          <div class="d-flex align-items-center gap-3">
            <img id="avatarPreview" src="{{ $avatar }}" alt="Foto {{ $user->name }}"
                 style="width:90px;height:90px;border-radius:50%;object-fit:cover;border:4px solid #fff;box-shadow:0 4px 14px rgba(0,0,0,.1);transition:.3s;">
            <div>
              <input class="form-control @error('avatar') is-invalid @enderror"
                     type="file" name="avatar" id="avatarInput" accept="image/*">
              @error('avatar') <div class="invalid-feedback">{{ $message }}</div> @enderror
              <div class="form-text">Format: JPG/PNG/WEBP, maks 2 MB.</div>

              <div class="form-check mt-2">
                <input class="form-check-input" type="checkbox" id="removeAvatar" name="remove_avatar" value="1">
                <label class="form-check-label text-danger" for="removeAvatar">Hapus foto profil</label>
              </div>
            </div>
          </div>
        </div>

        {{-- Nama --}}
        <div class="mb-3">
          <label class="form-label fw-semibold text-secondary">Nama Lengkap</label>
          <input type="text" name="name" value="{{ old('name', $user->name) }}"
                 class="form-control border-primary-subtle @error('name') is-invalid @enderror" required>
          @error('name') <div class="invalid-feedback">{{ $message }}</div> @enderror
        </div>

        {{-- Email --}}
        <div class="mb-3">
          <label class="form-label fw-semibold text-secondary">Email</label>
          <input type="email" name="email" value="{{ old('email', $user->email) }}"
                 class="form-control border-primary-subtle @error('email') is-invalid @enderror" required>
          @error('email') <div class="invalid-feedback">{{ $message }}</div> @enderror
        </div>

        <div class="d-flex justify-content-end gap-2 mt-4">
          <a href="{{ url()->previous() }}" class="btn btn-light border">Batal</a>
          <button type="submit" class="btn btn-primary">
            <i class="fa fa-save me-1"></i> Simpan Perubahan
          </button>
        </div>
      </form>
    </div>
  </div>
</div>

{{-- Script: preview avatar + hapus avatar --}}
<script>
(function () {
  const input   = document.getElementById('avatarInput');
  const preview = document.getElementById('avatarPreview');
  const remove  = document.getElementById('removeAvatar');

  if (input) {
    input.addEventListener('change', function () {
      const f = this.files && this.files[0];
      if (!f) return;

      if (f.size > 2*1024*1024) {
        alert('Ukuran gambar melebihi 2 MB.');
        this.value = '';
        return;
      }
      preview.src = URL.createObjectURL(f);
      if (remove) remove.checked = false;
      preview.style.opacity = 1;
    });
  }

  if (remove) {
    remove.addEventListener('change', function () {
      if (this.checked) {
        if (input) input.value = '';
        preview.style.opacity = .5;
      } else {
        preview.style.opacity = 1;
      }
    });
  }
})();
</script>
@endsection
