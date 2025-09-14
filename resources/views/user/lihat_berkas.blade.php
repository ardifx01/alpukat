@extends('user.theme.default')

@section('title', 'Lihat Berkas | ALPUKAT')

@section('content')
@php
  $kop   = collect($berkasUser ?? [])->filter(fn($i) => optional($i->syarat)->kategori_syarat === 'koperasi')->values();
  $peng  = collect($berkasUser ?? [])->filter(fn($i) => optional($i->syarat)->kategori_syarat === 'pengurus')->values();
  $was  = collect($berkasUser ?? [])->filter(fn($i) => optional($i->syarat)->kategori_syarat === 'pengawas')->values();

  $activeTab = in_array(request('tab'), ['pengurus','pengawas']) ? request('tab') : 'koperasi';
@endphp

{{-- ====== LATAR HALAMAN (DI LUAR CARD) ====== --}}
<div class="berkas-surface">
  <div class="container py-4" style="max-width:1040px;">

    {{-- ======= HEADER / COVER ======= --}}
    <div class="card shadow-sm border-0 mb-4" style="border-radius:18px; overflow:hidden;">
      <div class="position-relative"
           style="min-height:220px;padding:56px 0 28px;background:linear-gradient(135deg,#1f2a7a 0%, #4456d1 60%, #7e8af0 100%);">
        <span class="position-absolute rounded-circle" style="right:-40px;top:-40px;width:180px;height:180px;background:rgba(255,255,255,.08)"></span>
        <span class="position-absolute rounded-circle" style="left:-60px;bottom:-60px;width:240px;height:240px;background:rgba(255,255,255,.06)"></span>

        <div class="container text-white">
          <h2 class="mb-1 fw-bold" style="font-size:2rem;">Lihat Berkas</h2>
          <div class="opacity-85">Dokumen yang telah Anda unggah, dipisah berdasarkan jenis.</div>
        </div>
      </div>

      @if (session('success'))
        <div class="px-3 px-md-4 pt-3">
          <div class="alert alert-success border-0 shadow-sm rounded-3 mb-0">{{ session('success') }}</div>
        </div>
      @endif

      {{-- ======= NAV TABS ======= --}}
      <div class="px-3 px-md-4 pt-3 pb-1">
        <ul class="nav nav-pills gap-2 mb-0" id="berkasTab" data-active="{{ $activeTab }}" role="tablist">
          <li class="nav-item" role="presentation">
            <button class="nav-link soft-pill {{ $activeTab==='koperasi' ? 'active' : '' }}"
                    id="koperasi-tab" data-bs-toggle="tab" data-bs-target="#koperasi" type="button" role="tab"
                    aria-controls="koperasi" aria-selected="{{ $activeTab==='koperasi' ? 'true' : 'false' }}">
              Dokumen Koperasi
              <span class="badge badge-soft-primary ms-2">{{ $kop->count() }}</span>
            </button>
          </li>
          <li class="nav-item" role="presentation">
            <button class="nav-link soft-pill {{ $activeTab==='pengurus' ? 'active' : '' }}"
                    id="pengurus-tab" data-bs-toggle="tab" data-bs-target="#pengurus" type="button" role="tab"
                    aria-controls="pengurus" aria-selected="{{ $activeTab==='pengurus' ? 'true' : 'false' }}">
              Dokumen Pengurus Koperasi
              <span class="badge badge-soft-primary ms-2">{{ $peng->count() }}</span>
            </button>
          </li>
          <li class="nav-item" role="presentation">
            <button class="nav-link soft-pill {{ $activeTab==='pengawas' ? 'active' : '' }}"
                    id="pengawas-tab" data-bs-toggle="tab" data-bs-target="#pengawas" type="button" role="tab"
                    aria-controls="pengawas" aria-selected="{{ $activeTab==='pengawas' ? 'true' : 'false' }}">
              Dokumen Pengawas Koperasi
              <span class="badge badge-soft-primary ms-2">{{ $was->count() }}</span>
            </button>
          </li>
        </ul>
      </div>

      {{-- ======= TAB CONTENT ======= --}}
      <div class="card-body p-0">
        <div class="tab-content">

          {{-- TAB: KOPERASI --}}
          <div class="tab-pane fade {{ $activeTab==='koperasi' ? 'show active' : '' }}" id="koperasi" role="tabpanel" aria-labelledby="koperasi-tab" tabindex="0">
            @if($kop->isEmpty())
              <div class="p-5 text-center text-muted">Belum ada dokumen jenis koperasi.</div>
            @else
              <div class="table-responsive">
                <table class="table table-hover align-middle mb-0">
                  <thead class="table-light">
                    <tr>
                      <th style="width:56px;">No</th>
                      <th>Nama Dokumen</th>
                      <th>Nama File</th>
                      <th style="width:180px;">Diunggah</th>
                      <th style="width:220px;">Aksi</th>
                    </tr>
                  </thead>
                  <tbody>
                    @foreach ($kop as $item)
                      @php
                        $url  = $item->file_path ? Storage::url($item->file_path) : null;
                        $name = $item->original_name ?? ($item->file_path ? basename($item->file_path) : '-');
                      @endphp
                      <tr>
                        <td>{{ $loop->iteration }}</td>
                        <td>{{ $item->syarat->nama_syarat ?? '-' }}</td>
                        <td>
                          @if($url)
                            <a href="{{ $url }}" target="_blank" rel="noopener" class="text-decoration-none">
                              <span class="d-inline-block text-truncate" style="max-width:360px;" title="{{ $name }}">{{ $name }}</span>
                            </a>
                            @if(!empty($item->size))
                              <small class="text-muted d-block">{{ number_format($item->size/1024, 0) }} KB</small>
                            @endif
                          @else
                            <span class="badge badge-soft-danger">Belum diunggah</span>
                          @endif
                        </td>
                        <td>{{ optional($item->created_at)->format('d M Y, H:i') }}</td>
                        <td>
                          @if($url)
                            <div class="btn-group btn-group-sm" role="group">
                              <a href="{{ $url }}" target="_blank" rel="noopener" class="btn btn-outline-primary">
                                <i class="fa fa-eye me-1"></i> Lihat
                              </a>
                              <a href="{{ $url }}" download="{{ $name }}" class="btn btn-outline-secondary">
                                <i class="fa fa-download me-1"></i> Unduh
                              </a>
                            </div>
                          @else
                            <span class="text-muted">—</span>
                          @endif
                        </td>
                      </tr>
                    @endforeach
                  </tbody>
                </table>
              </div>
            @endif
          </div>

          {{-- TAB: PENGURUS --}}
          <div class="tab-pane fade {{ $activeTab==='pengurus' ? 'show active' : '' }}" id="pengurus" role="tabpanel" aria-labelledby="pengurus-tab" tabindex="0">
            @if($peng->isEmpty())
              <div class="p-5 text-center text-muted">Belum ada dokumen jenis pengurus koperasi.</div>
            @else
              <div class="table-responsive">
                <table class="table table-hover align-middle mb-0">
                  <thead class="table-light">
                    <tr>
                      <th style="width:56px;">No</th>
                      <th>Nama Dokumen</th>
                      <th>Nama File</th>
                      <th style="width:180px;">Diunggah</th>
                      <th style="width:220px;">Aksi</th>
                    </tr>
                  </thead>
                  <tbody>
                    @foreach ($peng as $item)
                      @php
                        $url  = $item->file_path ? Storage::url($item->file_path) : null;
                        $name = $item->original_name ?? ($item->file_path ? basename($item->file_path) : '-');
                      @endphp
                      <tr>
                        <td>{{ $loop->iteration }}</td>
                        <td>{{ $item->syarat->nama_syarat ?? '-' }}</td>
                        <td>
                          @if($url)
                            <a href="{{ $url }}" target="_blank" rel="noopener" class="text-decoration-none">
                              <span class="d-inline-block text-truncate" style="max-width:360px;" title="{{ $name }}">{{ $name }}</span>
                            </a>
                            @if(!empty($item->size))
                              <small class="text-muted d-block">{{ number_format($item->size/1024, 0) }} KB</small>
                            @endif
                          @else
                            <span class="badge badge-soft-danger">Belum diunggah</span>
                          @endif
                        </td>
                        <td>{{ optional($item->created_at)->format('d M Y, H:i') }}</td>
                        <td>
                          @if($url)
                            <div class="btn-group btn-group-sm" role="group">
                              <a href="{{ $url }}" target="_blank" rel="noopener" class="btn btn-outline-primary">
                                <i class="fa fa-eye me-1"></i> Lihat
                              </a>
                              <a href="{{ $url }}" download="{{ $name }}" class="btn btn-outline-secondary">
                                <i class="fa fa-download me-1"></i> Unduh
                              </a>
                            </div>
                          @else
                            <span class="text-muted">—</span>
                          @endif
                        </td>
                      </tr>
                    @endforeach
                  </tbody>
                </table>
              </div>
            @endif
          </div>

          {{-- TAB: PENGAWAS --}}
          <div class="tab-pane fade {{ $activeTab==='pengawas' ? 'show active' : '' }}" id="pengawas" role="tabpanel" aria-labelledby="pengawas-tab" tabindex="0">
            @if($peng->isEmpty())
              <div class="p-5 text-center text-muted">Belum ada dokumen jenis pengawas koperasi.</div>
            @else
              <div class="table-responsive">
                <table class="table table-hover align-middle mb-0">
                  <thead class="table-light">
                    <tr>
                      <th style="width:56px;">No</th>
                      <th>Nama Dokumen</th>
                      <th>Nama File</th>
                      <th style="width:180px;">Diunggah</th>
                      <th style="width:220px;">Aksi</th>
                    </tr>
                  </thead>
                  <tbody>
                    @foreach ($was as $item)
                      @php
                        $url  = $item->file_path ? Storage::url($item->file_path) : null;
                        $name = $item->original_name ?? ($item->file_path ? basename($item->file_path) : '-');
                      @endphp
                      <tr>
                        <td>{{ $loop->iteration }}</td>
                        <td>{{ $item->syarat->nama_syarat ?? '-' }}</td>
                        <td>
                          @if($url)
                            <a href="{{ $url }}" target="_blank" rel="noopener" class="text-decoration-none">
                              <span class="d-inline-block text-truncate" style="max-width:360px;" title="{{ $name }}">{{ $name }}</span>
                            </a>
                            @if(!empty($item->size))
                              <small class="text-muted d-block">{{ number_format($item->size/1024, 0) }} KB</small>
                            @endif
                          @else
                            <span class="badge badge-soft-danger">Belum diunggah</span>
                          @endif
                        </td>
                        <td>{{ optional($item->created_at)->format('d M Y, H:i') }}</td>
                        <td>
                          @if($url)
                            <div class="btn-group btn-group-sm" role="group">
                              <a href="{{ $url }}" target="_blank" rel="noopener" class="btn btn-outline-primary">
                                <i class="fa fa-eye me-1"></i> Lihat
                              </a>
                              <a href="{{ $url }}" download="{{ $name }}" class="btn btn-outline-secondary">
                                <i class="fa fa-download me-1"></i> Unduh
                              </a>
                            </div>
                          @else
                            <span class="text-muted">—</span>
                          @endif
                        </td>
                      </tr>
                    @endforeach
                  </tbody>
                </table>
              </div>
            @endif
          </div>

        </div>
      </div>
    </div>

  </div>
</div>

{{-- ===== Styles inline supaya pasti ter-load walau layout belum @stack("styles") ===== --}}
<style>
  :root{
    --theme-primary:#23349E;
    --theme-primary-soft:#e9edff;
    --theme-danger-soft:#ffe9ea;
    --theme-danger-text:#b42318;
  }

  /* LATAR HALAMAN DI LUAR CARD */
  .berkas-surface{
    position: relative;
    padding: 18px 0 36px;
    background:
      radial-gradient(360px 360px at calc(50% + 520px) 140px, rgba(126,138,240,.22), transparent 60%),
      radial-gradient(420px 420px at calc(50% - 520px) 560px, rgba(68,86,209,.18), transparent 60%),
      linear-gradient(180deg, #f6f8ff 0%, #eef2ff 55%, #eaf6ff 100%);
    min-height: 100%;
  }
  /* .berkas-surface::before,
  .berkas-surface::after{
    content:"";
    position:absolute; border-radius:50%; pointer-events:none; opacity:.22;
    background:#c2cdf2; filter: blur(2px);
  } */
  .berkas-surface::before{ width:220px;height:220px; left:-70px; top:120px; }
  .berkas-surface::after { width:180px;height:180px; right:-60px; bottom:80px; }

  /* pill nav */
  .soft-pill{ background:#f1f4ff; color:#334; border:0; }
  .soft-pill.active{ background:#e4e9ff; color:var(--theme-primary); font-weight:600; }

  /* badges */
  .badge{ vertical-align:middle; }
  .badge-soft-primary{
    color:var(--theme-primary);
    background:var(--theme-primary-soft);
    border:1px solid rgba(35,52,158,.12);
    border-radius:999px; font-weight:600;
  }
  .badge-soft-danger{
    color:var(--theme-danger-text);
    background:var(--theme-danger-soft);
    border:1px solid rgba(180,35,24,.15);
    border-radius:999px; font-weight:600;
  }

  .table thead th{ font-weight:600; }
  @media (max-width:576px){
    .table .text-truncate{ max-width:180px !important; }
  }

  /* lembutkan border card agar nyatu dengan latar */
  .card{ border-color:#e9ecff !important; }
</style>

{{-- ===== Script kecil untuk buka tab sesuai query ===== --}}
<script>
  (function(){
    var container = document.getElementById('berkasTab');
    var active = (container && container.getAttribute('data-active')) || 'koperasi';
    var map = { koperasi:'#koperasi', pengurus:'#pengurus', pengawas:'#pengawas' };
    var target = map[active] || '#koperasi';
    var trigger = document.querySelector('[data-bs-target="'+target+'"]');
    if (trigger && window.bootstrap && bootstrap.Tab) {
      new bootstrap.Tab(trigger).show();
    }
  })();
</script>
@endsection
