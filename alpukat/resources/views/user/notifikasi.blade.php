@extends('layouts.app')

@section('content')
<div class="container">
    <h2>Notifikasi Anda</h2>

    @if ($notifikasi->isEmpty())
        <p>Tidak ada notifikasi saat ini.</p>
    @else
        <ul class="list-group">
            @foreach ($notifikasi as $item)
                <li class="list-group-item d-flex justify-content-between align-items-center">
                    {{ $item->pesan }}
                    <small class="text-muted">{{ $item->created_at->diffForHumans() }}</small>
                </li>
            @endforeach
        </ul>
    @endif
</div>
@endsection
