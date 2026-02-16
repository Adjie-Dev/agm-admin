@extends('layouts.app')

@section('title', $amituojing->judul)

@section('header', 'Detail Amituojing')

@section('content')
<div class="max-w-4xl mx-auto">
    <!-- Back Button -->
    <div class="mb-6">
        <a href="{{ route('amituojing.index') }}"
           class="inline-flex items-center space-x-2 text-gray-400 hover:text-white transition-colors duration-200">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
            </svg>
            <span class="font-medium">Kembali ke Daftar</span>
        </a>
    </div>

    <!-- Detail Card -->
    <div class="bg-slate-800/70 backdrop-blur-sm rounded-2xl border border-slate-700/50 shadow-xl overflow-hidden">
        <!-- Content -->
        <div class="p-8">
            <!-- Header -->
            <div class="mb-6">
                <div class="flex items-center space-x-3 mb-4">
                    <div class="flex items-center justify-center w-12 h-12 bg-blue-500/10 rounded-lg">
                        <span class="text-blue-400 font-bold text-xl">{{ $amituojing->urutan }}</span>
                    </div>
                    <h1 class="text-3xl font-bold text-white">{{ $amituojing->judul }}</h1>
                </div>

                <div class="flex flex-wrap items-center gap-4 text-sm text-gray-400">
                    <!-- Durasi -->
                    @if($amituojing->durasi)
                    <div class="flex items-center space-x-2">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                        <span>{{ $amituojing->durasi }}</span>
                    </div>
                    @endif

                    <!-- Upload Date -->
                    <div class="flex items-center space-x-2">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                        </svg>
                        <span>{{ $amituojing->created_at->format('d F Y') }}</span>
                    </div>

                    <!-- Status -->
                    @if($amituojing->aktif)
                    <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-medium bg-green-500/10 text-green-400">
                        <svg class="w-3 h-3 mr-1" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path>
                        </svg>
                        Aktif
                    </span>
                    @else
                    <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-medium bg-gray-500/10 text-gray-400">
                        Nonaktif
                    </span>
                    @endif
                </div>
            </div>

            <!-- Divider -->
            <div class="border-t border-slate-700/50 mb-6"></div>

            <!-- Deskripsi -->
            @if($amituojing->deskripsi)
            <div class="mb-6">
                <h3 class="text-lg font-bold text-white mb-3">Deskripsi</h3>
                <div class="bg-slate-900/50 rounded-xl p-6 border border-slate-700/50">
                    <p class="text-gray-300 leading-relaxed">{{ $amituojing->deskripsi }}</p>
                </div>
            </div>
            @endif

            <!-- Audio Player -->
            @if($amituojing->audio_path)
            <div class="mb-6">
                <h3 class="text-lg font-bold text-white mb-3">Audio</h3>
                <div class="bg-slate-900/50 rounded-xl p-6 border border-slate-700/50">
                    <div class="flex items-center justify-between mb-4">
                        <div class="flex items-center space-x-3">
                            <div class="p-2 bg-green-500/10 rounded-lg">
                                <svg class="w-6 h-6 text-green-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19V6l12-3v13M9 19c0 1.105-1.343 2-3 2s-3-.895-3-2 1.343-2 3-2 3 .895 3 2zm12-3c0 1.105-1.343 2-3 2s-3-.895-3-2 1.343-2 3-2 3 .895 3 2zM9 10l12-3"></path>
                                </svg>
                            </div>
                            <div>
                                <p class="text-white font-medium">{{ $amituojing->audio_nama_asli }}</p>
                                <p class="text-sm text-gray-400">{{ $amituojing->audio_ukuran_formatted }}</p>
                            </div>
                        </div>
                    </div>
                    <audio controls class="w-full">
                        <source src="{{ asset('storage/' . $amituojing->audio_path) }}" type="{{ $amituojing->audio_mime }}">
                        Browser Anda tidak mendukung audio player.
                    </audio>
                </div>
            </div>
            @endif

            <!-- Teks Pali -->
            @if($amituojing->teks_pali)
            <div class="mb-6">
                <h3 class="text-lg font-bold text-white mb-3">Teks Pali</h3>
                <div class="bg-slate-900/50 rounded-xl p-6 border border-slate-700/50">
                    <p class="text-gray-300 leading-relaxed whitespace-pre-wrap font-mono">{{ $amituojing->teks_pali }}</p>
                </div>
            </div>
            @endif

            <!-- Terjemahan -->
            @if($amituojing->terjemahan)
            <div class="mb-6">
                <h3 class="text-lg font-bold text-white mb-3">Terjemahan</h3>
                <div class="bg-slate-900/50 rounded-xl p-6 border border-slate-700/50">
                    <p class="text-gray-300 leading-relaxed whitespace-pre-wrap">{{ $amituojing->terjemahan }}</p>
                </div>
            </div>
            @endif

            <!-- Divider -->
            <div class="border-t border-slate-700/50 mt-8 mb-6"></div>

            <!-- Actions -->
            <div class="flex flex-wrap items-center justify-end gap-4">
                <a href="{{ route('amituojing.edit', $amituojing) }}"
                   class="px-6 py-3 bg-indigo-600 hover:bg-indigo-700 text-white font-semibold rounded-xl transition-all duration-300 shadow-lg hover:shadow-xl flex items-center space-x-2">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                    </svg>
                    <span>Edit</span>
                </a>
                <form action="{{ route('amituojing.destroy', $amituojing) }}" method="POST" class="inline-block">
                    @csrf
                    @method('DELETE')
                    <button type="submit"
                            onclick="return confirm('Apakah Anda yakin ingin menghapus section ini?')"
                            class="px-6 py-3 bg-red-600 hover:bg-red-700 text-white font-semibold rounded-xl transition-all duration-300 shadow-lg hover:shadow-xl flex items-center space-x-2">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                        </svg>
                        <span>Hapus</span>
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
