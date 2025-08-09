<?php

namespace App\Http\Controllers;

use App\Models\BerkasAdmin;
use Illuminate\Http\Request;

class BerkasAdminController extends Controller
{
    // Menampilkan semua data berkas admin
    public function index()
    {
        $data = BerkasAdmin::all();
        return view('admin.berkas.index', compact('data'));
    }

    // Menampilkan form tambah berkas
    public function create()
    {
        return view('admin.berkas.create');
    }

    // Menyimpan berkas baru ke database
    public function store(Request $request)
    {
        $request->validate([
            'nama_berkas' => 'required|string|max:255',
            'file' => 'required|mimes:pdf|max:5120', 
            // Ukuran file nya maksimal 5 MB dulu supaya uploadnya cepat dan servernya tidak cepat penuh
        ]);

        $fileName = time() . '.' . $request->file->extension();
        $request->file->storeAs('berkas_admin', $fileName, 'public');

        BerkasAdmin::create([
            'nama_berkas' => $request->nama_berkas,
            'file' => $fileName
        ]);

        return redirect()->route('berkas-admin.index')->with('success', 'Berkas berhasil ditambahkan');
    }

    // Menampilkan detail satu data berdasarkan ID-nya
    public function show(string $id)
    {
        $berkas = BerkasAdmin::with(['user', 'verifikasi'])->findOrFail($id);

        return view('admin.berkas.show', compact('berkas'));
    }

    // Menampilkan form edit berkas
    public function edit($id)
    {
        $berkas = BerkasAdmin::findOrFail($id);
        return view('admin.berkas.edit', compact('berkas'));
    }

    // Menyimpan perubahan data
    public function update(Request $request, string $id)
    {
        $request->validate([
            'nama_berkas' => 'required|string|max:255',
        ]);

        $berkas = BerkasAdmin::findOrFail($id);

        if ($request->hasFile('file')) {
            $fileName = time() . '.' . $request->file->extension();
            $request->file->move(public_path('uploads'), $fileName);
            $berkas->file = $fileName;
        }

        $berkas->nama_berkas = $request->nama_berkas;
        $berkas->save();

        return redirect()->route('berkas-admin.index')->with('success', 'Berkas berhasil diperbarui');
    }

    // Menghapus data
    public function destroy(string $id)
    {
        $berkas = BerkasAdmin::findOrFail($id);
        $berkas->delete();

        return redirect()->route('berkas-admin.index')->with('success', 'Berkas berhasil dihapus');
    }

    public function download($id)
    {
        $berkas = BerkasAdmin::findOrFail($id);
        $path = storage_path('app/public/berkas_admin/' . $berkas->file);

        if (!file_exists($path)) {
            abort(404, 'File tidak ditemukan.');
        }

        return response()->download($path, $berkas->file);
    }

}
