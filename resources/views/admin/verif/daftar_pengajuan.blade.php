@extends('admin.theme.default')

@section('content')
<div class="container mt-5">
    <h2 class="mb-4 fw-bold">Daftar Pengajuan Koperasi</h2>
    <p>Berikut adalah daftar berkas yang telah masuk</p>

    <div class="table-responsive">
        <table class="table table-bordered align-middle mb-0">
            <thead class="table-dark">
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
                @forelse ($users as $user)
                @foreach ($user->dokumens as $index => $dokumen)
                <tr>
                    @if ($loop->first)
                    {{-- Nama dan email hanya di baris pertama untuk user ini --}}
                    <td rowspan="{{ $user->dokumens->count() }}">
                        {{ $user->name ?? '-'}}
                    </td>
                    <td rowspan="{{ $user->dokumens->count() }}">
                        {{ $user->email ?? '-'}}
                    </td>
                    @endif
                    <td>
                        {{ $dokumen->syarat->nama_syarat ?? '-'}}
                    </td>
                    <td>
                        {{ $dokumen->syarat->kategori_syarat ?? '-'}}
                    </td>
                    <td>
                        <a href="{{ asset('storage/' . $dokumen->file_path) }}" target="_blank">
                            Lihat File
                        </a>
                    </td>

                    @if ($loop->first)
                    <td rowspan="{{ $user->dokumens->count() }}">
                        <a href="{{ route('admin.verif.verif_berkas', $user->id) }}" class="btn btn-sm btn-primary">Verifikasi</a>
                    </td>
                    @endif
                </tr>
                @endforeach
                @empty
                <tr>
                    <td colspan="6" class="text-center">
                        Belum ada dokumen yang diunggah.
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    {{-- Pagination --}}
    <div class="mt-3">
        {{ $users->links() }}
    </div>
</div>
@endsection