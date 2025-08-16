<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;
use App\Models\Syarat;
use App\Models\Dokumen;
use App\Models\User;
use App\Models\Notifikasi;

class DokumenController extends Controller
{
    public function create()
    {
        $syaratKoperasi = Syarat::where('kategori_syarat', 'koperasi')
            ->orderBy('nama_syarat')->get();

        $syaratPengurus = Syarat::where('kategori_syarat', 'pengurus')
            ->orderBy('nama_syarat')->get();

        $cooldownUntil = null;
        if (Auth::check()) {
            $last = Dokumen::where('user_id', Auth::id())->max('created_at');
            if ($last) $cooldownUntil = Carbon::parse($last)->addMinutes(2);
        }

        return view('user.pengajuan', compact('syaratKoperasi', 'syaratPengurus', 'cooldownUntil'));
    }

    public function store(Request $request)
    {
        $user = $request->user();
        if (!$user) {
            return redirect()->route('login')->with('error', 'Anda harus login terlebih dahulu.');
        }

        // 0) Kebijakan pengajuan
        // cooldown 2 menit
        $lastUploadAt = Dokumen::where('user_id', $user->id)->max('created_at');
        if ($lastUploadAt) {
            $cooldownUntil = Carbon::parse($lastUploadAt)->addMinutes(2);
            if (now()->lt($cooldownUntil)) {
                // Tampilkan sisa waktu yang ramah
                $sisa = now()->diffForHumans($cooldownUntil, [
                    'parts' => 2,  // maksimal 2 bagian
                    'syntax' => Carbon::DIFF_ABSOLUTE
                ]);
                return back()->with('error', "Anda baru saja mengunggah berkas. Coba lagi sekitar $sisa.");
            }
        }

        // --- B. (OPSIONAL) SEKALI SAJA SEUMUR HIDUP: aktifkan blok ini, matikan kodingan yang cooldown 2 menit
        /*
        $pernah = Dokumen::where('user_id', $user->id)->exists();
        if ($pernah) {
            return back()->with('error', 'Pengajuan hanya dapat dilakukan satu kali.');
        }
        */

        // Kalau mau ubah 3 bulan, ganti addMinutes(2) menjadi addMonths(3)

        // 1) Ambil daftar syarat
        $syaratWajib    = Syarat::where('is_required', true)->get(['id', 'nama_syarat']);
        $syaratOpsional = Syarat::where('is_required', false)->get(['id', 'nama_syarat']);

        // 2) Rule dinamis
        $rules = ['dokumen' => ['required', 'array']];
        $messages = [];

        foreach ($syaratWajib as $s) {
            $rules["dokumen.{$s->id}"] = ['required', 'file', 'mimes:pdf,jpg,jpeg,png', 'max:5120'];
            $messages["dokumen.{$s->id}.required"] = "Berkas '{$s->nama_syarat}' wajib diunggah.";
            $messages["dokumen.{$s->id}.mimes"]    = "Berkas '{$s->nama_syarat}' harus berformat PDF/JPG/PNG.";
            $messages["dokumen.{$s->id}.max"]      = "Berkas '{$s->nama_syarat}' maksimal 5 MB.";
        }
        foreach ($syaratOpsional as $s) {
            $rules["dokumen.{$s->id}"] = ['nullable', 'file', 'mimes:pdf,jpg,jpeg,png', 'max:5120'];
            $messages["dokumen.{$s->id}.mimes"]    = "Berkas '{$s->nama_syarat}' harus berformat PDF/JPG/PNG.";
            $messages["dokumen.{$s->id}.max"]      = "Berkas '{$s->nama_syarat}' maksimal 5 MB.";
        }

        // 3) Validasi
        $validated = $request->validate($rules, $messages);

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

        // 5) Kirim notifikasi ke semua admin
        $adminIds = User::where('user_type', 'admin')->pluck('id');

        if ($adminIds->isNotEmpty()) {
            // Baris notifikasi untuk setiap admin
            $rows = $adminIds->map(fn($id) => [
                'user_id' => $id,
                'verifikasi_id' => null,
                'pesan' => "Pengajuan baru dari {$user->name}. Silahkan lihat di menu daftar pengajuan.",
                'file_path' => null,
                'dibaca' => false,
                'created_at' => now(),
                'updated_at' => now(),
            ])->all();

            // Pastikan ada model notifikasi yang sesuai
            Notifikasi::insert($rows);
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
