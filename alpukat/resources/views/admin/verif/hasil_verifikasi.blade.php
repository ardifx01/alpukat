@extends('admin.theme.default')

@section('content')

<div class="container mt-5">
    <h2 class="mb-4 fw-bold">Hasil Verifikasi Pengajuan</h2>
    <p>Berikut adalah hasil verifikasi pengajuan surat</p>

    <table class="table table-bordered align-middle">
        <thead class="table-dark">
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
                <tr class="{{ $item->status == 'diterima' ? 'table-success' : 'table-danger' }}">
                    <td>{{ $item->user->name }}</td>
                    <td>
                        <span class="badge rounded-pill bg-{{ $item->status == 'diterima' ? 'success' : 'danger' }} px-3 py-2">
                            {!! $item->status == 'diterima' 
                                ? '<i class="fas fa-check me-1"></i> Diterima' 
                                : '<i class="fas fa-times me-1"></i> Ditolak' !!}
                        </span>
                    </td>
                    <td>{{ \Carbon\Carbon::parse($item->updated_at)->format('d M Y') }}</td>
                    <td class="{{ $item->feedback ? '' : 'text-muted' }}">{{ $item->feedback ?? '-' }}</td>
                    <td class="{{ $item->tanggal_wawancara ? '' : 'text-muted' }}">
                        {{ $item->tanggal_wawancara ? \Carbon\Carbon::parse($item->tanggal_wawancara)->format('d M Y') : '-' }}
                    </td>
                    <td class="{{ $item->lokasi_wawancara ? '' : 'text-muted' }}">{{ $item->lokasi_wawancara ?? '-' }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>

    <!-- Pagination -->
    <div class="mt-3">
        {{ $verifikasi->links() }}
    </div>
</div>

@endsection
