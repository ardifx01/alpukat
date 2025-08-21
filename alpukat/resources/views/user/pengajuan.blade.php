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

<div class="container py-4" style="max-width: 1040px;">

  {{-- ======= HEADER / COVER (tanpa ikon, teks agak diturunkan) ======= --}}
<div class="card shadow-sm border-0 mb-4" style="border-radius:18px; overflow:hidden;">
  <div class="position-relative"
       style="
         min-height: 220px;                       /* sedikit lebih tinggi */
         padding: 56px 0 28px;                    /* dorong teks ke bawah */
         background: linear-gradient(135deg,#1f2a7a 0%, #4456d1 60%, #7e8af0 100%);
       ">
    <span class="position-absolute rounded-circle" style="right:-40px;top:-40px;width:180px;height:180px;background:rgba(255,255,255,0.08)"></span>
    <span class="position-absolute rounded-circle" style="left:-60px;bottom:-60px;width:240px;height:240px;background:rgba(255,255,255,0.06)"></span>

    <div class="container text-white">
      <h2 class="mb-1 fw-bold" style="font-size:2rem;">Pengajuan SK UKK</h2>
      <div class="opacity-85">Unggah dokumen persyaratan sesuai instruksi di bawah ini.</div>
    </div>
  </div>

    {{-- body ringkas di bawah cover --}}
    <div class="px-3 px-md-4 pt-3 pb-4">
      @if($onCooldown)
        <div class="alert alert-warning border-0 shadow-sm rounded-3 mb-3">
          <i class="fa fa-clock-o me-1"></i>
          Anda bisa mengunggah lagi {{ $cooldownUntil->diffForHumans(['parts' => 2]) }}.
        </div>
      @endif

      <div class="alert alert-info border-0 shadow-sm rounded-3 mb-3">
        <div class="d-flex align-items-start gap-2">
          <i class="fa fa-info-circle mt-1"></i>
          <div>
            <strong>Catatan:</strong> Format file <code>PDF/JPG/PNG</code>, ukuran maksimal <strong>5 MB</strong> per file.
            Anda bisa klik area unggah atau seret & letakkan berkas ke sana.
          </div>
        </div>
      </div>

      {{-- ======= NAV TABS (pill lembut, konsisten) ======= --}}
      <div class="d-flex align-items-center justify-content-between flex-wrap gap-2">
        <ul class="nav nav-pills gap-2 mb-0" id="uploadTab" role="tablist">
          <li class="nav-item" role="presentation">
            <button class="nav-link soft-pill {{ $activeTab==='koperasi' ? 'active' : '' }}"
                    id="koperasi-tab" data-bs-toggle="tab" data-bs-target="#koperasi" type="button" role="tab">
              📁 Dokumen Berkas Koperasi
            </button>
          </li>
          <li class="nav-item" role="presentation">
            <button class="nav-link soft-pill {{ $activeTab==='pengurus' ? 'active' : '' }}"
                    id="pengurus-tab" data-bs-toggle="tab" data-bs-target="#pengurus" type="button" role="tab">
              🗂️ Dokumen Berkas Pengurus/Pengawas
            </button>
          </li>
        </ul>

        {{-- chip status per kategori --}}
        <div class="d-flex align-items-center gap-2 small">
          <span class="chip" id="chipKoperasi"><i class="fa fa-circle me-1"></i> Koperasi: <b>Belum</b></span>
          <span class="chip" id="chipPengurus"><i class="fa fa-circle me-1"></i> Pengurus: <b>Belum</b></span>
        </div>
      </div>

      {{-- ======= FORM ======= --}}
      <form method="POST" action="{{ route('user.store') }}" enctype="multipart/form-data"
            id="formPengajuan"
            class="tab-content bg-white p-3 p-md-4 border rounded-4 shadow-sm mt-3">
        @csrf

        {{-- === TAB KOPERASI === --}}
        <div class="tab-pane fade {{ $activeTab==='koperasi' ? 'show active' : '' }}" id="koperasi" role="tabpanel">
          @if(!$hasKoperasi)
            <div class="alert alert-secondary rounded-3">Belum ada persyaratan untuk kategori koperasi.</div>
          @else
            <div class="row g-3">
              @foreach ($syaratKoperasi as $syarat)
                @php $inputId = "dokumen_koperasi_{$syarat->id}"; @endphp
                <div class="col-12">
                  <div class="p-3 p-md-4 rounded-4 border upload-card h-100">
                    <div class="fw-semibold">{{ $syarat->nama_syarat }}</div>
                    <div class="text-muted small">
                      @if($syarat->is_required)
                        <span class="badge rounded-pill bg-danger-subtle text-danger">*</span> Wajib
                      @else
                        <span class="badge rounded-pill bg-secondary-subtle text-secondary">Opsional</span>
                      @endif
                    </div>

                    {{-- Dropzone (label) --}}
                    <label class="dz mt-3 d-block text-center p-4 rounded-3 border"
                           for="{{ $inputId }}">
                      <i class="fa fa-cloud-upload fa-2x mb-2 text-primary"></i>
                      <div class="small text-muted">
                        Seret & letakkan berkas di sini, atau <span class="text-primary fw-semibold">klik untuk memilih</span>.
                      </div>

                      <span class="dz-file d-none mt-3 d-inline-flex align-items-center gap-2">
                        <span class="badge bg-light text-dark border">
                          <i class="fa fa-file-o me-1"></i> <span class="dz-filename"></span>
                        </span>
                        <button type="button" class="dz-clear btn btn-sm btn-outline-danger rounded-pill">
                          <i class="fa fa-times"></i> Hapus
                        </button>
                      </span>

                      <small class="dz-msg text-muted mt-2 d-block"></small>
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
                </div>
              @endforeach
            </div>
          @endif
        </div>

        {{-- === TAB PENGURUS === --}}
        <div class="tab-pane fade {{ $activeTab==='pengurus' ? 'show active' : '' }}" id="pengurus" role="tabpanel">
          @if(!$hasPengurus)
            <div class="alert alert-secondary rounded-3">Belum ada persyaratan untuk kategori pengurus/pengawas.</div>
          @else
            <div class="row g-3">
              @foreach ($syaratPengurus as $syarat)
                @php $inputId = "dokumen_pengurus_{$syarat->id}"; @endphp
                <div class="col-12">
                  <div class="p-3 p-md-4 rounded-4 border upload-card h-100">
                    <div class="fw-semibold">{{ $syarat->nama_syarat }}</div>
                    <div class="text-muted small">
                      @if($syarat->is_required)
                        <span class="badge rounded-pill bg-danger-subtle text-danger">*</span> Wajib
                      @else
                        <span class="badge rounded-pill bg-secondary-subtle text-secondary">Opsional</span>
                      @endif
                    </div>

                    <label class="dz mt-3 d-block text-center p-4 rounded-3 border"
                           for="{{ $inputId }}">
                      <i class="fa fa-cloud-upload fa-2x mb-2 text-primary"></i>
                      <div class="small text-muted">
                        Seret & letakkan berkas di sini, atau <span class="text-primary fw-semibold">klik untuk memilih</span>.
                      </div>

                      <span class="dz-file d-none mt-3 d-inline-flex align-items-center gap-2">
                        <span class="badge bg-light text-dark border">
                          <i class="fa fa-file-o me-1"></i> <span class="dz-filename"></span>
                        </span>
                        <button type="button" class="dz-clear btn btn-sm btn-outline-danger rounded-pill">
                          <i class="fa fa-times"></i> Hapus
                        </button>
                      </span>

                      <small class="dz-msg text-muted mt-2 d-block"></small>
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
                </div>
              @endforeach
            </div>
          @endif
        </div>

        {{-- ======= Action bar (non-sticky) ======= --}}
        <div class="mt-4">
          <div class="d-flex align-items-center justify-content-between gap-2 p-3 rounded-3 border bg-light-subtle">
            <div class="small text-muted">
              <i class="fa fa-shield"></i>
              Pastikan semua <strong>syarat wajib</strong> di setiap kategori sudah diunggah.
            </div>
            <button id="btnKirim" type="submit" name="action" value="submit"
                    class="btn btn-primary px-4" {{ $onCooldown ? 'disabled' : '' }}>
              <i class="fa fa-paper-plane me-1"></i> Kirim Pengajuan
            </button>
          </div>
          <div id="barWarning" class="small text-danger mt-2 d-none">
            Untuk mengirim pengajuan, unggah berkas pada <strong>Koperasi</strong> dan
            <strong>Pengurus/Pengawas</strong> serta penuhi semua syarat (<strong>*</strong> = wajib).
          </div>
        </div>
      </form>
    </div>
  </div>
</div>

{{-- ======= Styles konsisten ======= --}}
<style>
  .soft-pill{ background:#f1f4ff; color:#334; border:0; }
  .soft-pill.active{ background:#e4e9ff; color:#23349E; font-weight:600; }

  .chip{
    padding:.35rem .65rem; border-radius:999px;
    background:#f6f7fb; border:1px solid #e8eaf6; color:#546; display:inline-flex; align-items:center;
  }
  .chip.ok{ background:#e9fbf0; border-color:#c9f1d9; color:#176d3a; }
  .chip > .fa-circle{ font-size:.5rem; }
  .chip.ok > .fa-circle{ color:#1db45a; }
  .chip:not(.ok) > .fa-circle{ color:#d3d7f8; }

  .upload-card{ background:#fff; border-color:#eef1ff !important; }
  .dz{ background:#f9fbff; border:1px dashed #c8d2ff !important; transition:.2s; cursor:pointer; }
  .dz:hover{ background:#f2f6ff; }
  .dz-file .badge{ font-weight:600; }
  .dz-msg.text-danger{ color:#d9534f !important; }
</style>

{{-- ======= Script (validasi & enabling tombol) ======= --}}
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
    dz.querySelector('.dz-file')?.classList.add('d-none');
    setMessage(dz, '', false);
    input.value = '';
    dz.dataset.hasfile = '0';
    updateSubmit();
  }

  function showFile(dz, file){
    dz.querySelector('.dz-filename').textContent = file.name;
    dz.querySelector('.dz-file').classList.remove('d-none');
    dz.dataset.hasfile = '1';
    updateSubmit();
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

  function catStatus(cat){
    const inputs = document.querySelectorAll('input[type="file"][data-category="'+cat+'"]');
    if (!inputs.length) return {hasAny:false, allReq:true, ok:true};
    let hasAny=false, allReq=true;
    inputs.forEach(inp=>{
      const has = !!(inp.files && inp.files.length);
      if (has) hasAny = true;
      if ((inp.dataset.required|0)===1 && !has) allReq = false;
    });
    return {hasAny, allReq, ok: hasAny && allReq};
  }

  function updateChips(){
    const k = catStatus('koperasi'), p = catStatus('pengurus');
    const ck = document.getElementById('chipKoperasi');
    const cp = document.getElementById('chipPengurus');
    if (ck){ ck.classList.toggle('ok', k.ok); ck.querySelector('b').textContent = k.ok?'Lengkap':'Belum'; }
    if (cp){ cp.classList.toggle('ok', p.ok); cp.querySelector('b').textContent = p.ok?'Lengkap':'Belum'; }
  }

  function updateSubmit(){
    const ok = catStatus('koperasi').ok && catStatus('pengurus').ok;
    const btn = document.getElementById('btnKirim');
    const warn= document.getElementById('barWarning');
    if (btn) btn.disabled = !ok;
    if (warn) warn.classList.toggle('d-none', ok);
    updateChips();
  }

  // Init dropzone
  document.querySelectorAll('label.dz').forEach(dz=>{
    const input = document.getElementById(dz.getAttribute('for'));
    if (!input) return;

    input.addEventListener('change', function(){
      const f = this.files && this.files[0];
      f ? validateAndShow(dz, input, f) : clearFile(dz, input);
    });
    dz.querySelector('.dz-clear')?.addEventListener('click', e=>{
      e.preventDefault(); e.stopPropagation(); clearFile(dz, input);
    });
    ['dragenter','dragover'].forEach(ev=>dz.addEventListener(ev, e=>{
      e.preventDefault(); e.stopPropagation(); dz.classList.add('shadow-sm');
    }));
    ['dragleave','drop'].forEach(ev=>dz.addEventListener(ev, e=>{
      e.preventDefault(); e.stopPropagation(); dz.classList.remove('shadow-sm');
    }));
    dz.addEventListener('drop', e=>{
      const f = e.dataTransfer.files && e.dataTransfer.files[0];
      if (!f) return;
      const dt = new DataTransfer(); dt.items.add(f); input.files = dt.files;
      validateAndShow(dz, input, f);
    });
  });

  // Submit guard
  document.getElementById('formPengajuan')?.addEventListener('submit', function(e){
    updateSubmit();
    if (!(catStatus('koperasi').ok && catStatus('pengurus').ok)) {
      e.preventDefault();
      const firstErr = document.querySelector('input[type="file"][data-required="1"]:not([value])');
      if (firstErr) document.querySelector('label.dz[for="'+firstErr.id+'"]').scrollIntoView({behavior:'smooth', block:'center'});
    }
  });

  updateSubmit();
})();
</script>
@endsection
