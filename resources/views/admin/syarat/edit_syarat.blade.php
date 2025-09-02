@extends('admin.theme.default')

@section('content')
<div class="container mt-5">
    <h2 class="mb-4 fw-bold">Edit Syarat Dokumen</h2>
    <p class="text-muted">Edit Persyaratan Dokumen yang Harus Dimasukkan oleh Koperasi</p>

    <form action="{{ route('admin.syarat.post_edit_syarat', $syarat->id) }}" method="POST">
        @csrf

        {{-- Nama Persyaratan --}}
        <div class="mb-3">
            <label for="nama_syarat" class="form-label">Nama Syarat</label>
            <input 
                type="text" 
                name="nama_syarat" 
                id="nama_syarat"
                value="{{ $syarat->nama_syarat }}" 
                placeholder="Tuliskan nama persyaratan"
                class="form-control"
                required
            >
        </div>

        {{-- Kategori Persyaratan --}}
        <div class="mb-3">
            <label for="kategori_syarat" class="form-label">Kategori Syarat</label>
            <select 
                name="kategori_syarat" 
                id="kategori_syarat"
                class="form-select"
                required
            >
                <option value="">-- Pilih Kategori --</option>
                <option value="koperasi" {{ $syarat->kategori_syarat == 'koperasi' ? 'selected' : '' }}>Koperasi</option>
                <option value="pengurus" {{ $syarat->kategori_syarat == 'pengurus' ? 'selected' : '' }}>Pengurus Koperasi</option>
                <option value="pengawas" {{ $syarat->kategori_syarat == 'pengawas' ? 'selected' : '' }}>Pengawas Koperasi</option>
            </select>
        </div>

        {{-- Wajib diisi atau tidak --}}
        <div class="form-check mb-4">
            <input 
                type="checkbox"
                name="is_required"
                id="is_required"
                class="form-check-input"
                value="1"
                @checked(old('is_required', (bool) $syarat->is_required))
            >
            <label class="form-check-label" for="is_required">Wajib diisi</label>
        </div>

        {{-- Tombol Submit --}}
        <div class="text-end">
            <button type="submit" class="btn btn-primary">
                Edit Syarat
            </button>
        </div>
    </form>
</div>
@endsection
