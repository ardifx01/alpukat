<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            Upload Dokumen Permohonan SK UKK
        </h2>
    </x-slot>

    <div class="py-6">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            @if (session('success'))
                <div class="mb-4 font-medium text-sm text-green-600">
                    {{ session('success') }}
                </div>
            @endif

            <form method="POST" action="{{ route('dokumen.store') }}" enctype="multipart/form-data" class="space-y-6 bg-white p-6 rounded shadow">
                @csrf

                <h3 class="text-lg font-semibold">Dokumen Koperasi</h3>
                @foreach ($syaratKoperasi as $syarat)
                    <div>
                        <label class="block text-gray-700">{{ $syarat->nama_syarat }}</label>
                        <input type="file" name="dokumen[{{ $syarat->id }}]" class="mt-1 block w-full">
                        @error("dokumen.{$syarat->id}")
                            <span class="text-red-500 text-sm">{{ $message }}</span>
                        @enderror
                    </div>
                @endforeach

                <h3 class="text-lg font-semibold mt-6">Dokumen Pengurus</h3>
                @foreach ($syaratPengurus as $syarat)
                    <div>
                        <label class="block text-gray-700">{{ $syarat->nama_syarat }}</label>
                        <input type="file" name="dokumen[{{ $syarat->id }}]" class="mt-1 block w-full">
                        @error("dokumen.{$syarat->id}")
                            <span class="text-red-500 text-sm">{{ $message }}</span>
                        @enderror
                    </div>
                @endforeach

                <button type="submit" class="bg-blue-600 text-black px-4 py-2 rounded hover:bg-blue-700">
                    Upload Semua
                </button>
            </form>
        </div>
    </div>
</x-app-layout>
