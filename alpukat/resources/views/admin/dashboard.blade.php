@extends('admin.theme.default')

@section('title', 'Dashboard Admin | ALPUKAT')

@section('content')
<div class="container py-4">
  {{-- Header & Quick Actions --}}
  <div class="d-flex flex-column flex-md-row align-items-md-center justify-content-between gap-2 mb-3">
    <h1 class="h4 fw-bold mb-0">Halaman Admin</h1>
  </div>
  <p class="text-muted mb-4">Selamat datang di dashboard admin! Ringkasan kondisi terbaru sistem ALPUKAT.</p>

  {{-- KPI Cards --}}
  @php
    $countPengajuan   = $countPengajuan   ?? 0;
    $countPending     = $countPending     ?? 0;
    $countApproved    = $countApproved    ?? 0;
    $countRejected    = $countRejected    ?? 0;
  @endphp

  <div class="row g-3 mb-4">
    <div class="col-6 col-md-3">
      <div class="card shadow-sm border-0 h-100">
        <div class="card-body">
          <div class="small text-muted">Total Pengajuan</div>
          <div class="display-6 fw-bold">{{ $countPengajuan }}</div>
        </div>
      </div>
    </div>
    <div class="col-6 col-md-3">
      <div class="card shadow-sm border-0 h-100">
        <div class="card-body">
          <div class="small text-muted">Menunggu Verifikasi</div>
          <div class="display-6 fw-bold text-warning">{{ $countPending }}</div>
        </div>
      </div>
    </div>
    <div class="col-6 col-md-3">
      <div class="card shadow-sm border-0 h-100">
        <div class="card-body">
          <div class="small text-muted">Disetujui</div>
          <div class="display-6 fw-bold text-success">{{ $countApproved }}</div>
        </div>
      </div>
    </div>
    <div class="col-6 col-md-3">
      <div class="card shadow-sm border-0 h-100">
        <div class="card-body">
          <div class="small text-muted">Ditolak</div>
          <div class="display-6 fw-bold text-danger">{{ $countRejected }}</div>
        </div>
      </div>
    </div>
  </div>

  <div class="row g-3">
    {{-- Grafik (opsional) --}}
    <div class="col-lg-6">
      <div class="card shadow-sm border-0 h-100">
        <div class="card-header bg-white border-0">
          <div class="d-flex align-items-center justify-content-between">
            <h2 class="h6 mb-0">Pengajuan per Bulan</h2>
            <div class="dropdown">
              <button class="btn btn-sm btn-outline-secondary dropdown-toggle" data-bs-toggle="dropdown">Periode</button>
              <ul class="dropdown-menu dropdown-menu-end">
                <li><a class="dropdown-item" href="?range=6">6 Bulan</a></li>
                <li><a class="dropdown-item" href="?range=12">12 Bulan</a></li>
              </ul>
            </div>
          </div>
        </div>
        <div class="card-body">
          <canvas id="chartPengajuan" height="160"></canvas>
          <small class="text-muted d-block mt-2">* Grafik ini opsional. Hapus section ini jika tidak diperlukan.</small>
        </div>
      </div>
    </div>

    {{-- Tabel Pengajuan Terbaru --}}
    <div class="col-lg-6">
      <div class="card shadow-sm border-0 h-100">
        <div class="card-header bg-white border-0 d-flex align-items-center justify-content-between">
          <h2 class="h6 mb-0">Pengajuan Terbaru</h2>
          <form method="GET" @if(Route::has('admin.pengajuan.index')) action="{{ route('admin.pengajuan.index') }}" @endif class="d-none d-md-block">
            <div class="input-group input-group-sm" style="width: 220px;">
              <input type="text" name="q" class="form-control" placeholder="Cari pemohon/ID" value="{{ request('q') }}">
              <button class="btn btn-outline-secondary">Cari</button>
            </div>
          </form>
        </div>
        <div class="card-body p-0">
          <div class="table-responsive">
            <table class="table table-hover align-middle mb-0">
              <thead class="table-light">
                <tr>
                  <th style="width:56px;">No</th>
                  <th>Pemohon</th>
                  <th>Status</th>
                  <th style="width:160px;">Dibuat</th>
                  <th style="width:150px;">Aksi</th>
                </tr>
              </thead>
              <tbody>
                @forelse (($recentPengajuan ?? []) as $p)
                  <tr>
                    <td>{{ $loop->iteration }}</td>
                    <td>
                      <div class="fw-semibold">{{ $p->user->name ?? '—' }}</div>
                      <small class="text-muted">ID: {{ $p->id ?? '—' }}</small>
                    </td>
                    <td>
                      @php $status = $p->status ?? 'pending'; @endphp
                      @if($status === 'approved')
                        <span class="badge text-bg-success">Disetujui</span>
                      @elseif($status === 'rejected')
                        <span class="badge text-bg-danger">Ditolak</span>
                      @else
                        <span class="badge text-bg-warning text-dark">Menunggu</span>
                      @endif
                    </td>
                    <td>{{ optional($p->created_at)->format('d M Y, H:i') }}</td>
                    <td>
                      <div class="btn-group btn-group-sm" role="group">
                        @if (Route::has('admin.pengajuan.show'))
                          <a href="{{ route('admin.pengajuan.show', $p->id) }}" class="btn btn-outline-primary">Lihat</a>
                        @else
                          <a href="#" class="btn btn-outline-primary">Lihat</a>
                        @endif
                        @if (Route::has('admin.pengajuan.review'))
                          <a href="{{ route('admin.pengajuan.review', $p->id) }}" class="btn btn-outline-secondary">Review</a>
                        @endif
                      </div>
                    </td>
                  </tr>
                @empty
                  <tr>
                    <td colspan="5" class="text-center text-muted p-4">Belum ada pengajuan.</td>
                  </tr>
                @endforelse
              </tbody>
            </table>
          </div>
        </div>
        @if(isset($recentPengajuan) && method_exists($recentPengajuan, 'links'))
          <div class="card-footer bg-white border-0">
            {{ $recentPengajuan->links() }}
          </div>
        @endif
      </div>
    </div>
  </div>
</div>
@endsection

@push('scripts')
  {{-- Chart.js (opsional). Hapus jika tidak dipakai. --}}
  <script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.1/dist/chart.umd.min.js"></script>
  <script>
    (function(){
      var ctx = document.getElementById('chartPengajuan');
      if (!ctx || typeof Chart === 'undefined') return;
      var labels = {!! json_encode($chartLabels ?? []) !!};
      var data   = {!! json_encode($chartData ?? []) !!};
      // Fallback sederhana jika backend belum kirim data
      if (!labels.length) { labels = ['Jan','Feb','Mar','Apr','Mei','Jun']; data = [0,0,0,0,0,0]; }

      new Chart(ctx, {
        type: 'line',
        data: {
          labels: labels,
          datasets: [{
            label: 'Jumlah Pengajuan',
            data: data,
            tension: 0.35,
            fill: false,
            borderWidth: 2,
          }]
        },
        options: {
          responsive: true,
          maintainAspectRatio: false,
          plugins: { legend: { display: false } },
          scales: { y: { beginAtZero: true } }
        }
      });
    })();
  </script>
@endpush
