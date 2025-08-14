@extends('layouts.app')

@section('header')
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            Upload Dokumen Permohonan SK UKK
        </h2>
    </x-slot>
@endsection

@section('content')
    <div class="py-6">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            @if (session('success'))
                <div class="mb-4 font-medium text-sm text-green-600">
                    {{ session('success') }}
                </div>
            @endif

            <form method="POST" action="{{ route('user.store') }}" enctype="multipart/form-data" class="space-y-6 bg-white p-6 rounded shadow">
                @csrf

                <h3 class="text-lg font-semibold">Dokumen Koperasi</h3>
                @foreach ($syaratKoperasi as $syarat)
                    <div>
                        <label class="block text-gray-700 dark:text-gray-300">
                            {{ $syarat->nama_syarat }}
                            @if($syarat->is_required)
                                <span class="ml-2 inline-flex items-center rounded-full bg-red-100 px-2 py-0.5 text-xs font-medium text-red-800">
                                    Wajib
                                </span>
                            @else
                                <span class="ml-2 inline-flex items-center rounded-full bg-gray-100 px-2 py-0.5 text-xs font-medium text-gray-700">
                                    Opsional
                                </span>
                            @endif
                        </label>
                        <input 
                            type="file" 
                            name="dokumen[{{ $syarat->id }}]" 
                            accept=".pdf,.jpg,.jpeg,.png"
                            @if($syarat->is_required) required @endif
                            class="mt-1 block w-full text-sm text-gray-900 file:mr-4 file:py-2 file:px-4
                                    file:rounded file:border-0 file:text-sm file:font-semibold
                                    file:bg-blue-50 file:text-blue-700 hover:file:bg-blue-100
                                    dark:text-gray-100 dark:file:bg-gray-700 dark:file:text-gray-200"
                        >
                        @error("dokumen.{$syarat->id}")
                            <span class="text-red-500 text-sm">{{ $message }}</span>
                        @enderror
                    </div>
                @endforeach

                <h3 class="text-lg font-semibold">Dokumen Pengurus</h3>
                    @foreach ($syaratPengurus as $syarat)
                        <div>
                            <label class="block text-gray-700 dark:text-gray-300">
                                {{ $syarat->nama_syarat }}
                                @if($syarat->is_required)
                                    <span class="ml-2 inline-flex items-center rounded-full bg-red-100 px-2 py-0.5 text-xs font-medium text-red-800">
                                        Wajib
                                    </span>
                                @else
                                    <span class="ml-2 inline-flex items-center rounded-full bg-gray-100 px-2 py-0.5 text-xs font-medium text-gray-700">
                                        Opsional
                                    </span>
                                @endif
                            </label>
                            <input 
                                type="file" 
                                name="dokumen[{{ $syarat->id }}]" 
                                accept=".pdf,.jpg,.jpeg,.png"
                                    @if($syarat->is_required) required @endif
                                    class="mt-1 block w-full text-sm text-gray-900 file:mr-4 file:py-2 file:px-4
                                        file:rounded file:border-0 file:text-sm file:font-semibold
                                        file:bg-blue-50 file:text-blue-700 hover:file:bg-blue-100
                                        dark:text-gray-100 dark:file:bg-gray-700 dark:file:text-gray-200"
                            >
                            @error("dokumen.{$syarat->id}")
                                <p class="mt-1 text-red-500 text-sm">{{ $message }}</p>
                            @enderror
                        </div>
                    @endforeach
                    <div class="flex gap-2">
                        <button type="submit" name="action" value="submit"
                                class="bg-blue-600 text-black px-4 py-2 rounded hover:bg-blue-700">
                            Kirim Pengajuan
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>
@endsection