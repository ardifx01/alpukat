@extends('user.theme.default')

@section('title', 'Notifikasi | ALPUKAT')

@section('content')
{{-- ====== WRAPPER LATAR HALAMAN ====== --}}
<div class="notif-surface">
  <div class="container py-4" style="max-width:1040px;">

    {{-- ======= HEADER / COVER (seragam) ======= --}}
    <div class="card shadow-sm border-0 mb-4" style="border-radius:18px; overflow:hidden;">
      <div class="position-relative"
           style="min-height:220px;padding:56px 0 28px;background:linear-gradient(135deg,#1f2a7a 0%, #4456d1 60%, #7e8af0 100%);">
        <span class="position-absolute rounded-circle" style="right:-40px;top:-40px;width:180px;height:180px;background:rgba(255,255,255,.08)"></span>
        <span class="position-absolute rounded-circle" style="left:-60px;bottom:-60px;width:240px;height:240px;background:rgba(255,255,255,.06)"></span>

        <div class="container text-white">
          <h2 class="mb-1 fw-bold" style="font-size:2rem;">Notifikasi</h2>
          <div class="opacity-85">Pemberitahuan terbaru terkait akun & pengajuan Anda.</div>
        </div>
      </div>

      {{-- ======= BODY ======= --}}
      <div class="px-3 px-md-4 pt-3 pb-4">

        @if ($notifikasi->isEmpty())
          <div class="alert alert-info border-0 shadow-sm rounded-3 mb-0">
            Tidak ada notifikasi saat ini.
          </div>
        @else
          <div class="card border-0 shadow-sm">
            <div class="list-group list-group-flush">

              @foreach ($notifikasi as $item)
                <div class="list-group-item px-3 py-3 noti-item">
                  <div class="d-flex align-items-start gap-3">
                    <div class="noti-icon flex-shrink-0">
                      <i class="fa fa-bell"></i>
                    </div>
                    <div class="flex-grow-1">
                      <div class="d-flex justify-content-between align-items-start gap-2">
                        <div class="fw-semibold text-body">{{ $item->judul ?? 'Notifikasi' }}</div>
                        <span class="badge badge-soft-primary">{{ $item->created_at->diffForHumans() }}</span>
                      </div>
                      <div class="text-muted mt-1">
                        {{ $item->pesan }}
                      </div>

                      @php
                        $fileUrl  = !empty($item->file_path) ? (\Illuminate\Support\Facades\Storage::url($item->file_path)) : null;
                        $fileName = !empty($item->file_path) ? basename($item->file_path) : null;
                      @endphp

                      @if ($fileUrl)
                        <div class="mt-2 d-flex align-items-center gap-2">
                          <a href="{{ $fileUrl }}" target="_blank" rel="noopener" class="btn btn-sm btn-outline-primary">
                            <i class="fa fa-eye me-1"></i> Lihat File
                          </a>
                          <a href="{{ $fileUrl }}" download="{{ $fileName }}" class="btn btn-sm btn-outline-secondary">
                            <i class="fa fa-download me-1"></i> Unduh
                          </a>
                        </div>
                      @endif
                    </div>
                  </div>
                </div>
              @endforeach

            </div>
          </div>
        @endif

      </div>
    </div>

  </div>
</div>

{{-- ===== Styles inline supaya pasti aktif walau layout belum @stack("styles") ===== --}}
<style>
  :root{
    --theme-primary:#23349E;
    --theme-primary-soft:#e9edff;
  }

  /* LATAR HALAMAN DI LUAR CARD (seragam dg Lihat Berkas) */
  .notif-surface{
    position: relative;
    padding: 18px 0 36px;
    background:
      radial-gradient(360px 360px at calc(50% + 520px) 140px, rgba(126,138,240,.22), transparent 60%),
      radial-gradient(420px 420px at calc(50% - 520px) 560px, rgba(68,86,209,.18), transparent 60%),
      linear-gradient(180deg, #f6f8ff 0%, #eef2ff 55%, #eaf6ff 100%);
    min-height: 100%;
  }
  .notif-surface::before,
  .notif-surface::after{
    content:"";
    position:absolute; border-radius:50%; pointer-events:none; opacity:.22;
    background:#c2cdf2; filter: blur(2px);
  }
  .notif-surface::before{ width:220px;height:220px; left:-70px; top:120px; }
  .notif-surface::after { width:180px;height:180px; right:-60px; bottom:80px; }

  /* Badge lembut */
  .badge{ vertical-align:middle; }
  .badge-soft-primary{
    color:var(--theme-primary);
    background:var(--theme-primary-soft);
    border:1px solid rgba(35,52,158,.12);
    border-radius:999px; font-weight:600;
  }

  /* Item notifikasi */
  .noti-item{ border-color:#eef1ff !important; }
  .noti-icon{
    width:42px; height:42px; border-radius:50%;
    background:#f1f4ff; color:#23349E;
    display:flex; align-items:center; justify-content:center;
    border:1px solid rgba(35,52,158,.12);
  }

  /* Samakan nuansa border card dengan latar */
  .card{ border-color:#e9ecff !important; }

  @media (max-width:576px){
    .badge-soft-primary{ font-size:.72rem; }
  }
</style>
@endsection
