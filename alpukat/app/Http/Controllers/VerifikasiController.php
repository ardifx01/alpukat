<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Dokumen;
use App\Models\Verifikasi;
use App\Models\Notifikasi;
use App\Models\User;
use Carbon\Carbon;

class VerifikasiController extends Controller
{
    // Tampilkan form verifikasi
    public function verifBerkas($id)
    {
        $users = \App\Models\User::findOrFail($id);
        $dokumen = $users->dokumen;
        $verifikasi = Verifikasi::where('user_id', $id)->first();

        // Hitung 30 hari kerja dari hari ini
        $batasMax = $this->hitungBatasWawancara(30);

        return view('admin.verif_berkas', compact('dokumen', 'users', 'verifikasi', 'batasMax'));
    }

    public function hitungBatasWawancara($jumlahHariKerja) 
    {
        $tanggal = Carbon::now();
        $hariKerja = 0;

        while ($hariKerja < $jumlahHariKerja) {
            if (!$tanggal->isWeekend()) {
                $hariKerja++;
            }
            if ($hariKerja < $jumlahHariKerja) {
                $tanggal->addDay();
            }
        }

        return $tanggal;
    }

    // Simpan hasil verifikasi
    public function postVerifBerkas(Request $request, $id)
    {
        // Validasi input atau data yang masuk
        $request->validate([
            'status' => 'required|in:diterima,ditolak',
            'feedback' => 'nullable|string|max:1000',
            'tanggal_wawancara' => 'required_if:status,diterima|nullable|date',
            'lokasi_wawancara' => 'required_if:status,diterima|nullable|string|max:255',
        ]);

        // Cek apakah verifikasi sudah ada
        $sudahAda = Verifikasi::where('user_id', $id)->exists();
        if ($sudahAda) {
            return redirect()->back()->with('error', 'Verifikasi hanya bisa diberikan sekali.');
        }

        // Simpan hasil verifikasi ke dalam variabel
        $batasWawancara = null;

        if ($request->status === 'diterima') {
            // Hitung 30 hari kerja dari sekarang
            $startDate = Carbon::now();
            $workDays = 0;
            $date = $startDate->copy();

            while ($workDays < 30) {
                if (!$date->isWeekend()) {
                    $workDays++;
                }
                if ($workDays < 30) {
                    $date->addDay();
                }
            }

            $batasWawancara = $date;

            // Validasi agar tanggal_wawancara tidak melebihi batas
            if ($request->tanggal_wawancara && Carbon::parse($request->tanggal_wawancara)->gt($batasWawancara)) {
                return redirect()->back()->with('error', 'Tanggal wawancara tidak boleh melebihi batas maksimal (' . $batasWawancara->translatedFormat('d F Y') . ').');
            }
        }
        
        $verifikasi = Verifikasi::create([
            'user_id' => $id,
            'status' => $request->status,
            'feedback' => $request->feedback,
            'tanggal_wawancara' => $request->tanggal_wawancara,
            'lokasi_wawancara' => $request->lokasi_wawancara,
            'batas_wawancara' => $batasWawancara,
        ]);

        // Ambil data user berdasarkan id
        $user = User::find($id);

        // Siapkan pesan notifikasi berdasarkan status
        if ($request->status === 'diterima') {
            $pesan = "Selamat! Berkas Anda sudah lengkap. Silakan ikut wawancara pada tanggal " . date('d M Y', strtotime($request->tanggal_wawancara)) . " di " . $request->lokasi_wawancara . ".";
        } else {
            $pesan = "Maaf, pengajuan Anda ditolak. " . $request->feedback;
        }

        // Simpan notifikasi
        $notifikasi = Notifikasi::create([
            'user_id' => $user->id, //id koperasi
            'verifikasi_id' => $verifikasi->id,
            'pesan' => $pesan,
            'dibaca' => false, 
        ]);

        // dd($notifikasi);

        return redirect()->route('admin.verif_berkas', ['id' => $id])->with('verif_pesan', 'Verifikasi berhasil disimpan.');
    }

    public function hasilVerifikasi()
    {
        $verifikasi = Verifikasi::with('user')->orderBy('updated_at', 'desc')->paginate(10);

        // dd($verifikasi);
        return view('admin.hasil_verifikasi', compact('verifikasi'));
    }
}
