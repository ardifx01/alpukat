@extends('admin.theme.default')

@section('title', 'Notifikasi Admin')

@section('content')
<div class="container py-4">
    <div class="d-flex align-items-center justify-content-between mb-3">
        <h2 class="mb-2 fw-bold">Notifikasi</h2>
    </div>

    @if ($notif->isEmpty())
        <p>Tidak ada notifikasi saat ini.</p>
    @else
        <ul class="list-group">
            @foreach ($notif as $item)
                <li class="list-group-item">
                    <div class="d-flex justify-content-between">
                        <span>{{ $item->pesan }}</span>
                        <small class="text-muted">{{ $item->created_at->diffForHumans() }}</small>
                    </div>

                    @if(!empty($item->file_path))
                        <a href="{{ asset('storage/' . $item->file_path) }}" target="_blank"
                           class="btn btn-sm btn-primary mt-2">
                            Lihat File
                        </a>
                    @endif
                </li>
            @endforeach
        </ul>
    @endif
</div>
@endsection
