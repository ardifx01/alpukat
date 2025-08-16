@extends('user.dashboard')

@section('title', 'Pengajuan | ALPUKAT')

@section('content')
<div class="container py-4">
    <h2 class="mb-2 fw-bold">Upload Dokumen Permohonan SK UKK</h2>
    <p class="text-muted mb-4">Unggah Dokumen Permohonan Surat Keputusan Uji Kelayakan dan Kepatutan (SK UKK) Anda di sini</p>

    @if(isset($cooldownUntil) && now()->lt($cooldownUntil))
    <div class="alert alert-warning">
        Anda bisa mengunggah lagi tunggu {{ $cooldownUntil->diffForHumans(['parts' => 2]) }}
    </div>
    @endif

    @php
        // Tentukan tab aktif: default "koperasi". Jika ada error di tab pengurus, aktifkan pengurus.
        $activeTab = 'koperasi';
        foreach (($syaratPengurus ?? []) as $s) {
        if ($errors->has("dokumen.$s->id")) { $activeTab = 'pengurus'; break; }
        }
        // Opsional: izinkan query ?tab=pengurus untuk memaksa tab
        if (request('tab') === 'pengurus') { $activeTab = 'pengurus'; }
    @endphp

    {{-- NAV TABS --}}
    <ul class="nav nav-tabs" id="uploadTab" role="tablist">
        <li class="nav-item" role="presentation">
        <button class="nav-link {{ $activeTab==='koperasi' ? 'active' : '' }}" id="koperasi-tab"
                data-bs-toggle="tab" data-bs-target="#koperasi" type="button" role="tab"
                aria-controls="koperasi" aria-selected="{{ $activeTab==='koperasi' ? 'true' : 'false' }}">
            📁 Koperasi
        </button>
        </li>
        <li class="nav-item" role="presentation">
        <button class="nav-link {{ $activeTab==='pengurus' ? 'active' : '' }}" id="pengurus-tab"
                data-bs-toggle="tab" data-bs-target="#pengurus" type="button" role="tab"
                aria-controls="pengurus" aria-selected="{{ $activeTab==='pengurus' ? 'true' : 'false' }}">
            🗂️ Pengurus/Pengawas
        </button>
        </li>
    </ul>

    <form method="POST" action="{{ route('user.store') }}" enctype="multipart/form-data"
            class="tab-content border-start border-end border-bottom p-3 rounded-bottom" id="uploadTabContent">
        @csrf

        {{-- TAB: KOPERASI --}}
        <div class="tab-pane fade {{ $activeTab==='koperasi' ? 'show active' : '' }}" id="koperasi" role="tabpanel" aria-labelledby="koperasi-tab" tabindex="0">
        @if(collect($syaratKoperasi ?? [])->isEmpty())
            <div class="alert alert-info mt-3">Belum ada persyaratan untuk kategori koperasi.</div>
        @else
            @foreach ($syaratKoperasi as $syarat)
            <div class="mb-3">
                <label for="dokumen_{{ $syarat->id }}" class="form-label">
                {{ $syarat->nama_syarat }}
                @if($syarat->is_required)
                    <span class="badge text-bg-danger ms-2">Wajib</span>
                @else
                    <span class="badge text-bg-secondary ms-2">Opsional</span>
                @endif
                </label>
                <input type="file" id="dokumen_{{ $syarat->id }}" name="dokumen[{{ $syarat->id }}]"
                    accept=".pdf,.jpg,.jpeg,.png"
                    class="form-control @error('dokumen.'.$syarat->id) is-invalid @enderror"
                    @if($syarat->is_required) required @endif>
                @error('dokumen.'.$syarat->id)
                <div class="invalid-feedback">{{ $message }}</div>
                @else
                <div class="form-text">Format: PDF/JPG/PNG.</div>
                @enderror
            </div>
            @endforeach
        @endif
        </div>

        {{-- TAB: PENGURUS/PENGAWAS --}}
        <div class="tab-pane fade {{ $activeTab==='pengurus' ? 'show active' : '' }}" id="pengurus" role="tabpanel" aria-labelledby="pengurus-tab" tabindex="0">
        @if(collect($syaratPengurus ?? [])->isEmpty())
            <div class="alert alert-info mt-3">Belum ada persyaratan untuk kategori pengurus/pengawas.</div>
        @else
            @foreach ($syaratPengurus as $syarat)
            <div class="mb-3">
                <label for="dokumen_{{ $syarat->id }}" class="form-label">
                {{ $syarat->nama_syarat }}
                @if($syarat->is_required)
                    <span class="badge text-bg-danger ms-2">Wajib</span>
                @else
                    <span class="badge text-bg-secondary ms-2">Opsional</span>
                @endif
                </label>
                <input type="file" id="dokumen_{{ $syarat->id }}" name="dokumen[{{ $syarat->id }}]"
                    accept=".pdf,.jpg,.jpeg,.png"
                    class="form-control @error('dokumen.'.$syarat->id) is-invalid @enderror"
                    @if($syarat->is_required) required @endif>
                @error('dokumen.'.$syarat->id)
                <div class="invalid-feedback">{{ $message }}</div>
                @else
                <div class="form-text">Format: PDF/JPG/PNG.</div>
                @enderror
            </div>
            @endforeach
        @endif
        </div>

        <div class="d-flex gap-2 mt-3">
        @php $onCooldown = $cooldownUntil && now()->lt($cooldownUntil); @endphp
        <button type="submit" name="action" value="submit" class="btn btn-primary" {{ $onCooldown ? 'disabled' : '' }}>
            Kirim Pengajuan
        </button>
        </div>
    </form>
</div>
@endsection

@push('scripts')
<script>
// Jika URL punya hash #pengurus, buka tab Pengurus saat load
(function(){
    const hash = window.location.hash;
    if (hash === '#pengurus') {
    const trigger = document.querySelector('[data-bs-target="#pengurus"]');
    if (trigger) new bootstrap.Tab(trigger).show();
    }
})();
</script>
@endpush
