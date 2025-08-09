@extends('admin.dashboard')

@section('content')
<div class="container mt-5 mb-5">
    <h1 class="mb-4 fw-bold">Tambah Berkas</h1>
    <p>Masukkan berita acara dan SK UKK di sini</p>

    <!-- Tampilkan pesan error validasi -->
    @if ($errors->any())
        <div class="alert alert-danger">
            <ul class="mb-0">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form id="formTambahBerkas" action="{{ route('berkas-admin.store') }}" method="POST" enctype="multipart/form-data" novalidate>
        @csrf

        <!-- Pilih Koperasi yang telah diwawancarai -->
        <div class="mb-3">
            <label for="verifikasi_id" class="form-label">Pilih Koperasi yang Telah Diwawancarai</label>
            <select name="verifikasi_id" id="verifikasi_id" class="form-select" required>
                <option value="" disabled selected>-- Pilih Koperasi yang Telah Diwawancarai --</option>
                @foreach($verifikasis as $verifikasi)
                    <option value="{{ $verifikasi->id }}" {{ old('verifikasi_id') == $verifikasi->id ? 'selected' : '' }}>
                        {{ optional($verifikasi->tanggal_wawancara)->format('d-m-Y') ?? '-' }} - {{ $verifikasi->user->name ?? 'User' }}
                    </option>  
                @endforeach 
            </select>
            <div class="invalid-feedback">Harap pilih koperasi yang sudah diwawancara.</div>
        </div>

        <!-- Jenis Surat -->
        <div class="mb-3">
            <label for="jenis_surat" class="form-label">Jenis Surat</label>
            <select name="jenis_surat" id="jenis_surat" class="form-select" required>
                <option value="" disabled selected>-- Pilih Jenis Surat --</option>
                <option value="berita_acara" {{ old('jenis_surat') == 'berita_acara' ? 'selected' : '' }}>Berita Acara</option>
                <option value="sk_ukk" {{ old('jenis_surat') == 'sk_ukk' ? 'selected' : '' }}>SK UKK</option>
            </select>
            <div class="invalid-feedback">Jenis surat wajib dipilih.</div>
        </div>

        <!-- Upload File -->
        <div class="mb-3">
            <label for="file" class="form-label">File PDF</label>
            <input type="file" name="file" id="file" class="form-control" accept="application/pdf" required>
            <small class="text-muted">Hanya file PDF, ukuran maksimal 5 MB</small>
            <div class="invalid-feedback" id="fileError">Mohon pilih file PDF yang ukurannya maksimal 5 MB.</div>
        </div>

        <div class="d-flex gap-2">
            <button type="submit" class="btn btn-primary">Simpan</button>
            <a href="{{ route('berkas-admin.index') }}" class="btn btn-secondary">Batal</a>
        </div>
    </form>

    <script>
        (function () {
            'use strict';

            const form = document.getElementById('formTambahBerkas');
            const fileInput = document.getElementById('file');
            const maxSize = 5 * 1024 * 1024; // 5 MB

            form.addEventListener('submit', function (event) {
                // Reset custom validation
                fileInput.classList.remove('is-invalid');

                // Cek file dulu
                if (fileInput.files.length === 0) {
                    // Jika tidak ada file, biarkan validasi HTML berjalan (required)
                } else {
                    // Cek ekstensi (hanya pdf)
                    const file = fileInput.files[0];
                    const validTypes = ['application/pdf'];
                    if (!validTypes.includes(file.type)) {
                        fileInput.classList.add('is-invalid');
                        event.preventDefault();
                        event.stopPropagation();
                        return;
                    }
                    // Cek ukuran
                    if (file.size > maxSize) {
                        fileInput.classList.add('is-invalid');
                        event.preventDefault();
                        event.stopPropagation();
                        return;
                    }
                }

                if (!form.checkValidity()) {
                    event.preventDefault();
                    event.stopPropagation();
                }

                form.classList.add('was-validated');
            }, false);
        })();
    </script>
</div>
@endsection
