@extends('user.dashboard')

@section('title', 'Pengajuan | ALPUKAT')

@section('content')
@php
    // Tentukan tab aktif
    $activeTab = 'koperasi';
    foreach (($syaratPengurus ?? []) as $s) {
        if ($errors->has("dokumen.$s->id")) { $activeTab = 'pengurus'; break; }
    }
    if (request('tab') === 'pengurus') { $activeTab = 'pengurus'; }
    $onCooldown = isset($cooldownUntil) && now()->lt($cooldownUntil);

    $hasKoperasi = !empty($syaratKoperasi) && count($syaratKoperasi) > 0;
    $hasPengurus = !empty($syaratPengurus) && count($syaratPengurus) > 0;
@endphp

{{-- HERO SECTION --}}
<section class="hero position-relative text-white mb-4">
    <div class="hero-bg"
         style="background:url('{{ asset('images/pengajuan.png') }}') center/cover no-repeat;
                height:280px; position:relative;">
        <div class="overlay position-absolute top-0 start-0 w-100 h-100" style="background:rgba(0,0,0,.45);"></div>
        <div class="container h-100 d-flex flex-column justify-content-center align-items-center text-center position-relative">
            <h1 class="fw-bold mb-2" style="font-size:2rem;">Pengajuan SK UKK</h1>
            <p class="mb-0" style="max-width:720px;">Unggah dokumen persyaratan sesuai instruksi di bawah ini.</p>
        </div>
    </div>
</section>

<div class="container py-4" style="max-width:1000px">
    {{-- Cooldown --}}
    @if($onCooldown)
        <div class="alert alert-warning border-0 shadow-sm rounded-3">
            <i class="fa fa-clock-o me-1"></i>
            Anda bisa mengunggah lagi {{ $cooldownUntil->diffForHumans(['parts' => 2]) }}.
        </div>
    @endif

    {{-- Info umum --}}
    <div class="alert alert-info border-0 shadow-sm rounded-3">
        <div class="d-flex align-items-start gap-2">
            <i class="fa fa-info-circle mt-1"></i>
            <div>
                <strong><br>Catatan:</strong> Format file <code>PDF/JPG/PNG</code>, ukuran maksimal <strong>5 MB</strong> per file.
                Anda bisa klik area unggah atau seret & letakkan berkas ke sana.
            </div>
        </div>
    </div>

    {{-- NAV TABS + tombol lihat --}}
    <div class="d-flex align-items-center justify-content-between flex-wrap gap-2">
        <ul class="nav nav-tabs gap-2 border-0 mb-0" id="uploadTab" role="tablist">
            <li class="nav-item" role="presentation">
                <button class="nav-link rounded-pill {{ $activeTab==='koperasi' ? 'active' : '' }}"
                        id="koperasi-tab" data-bs-toggle="tab" data-bs-target="#koperasi" type="button" role="tab">
                    📁 Dokumen Berkas Koperasi
                </button>
            </li>
            <li class="nav-item" role="presentation">
                <button class="nav-link rounded-pill {{ $activeTab==='pengurus' ? 'active' : '' }}"
                        id="pengurus-tab" data-bs-toggle="tab" data-bs-target="#pengurus" type="button" role="tab">
                    🗂️ Dokumen Berkas Pengurus/Pengawas
                </button>
            </li>
        </ul>
    </div>

    <form method="POST" action="{{ route('user.store') }}" enctype="multipart/form-data"
          id="formPengajuan"
          class="tab-content bg-white p-3 p-md-4 border rounded-bottom rounded-4 shadow-sm mt-2">
        @csrf

        {{-- ========== TAB: KOPERASI ========== --}}
        <div class="tab-pane fade {{ $activeTab==='koperasi' ? 'show active' : '' }}" id="koperasi" role="tabpanel">
            @if(!$hasKoperasi)
                <div class="alert alert-secondary rounded-3">Belum ada persyaratan untuk kategori koperasi.</div>
            @else
                <div class="row g-3">
                    @foreach ($syaratKoperasi as $syarat)
                        @php $inputId = "dokumen_koperasi_{$syarat->id}"; @endphp
                        <div class="col-12">
                            <label class="form-label fw-semibold mb-2 d-block">
                                {{ $syarat->nama_syarat }}
                                @if($syarat->is_required)
                                    <span class="badge rounded-pill bg-danger-subtle text-danger ms-2">*</span>
                                @else
                                    <span class="badge rounded-pill bg-secondary-subtle text-secondary ms-2">Opsional</span>
                                @endif
                            </label>

                            {{-- Dropzone sebagai LABEL agar klik selalu memicu input file --}}
                            <label class="dz border rounded-3 p-3 d-flex flex-column align-items-center justify-content-center text-center"
                                   for="{{ $inputId }}">
                                <i class="fa fa-cloud-upload fa-2x mb-2 text-primary"></i>
                                <div class="small text-muted">
                                    Seret & letakkan berkas di sini, atau <span class="text-primary fw-semibold">klik untuk memilih</span>.
                                </div>
                                <span class="dz-file d-none mt-2">
                                    <span class="badge bg-light text-dark border">
                                        <i class="fa fa-file-o me-1"></i> <span class="dz-filename"></span>
                                    </span>
                                    <button type="button" class="dz-clear btn btn-link btn-sm text-danger">Hapus</button>
                                </span>
                                <small class="dz-msg text-muted mt-1"></small>
                            </label>

                            <input type="file" id="{{ $inputId }}" name="dokumen[{{ $syarat->id }}]"
                                   accept=".pdf,.jpg,.jpeg,.png" hidden
                                   data-required="{{ $syarat->is_required ? 1 : 0 }}"
                                   data-category="koperasi"
                                   class="@error('dokumen.'.$syarat->id) is-invalid @enderror">

                            @error('dokumen.'.$syarat->id)
                                <div class="invalid-feedback d-block">{{ $message }}</div>
                            @enderror
                        </div>
                    @endforeach
                </div>
            @endif
        </div>

        {{-- ========== TAB: PENGURUS/PENGAWAS ========== --}}
        <div class="tab-pane fade {{ $activeTab==='pengurus' ? 'show active' : '' }}" id="pengurus" role="tabpanel">
            @if(!$hasPengurus)
                <div class="alert alert-secondary rounded-3">Belum ada persyaratan untuk kategori pengurus/pengawas.</div>
            @else
                <div class="row g-3">
                    @foreach ($syaratPengurus as $syarat)
                        @php $inputId = "dokumen_pengurus_{$syarat->id}"; @endphp
                        <div class="col-12">
                            <label class="form-label fw-semibold mb-2 d-block">
                                {{ $syarat->nama_syarat }}
                                @if($syarat->is_required)
                                    <span class="badge rounded-pill bg-danger-subtle text-danger ms-2">*</span>
                                @else
                                    <span class="badge rounded-pill bg-secondary-subtle text-secondary ms-2">Opsional</span>
                                @endif
                            </label>

                            <label class="dz border rounded-3 p-3 d-flex flex-column align-items-center justify-content-center text-center"
                                   for="{{ $inputId }}">
                                <i class="fa fa-cloud-upload fa-2x mb-2 text-primary"></i>
                                <div class="small text-muted">
                                    Seret & letakkan berkas di sini, atau <span class="text-primary fw-semibold">klik untuk memilih</span>.
                                </div>
                                <span class="dz-file d-none mt-2">
                                    <span class="badge bg-light text-dark border">
                                        <i class="fa fa-file-o me-1"></i> <span class="dz-filename"></span>
                                    </span>
                                    <button type="button" class="dz-clear btn btn-link btn-sm text-danger">Hapus</button>
                                </span>
                                <small class="dz-msg text-muted mt-1"></small>
                            </label>

                            <input type="file" id="{{ $inputId }}" name="dokumen[{{ $syarat->id }}]"
                                   accept=".pdf,.jpg,.jpeg,.png" hidden
                                   data-required="{{ $syarat->is_required ? 1 : 0 }}"
                                   data-category="pengurus"
                                   class="@error('dokumen.'.$syarat->id) is-invalid @enderror">

                            @error('dokumen.'.$syarat->id)
                                <div class="invalid-feedback d-block">{{ $message }}</div>
                            @enderror
                        </div>
                    @endforeach
                </div>
            @endif
        </div>

        {{-- Sticky Action Bar --}}
        <div class="position-sticky mt-4" style="bottom:0;">
            <div class="d-flex align-items-center justify-content-between gap-2 p-3 rounded-3 border bg-light-subtle">
                <div class="small text-muted">
                    <i class="fa fa-shield"></i> Pastikan semua <strong>syarat wajib</strong> di setiap kategori sudah diunggah.
                </div>
                <button id="btnKirim" type="submit" name="action" value="submit"
                        class="btn btn-primary px-4" {{ $onCooldown ? 'disabled' : '' }}>
                    <i class="fa fa-paper-plane me-1"></i> Kirim Pengajuan
                </button>
            </div>
            <div id="barWarning" class="small text-danger mt-2 d-none">
                Untuk mengirim pengajuan, unggah berkas pada <strong>Koperasi</strong> dan <strong>Pengurus/Pengawas</strong> serta penuhi semua syarat (* = wajib).
            </div>
        </div>
    </form>
</div>

{{-- Styles --}}
<style>
    .nav-tabs .nav-link { border:0; padding:.5rem 1rem; }
    .nav-tabs .nav-link.active { background:#e9edff; color:#23349E; }
    .dz { background:#f9fbff; border:1px dashed #bfc8ff; cursor:pointer; transition:.2s; }
    .dz:hover { background:#f2f6ff; }
</style>

{{-- INLINE SCRIPT --}}
<script>
(function(){
  const MAX = 5 * 1024 * 1024; // 5 MB
  const ALLOWED = ['pdf','jpg','jpeg','png'];

  // Buka tab pengurus via hash
  if (window.location.hash === '#pengurus') {
    const trigger = document.querySelector('[data-bs-target="#pengurus"]');
    if (trigger && window.bootstrap?.Tab) new bootstrap.Tab(trigger).show();
  }

  function setMessage(dz, text, isError){
    const msgEl = dz.querySelector('.dz-msg');
    if (!msgEl) return;
    msgEl.textContent = text || '';
    msgEl.classList.toggle('text-danger', !!isError);
    msgEl.classList.toggle('text-muted', !isError);
  }

  function clearFile(dz, input){
    const fileBox = dz.querySelector('.dz-file');
    setMessage(dz, '', false);
    if (fileBox) fileBox.classList.add('d-none');
    input.value = '';
    dz.dataset.hasfile = '0';
    updateSubmitState();
  }

  function showFile(dz, file){
    const fileBox = dz.querySelector('.dz-file');
    const fnameEl = dz.querySelector('.dz-filename');
    if (fnameEl) fnameEl.textContent = file.name;
    if (fileBox) fileBox.classList.remove('d-none');
    dz.dataset.hasfile = '1';
    updateSubmitState();
  }

  function validateAndShow(dz, input, file){
    if (!file) return false;
    const ext = (file.name.split('.').pop() || '').toLowerCase();
    if (!ALLOWED.includes(ext)) {
      alert('Tipe file tidak didukung. Gunakan PDF/JPG/PNG.');
      setMessage(dz, 'Tipe file tidak didukung. Gunakan PDF/JPG/PNG.', true);
      clearFile(dz, input);
      return false;
    }
    if (file.size > MAX) {
      alert('Ukuran file melebihi 5 MB.');
      setMessage(dz, 'Ukuran file melebihi 5 MB.', true);
      clearFile(dz, input);
      return false;
    }
    setMessage(dz, 'Siap diunggah.', false);
    showFile(dz, file);
    return true;
  }

  // Hitung status kategori
  function categoryStatus(category){
    const inputs = document.querySelectorAll('input[type="file"][data-category="'+category+'"]');
    if (!inputs.length) {
      // kategori tanpa syarat, dianggap lolos
      return { hasAny:false, allRequired:true, ok:true };
    }
    let hasAny = false;
    let allRequired = true;
    inputs.forEach(inp => {
      const dz = document.querySelector('label.dz[for="'+ inp.id +'"]');
      const hasFile = !!(inp.files && inp.files.length);
      if (hasFile) hasAny = true;
      if (parseInt(inp.dataset.required || '0',10) === 1 && !hasFile) {
        allRequired = false;
      }
    });
    // aturan: harus ada minimal satu file DI kategori tsb + semua yang wajib terisi
    const ok = hasAny && allRequired;
    return { hasAny, allRequired, ok };
  }

  function updateSubmitState(){
    const koperasi = categoryStatus('koperasi');
    const pengurus = categoryStatus('pengurus');
    const btn = document.getElementById('btnKirim');
    const warn = document.getElementById('barWarning');
    const overallOK = koperasi.ok && pengurus.ok;

    if (btn) btn.disabled = !overallOK;
    if (warn) warn.classList.toggle('d-none', overallOK);
  }

  // Init semua dropzone
  document.querySelectorAll('label.dz').forEach(function(dz){
    const inputId = dz.getAttribute('for');
    const input   = document.getElementById(inputId);
    if (!input) return;

    dz.dataset.hasfile = '0';

    // Perubahan via dialog
    input.addEventListener('change', function(){
      const f = this.files && this.files[0];
      if (f) validateAndShow(dz, input, f);
      else { clearFile(dz, input); }
    });

    // Tombol Hapus
    dz.querySelector('.dz-clear')?.addEventListener('click', function(e){
      e.preventDefault(); e.stopPropagation();
      clearFile(dz, input);
    });

    // Drag & drop
    ['dragenter','dragover'].forEach(ev => dz.addEventListener(ev, e => {
      e.preventDefault(); e.stopPropagation(); dz.classList.add('shadow-sm');
    }));
    ['dragleave','drop'].forEach(ev => dz.addEventListener(ev, e => {
      e.preventDefault(); e.stopPropagation(); dz.classList.remove('shadow-sm');
    }));
    dz.addEventListener('drop', function(e){
      const file = e.dataTransfer.files && e.dataTransfer.files[0];
      if (!file) return;
      // taruh ke input agar terkirim saat submit
      const dt = new DataTransfer();
      dt.items.add(file);
      input.files = dt.files;
      validateAndShow(dz, input, file);
    });
  });

  // Validasi saat submit (pastikan dua kategori memenuhi aturan)
  document.getElementById('formPengajuan')?.addEventListener('submit', function(e){
    // refresh state
    updateSubmitState();

    const koperasi = categoryStatus('koperasi');
    const pengurus = categoryStatus('pengurus');

    if (!koperasi.ok || !pengurus.ok) {
      e.preventDefault();

      // Sorot pesan pada kategori yang kurang
      if (!koperasi.ok) {
        document.querySelectorAll('input[type="file"][data-category="koperasi"][data-required="1"]').forEach(function(inp){
          if (!inp.files || !inp.files.length) {
            const dz = document.querySelector('label.dz[for="'+ inp.id +'"]');
            if (dz) setMessage(dz, 'Berkas wajib diunggah (Koperasi).', true);
          }
        });
      }
      if (!pengurus.ok) {
        document.querySelectorAll('input[type="file"][data-category="pengurus"][data-required="1"]').forEach(function(inp){
          if (!inp.files || !inp.files.length) {
            const dz = document.querySelector('label.dz[for="'+ inp.id +'"]');
            if (dz) setMessage(dz, 'Berkas wajib diunggah (Pengurus/Pengawas).', true);
          }
        });
      }

      // Scroll ke area pertama yang error
      const firstErrDz = document.querySelector('.dz .text-danger:not(.d-none)')?.closest('.dz') ||
                         document.querySelector('label.dz[data-hasfile="0"]');
      if (firstErrDz) firstErrDz.scrollIntoView({behavior:'smooth', block:'center'});
      return false;
    }
  });

  // Set state awal tombol
  updateSubmitState();

})();
</script>
@endsection
