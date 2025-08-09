<!-- Form edit berkas -->

@extends('admin.dashboard')

@section('content')
<h1>Edit Berkas</h1>

@if ($errors->any())
<div class="alert alert-danger">
    <ul>
        @foreach ($errors->all() as $error)
        <li>{{ $error }}</li>
        @endforeach
    </ul>
</div>
@endif

<form action="{{ route('berkas-admin.update', $berkas->id) }}" method="POST" enctype="multipart/form-data">
    @csrf
    @method('PUT')

    <div class="mb-3">
        <label for="nama_berkas" class="form-label">
            Nama Berkas
        </label>
        <input type="text" name="nama_berkas" class="form-control" value="{{ old('nama_berkas', $berkas->nama_berkas) }}" required>
    </div>

    <div class="mb-3">
        <label for="file" class="form-label">
            Ganti File (Opsional)
        </label>
        <input type="file" name="file" id="file" class="form-control" accept="application/pdf">
        <small class="text-muted">
            Kosongkan jika tidak ingin mengganti file
        </small>
    </div>

    <p>
        <strong>File saat ini:</strong>
        <a href="{{ asset('storage/berkas_admin/'.$berkas->file) }}" target="_blank">
            Lihat PDF
        </a>
    </p>

    <button type="submit" class="btn-primary">
        Simpan Perubahan
    </button>
    <a href="{{ route('berkas-admin.index') }}" class="btn btn-secondary">Batal</a>
</form>
@endsection