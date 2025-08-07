@extends('admin.dashboard')

@section('content')

    @if(session('syarat_pesan'))
        <div class="mb-4 bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative">
            {{ session('syarat_pesan') }}
        </div>
    @endif

    <div class="max-w-xl mx-auto bg-white shadow-md rounded-lg p-6 mt-6">
        <h2 class="text-2xl font-semibold mb-4 text-gray-800">Tambah Syarat Dokumen</h2>

        <form action="{{ route('admin.post_tambah_syarat') }}" method="POST" class="space-y-4">
            @csrf

            <div>
                <label for="nama_syarat" class="block text-gray-700 font-medium mb-1">Nama Syarat</label>
                <input
                    type="text"
                    name="nama_syarat"
                    id="nama_syarat"
                    placeholder="Contoh: Akta Pendirian"
                    class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500"
                    required
                >
            </div>

            <div>
                <label for="kategori_syarat" class="block text-gray-700 font-medium mb-1">Kategori Syarat</label>
                <select
                    name="kategori_syarat"
                    id="kategori_syarat"
                    required
                    class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500"
                >
                    <option value="">-- Pilih Kategori --</option>
                    <option value="koperasi">Koperasi</option>
                    <option value="pengurus">Pengurus/Pengawas Koperasi</option>
                </select>
            </div>

            <div class="text-right">
                <button
                    type="submit"
                    class="bg-blue-600 hover:bg-blue-700 text-white font-semibold py-2 px-6 rounded-lg transition duration-200"
                >
                    Tambah Syarat
                </button>
            </div>
        </form>
    </div>

@endsection
