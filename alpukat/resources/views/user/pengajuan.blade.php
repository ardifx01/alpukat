@extends('user.dashboard') 

@section('title', 'Pengajuan | ALPUKAT')

@section('content')
@php
  // Tentukan tab aktif & state kategori
  $activeTab = 'koperasi';
  foreach (($syaratPengurus ?? []) as $s) {
      if ($errors->has("dokumen.$s->id")) { $activeTab = 'pengurus'; break; }
  }
  if (request('tab') === 'pengurus') { $activeTab = 'pengurus'; }

  $onCooldown  = isset($cooldownUntil) && now()->lt($cooldownUntil);
  $hasKoperasi = !empty($syaratKoperasi) && count($syaratKoperasi) > 0;
  $hasPengurus = !empty($syaratPengurus) && count($syaratPengurus) > 0;
@endphp

<div class="container py-4" style="max-width:1040px;">
  {{-- ======= HEADER / COVER (SERAGAM) ======= --}}
  <div class="card shadow-sm border-0 mb-3" style="border-radius:18px; overflow:hidden;">
    <div class="position-relative"
         style="min-height:220px; padding:56px 0 28px; background:linear-gradient(135deg,#1f2a7a 0%, #4456d1 60%, #7e8af0 100%);">
      <span class="position-absolute rounded-circle" style="right:-40px;top:-40px;width:180px;height:180px;background:rgba(255,255,255,.08)"></span>
      <span class="position-absolute rounded-circle" style="left:-60px;bottom:-60px;width:240px;height:240px;background:rgba(255,255,255,.06)"></span>

      <div class="container text-white">
        <h2 class="mb-1 fw-bold" style="font-size:2rem;">Pengajuan SK UKK</h2>
        <div class="opacity-85">Unggah dokumen persyaratan sesuai instruksi di bawah ini.</div>
      </div>
    </div>

    {{-- Info ringkas tepat di bawah cover --}}
    <div class="px-3 px-md-4 pt-3 pb-3">
      @if($onCooldown)
        <div class="alert alert-warning border-0 shadow-sm rounded-3 mb-2 small">
          <i class="fa fa-clock-o me-1"></i>
          Anda bisa mengunggah lagi {{ $cooldownUntil->diffForHumans(['parts' => 2]) }}.
        </div>
      @endif

      <div class="alert alert-info border-0 shadow-sm rounded-3 mb-0 small">
        <div class="d-flex align-items-start gap-2">
          <i class="fa fa-info-circle mt-1"></i>
          <div>
            <strong>Catatan:</strong> File <code>PDF/JPG/PNG</code>, maks. <strong>5 MB</strong> per file.
          </div>
        </div>
      </div>
    </div>
  </div>

  {{-- ======= BOX: Tabs + Daftar Unggahan MENYATU ======= --}}
  <div class="card shadow-sm border rounded-3">
    {{-- Header box: tabs & chip status DI DALAM BOX YANG SAMA --}}
    <div class="card-header bg-white border-0 pb-0">
      <div class="d-flex align-items-center justify-content-between flex-wrap gap-2">
        <ul class="nav nav-pills gap-2 mb-0" id="uploadTab" role="tablist">
          <li class="nav-item" role="presentation">
            <button class="nav-link soft-pill {{ $activeTab==='koperasi' ? 'active' : '' }}"
                    id="koperasi-tab" data-bs-toggle="tab" data-bs-target="#pane-koperasi" type="button" role="tab">
              Dokumen Berkas Koperasi
            </button>
          </li>
          <li class="nav-item" role="presentation">
            <button class="nav-link soft-pill {{ $activeTab==='pengurus' ? 'active' : '' }}"
                    id="pengurus-tab" data-bs-toggle="tab" data-bs-target="#pane-pengurus" type="button" role="tab">
              Dokumen Berkas Pengurus/Pengawas
            </button>
          </li>
        </ul>

        <div class="d-flex align-items-center gap-2 x-small">
          <span class="chip" id="chipKoperasi"><i class="fa fa-circle me-1"></i> Koperasi: <b>Belum</b></span>
          <span class="chip" id="chipPengurus"><i class="fa fa-circle me-1"></i> Pengurus: <b>Belum</b></span>
        </div>
      </div>
    </div>

    {{-- Form & Tab content dalam satu card-body --}}
    <div class="card-body pt-2">
      <form method="POST" action="{{ route('user.store') }}" enctype="multipart/form-data" id="formPengajuan">
        @csrf

        <div class="tab-content">

          {{-- === PANE KOPERASI === --}}
          <div class="tab-pane fade {{ $activeTab==='koperasi' ? 'show active' : '' }}" id="pane-koperasi" role="tabpanel">
            @if(!$hasKoperasi)
              <div class="alert alert-secondary rounded-3 small mb-2">Belum ada persyaratan untuk kategori koperasi.</div>
            @else
              <div class="row g-2">
                @foreach ($syaratKoperasi as $syarat)
                  @php $inputId = "dokumen_koperasi_{$syarat->id}"; @endphp
                  <div class="col-md-6">
                    <div class="p-2 rounded-3 border upload-card h-100">
                      {{-- Nama syarat: BOLD + * wajib setelah nama --}}
                      <div class="small text-dark">
                        <strong>{{ $syarat->nama_syarat }}</strong>
                        @if($syarat->is_required)
                          <span class="ms-1 text-danger fw-bold">*</span>
                          <span class="text-muted x-small">wajib</span>
                        @else
                          <span class="text-muted x-small ms-1">opsional</span>
                        @endif
                      </div>

                      {{-- Dropzone (label) --}}
                      <label class="dz mt-2 d-block text-center p-2 rounded-2 border" for="{{ $inputId }}">
                        <span class="x-small text-muted">Seret & lepas / klik untuk memilih</span>

                        <span class="dz-file d-none mt-2 d-inline-flex align-items-center gap-2">
                          <span class="badge bg-light text-dark border x-small">
                            <i class="fa fa-file-o me-1"></i> <span class="dz-filename"></span>
                          </span>
                          <button type="button" class="dz-clear btn btn-xs btn-outline-danger rounded-pill px-2 py-0" aria-label="Hapus berkas">
                            <i class="fa fa-times"></i>
                          </button>
                        </span>

                        <small class="dz-msg text-muted d-block mt-1 x-small"></small>
                      </label>

                      <input type="file" id="{{ $inputId }}" name="dokumen[{{ $syarat->id }}]"
                             accept=".pdf,.jpg,.jpeg,.png" hidden
                             data-required="{{ $syarat->is_required ? 1 : 0 }}"
                             data-category="koperasi"
                             class="@error('dokumen.'.$syarat->id) is-invalid @enderror">

                      @error('dokumen.'.$syarat->id)
                        <div class="invalid-feedback d-block x-small">{{ $message }}</div>
                      @enderror
                    </div>
                  </div>
                @endforeach
              </div>
            @endif
          </div>

          {{-- === PANE PENGURUS === --}}
          <div class="tab-pane fade {{ $activeTab==='pengurus' ? 'show active' : '' }}" id="pane-pengurus" role="tabpanel">
            @if(!$hasPengurus)
              <div class="alert alert-secondary rounded-3 small mb-2">Belum ada persyaratan untuk kategori pengurus/pengawas.</div>
            @else
              <div class="row g-2">
                @foreach ($syaratPengurus as $syarat)
                  @php $inputId = "dokumen_pengurus_{$syarat->id}"; @endphp
                  <div class="col-md-6">
                    <div class="p-2 rounded-3 border upload-card h-100">
                      <div class="small text-dark">
                        <strong>{{ $syarat->nama_syarat }}</strong>
                        @if($syarat->is_required)
                          <span class="ms-1 text-danger fw-bold">*</span>
                          <span class="text-muted x-small">wajib</span>
                        @else
                          <span class="text-muted x-small ms-1">opsional</span>
                        @endif
                      </div>

                      <label class="dz mt-2 d-block text-center p-2 rounded-2 border" for="{{ $inputId }}">
                        <span class="x-small text-muted">Seret & lepas / klik untuk memilih</span>

                        <span class="dz-file d-none mt-2 d-inline-flex align-items-center gap-2">
                          <span class="badge bg-light text-dark border x-small">
                            <i class="fa fa-file-o me-1"></i> <span class="dz-filename"></span>
                          </span>
                          <button type="button" class="dz-clear btn btn-xs btn-outline-danger rounded-pill px-2 py-0" aria-label="Hapus berkas">
                            <i class="fa fa-times"></i>
                          </button>
                        </span>

                        <small class="dz-msg text-muted d-block mt-1 x-small"></small>
                      </label>

                      <input type="file" id="{{ $inputId }}" name="dokumen[{{ $syarat->id }}]"
                             accept=".pdf,.jpg,.jpeg,.png" hidden
                             data-required="{{ $syarat->is_required ? 1 : 0 }}"
                             data-category="pengurus"
                             class="@error('dokumen.'.$syarat->id) is-invalid @enderror">

                      @error('dokumen.'.$syarat->id)
                        <div class="invalid-feedback d-block x-small">{{ $message }}</div>
                      @enderror
                    </div>
                  </div>
                @endforeach
              </div>
            @endif
          </div>

        </div>

        {{-- ======= Action bar ======= --}}
        <div class="mt-3">
          <div class="d-flex align-items-center justify-content-between gap-2 p-2 rounded-2 border bg-light-subtle x-small">
            <div class="text-muted">
              <i class="fa fa-shield"></i>
              Pastikan semua <strong>syarat wajib</strong> sudah diunggah.
            </div>
            <button id="btnKirim" type="submit" name="action" value="submit"
                    class="btn btn-primary btn-sm px-3" {{ $onCooldown ? 'disabled' : '' }}>
              <i class="fa fa-paper-plane me-1"></i> Kirim
            </button>
          </div>
          <div id="barWarning" class="x-small text-danger mt-2 d-none">
            Lengkapi unggahan pada <strong>Koperasi</strong> & <strong>Pengurus/Pengawas</strong> sebelum kirim.
          </div>
        </div>

      </form>
    </div>
  </div>
</div>

{{-- ======= Styles (compact & unified) ======= --}}
<style>
  .soft-pill{ background:#f1f4ff; color:#334; border:0; font-size:.9rem; padding:.35rem .8rem }
  .soft-pill.active{ background:#e4e9ff; color:#23349E; font-weight:600; }

  .chip{ padding:.22rem .5rem; border-radius:999px; background:#f6f7fb; border:1px solid #e8eaf6; color:#546; }
  .chip.ok{ background:#e9fbf0; border-color:#c9f1d9; color:#176d3a; }
  .chip > .fa-circle{ font-size:.5rem; vertical-align:middle }

  .upload-card{ background:#fff; border-color:#eef1ff !important; font-size:.9rem }
  .dz{ background:#f9fbff; border:1px dashed #c8d2ff !important; cursor:pointer; font-size:.85rem; transition:.15s }
  .dz:hover{ background:#f2f6ff; }
  .dz-file .badge{ font-weight:600; }
  .btn-xs{ font-size:.75rem; line-height:1; }
  .x-small{ font-size:.8rem; }
</style>

{{-- ======= Script (validasi & enabling tombol) ======= --}}
<script>
// Semua script yang telah diberikan tetap sama, tidak ada perubahan yang dibutuhkan
</script>
@endsection
