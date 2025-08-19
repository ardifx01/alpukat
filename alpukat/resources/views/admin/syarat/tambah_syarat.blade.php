@extends('admin.dashboard')

@section('content')
<div class="container mt-5">
    <h2 class="mb-4 fw-bold">Tambah Syarat Dokumen</h2>
    <p class="text-muted">Masukkan persyaratan berkas yang perlu pihak koperasi masukkan</p>

    <form action="{{ route('admin.syarat.post_tambah_syarat') }}" method="POST">
        @csrf

        <div class="row mb-4">
            <!-- Nama Syarat -->
            <div class="col-md-6 mb-3">
                <label for="nama_syarat" class="form-label fw-semibold">Nama Syarat</label>
                <input
                    type="text"
                    name="nama_syarat"
                    id="nama_syarat"
                    placeholder="Contoh: Surat Permohonan"
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

            <!-- Checkbox wajib diisi atau tidak -->
            <div class="col-12">
                <div class="form-check">
                    <input 
                        type="checkbox"
                        name="is_required"
                        id="is_required"
                        class="form-check-input"
                        value="1"
                        @checked(old('is_required', true))
                    >
                    <label class="form-check-label" for="is_required">Wajib diisi</label>
                </div>
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
