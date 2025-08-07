@extends('admin.dashboard')

@section('content')
<div class="container">
    <h2 class="mb-4">Daftar Pengajuan Koperasi</h2>

    <table class="table table-bordered">
        <thead>
            <tr>
                <th>Nama Koperasi</th>
                <th>Email</th>
                <th>Nama Syarat</th>
                <th>Kategori</th>
                <th>File</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
            @php
                $grouped = $dokumens->groupBy('user_id');
            @endphp

            @forelse ($grouped as $userId => $dokumens)
                @foreach ($dokumens as $index => $dokumen)
                    <tr>
                        <td>{{ $dokumen->user->name ?? '-' }}</td>
                        <td>{{ $dokumen->user->email ?? '-' }}</td>
                        <td>{{ $dokumen->syarat->nama_syarat ?? '-' }}</td>
                        <td>{{ $dokumen->syarat->kategori_syarat ?? '-' }}</td>
                        <td>
                            <a href="{{ asset('storage/' . $dokumen->file_path) }}" target="_blank">Lihat File</a>
                        </td>

                        @if ($loop->first)
                            <td rowspan="{{ $dokumens->count() }}">
                                <a href="{{ route('admin.verif_berkas', $userId) }}" class="btn btn-sm btn-primary">Verifikasi</a>
                            </td>
                        @endif
                    </tr>
                @endforeach
            @empty
                <tr>
                    <td colspan="7">Belum ada dokumen yang diunggah.</td>
                </tr>
            @endforelse
        </tbody>
    </table>
</div>
@endsection
