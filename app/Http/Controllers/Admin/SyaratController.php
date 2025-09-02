<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Models\Syarat;
use App\Http\Controllers\Controller;

class SyaratController extends Controller
{
    public function tambahSyarat()
    {
        $syarat = new Syarat();
        
        return view('admin.syarat.tambah_syarat');
    }

    public function postTambahSyarat(Request $request)
    {
        // Validasi input
        $data = $request->validate([
            'nama_syarat' => 'required|string|max:255',
            'kategori_syarat' => 'required|in:koperasi,pengurus,pengawas',
            'is_required' => ['nullable'],
        ]);

        $data['is_required'] = $request->boolean('is_required');

        Syarat::create($data);

        return redirect()->route('admin.syarat.lihat_syarat')->with('success', 'Persyaratan berhasil ditambahkan!');
    }

    public function lihatSyarat()
    {
        $syarat_koperasi = Syarat::where('kategori_syarat', 'koperasi')->get();
        $syarat_pengurus = Syarat::where('kategori_syarat', 'pengurus')->get();
        $syarat_pengawas = Syarat::where('kategori_syarat', 'pengawas')->get();
        
        return view('admin.syarat.lihat_syarat', compact('syarat_koperasi', 'syarat_pengurus', 'syarat_pengawas'));
    }

    public function hapusSyarat($id)
    {
        $syarat=Syarat::findOrFail($id);

        $syarat->delete();

        return redirect()->route('admin.syarat.lihat_syarat')->with('success', 'Persyaratan berhasil dihapus!');
    }

    public function editSyarat($id)
    {
        $syarat=Syarat::findOrFail($id);
        return view('admin.syarat.edit_syarat', compact('syarat'));
    }

    public function postEditsyarat(Request $request, $id){

        $syarat=Syarat::findOrFail($id);

        // Validasi input
        $request->validate([
            'nama_syarat' => 'required|string|max:255',
            'kategori_syarat' => 'required|in:koperasi,pengurus,pengawas',
            'is_required' => ['nullable'],
        ]);

        $data['is_required'] = $request->boolean('is_required');

        $syarat->update($data);

        $syarat->nama_syarat=$request->nama_syarat;
        $syarat->kategori_syarat=$request->kategori_syarat;
        $syarat->save();
        
        return redirect()->route('admin.syarat.lihat_syarat')->with('success', 'Persyaratan berhasil diedit!');
    }
}
