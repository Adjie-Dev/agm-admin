@extends('layouts.app')

@section('title', $ebook->title)

@section('header', 'Detail E-Book')

@section('content')
<div class="max-w-5xl mx-auto">
    <!-- Back Button -->
    <div class="mb-6">
        <a href="{{ route('ebooks.index') }}"
           class="inline-flex items-center space-x-2 text-gray-400 hover:text-white transition-colors duration-200">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
            </svg>
            <span class="font-medium">Kembali ke Daftar E-Book</span>
        </a>
    </div>

    <div class="bg-slate-800/70 backdrop-blur-sm rounded-2xl border border-slate-700/50 shadow-xl overflow-hidden">
        <div class="p-8">
            <div class="grid md:grid-cols-3 gap-8">
                <!-- Cover Image -->
                <div class="md:col-span-1">
                    <div class="w-full aspect-[3/4] bg-slate-700 rounded-xl border border-slate-600 overflow-hidden">
                        <img src="{{ asset('storage/' . $ebook->cover_image) }}"
                            alt="{{ $ebook->title }}"
                            class="w-full h-full object-cover" />
                    </div>

                    <!-- Download Button -->
                    <a href="{{ asset('storage/' . $ebook->pdf_file) }}"
                    download
                    class="mt-4 w-full px-4 py-3 bg-green-600 hover:bg-green-700 text-white font-semibold rounded-xl transition-all duration-300 flex items-center justify-center shadow-lg hover:shadow-xl">
                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                        </svg>
                        Download PDF
                    </a>
                </div>

                <!-- Information -->
                <div class="md:col-span-2">
                    <h1 class="text-3xl font-bold text-white mb-4">{{ $ebook->title }}</h1>

                    <!-- Meta Information -->
                    <div class="space-y-3 mb-6">
                        <div class="flex items-center text-gray-300">
                            <svg class="w-5 h-5 mr-3 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                            </svg>
                            <span class="font-medium">Halaman:</span>
                            <span class="ml-2">{{ $ebook->page_count }} halaman</span>
                        </div>

                        <div class="flex items-center text-gray-300">
                            <svg class="w-5 h-5 mr-3 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                            </svg>
                            <span class="font-medium">Diupload oleh:</span>
                            <span class="ml-2">{{ $ebook->uploader->name ?? 'Unknown' }}</span>
                        </div>

                        <div class="flex items-center text-gray-300">
                            <svg class="w-5 h-5 mr-3 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                            </svg>
                            <span class="font-medium">Tanggal Upload:</span>
                            <span class="ml-2">{{ $ebook->created_at->format('d M Y, H:i') }}</span>
                        </div>
                    </div>

                    <!-- Description -->
                    @if($ebook->description)
                    <div class="border-t border-slate-700 pt-6">
                        <h2 class="text-xl font-semibold text-white mb-3">Deskripsi</h2>
                        <p class="text-gray-300 leading-relaxed whitespace-pre-wrap">{{ $ebook->description }}</p>
                    </div>
                    @endif

                    <!-- Action Buttons -->
                    <div class="border-t border-slate-700 pt-6 mt-6">
                        <div class="flex items-center space-x-3">
                            <a href="{{ route('ebooks.edit', $ebook) }}"
                               class="px-6 py-3 bg-indigo-600 hover:bg-indigo-700 text-white font-semibold rounded-xl transition-all duration-300 shadow-lg hover:shadow-xl flex items-center space-x-2">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                                </svg>
                                <span>Edit E-Book</span>
                            </a>

                            <form action="{{ route('ebooks.destroy', $ebook) }}" method="POST" class="inline-block">
                                @csrf
                                @method('DELETE')
                                <button type="submit"
                                        onclick="return confirm('Apakah Anda yakin ingin menghapus e-book ini?')"
                                        class="px-6 py-3 bg-red-600 hover:bg-red-700 text-white font-semibold rounded-xl transition-all duration-300 shadow-lg hover:shadow-xl flex items-center space-x-2">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                                    </svg>
                                    <span>Hapus E-Book</span>
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
