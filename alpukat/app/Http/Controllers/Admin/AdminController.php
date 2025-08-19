<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Dokumen;
use App\Models\BerkasAdmin;
use App\Models\User;
use App\Models\Verifikasi;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;

class AdminController extends Controller
{
    public function dashboard(Request $request)
    {
        // Menghitung jumlah user yang sudah mengirimkan dokumen
        $hitungPengajuan = Dokumen::distinct('user_id')->count('user_id');

        // Menghitung jumlah berita acara yang diunggah
        $hitungBeritaAcara = BerkasAdmin::where('jenis_surat', 'berita_acara')->count();

        // Menghitung jumlah SK UKK yang diunggah
        $hitungSkUkk = BerkasAdmin::where('jenis_surat', 'sk_ukk')->count();

        // Menghitung status verifikasi diterima dan ditolak
        $statusCounts = Verifikasi::selectRaw("
            SUM(CASE WHEN status = 'diterima' THEN 1 ELSE 0 END) AS diterima,
            SUM(CASE WHEN status = 'ditolak' THEN 1 ELSE 0 END) AS ditolak
        ")->first();

        // Mengambil hasil
        $hitungDiterima = (int) ($statusCounts->diterima ?? 0);
        $hitungDitolak = (int) ($statusCounts->ditolak ?? 0);

        // Mengirimkan hasil ke view
        return view('admin.dashboard', [
            'countPengajuan' => $hitungPengajuan,
            'countApproved' => $hitungDiterima,
            'countRejected' => $hitungDitolak,
            'countBeritaAcara' => $hitungBeritaAcara,
            'countSkUkk' => $hitungSkUkk,
        ]);
    }

}
