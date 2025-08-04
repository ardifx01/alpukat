@extends('admin.dashboard')

@section('lihat_syarat')

@if(session('hapussyarat_pesan'))
    <div style="margin-bottom: 10px; color: black; background-color:orangered;">
        {{session('hapussyarat_pesan')}}
    </div>
@endif
<div class="container mt-5">
    <h2 class="mb-4">Lihat Persyaratan Berkas</h2>

    @if(session('syarat_pesan'))
    <div class="alert alert-success">
        {{ session('syarat_pesan') }}
    </div>
    @endif

    {{-- TAB NAV --}}
    <ul class="nav nav-tabs" id="syaratTab" role="tablist">
        <li class="nav-item">
            <a class="nav-link active" id="koperasi-tab" data-toggle="tab" href="#koperasi" role="tab" aria-controls="koperasi" aria-selected="true">
                📁 Koperasi
            </a>
        </li>
        <li class="nav-item">
            <a class="nav-link" id="pengurus-tab" data-toggle="tab" href="#pengurus" role="tab" aria-controls="pengurus" aria-selected="false">
                🗂️ Pengurus/Pengawas
            </a>
        </li>
    </ul>


    {{-- TAB CONTENT --}}
    <div class="tab-content mt-3" id="syaratTabContent">
        {{-- Tab Koperasi --}}
        <div class="tab-pane fade show active" id="koperasi" role="tabpanel" aria-labelledby="koperasi-tab">
            @if($syarat_koperasi->isEmpty())
            <div class="alert alert-info mt-2">Belum ada persyaratan untuk kategori koperasi.</div>
            @else
            <table class="table table-bordered table-striped mt-2">
                <thead class="table-dark">
                    <tr>
                        <th>No</th>
                        <th>Nama Syarat</th>
                        <th>Tanggal Ditambahkan</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($syarat_koperasi as $index => $syarat)
                    <tr>
                        <td>{{ $index + 1 }}</td>
                        <td>{{ $syarat->nama_syarat }}</td>
                        <td>{{ $syarat->created_at->format('d-m-Y H:i') }}</td>
                        <td>
                            <a href="{{ route('admin.edit_syarat', $syarat->id) }}" style="color: green;">Edit</a>
                            <a href="{{ route('admin.hapus_syarat', $syarat->id) }}" onclick="return confirm('Apakah Anda yakin?')">Hapus</a>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
            @endif
        </div>

        {{-- Tab Pengurus/Pengawas --}}
        <div class="tab-pane fade" id="pengurus" role="tabpanel" aria-labelledby="pengurus-tab">
            @if($syarat_pengurus->isEmpty())
            <div class="alert alert-info mt-2">Belum ada syarat untuk kategori pengurus/pengawas.</div>
            @else
            <table class="table table-bordered table-striped mt-2">
                <thead class="table-dark">
                    <tr>
                        <th>No</th>
                        <th>Nama Syarat</th>
                        <th>Tanggal Ditambahkan</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($syarat_pengurus as $index => $syarat)
                    <tr>
                        <td>{{ $index + 1 }}</td>
                        <td>{{ $syarat->nama_syarat }}</td>
                        <td>{{ $syarat->created_at->format('d-m-Y H:i') }}</td>
                        <td>
                            <a href="{{ route('admin.edit_syarat', $syarat->id) }}" style="color: green;">Edit</a>
                            <a href="{{ route('admin.hapus_syarat', $syarat->id) }}" onclick="return confirm('Apakah Anda yakin?')">Hapus</a>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
            @endif
        </div>
    </div>
</div>
@endsection