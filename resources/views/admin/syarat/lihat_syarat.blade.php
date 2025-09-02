@extends('admin.theme.default')

@section('content')

<div class="container mt-5">
    <h2 class="mb-4 fw-bold">Lihat Persyaratan Berkas</h2>
    <p class="text-muted">Lihat Persyaratan Berkas yang Telah Anda Masukkan</p>

    <a href="{{ route('admin.syarat.tambah_syarat') }}" class="btn btn-primary mb-4">Tambah Syarat</a>

    {{-- TAB NAV --}}
    <ul class="nav nav-tabs" id="syaratTab" role="tablist">
        <li class="nav-item">
            <a class="nav-link active" id="koperasi-tab" data-bs-toggle="tab" href="#koperasi" role="tab" aria-controls="koperasi" aria-selected="true">
                📁 Koperasi
            </a>
        </li>
        <li class="nav-item">
            <a class="nav-link" id="pengurus-tab" data-bs-toggle="tab" href="#pengurus" role="tab" aria-controls="pengurus" aria-selected="false">
                🗂️ Pengurus Koperasi
            </a>
        </li>
        <li class="nav-item">
            <a class="nav-link" id="pengawas-tab" data-bs-toggle="tab" href="#pengawas" role="tab" aria-controls="pengawas" aria-selected="false">
                📂 Pengawas Koperasi
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
                        <th>Waktu Ditambahkan</th>
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
                            <a href="{{ route('admin.syarat.edit_syarat', $syarat->id) }}" style="color: green;">Edit</a>
                            <a href="{{ route('admin.syarat.hapus_syarat', $syarat->id) }}" onclick="return confirm('Apakah Anda yakin?')">Hapus</a>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
            @endif
        </div>

        {{-- Tab Pengurus --}}
        <div class="tab-pane fade" id="pengurus" role="tabpanel" aria-labelledby="pengurus-tab">
            @if($syarat_pengurus->isEmpty())
            <div class="alert alert-info mt-2">Belum ada syarat untuk kategori pengurus.</div>
            @else
            <table class="table table-bordered table-striped mt-2">
                <thead class="table-dark">
                    <tr>
                        <th>No</th>
                        <th>Nama Syarat</th>
                        <th>Waktu Ditambahkan</th>
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
                            <a href="{{ route('admin.syarat.edit_syarat', $syarat->id) }}" style="color: green;">Edit</a>
                            <a href="{{ route('admin.syarat.hapus_syarat', $syarat->id) }}" onclick="return confirm('Apakah Anda yakin?')">Hapus</a>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
            @endif
        </div>

        {{-- Tab Pengawas --}}
        <div class="tab-pane fade" id="pengawas" role="tabpanel" aria-labelledby="pengawas-tab">
            @if($syarat_pengawas->isEmpty())
            <div class="alert alert-info mt-2">Belum ada syarat untuk kategori pengawas.</div>
            @else
            <table class="table table-bordered table-striped mt-2">
                <thead class="table-dark">
                    <tr>
                        <th>No</th>
                        <th>Nama Syarat</th>
                        <th>Waktu Ditambahkan</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($syarat_pengawas as $index => $syarat)
                    <tr>
                        <td>{{ $index + 1 }}</td>
                        <td>{{ $syarat->nama_syarat }}</td>
                        <td>{{ $syarat->created_at->format('d-m-Y H:i') }}</td>
                        <td>
                            <a href="{{ route('admin.syarat.edit_syarat', $syarat->id) }}" style="color: green;">Edit</a>
                            <a href="{{ route('admin.syarat.hapus_syarat', $syarat->id) }}" onclick="return confirm('Apakah Anda yakin?')">Hapus</a>
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