<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use App\Models\Syarat;
use App\Models\Dokumen;

class DokumenController extends Controller
{
    public function create()
    {
        $syaratKoperasi = Syarat::where('kategori_syarat', 'koperasi')
            ->orderBy('nama_syarat')->get();

        $syaratPengurus = Syarat::where('kategori_syarat', 'pengurus')
            ->orderBy('nama_syarat')->get();

        return view('user.pengajuan', compact('syaratKoperasi', 'syaratPengurus'));
    }

    public function store(Request $request)
    {
        $user = $request->user();
        if (!$user) {
            return redirect()->route('login')->with('error', 'Anda harus login terlebih dahulu.');
        }

        // 1) Ambil daftar syarat (wajib & opsional)
        $syaratWajib    = Syarat::where('is_required', true)->get(['id','nama_syarat']);
        $syaratOpsional = Syarat::where('is_required', false)->get(['id','nama_syarat']);

        // 2) Susun rule dinamis per syarat
        $rules = [
            'dokumen' => ['required','array'],
        ];
        $messages = [];

        foreach ($syaratWajib as $s) {
            $rules["dokumen.{$s->id}"] = ['required','file','mimes:pdf,jpg,jpeg,png','max:5120'];
            $messages["dokumen.{$s->id}.required"] = "Berkas '{$s->nama_syarat}' wajib diunggah.";
            $messages["dokumen.{$s->id}.mimes"]    = "Berkas '{$s->nama_syarat}' harus berformat PDF/JPG/PNG.";
            $messages["dokumen.{$s->id}.max"]      = "Berkas '{$s->nama_syarat}' maksimal 5 MB.";
        }
        foreach ($syaratOpsional as $s) {
            $rules["dokumen.{$s->id}"] = ['nullable','file','mimes:pdf,jpg,jpeg,png','max:5120'];
            $messages["dokumen.{$s->id}.mimes"]    = "Berkas '{$s->nama_syarat}' harus berformat PDF/JPG/PNG.";
            $messages["dokumen.{$s->id}.max"]      = "Berkas '{$s->nama_syarat}' maksimal 5 MB.";
        }

        // 3) Validasi
        $validated = $request->validate($rules, $messages);

        // 4) Simpan file + upsert Dokumen
        $files = $request->file('dokumen', []);
        foreach ($files as $syaratId => $file) {
            if (!$file) continue; // opsional yang kosong

            // simpan file ke storage/app/public/dokumen/...
            $path = $file->store('dokumen', 'public');

            // kalau sudah ada dokumen untuk syarat ini, hapus file lama & update path
            $existing = Dokumen::where('user_id', $user->id)
                ->where('syarat_id', (int) $syaratId)
                ->first();

            if ($existing) {
                if ($existing->file_path && Storage::disk('public')->exists($existing->file_path)) {
                    Storage::disk('public')->delete($existing->file_path);
                }
                $existing->update(['file_path' => $path]);
            } else {
                Dokumen::create([
                    'user_id'   => $user->id,
                    'syarat_id' => (int) $syaratId,
                    'file_path' => $path,
                ]);
            }
        }

        return redirect()
            ->route('user.lihat_berkas')
            ->with('success', 'Dokumen berhasil diunggah!');
    }

    public function lihatBerkas()
    {
        $user = Auth::user();

        $berkasUser = Dokumen::with('syarat')
            ->where('user_id', $user->id)
            ->get();

        return view('user.lihat_berkas', compact('berkasUser'));
    }

    public function daftarPengajuan()
    {
        $users = \App\Models\User::whereHas('dokumens')
            ->with(['dokumens.syarat'])
            ->paginate(1);

        return view('admin.verif.daftar_pengajuan', compact('users'));
    }
}
