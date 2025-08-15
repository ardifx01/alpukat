<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
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

        // 1) Ambil daftar syarat
        $syaratWajib    = Syarat::where('is_required', true)->get(['id','nama_syarat']);
        $syaratOpsional = Syarat::where('is_required', false)->get(['id','nama_syarat']);

        // 2) Rule dinamis
        $rules = ['dokumen' => ['required','array']];
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
        $validator = Validator::make($request->all(), $rules, $messages);

        if ($validator->fails()) {
            // Kumpulkan nama berkas wajib yang kosong (biar ada ringkasan singkat di atas)
            $submitted = collect($request->file('dokumen', []))
                ->filter(fn($f) => !is_null($f))     // hanya yang ada filenya
                ->keys()->map(fn($k) => (int) $k);   // daftar id syarat yang terisi

            $missingNames = $syaratWajib
                ->whereNotIn('id', $submitted)
                ->pluck('nama_syarat')
                ->values()
                ->all();

            return back()
                ->withErrors($validator)
                ->withInput()
                ->with('missing_required', $missingNames);   // <— dipakai di Blade
        }

        // 4) Simpan file + upsert Dokumen
        $files = $request->file('dokumen', []);           // <- array [syarat_id => UploadedFile|null]
        foreach ($files as $syaratId => $file) {
            if (!$file) continue; // lewati opsional yang kosong

            // Susun nama file yang rapi (slug + timestamp + random)
            $origName = $file->getClientOriginalName();
            $ext      = $file->getClientOriginalExtension();
            $base     = pathinfo($origName, PATHINFO_FILENAME);
            $safeBase = Str::slug($base);
            $filename = $safeBase . '-' . now()->format('YmdHis') . '-' . Str::random(5) . '.' . $ext;

            // Folder per user (lebih rapih)
            $folder = 'dokumen/' . $user->id;

            // SIMPAN di disk 'public', dapatkan path string
            $storedPath = $file->storeAs($folder, $filename, 'public');

            // Upsert record + hapus file lama bila ada
            $existing = Dokumen::where('user_id', $user->id)
                ->where('syarat_id', (int) $syaratId)
                ->first();

            if ($existing) {
                if ($existing->file_path && Storage::disk('public')->exists($existing->file_path)) {
                    Storage::disk('public')->delete($existing->file_path);
                }
                $existing->update([
                    'file_path'      => $storedPath,            // <- simpan path STRING hasil storeAs
                    'original_name'  => $origName,              // (opsional tapi disarankan)
                    'mime'           => $file->getClientMimeType(),
                    'size'           => $file->getSize(),
                ]);
            } else {
                Dokumen::create([
                    'user_id'        => $user->id,
                    'syarat_id'      => (int) $syaratId,
                    'file_path'      => $storedPath,            // <- path STRING
                    'original_name'  => $origName,              // simpan nama asli untuk ditampilkan
                    'mime'           => $file->getClientMimeType(),
                    'size'           => $file->getSize(),
                ]);
            }
        }

        return redirect()
            ->route('user.store')
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
