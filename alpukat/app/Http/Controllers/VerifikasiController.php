<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Dokumen;
use App\Models\Verifikasi;
use App\Models\Notifikasi;
use App\Models\User;

class VerifikasiController extends Controller
{
    // Tampilkan form verifikasi
    public function verifBerkas($id)
    {
        $dokumen = Dokumen::where('user_id', $id)->get(); // ambil semua dokumen milik user
        $verifikasi = Verifikasi::where('user_id', $id)->first();
        $users = \App\Models\User::findOrFail($id);

        return view('admin.verif_berkas', compact('dokumen', 'users', 'verifikasi'));
    }

    // Simpan hasil verifikasi
    public function postVerifBerkas(Request $request, $id)
    {
        // Validasi input
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
        $verifikasi = Verifikasi::create([
            'user_id' => $id,
            'status' => $request->status,
            'feedback' => $request->feedback,
            'tanggal_wawancara' => $request->tanggal_wawancara,
            'lokasi_wawancara' => $request->lokasi_wawancara,
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
