@extends('layouts.app')

@section('content')
<div class="container">
    <h2>Notifikasi Anda</h2>

    @if ($notifikasi->isEmpty())
        <p>Tidak ada notifikasi saat ini.</p>
    @else
        <ul class="list-group">
            @foreach ($notifikasi as $item)
                <li class="list-group-item">
                    <div class="d-flex justify-content-between">
                        <span>
                            {{ $item->pesan }}
                        </span>
                        <small class="text-muted">
                            {{ $item->created_at->diffForHumans() }}
                        </small>
                    </div>
                    @if(!empty($item->file_path))
                        <a href="{{ asset('storage/' . $item->file_path) }}" target="_blank" class="btn btn-sm btn-primary mt-2">
                            Lihat File
                        </a>
                    @endif
                </li>
            @endforeach
        </ul>

    @endif
</div>
@endsection
