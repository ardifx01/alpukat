<!-- Form tambah berkas -->
@extends('admin.dashboard')

@section('content')
<h1>Tambah Berkas</h1>

<!-- Tampilkan pesan error validasi -->
@if ($errors->any())
    <div class="alert alert-danger">
        <ul>
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif

<form action="{{ route('berkas-admin.store') }}" method="POST" enctype="multipart/form-data">
    @csrf
    <div class="mb-3">
        <label for="nama_berkas" class="form-label">
            Nama Berkas
        </label>
        <input type="text" name="nama_berkas" id="nama_berkas" class="form-control" value="{{ old('nama_berkas') }}" required>
    </div>

    <div class="mb-3">
        <label for="file" class="form-label">File PDF</label>
        <input type="file" name="file" id="file" class="form-control" accept="application/pdf" required>
        <small class="text-muted">Hanya file PDF, ukuran maksimal 5 MB</small>
    </div>

    <button type="submit" class="btn btn-primary">
        Simpan
    </button>
    <a href="{{ route('berkas-admin.index') }}" class="btn btn-secondary">
        Batal
    </a>
</form>
@endsection