@extends('admin.dashboard')

@section('content')
<div class="container mt-5">
    <h2 class="mb-4 fw-bold">Edit Syarat Dokumen</h2>
    <p>Edit Persyaratan Dokumen yang Harus Dimasukkan oleh Koperasi</p>

    <form action="{{ route('admin.post_edit_syarat', $syarat->id) }}" method="POST">
        @csrf

        {{-- Nama Persyaratan --}}
        <div class="mb-3">
            <label for="nama_syarat" class="form-label">Nama Persyaratan</label>
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
            <label for="kategori_syarat" class="form-label">Kategori Persyaratan</label>
            <select 
                name="kategori_syarat" 
                id="kategori_syarat"
                class="form-select"
                required
            >
                <option value="">-- Pilih Kategori --</option>
                <option value="koperasi" {{ $syarat->kategori_syarat == 'koperasi' ? 'selected' : '' }}>Koperasi</option>
                <option value="pengurus" {{ $syarat->kategori_syarat == 'pengurus' ? 'selected' : '' }}>Pengurus/Pengawas Koperasi</option>
            </select>
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
