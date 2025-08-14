<?php

namespace App\Http\Controllers\Admin;

use App\Models\BerkasAdmin;
use App\Models\User;
use App\Models\Verifikasi;
use App\Models\Notifikasi;
use Carbon\Carbon;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class BerkasAdminController extends Controller
{
    // Menampilkan semua data berkas admin
    public function index()
    {
        $data = BerkasAdmin::with(['verifikasi.user'])->latest()->paginate(3);

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
        ]);

        $verifikasi = Verifikasi::findOrFail($request->verifikasi_id);

        if (!$verifikasi->tanggal_wawancara) {
            return back()->withErrors(['file_path' => 'Tanggal wawancara tidak ditemukan.']);
        }

        // Hitung batas waktu
        $tanggalWawancara = Carbon::parse($verifikasi->tanggal_wawancara);
        $batasWawancara = $this->addBusinessDays($tanggalWawancara, 30);

        if (Carbon::now()->greaterThan($batasWawancara)) {
            return back()->withErrors(['file' => 'Batas waktu upload sudah lewat 30 hari kerja setelah wawancara']);
        }

        // Simpan file dengan nama rapi
        $file = $request->file('file');
        $namaBersih = preg_replace('/\s+/', '_', strtolower($file->getClientOriginalName()));
        $namaFileFinal = time() . '_' . $namaBersih;

        $file->storeAs('berkas_admin', $namaFileFinal, 'public');

        // Simpan ke database (pakai nama yang sama seperti di storage)
        BerkasAdmin::create([
            'verifikasi_id' => $request->verifikasi_id,
            'user_id' => $verifikasi->user_id,
            'jenis_surat' => $request->jenis_surat,
            'file_path' => $namaFileFinal,
        ]);

        // Tentukan pesan notifikasi berdasarkan jenis surat
        $pesanNotif = $request->jenis_surat === 'sk_ukk' ? "Admin telah mengunggah SK UKK Anda." : "Admin telah mengunggah Berita Acara Anda.";

        // Simpan notifikasi untuk user 
        Notifikasi::create([
            'user_id' => $verifikasi->user_id,
            'verifikasi_id' => $request->verifikasi_id,
            'pesan' => $pesanNotif,
            'file_path' => 'berkas_admin/' . $namaFileFinal,
            'dibaca' => 0,
        ]);

        return redirect()->route('admin.berkas-admin.index')->with('success', 'Berkas berhasil ditambahkan');
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