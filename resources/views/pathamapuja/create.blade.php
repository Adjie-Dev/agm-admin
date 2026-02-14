@extends('layouts.app')

@section('title', 'Tambah Pathama Puja')

@section('header', 'Tambah Pathama Puja')

@section('content')
<div class="max-w-4xl mx-auto">
    <!-- Back Button -->
    <div class="mb-6">
        <a href="{{ route('pathama-puja.index') }}"
           class="inline-flex items-center space-x-2 text-gray-400 hover:text-white transition-colors duration-200">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
            </svg>
            <span class="font-medium">Kembali ke Daftar</span>
        </a>
    </div>

    <!-- Form Card -->
    <div class="bg-slate-800/70 backdrop-blur-sm rounded-2xl border border-slate-700/50 shadow-xl overflow-hidden">
        <div class="p-8">
            <h2 class="text-2xl font-bold text-white mb-6">Tambah Section Baru</h2>

            @if($nextUrutan === null)
            <div class="mb-6 bg-red-500/10 border border-red-500/50 rounded-xl p-4">
                <div class="flex items-center space-x-3">
                    <svg class="w-6 h-6 text-red-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                    <p class="text-red-400 font-medium">Semua 17 section sudah terisi. Tidak dapat menambah section baru.</p>
                </div>
            </div>
            @endif

            <x-puja-form :action="route('pathama-puja.store')"
                         method="POST"
                         :backRoute="route('pathama-puja.index')"
                         submitLabel="Simpan"
                         :nextUrutan="$nextUrutan"
                         :maxUrutan="17"
                         :includeDeskripsi="false" />

        </div>
    </div>
</div>

@endsection
