@extends('admin.dashboard')

@section('content')

<div class="container">
    <h2 class="mb-4">Hasil Verifikasi Pengajuan</h2>

    <table class="table table-bordered">
        <thead>
            <tr>
                <th>Nama Koperasi</th>
                <th>Status</th>
                <th>Tanggal Verifikasi</th>
                <th>Feedback Admin</th>
                <th>Tanggal Wawancara</th>
                <th>Lokasi Wawancara</th>
            </tr>
        </thead>
        <tbody>
            @foreach($verifikasi as $item)
                <tr>
                    <td>{{ $item->user->name }}</td>
                    <td>
                        <span class="badge bg-{{ $item->status == 'diterima' ? 'success' : 'danger' }}">
                            {{ ucfirst($item->status) }}
                        </span>
                    </td>
                    <td>{{ \Carbon\Carbon::parse($item->updated_at)->format('d M Y') }}</td>
                    <td>{{ $item->feedback ?? '-' }}</td>
                    <td>{{ $item->tanggal_wawancara ? \Carbon\Carbon::parse($item->tanggal_wawancara)->format('d M Y') : '-' }}</td>
                    <td>{{ $item->lokasi_wawancara ?? '-' }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>

    {{-- Pagination --}}
    <div class="d-flex justify-content-center">
        {{ $verifikasi->links() }}
    </div>
</div>
@endsection