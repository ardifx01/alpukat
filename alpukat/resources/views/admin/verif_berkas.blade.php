@extends('admin.dashboard')

@section('verif_berkas')
    @if(session('verif_pesan'))
        <div class="alert alert-success">
            {{ session('verif_pesan') }}
        </div>
    @endif

    @if(session('error'))
        <div class="alert alert-danger">
            {{ session('error') }}
        </div>
    @endif

    <div class="container-fluid">
        <h2 class="mb-4">Verifikasi Pengajuan: {{ $users->name }}</h2>
        <form method="POST" action="{{ route('admin.verif_berkas', ['id' => $users->id]) }}">
            @csrf

            <div class="mb-3">
                <label for="status" class="form-label">Status:</label>
                <select name="status" id="status" class="form-select" required onchange="toggleWawancara(this.value)">
                    <option value="">-- Pilih Status --</option>
                    <option value="diterima" {{ $verifikasi?->status == 'diterima' ? 'selected' : '' }}>Diterima</option>
                    <option value="ditolak" {{ $verifikasi?->status == 'ditolak' ? 'selected' : '' }}>Ditolak</option>
                </select>
            </div>

            <div id="wawancara-fields" style="display: none;">
                <div class="mb-3">
                    <label for="tanggal_wawancara" class="form-label">Tanggal Wawancara:</label>
                    <input type="date" name="tanggal_wawancara" class="form-control" value="{{ $verifikasi?->tanggal_wawancara }}">
                </div>

                <div class="mb-3">
                    <label for="lokasi_wawancara" class="form-label">Lokasi Wawancara:</label>
                    <input type="text" name="lokasi_wawancara" class="form-control" value="{{ $verifikasi?->lokasi_wawancara }}">
                </div>
            </div>

            <div class="mb-3">
                <label for="feedback" class="form-label">Feedback:</label>
                <textarea name="feedback" class="form-control" rows="3">{{ $verifikasi?->feedback }}</textarea>
            </div>

            <button type="submit" class="btn btn-success">Simpan Verifikasi</button>
        </form>
    </div>
</div>

<script>
function toggleWawancara(status) {
    const wawancaraFields = document.getElementById('wawancara-fields');
    wawancaraFields.style.display = (status === 'diterima') ? 'block' : 'none';
}

window.onload = function () {
    toggleWawancara(document.querySelector('select[name="status"]').value);
}
</script>
@endsection
