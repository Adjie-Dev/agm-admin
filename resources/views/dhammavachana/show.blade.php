@extends('layouts.app')

@section('title', $dhammavachana->title)

@section('header', 'Dhammavācanā Detail')

@section('content')
<div class="max-w-4xl mx-auto">
    <!-- Back Button -->
    <div class="mb-6">
        <a href="{{ route('dhammavachana.index') }}"
           class="inline-flex items-center space-x-2 text-gray-400 hover:text-white transition-colors duration-200">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
            </svg>
            <span class="font-medium">Kembali ke Dhammavācanā</span>
        </a>
    </div>

    <!-- Dhammavachana Card -->
    <div class="bg-slate-800/70 backdrop-blur-sm rounded-2xl border border-slate-700/50 shadow-xl overflow-hidden">
        <!-- Cover Image -->
        @if($dhammavachana->cover_image)
        <div class="w-full h-96 overflow-hidden bg-slate-900/50">
            <img src="{{ asset('storage/' . $dhammavachana->cover_image) }}"
                 alt="{{ $dhammavachana->title }}"
                 class="w-full h-full object-contain">
        </div>
        @endif

        <!-- Content -->
        <div class="p-8">
            <!-- Header -->
            <div class="mb-6">
                <h1 class="text-3xl font-bold text-white mb-4">{{ $dhammavachana->title }}</h1>

                <div class="flex flex-wrap items-center gap-4 text-sm text-gray-400">
                    <!-- Author -->
                    @if($dhammavachana->author)
                    <div class="flex items-center space-x-2">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                        </svg>
                        <span>{{ $dhammavachana->author }}</span>
                    </div>
                    @endif

                    <!-- Upload Date -->
                    <div class="flex items-center space-x-2">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                        </svg>
                        <span>{{ $dhammavachana->created_at->format('d F Y') }}</span>
                    </div>

                    <!-- Page Count -->
                    <div class="flex items-center space-x-2">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                        </svg>
                        <span>{{ $dhammavachana->page_count }} halaman</span>
                    </div>
                </div>
            </div>

            <!-- Divider -->
            <div class="border-t border-slate-700/50 mb-6"></div>

            <!-- Information Grid -->
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                <div class="bg-slate-900/50 rounded-xl p-4 border border-slate-700/50">
                    <div class="flex items-center space-x-3">
                        <div class="p-2 bg-blue-500/10 rounded-lg">
                            <svg class="w-5 h-5 text-blue-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M15 13l-3-3m0 0l-3 3m3-3v12"></path>
                            </svg>
                        </div>
                        <div>
                            <p class="text-xs text-gray-500 uppercase tracking-wider">Diupload oleh</p>
                            <p class="text-white font-medium">{{ $dhammavachana->uploader->name ?? 'Unknown' }}</p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Description -->
            @if($dhammavachana->description)
            <div class="mb-6">
                <h3 class="text-lg font-bold text-white mb-3">Deskripsi</h3>
                <div class="bg-slate-900/50 rounded-xl p-6 border border-slate-700/50">
                    <p class="text-gray-300 leading-relaxed">{{ $dhammavachana->description }}</p>
                </div>
            </div>
            @endif

            <!-- Divider -->
            <div class="border-t border-slate-700/50 mt-8 mb-6"></div>

            <!-- Actions -->
            <div class="flex flex-wrap items-center justify-end gap-4">
                <a href="{{ asset('storage/' . $dhammavachana->pdf_path) }}"
                   target="_blank"
                   class="px-6 py-3 bg-blue-600 hover:bg-blue-700 text-white font-semibold rounded-xl transition-all duration-300 shadow-lg hover:shadow-xl flex items-center space-x-2">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                    </svg>
                    <span>Buka PDF</span>
                </a>
                <a href="{{ route('dhammavachana.edit', $dhammavachana) }}"
                   class="px-6 py-3 bg-indigo-600 hover:bg-indigo-700 text-white font-semibold rounded-xl transition-all duration-300 shadow-lg hover:shadow-xl flex items-center space-x-2">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                    </svg>
                    <span>Edit</span>
                </a>
                <form action="{{ route('dhammavachana.destroy', $dhammavachana) }}" method="POST" class="inline-block">
                    @csrf
                    @method('DELETE')
                    <button type="submit"
                            onclick="return confirm('Apakah Anda yakin ingin menghapus dhammavācanā ini?')"
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
