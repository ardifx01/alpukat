@extends('admin.dashboard')

<base href="/public">
@section('edit_syarat')

@if(session('editsyarat_pesan'))
<div style="border: 1px solid blue; color:white; border-radius: 4px rounded; padding: 10px; background-color:blue; margin-bottom: 10px;">
    {{ session('editsyarat_pesan') }}
</div>
@endif
<div class="container-fluid">
    <form action="{{ route('admin.posteditsyarat', $syarat->id) }}" method="POST">
        @csrf

        <div class="form-group">
            <label for="nama_syarat">Nama Persyaratan</label>
            <input type="text" name="nama_syarat" value="{{ $syarat->nama_syarat }}" placeholder="Tuliskan nama persyaratan">
        </div>

        <div class="form-group">
            <label for="kategori_syarat">Kategori Persyaratan</label>
            <select name="kategori_syarat" required>
                <option value="">-- Pilih Kategori --</option>
                <option value="koperasi" {{ $syarat->kategori_syarat == 'koperasi' ? 'selected' : '' }}>Koperasi</option>
                <option value="pengurus" {{ $syarat->kategori_syarat == 'pengurus' ? 'selected' : '' }}>Pengurus/Pengawas Koperasi</option>
            </select>
        </div>

        <input type="submit" name="submit" value="Edit Syarat">
    </form>
</div>
@endsection