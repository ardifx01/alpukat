@extends('admin.theme.default')

@section('content')
<div class="container mt-5 mb-5">
    <h1 class="mb-4 fw-bold">Tambah Berkas</h1>
    <p>Masukkan berita acara dan SK UKK di sini</p>

    @if ($errors->any())
        <div class="alert alert-danger">
            <ul class="mb-0">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form id="formTambahBerkas" action="{{ route('admin.berkas-admin.store') }}" method="POST" enctype="multipart/form-data" novalidate>
        @csrf

        {{-- Pilih Koperasi --}}
        <div class="mb-3">
            <label for="verifikasi_id" class="form-label">Pilih Koperasi yang Telah Diwawancarai</label>
            <select name="verifikasi_id" id="verifikasi_id" class="form-select" required>
                <option value="" disabled selected>-- Pilih Koperasi --</option>
                @foreach($verifikasis as $verifikasi)
                    <option 
                        value="{{ $verifikasi->id }}" 
                        data-datetime="{{ optional($verifikasi->tanggal_wawancara) ? \Carbon\Carbon::parse($verifikasi->tanggal_wawancara)->format('Y-m-d\TH:i:sP') : '' }}">
                        {{ $verifikasi->user->name ?? 'User' }}
                    </option>  
                @endforeach 
            </select>
            <div class="invalid-feedback">Harap pilih koperasi yang sudah diwawancara.</div>
        </div>

        {{-- Tanggal Wawancara --}}
        <div class="mb-3">
            <label for="tanggal_wawancara" class="form-label">Tanggal Wawancara</label>
            <input type="text" id="tanggal_wawancara" class="form-control" readonly>
            <div class="form-text" id="batasInfo"></div>
        </div>

        {{-- Jenis Surat --}}
        <div class="mb-3">
            <label for="jenis_surat" class="form-label">Jenis Surat</label>
            <select name="jenis_surat" id="jenis_surat" class="form-select" required>
                <option value="" disabled selected>-- Pilih Jenis Surat --</option>
                <option value="berita_acara" {{ old('jenis_surat') == 'berita_acara' ? 'selected' : '' }}>Berita Acara</option>
                <option value="sk_ukk" {{ old('jenis_surat') == 'sk_ukk' ? 'selected' : '' }}>SK UKK</option>
            </select>
            <div class="invalid-feedback">Jenis surat wajib dipilih.</div>
        </div>

        {{-- Upload File --}}
        <div class="mb-3">
            <label for="file" class="form-label">File PDF</label>
            <input type="file" name="file" id="file" class="form-control" accept="application/pdf" required>
            <small class="text-muted">Hanya file PDF, ukuran maksimal 5 MB</small>
            <div class="invalid-feedback" id="fileError">Mohon pilih file PDF yang ukurannya maksimal 5 MB.</div>
        </div>

        <div class="d-flex gap-2">
            <button type="submit" class="btn btn-primary">Simpan</button>
            <a href="{{ route('admin.berkas-admin.index') }}" class="btn btn-secondary">Batal</a>
        </div>
    </form>

    <div id="cfg"
        data-days="{{ (int) config('app.batas_unggah_wawancara_days', 30) }}"
        data-seconds="{{ config('app.batas_unggah_wawancara_seconds') }}">
    </div>

    {{-- Script --}}
    <script>
        // Validasi file & form
        (function () {
            'use strict';

            const form = document.getElementById('formTambahBerkas');
            const selectVerifikasi = document.getElementById('verifikasi_id');
            const fileInput = document.getElementById('file');
            const maxSize = 5 * 1024 * 1024; // 5 MB
            const batasInfo = document.getElementById('batasInfo');

            const cfgEl = document.getElementById('cfg');
            const DAYS = Number(cfgEl.dataset.days) || 30;

            const rawSeconds = cfgEl.getAttribute('data-seconds'); // null kalau atribut tidak ada
            const DEMO_SECONDS = (rawSeconds !== null && rawSeconds !== '')
            ? Number(rawSeconds)
            : null;

            const isDemo = Number.isFinite(DEMO_SECONDS);

            function addBusinessDays(start, days) {
                const d = new Date(date.getTime());
                let added = 0;
                while (added < days) {
                    d.setDate(d.getDate() + 1);
                    const day = d.getDay(); // 0=Min,6=Sab
                    if (day !== 0 && day !== 6) added++;
                    }
                return d;
            }

            function formatID(d) {
                return d.toLocaleString('id-ID', { timeZone: 'Asia/Jakarta', day: '2-digit', month: 'long', year: 'numeric', hour: '2-digit', minute: '2-digit' });
            }

            let deadline = null;

            selectVerifikasi.addEventListener('change', function () {
                const opt = this.options[this.selectedIndex];

                const iso = opt?.getAttribute('data-datetime') || '';
                if (!iso) {
                    document.getElementById('tanggal_wawancara').value = tanggal;
                    batasInfo.textContent = '';
                    deadline = null;
                    return;
                }

                const start = new Date(iso);
    
                // tampilkan datetime ke input readonly (supaya admin bisa melihat jamnya)
                document.getElementById('tanggal_wawancara').value = formatID(start) + ' WIB';

                // Hitung tenggat: demo = detik dari jam wawancara; hari = 30 hari kerja dari jam wawancara
                deadline = isDemo
                    ? new Date(start.getTime() + DEMO_SECONDS * 1000)
                    : addBusinessDays(start, DAYS);

                // batas tidak di set ke 23:59 karena mengikuti jam wawancara
                batasInfo.textContent = `Batas unggah (${isDemo ? `demo ${DEMO_SECONDS} detik` : `${DAYS} hari kerja`}): ${formatID(deadline)} WIB`;
            });

            form.addEventListener('submit', function (event) {
                fileInput.classList.remove('is-invalid');

                // Validasi file
                if (fileInput.files.length > 0) {
                    const file = fileInput.files[0];
                    if (file.type !== 'application/pdf' || file.size > maxSize) {
                        fileInput.classList.add('is-invalid');
                        event.preventDefault();
                        event.stopPropagation();
                        return;
                    }
                }

                // blokir submit jika sudah lewat deadline (client-side helper)
                if (deadline && new Date() > deadline) {
                alert('Batas waktu unggah sudah lewat.');
                event.preventDefault(); event.stopPropagation();
                return;
                }

                if (!form.checkValidity()) {
                    event.preventDefault();
                    event.stopPropagation();
                }

                form.classList.add('was-validated');
            }, false);

            // kalau sudah ada pilihan (old value), hitung ulang saat load
            if (selectVerifikasi.value) {
                selectVerifikasi.dispatchEvent(new Event('change'));
            }
        })();
    </script>
</div>
@endsection