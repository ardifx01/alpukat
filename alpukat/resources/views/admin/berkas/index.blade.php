<!-- List semua berkas -->

@extends('admin.dashboard')

@section('content')
<h1>Daftar Berkas</h1>

<a href="{{ route('berkas-admin.create') }}" class="btn btn-primary">Tambah Berkas</a>

<table class="table table-bordered">
    <thead>
        <tr>
            <th>Nama Berkas</th>
            <th>File</th>
            <th>Aksi</th>
        </tr>
    </thead>
    <tbody>
        @foreach($data as $berkas)
        <tr>
            <td>{{ $berkas->nama_berkas }}</td>
            <td>
                <a href="{{ asset('storage/berkas_Admin/'.$berkas->file) }}" target="_blank">Lihat</a></td>
            <td>
                <a href="{{ route('berkas-admin.show', $berkas->id) }}" class="btn btn-info btn-sm">Detail</a>
                <a href="{{ route('berkas-admin.edit', $berkas->id) }}" class="btn btn-warning btn-sm">Edit</a>
                <a href="{{ route('berkas-admin.download', $berkas->id) }}" class="btn btn-success btn-sm">Download</a>
                <form action="{{ route('berkas-admin.destroy', $berkas->id) }}" method="POST" style="display:inline-block;" onsubmit="return confirm('akin ingin menghapus berkas ini?');">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-danger btn-sm">Hapus</button>
                </form>
            </td>
        </tr>
        @endforeach
    </tbody>
</table>
@endsection