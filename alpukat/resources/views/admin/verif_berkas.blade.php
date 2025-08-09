@extends('admin.dashboard')

@section('content')
<div class="container mt-5 mb-5">
    <h2 class="mb-4 fw-bold">Verifikasi Pengajuan: {{ $users->name }}</h2>
    <p>Periksa dokumen yang telah diunggah oleh {{ $users->name }}</p>
    
    <form method="POST" action="{{ route('admin.verif_berkas', ['id' => $users->id]) }}">
        @csrf

        <div class="mb-3">
            <label for="status" class="form-label">Status:</label>
            <select name="status" id="status" class="form-select" required onchange="toggleWawancara(this.value)">
                <option value="">-- Pilih Status --</option>
                <option value="diterima" {{ $verifikasi?->status === 'diterima' ? 'selected' : '' }}>Diterima</option>
                <option value="ditolak" {{ $verifikasi?->status === 'ditolak' ? 'selected' : '' }}>Ditolak</option>
            </select>
        </div>

        @if ($verifikasi && $verifikasi->status === 'diterima' && $verifikasi->batas_wawancara)
            <div class="alert alert-info">
                <strong>Batas maksimal wawancara:</strong>
                {{ \Carbon\Carbon::parse($verifikasi->batas_wawancara)->translatedFormat('d F Y') }}
            </div>  
        @endif

        <div id="wawancara-fields" style="display: none;">
            <div class="mb-3">
                <label for="tanggal_wawancara" class="form-label">Tanggal Wawancara:</label>
                <input 
                    type="date" 
                    name="tanggal_wawancara" 
                    class="form-control" 
                    value="{{ old('tanggal_wawancara', $verifikasi?->tanggal_wawancara) }}" 
                    max="{{ $verifikasi?->batas_wawancara }}"
                >
                <small class="text-muted">
                    Batas maksimal wawancara: <strong>{{ $batasMax }}</strong>
                </small>
            </div>

            <div class="mb-3">
                <label for="lokasi_wawancara" class="form-label">Lokasi Wawancara:</label>
                <input 
                    type="text" 
                    name="lokasi_wawancara" 
                    class="form-control" 
                    value="{{ old('lokasi_wawancara', $verifikasi?->lokasi_wawancara) }}"
                >
            </div>
        </div>

        <div class="mb-3">
            <label for="feedback" class="form-label">Feedback:</label>
            <textarea name="feedback" class="form-control" rows="3">{{ old('feedback', $verifikasi?->feedback) }}</textarea>
        </div>

        <button type="submit" class="btn btn-success">Simpan Verifikasi</button>
    </form>
</div>

<script>
    function toggleWawancara(status) {
        const wawancaraFields = document.getElementById('wawancara-fields');
        wawancaraFields.style.display = (status === 'diterima') ? 'block' : 'none';
    }

    window.addEventListener('DOMContentLoaded', () => {
        toggleWawancara(document.getElementById('status').value);
    });
</script>
@endsection
