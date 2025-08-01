<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Syarat;
use App\Models\Dokumen;

class DokumenController extends Controller
{
    public function create()
    {
        $syaratKoperasi = Syarat::where('kategori_syarat', 'koperasi')->get();
        $syaratPengurus = Syarat::where('kategori_syarat', 'pengurus')->get();

        return view('dokumen/pengajuan', compact('syaratKoperasi', 'syaratPengurus'));
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
            'dokumen.*' => 'nullable|file|mimes:pdf,jpg,jpeg,png|max:2048'
        ]);

        $files = $request->file('dokumen');

        // Cek kalau semua file kosong
        if (!$files || count($files) === 0) {
            return redirect()->back()->with('error', 'Tidak ada dokumen yang diunggah.');
        }

        // Loop dan simpan file yang benar-benar diunggah
        foreach ($request->file('dokumen') as $syaratId => $file) {
            if ($file) {
                $path = $file->store('dokumen', 'public');

                Dokumen::create([
                    'user_id' => $user->id,
                    'syarat_id' => $syaratId,
                    'file_path' => $path,
                ]);
            }
        }

        return redirect()->route('dokumen.store')->with('success', 'Dokumen berhasil diunggah!');
    }
}
