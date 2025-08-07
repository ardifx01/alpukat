<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Models\Syarat;
use App\Models\Verifikasi;

class AdminController extends Controller
{
    public function dashboard()
    {
        return view('admin.dashboard');
    }

    public function tambahSyarat()
    {
        return view('admin.tambah_syarat');
    }

    public function postTambahSyarat(Request $request)
    {
        // Validasi input
        $request->validate([
            'nama_syarat' => 'required|string|max:255',
            'kategori_syarat' => 'required|in:koperasi,pengurus',
        ]);

        // Simpan ke database pakai Eloquent
        $syarat=new Syarat();
        $syarat->nama_syarat = $request->nama_syarat;
        $syarat->kategori_syarat = $request->kategori_syarat;
        $syarat->save();

        return redirect()->back()->with('syarat_pesan', 'Persyaratan berhasil ditambahkan!');
    }

    public function lihatSyarat()
    {
        $syarat_koperasi = Syarat::where('kategori_syarat', 'koperasi')->get();
        $syarat_pengurus = Syarat::where('kategori_syarat', 'pengurus')->get();
        
        return view('admin.lihat_syarat', compact('syarat_koperasi', 'syarat_pengurus'));
    }

    public function hapusSyarat($id)
    {
        $syarat=Syarat::findOrFail($id);

        $syarat->delete();

        return redirect()->back()->with('hapussyaratsyarat_pesan', 'Persyaratan berhasil dihapus!');
    }

    public function editSyarat($id)
    {
        $syarat=Syarat::findOrFail($id);
        return view('admin.edit_syarat', compact('syarat'));
    }

    public function postEditsyarat(Request $request, $id){
        // Validasi input
        $request->validate([
            'nama_syarat' => 'required|string|max:255',
            'kategori_syarat' => 'required|in:koperasi,pengurus',
        ]);

        $syarat=Syarat::findOrFail($id);

        $syarat->nama_syarat=$request->nama_syarat;
        $syarat->kategori_syarat=$request->kategori_syarat;
        $syarat->save();
        
        return redirect()->back()->with('editsyarat_pesan', 'Persyaratan berhasil diedit!');
    }
}
