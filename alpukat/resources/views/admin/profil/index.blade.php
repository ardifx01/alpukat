@extends('admin.theme.default')

@section('title', 'Profil Admin')

@section('content')
@php
  // aman kalau $admin tidak dikirim: fallback ke user yang login
  $admin = $admin ?? auth()->user();
  $name  = $admin?->name ?? '-';
  $email = $admin?->email ?? '-';

  // bikin inisial (max 2 huruf)
  $initials = collect(explode(' ', trim($name)))
                ->filter()
                ->map(fn($p) => mb_substr($p, 0, 1))
                ->take(2)
                ->implode('');
@endphp

<style>
  .avatar-initials{
    width: 96px; height: 96px; border-radius: 50%;
    background: #e9ecef; color:#495057;
    display:flex; align-items:center; justify-content:center;
    font-weight:700; font-size: 32px;
    border: 4px solid #fff; box-shadow: 0 10px 25px rgba(0,0,0,.12);
  }
  .list-key{ width: 120px; color:#6c757d; }
</style>

<div class="container py-4">
  <div class="profile-hero shadow-sm position-relative"></div>

  <div class="overlap">
    <div class="d-flex align-items-center gap-3">
      {{-- kalau suatu saat punya avatar_path di DB, tinggal ganti div ini dengan <img> --}}
      <div class="avatar-initials">{{ $initials ?: 'A' }}</div>
      <div>
        <div class="h4 mb-1 text-body">{{ $name }}</div>
        <span class="badge bg-primary-subtle text-primary border border-primary-subtle">Admin</span>
      </div>
    </div>
  </div>

  <div class="card border-0 shadow-sm mt-3">
    <div class="card-body">
      <div class="d-flex align-items-center mb-2">
        <div class="list-key">Nama</div>
        <div class="fw-semibold">{{ $name }}</div>
      </div>
      <div class="d-flex align-items-center">
        <div class="list-key">Email</div>
        <div class="fw-semibold me-2">{{ $email }}</div>
        <button type="button" class="btn btn-sm btn-outline-secondary"
                onclick="navigator.clipboard.writeText('{{ $email }}')">
          Salin
        </button>
      </div>
    </div>
  </div>

  <div class="mt-3 d-flex gap-2">
    <a href="{{ url()->previous() }}" class="btn btn-light">Kembali</a>
  </div>
</div>
@endsection
