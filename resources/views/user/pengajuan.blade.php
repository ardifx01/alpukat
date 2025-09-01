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

{{-- ====== WRAPPER LATAR HALAMAN ====== --}}
<div class="pengajuan-surface">

  <div class="container py-4" style="max-width:1040px;">

    {{-- ======= HEADER / COVER (SERAGAM) ======= --}}
    <div class="card shadow-sm border-0 mb-3" style="border-radius:18px; overflow:hidden;">
      <div class="position-relative"
           style="
             min-height:220px;
             padding:56px 0 28px;
             background:linear-gradient(135deg,#1f2a7a 0%, #4456d1 60%, #7e8af0 100%);
           ">
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
                Koperasi
              </button>
            </li>
            <li class="nav-item" role="presentation">
              <button class="nav-link soft-pill {{ $activeTab==='pengurus' ? 'active' : '' }}"
                      id="pengurus-tab" data-bs-toggle="tab" data-bs-target="#pane-pengurus" type="button" role="tab">
                Pengurus dan Pengawas Koperasi
              </button>
            </li>
          </ul>

          <div class="d-flex align-items-center gap-2 x-small">
            <span class="chip" id="chipKoperasi"><i class="fa fa-circle me-1"></i> Koperasi: <b>Belum</b></span>
            <span class="chip" id="chipPengurus"><i class="fa fa-circle me-1"></i> Pengurus dan Pengawas Koperasi: <b>Belum</b></span>
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
                    <div class="col-12">
                      <div class="p-2 rounded-3 border upload-card h-100">
                        {{-- Nama syarat --}}
                        <div class="small text-dark">
                          <strong>{{ $syarat->nama_syarat }}</strong>
                          @if($syarat->is_required)
                            <span class="ms-1 text-danger fw-bold">*</span>
                            <span class="text-muted x-small">Wajib</span>
                          @else
                            <span class="text-muted x-small ms-1">Opsional</span>
                          @endif
                        </div>

                        {{-- Dropzone --}}
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
                <div class="alert alert-secondary rounded-3 small mb-2">Belum ada persyaratan untuk kategori pengurus dan pengawas koperasi.</div>
              @else
                <div class="row g-2">
                  @foreach ($syaratPengurus as $syarat)
                    @php $inputId = "dokumen_pengurus_{$syarat->id}"; @endphp
                    <div class="col-12">
                      <div class="p-2 rounded-3 border upload-card h-100">
                        <div class="small text-dark">
                          <strong>{{ $syarat->nama_syarat }}</strong>
                          @if($syarat->is_required)
                            <span class="ms-1 text-danger fw-bold">*</span>
                            <span class="text-muted x-small">Wajib</span>
                          @else
                            <span class="text-muted x-small ms-1">Opsional</span>
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
              Lengkapi unggahan pada <strong>Koperasi</strong> serta <strong>Pengurus dan Pengawas Koperasi</strong> sebelum kirim.
            </div>
          </div>

        </form>
      </div>
    </div>
  </div>

</div> {{-- /.pengajuan-surface --}}

{{-- ======= Styles (compact & unified) ======= --}}
<style>
  /* LATAR HALAMAN DI LUAR CARD */
  .pengajuan-surface{
    position: relative;
    padding: 18px 0 36px;
    /* gradient lembut + bokeh */
    background:
      radial-gradient(360px 360px at calc(50% + 520px) 140px, rgba(126,138,240,.22), transparent 60%),
      radial-gradient(420px 420px at calc(50% - 520px) 560px, rgba(68,86,209,.18), transparent 60%),
      linear-gradient(180deg, #f6f8ff 0%, #eef2ff 55%, #eaf6ff 100%);
    min-height: 100%;
  }
  /* dekor lingkaran halus */
  .pengajuan-surface::before,
  .pengajuan-surface::after{
    content:"";
    position:absolute; border-radius:50%; pointer-events:none; opacity:.22;
    background:#c2cdf2; filter: blur(2px);
  }
  .pengajuan-surface::before{ width:220px;height:220px; left:-70px; top:120px; }
  .pengajuan-surface::after { width:180px;height:180px; right:-60px; bottom:80px; }

  .soft-pill{ background:#f1f4ff; color:#334; border:0; font-size:.9rem; padding:.35rem .8rem }
  .soft-pill.active{ background:#e4e9ff; color:#23349E; font-weight:600; }

  .chip{ padding:.22rem .5rem; border-radius:999px; background:#ff4d4f; border:1px solid #ff4d4f; color:#fff; }
  .chip.ok{ background:#e9fbf0; border-color:#c9f1d9; color:#176d3a; }
  .chip > .fa-circle{ font-size:.5rem; vertical-align:middle }

  .upload-card{ background:#fff; border-color:#eef1ff !important; font-size:.9rem }
  .dz{ background:#f9fbff; border:1px dashed #c8d2ff !important; cursor:pointer; font-size:.85rem; transition:.15s }
  .dz:hover{ background:#f2f6ff; }
  .dz-file .badge{ font-weight:600; }
  .btn-xs{ font-size:.75rem; line-height:1; }
  .x-small{ font-size:.8rem; }

  /* (opsional) peredam kontras border card terhadap latar baru */
  .card{ border-color:#e9ecff !important; }
</style>

{{-- ======= Script (validasi & enabling tombol) ======= --}}
<script>
(function(){
  const MAX = 5 * 1024 * 1024; // 5 MB
  const ALLOWED = ['pdf','jpg','jpeg','png'];

  if (window.location.hash === '#pengurus') {
    const trigger = document.querySelector('[data-bs-target="#pane-pengurus"]');
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
    const fnameEl = dz.querySelector('.dz-filename'); if (fnameEl) fnameEl.textContent = '';
    setMessage(dz, '', false);
    dz.classList.remove('shadow-sm');
    input.value = '';
    dz.dataset.hasfile = '0';
    updateSubmit();
  }

  function showFile(dz, file){
    const fnameEl = dz.querySelector('.dz-filename'); if (fnameEl) fnameEl.textContent = file.name;
    dz.querySelector('.dz-file')?.classList.remove('d-none');
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

  document.querySelectorAll('label.dz').forEach(dz=>{
    const input = document.getElementById(dz.getAttribute('for'));
    if (!input) return;

    input.addEventListener('change', function(){
      const f = this.files && this.files[0];
      f ? validateAndShow(dz, input, f) : clearFile(dz, input);
    });

    dz.querySelector('.dz-clear')?.addEventListener('click', e=>{
      e.preventDefault(); e.stopPropagation();
      clearFile(dz, input);
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

  document.getElementById('formPengajuan')?.addEventListener('submit', function(e){
    updateSubmit();
    if (!(catStatus('koperasi').ok && catStatus('pengurus').ok)) {
      e.preventDefault();
      const firstErrReq = document.querySelector('input[type="file"][data-required="1"]:not([value])');
      if (firstErrReq) {
        const dz = document.querySelector('label.dz[for="'+firstErrReq.id+'"]');
        if (dz) dz.scrollIntoView({behavior:'smooth', block:'center'});
      }
    }
  });

  updateSubmit();
})();
</script>
@endsection
