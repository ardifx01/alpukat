<?php

namespace App\Http\Controllers;

use App\Models\BerkasAdmin;
use App\Models\User;
use App\Models\Verifikasi;
use Carbon\Carbon;
use Carbon\CarbonPeriod;

use Illuminate\Http\Request;

class BerkasAdminController extends Controller
{
    // Menampilkan semua data berkas admin
    public function index()
    {
        $data = BerkasAdmin::with(['verifikasi.user'])->paginate(3);

        return view('admin.berkas.index', compact('data'));
    }

    // Menampilkan form tambah berkas
    public function create()
    {
        // Ambil user yang telah diverifikasi
        $users = User::whereHas('verifikasi', function($query) {
            $query->whereNotNull('tanggal_wawancara');
        })->get();

        // Ambil data verifikasi dengan tanggal wawancara supaya dropdown verifikasi valid
        $verifikasis = Verifikasi::whereNotNull('tanggal_wawancara')->with('user')->get();

        return view('admin.berkas.create', compact('users', 'verifikasis'));
    }

    // Menyimpan berkas baru ke database
    public function store(Request $request)
    {
        $request->validate([
            'verifikasi_id' => 'required|exists:verifikasis,id',
            'jenis_surat' => 'required|in:berita_acara,sk_ukk',
            'file' => 'required|mimes:pdf|max:5120', 
            // Ukuran file nya maksimal 5 MB dulu supaya uploadnya cepat dan servernya tidak cepat penuh
        ]);

        $verifikasi = Verifikasi::findOrFail($request->verifikasi_id);

        if (!$verifikasi->tanggal_wawancara) {
            return back()->withErrors(['file' => 'Tanggal wawancara tidak ditemukan.']);
        }

        // Cek batas waktu 30 hari kerja (kecuali Sabtu dan Minggu)
        $tanggalWawancara = Carbon::parse($verifikasi->tanggal_wawancara);

        // Fungsi hitung 30 hari kerja setelah tanggal wawancara
        $batasWawancara = $this->addBusinessDays($tanggalWawancara, 30);

        if (Carbon::now()->greaterThan($batasWawancara)) {
            return back()->withErrors(['file' => 'Batas waktu upload sudah lewat 30 hari kerja setelah wawancara']);
        }

        // Kalau lolos validasi, simpan berkas
        $fileName = time() . '.' . $request->file->extension();
        $request->file->storeAs('berkas_admin', $fileName, 'public');

        BerkasAdmin::create([
            'verifikasi_id' => $request->verifikasi_id,
            'user_id' => $verifikasi->user_id, // ambil dari verifikasi
            'jenis_surat' => $request->jenis_surat,
            'file_path' => $fileName,
        ]);

        return redirect()->route('berkas-admin.index')->with('success', 'Berkas berhasil ditambahkan');
    }

    // Fungsi untuk menambahkan hari kerja 
    private function addBusinessDays(Carbon $date, int $days)
    {
        $addedDays = 0;
        $resultDate = $date->copy();

        while ($addedDays < $days) {
            $resultDate->addDay();

            // Cek kalau bukan Sabtu atau Minggu
            if(!in_array($resultDate->dayOfWeek, [Carbon::SATURDAY, Carbon::SUNDAY])) {
                $addedDays++;
            }
        }

        return $resultDate;
    }


    public function download($id)
    {
        $berkas = BerkasAdmin::findOrFail($id);
        $path = storage_path('app/public/berkas_admin/' . $berkas->file_path);

        if (!file_exists($path)) {
            abort(404, 'File tidak ditemukan.');
        }

        return response()->download($path, basename($berkas->file_path));
    }

}
