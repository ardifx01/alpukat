<!-- Detail berkas -->

@extends('admin.dashboard')

@section('content')
<h1>Detail Berkas</h1>

<div class="card">
    <div class="card-body">
        <h5 class="card-title">
            {{ $berkas->nama_berkas }}
        </h5>

        <!-- Tampilkan relasi user dan verifikasi jika ada -->
        @if($berkas->user)
            <p>
                <strong>Diunggah oleh:</strong> {{ $berkas->user->name }}
            </p>
        @endif

        @if($berkas->verifikasi)
            <p>
                <strong>Status Verifikasi:</strong> {{ $berkas->verifikasi->status }}
            </p>
        @endif

        <p>
            <strong>
                File:
            </strong>
            <a href="{{ asset('storage/berkas_admin/'.$berkas->file) }}" target="_blank">Lihat PDF</a>
        </p>

        <a href="{{ route('berkas-admin.download', $berkas->id) }}" class="btn btn-success">Download</a>
        <a href="{{ route('berkas-admin.index') }}" class="btn btn-secondary">Kembali</a>
    </div>
</div>
@endsection