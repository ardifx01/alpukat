<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Syarat;
use App\Models\Dokumen;

// Fokus ngatur upload atau tampilkan dokumen
class DokumenController extends Controller
{
    public function create()
    {
        $syaratKoperasi = Syarat::where('kategori_syarat', 'koperasi')->get();
        $syaratPengurus = Syarat::where('kategori_syarat', 'pengurus')->get();

        return view('user.pengajuan', compact('syaratKoperasi', 'syaratPengurus'));
    }

    public function store(Request $request)
    {
        $user = Auth::user();

        // Cek apakah user sudah login
        if (!$user) {
            return redirect()->route('login')->with('error', 'Anda harus login terlebih dahulu.');
        }

        // Validasi inputan: pastikan dokumen adalah array dan tiap itemnya valid
        $request->validate([
            'dokumen' => 'array',
            'dokumen.*' => 'nullable|file|mimes:pdf,jpg,jpeg,png|max:5120' // PDF atau gambar, ga boleh > 5 MB
        ]);

        $files = $request->file('dokumen');

        // Cek kalau semua file kosong
        if (!$files || count($files) === 0) {
            return redirect()->back()->with('error', 'Tidak ada dokumen yang diunggah.');
        }

        // Loop dan simpan file yang benar-benar diunggah
        foreach ($request->file('dokumen') as $syaratId => $file) {
            if ($file) {
                $namaBersih = preg_replace('/\s+/', '_', strtolower($file->getClientOriginalName()));
                $namaFileFinal = time() . '_' . $namaBersih;
                $path = $file->storeAs('dokumen', $namaFileFinal, 'public');

                Dokumen::create([
                    'user_id' => $user->id,
                    'syarat_id' => $syaratId,
                    'file_path' => $path,
                ]);
            }
        }

        return redirect()->route('user.create')->with('success', 'Dokumen berhasil diunggah!');
    }

    public function lihatBerkas()
    {
        $user = Auth::user();

        // Ambil semua dokumen milik user yang sedang login
        $berkasUser = Dokumen::with('syarat') // pastikan ada relasi ke tabel syarat nanti
            ->where('user_id', $user->id)
            ->get();

        // Kirim data ke view
        return view('user.lihat_berkas', compact('berkasUser'));
    }

    public function daftarPengajuan()
    {
        // Ambil user yang punya dokumen, dan relasi dokumennya
        $users = \App\Models\User::whereHas('dokumens')
            ->with(['dokumens.syarat']) // relasi dokumen + syarat
            ->paginate(1); // 1 user per halaman

        return view('admin.verif.daftar_pengajuan', compact('users'));
    }
}
