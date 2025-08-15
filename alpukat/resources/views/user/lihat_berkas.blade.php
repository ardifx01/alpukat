@extends('user.theme.default')

@section('title', 'Lihat Berkas | ALPUKAT')

@section('content')
<div class="container py-4">
  <div class="d-flex align-items-center justify-content-between mb-2">
    <h2 class="mb-2 fw-bold">Daftar Dokumen</h2>
  </div>
  <p class="text-muted mb-4">Dokumen yang telah Anda unggah, dipisah berdasarkan kategori.</p>

  @if (session('success'))
    <div class="alert alert-success mb-3">{{ session('success') }}</div>
  @endif

  @php
    // Kelompokkan data di sisi view (untuk performa besar, sebaiknya lakukan di Controller)
    $kop   = collect($berkasUser ?? [])->filter(fn($i) => optional($i->syarat)->kategori_syarat === 'koperasi')->values();
    $peng  = collect($berkasUser ?? [])->filter(fn($i) => optional($i->syarat)->kategori_syarat === 'pengurus')->values();
    $activeTab = request('tab') === 'pengurus' ? 'pengurus' : 'koperasi';
  @endphp

  {{-- NAV TABS --}}
  <ul class="nav nav-tabs mb-0" id="berkasTab" data-active="{{ $activeTab }}" role="tablist">
    <li class="nav-item" role="presentation">
      <button class="nav-link {{ $activeTab==='koperasi' ? 'active' : '' }}" id="koperasi-tab"
              data-bs-toggle="tab" data-bs-target="#koperasi" type="button" role="tab"
              aria-controls="koperasi" aria-selected="{{ $activeTab==='koperasi' ? 'true' : 'false' }}">
        📁 Koperasi <span class="badge rounded-pill text-bg-light ms-1">{{ $kop->count() }}</span>
      </button>
    </li>
    <li class="nav-item" role="presentation">
      <button class="nav-link {{ $activeTab==='pengurus' ? 'active' : '' }}" id="pengurus-tab"
              data-bs-toggle="tab" data-bs-target="#pengurus" type="button" role="tab"
              aria-controls="pengurus" aria-selected="{{ $activeTab==='pengurus' ? 'true' : 'false' }}">
        🗂️ Pengurus/Pengawas <span class="badge rounded-pill text-bg-light ms-1">{{ $peng->count() }}</span>
      </button>
    </li>
  </ul>

  <div class="card shadow-sm border-0 rounded-top-0">
    <div class="card-body p-0">
      <div class="tab-content">
        {{-- TAB: KOPERASI --}}
        <div class="tab-pane fade {{ $activeTab==='koperasi' ? 'show active' : '' }}" id="koperasi" role="tabpanel" aria-labelledby="koperasi-tab" tabindex="0">
          @if($kop->isEmpty())
            <div class="p-5 text-center text-muted">Belum ada dokumen kategori koperasi.</div>
          @else
            <div class="table-responsive">
              <table class="table table-hover align-middle mb-0">
                <thead class="table-light">
                  <tr>
                    <th style="width:56px;">No</th>
                    <th>Nama Dokumen</th>
                    <th>Nama File</th>
                    <th style="width:180px;">Diunggah</th>
                    <th style="width:180px;">Aksi</th>
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
                            <span class="d-inline-block text-truncate" style="max-width: 320px;" title="{{ $name }}">{{ $name }}</span>
                          </a>
                          @if(!empty($item->size))
                            <small class="text-muted d-block">{{ number_format($item->size/1024, 0) }} KB</small>
                          @endif
                        @else
                          <span class="text-danger">Belum diunggah</span>
                        @endif
                      </td>
                      <td>{{ optional($item->created_at)->format('d M Y, H:i') }}</td>
                      <td>
                        <div class="btn-group btn-group-sm" role="group">
                          @if($url)
                            <a href="{{ $url }}" target="_blank" rel="noopener" class="btn btn-outline-primary">Lihat</a>
                            <a href="{{ $url }}" download="{{ $name }}" class="btn btn-outline-secondary">Unduh</a>
                          @else
                            <span class="text-muted">—</span>
                          @endif
                        </div>
                      </td>
                    </tr>
                  @endforeach
                </tbody>
              </table>
            </div>
          @endif
        </div>

        {{-- TAB: PENGURUS/PENGAWAS --}}
        <div class="tab-pane fade {{ $activeTab==='pengurus' ? 'show active' : '' }}" id="pengurus" role="tabpanel" aria-labelledby="pengurus-tab" tabindex="0">
          @if($peng->isEmpty())
            <div class="p-5 text-center text-muted">Belum ada dokumen kategori pengurus/pengawas.</div>
          @else
            <div class="table-responsive">
              <table class="table table-hover align-middle mb-0">
                <thead class="table-light">
                  <tr>
                    <th style="width:56px;">No</th>
                    <th>Nama Dokumen</th>
                    <th>Nama File</th>
                    <th style="width:180px;">Diunggah</th>
                    <th style="width:180px;">Aksi</th>
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
                            <span class="d-inline-block text-truncate" style="max-width: 320px;" title="{{ $name }}">{{ $name }}</span>
                          </a>
                          @if(!empty($item->size))
                            <small class="text-muted d-block">{{ number_format($item->size/1024, 0) }} KB</small>
                          @endif
                        @else
                          <span class="text-danger">Belum diunggah</span>
                        @endif
                      </td>
                      <td>{{ optional($item->created_at)->format('d M Y, H:i') }}</td>
                      <td>
                        <div class="btn-group btn-group-sm" role="group">
                          @if($url)
                            <a href="{{ $url }}" target="_blank" rel="noopener" class="btn btn-outline-primary">Lihat</a>
                            <a href="{{ $url }}" download="{{ $name }}" class="btn btn-outline-secondary">Unduh</a>
                          @else
                            <span class="text-muted">—</span>
                          @endif
                        </div>
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
@endsection

@push('styles')
<style>
  .nav-tabs { border-bottom: 1px solid rgba(0,0,0,.08); }
  .nav-tabs .nav-link { border: none; color: var(--bs-body-color); }
  .nav-tabs .nav-link.active { border-bottom: 3px solid var(--bs-primary); font-weight: 600; color: var(--bs-primary); }
  @media (max-width: 576px) { .table .text-truncate { max-width: 160px !important; } }
</style>
@endpush

@push('scripts')
<script>
  // Jika ?tab=pengurus, buka tab Pengurus
  (function () {
    var container = document.getElementById('berkasTab');
    var active = (container && container.getAttribute('data-active')) || 'koperasi';
    if (active === 'pengurus') {
      var trigger = document.querySelector('[data-bs-target="#pengurus"]');
      if (trigger && window.bootstrap && bootstrap.Tab) {
        new bootstrap.Tab(trigger).show();
      }
    }
  })();
</script>
@endpush
