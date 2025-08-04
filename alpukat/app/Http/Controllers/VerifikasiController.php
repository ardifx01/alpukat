<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Dokumen;
use App\Models\Verifikasi;

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

        Verifikasi::create([
            'user_id' => $id,
            'status' => $request->status,
            'feedback' => $request->feedback,
            'tanggal_wawancara' => $request->tanggal_wawancara,
            'lokasi_wawancara' => $request->lokasi_wawancara,
        ]);

        return redirect()->route('admin.verif_berkas', ['id' => $id])->with('verif_pesan', 'Verifikasi berhasil disimpan.');
    }
}
