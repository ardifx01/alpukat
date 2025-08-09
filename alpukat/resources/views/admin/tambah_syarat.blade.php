@extends('admin.dashboard')

@section('content')
<div class="container mt-5">
    <h2 class="mb-4 fw-bold">Tambah Syarat Dokumen</h2>

    <form action="{{ route('admin.post_tambah_syarat') }}" method="POST">
        @csrf

        <div class="row mb-4">
            <!-- Nama Syarat -->
            <div class="col-md-6 mb-3">
                <label for="nama_syarat" class="form-label fw-semibold">Nama Syarat</label>
                <input
                    type="text"
                    name="nama_syarat"
                    id="nama_syarat"
                    placeholder="Contoh: Surat Permohonan Pengurus Koperasi"
                    class="form-control"
                    required
                >
            </div>

            <!-- Kategori Syarat -->
            <div class="col-md-6 mb-3">
                <label for="kategori_syarat" class="form-label fw-semibold">Kategori Syarat</label>
                <select
                    name="kategori_syarat"
                    id="kategori_syarat"
                    class="form-select"
                    required
                >
                    <option value="">-- Pilih Kategori --</option>
                    <option value="koperasi">Koperasi</option>
                    <option value="pengurus">Pengurus/Pengawas Koperasi</option>
                </select>
            </div>
        </div>

        <!-- Tombol Submit -->
        <div class="text-end">
            <button type="submit" class="btn btn-primary px-4 fw-semibold">
                <i class="bi bi-plus-circle me-1"></i> Tambah Syarat
            </button>
        </div>
    </form>
</div>
@endsection
