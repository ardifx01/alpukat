@extends('admin.dashboard')

@section('tambah_syarat')

    @if(session('syarat_pesan'))
    <div class="mb-4 bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative">
        {{ session('syarat_pesan') }}
    </div>
    @endif
    <div class="container-fluid">
        <form action="{{ route('admin.post_tambah_syarat') }}" method="POST">
            @csrf

            <div class="form-group">
                <label for="nama_syarat">Nama Syarat</label>
                <input type="text" name="nama_syarat" placeholder="Tuliskan nama syarat">
            </div>

            <div class="form-group">
                <label for="kategori_syarat">Kategori Syarat</label>
                <select name="kategori_syarat" required>
                    <option value="">-- Pilih Kategori --</option>
                    <option value="koperasi">Koperasi</option>
                    <option value="pengurus">Pengurus/Pengawas Koperasi</option>
                </select>
            </div>

            <input type="submit" name="submit" value="Tambah Syarat">
        </form>
    </div>
@endsection