<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use Carbon\CarbonPeriod;
use App\Models\Dokumen;
use App\Models\User;
use App\Models\Notifikasi;

class AdminController extends Controller
{
    public function dashboard(Request $r)
    {
        // --- KPI (pakai 2 query saja) ---
        $countPengajuan = Dokumen::count();

        $statusCounts = Dokumen::selectRaw("
            SUM(CASE WHEN status = 'pending'  THEN 1 ELSE 0 END) AS pending,
            SUM(CASE WHEN status = 'approved' THEN 1 ELSE 0 END) AS approved,
            SUM(CASE WHEN status = 'rejected' THEN 1 ELSE 0 END) AS rejected
        ")->first();

        $countPending  = (int) ($statusCounts->pending  ?? 0);
        $countApproved = (int) ($statusCounts->approved ?? 0);
        $countRejected = (int) ($statusCounts->rejected ?? 0);

        $countUsers       = User::count();
        $countNotifUnread = Notifikasi::where('role', 'admin')->where('dibaca', false)->count();

        // --- Grafik: pengajuan per bulan (default 6 bulan; bisa ?range=12) ---
        $months = (int) $r->query('range', 6);
        if ($months < 1 || $months > 24) { $months = 6; }

        $startMonth = now()->startOfMonth()->subMonths($months - 1);
        $endMonth   = now()->endOfMonth();

        // Hitung sekali di DB, lalu isi kekosongan di PHP
        $monthly = Dokumen::selectRaw("DATE_FORMAT(created_at, '%Y-%m-01') AS m, COUNT(*) AS c")
            ->whereBetween('created_at', [$startMonth, $endMonth])
            ->groupBy('m')
            ->pluck('c', 'm'); // ['2025-03-01' => 12, ... ]

        $period = CarbonPeriod::create($startMonth, '1 month', now()->startOfMonth());
        $labels = [];
        $values = [];

        // Set locale ID untuk label bulan (opsional)
        Carbon::setLocale('id');

        foreach ($period as $m) {
            $key = $m->format('Y-m-01');
            // Gunakan translatedFormat agar "Mei", "Agu", dst. (butuh locale ID aktif)
            $labels[] = $m->translatedFormat('M Y');
            $values[] = (int) ($monthly[$key] ?? 0);
        }

        // --- Tabel pengajuan terbaru ---
        $recentPengajuan = Dokumen::with('user')->latest()->paginate(8);

        return view('admin.dashboard', [
            'countPengajuan'   => $countPengajuan,
            'countPending'     => $countPending,
            'countApproved'    => $countApproved,
            'countRejected'    => $countRejected,
            'countUsers'       => $countUsers,
            'countNotifUnread' => $countNotifUnread,
            // chart
            'chartLabels'      => $labels,
            'chartData'        => $values,
            // table
            'recentPengajuan'  => $recentPengajuan,
        ]);
    }
}
