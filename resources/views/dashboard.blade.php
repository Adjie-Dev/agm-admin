@extends('layouts.app')

@section('title', 'Dashboard')

@section('header', 'Dashboard')

@section('content')
<div class="max-w-6xl mx-auto">
    <!-- Welcome Section -->
    <div class="bg-neutral-800 rounded-2xl p-8 mb-6 text-center">
        <h1 class="text-2xl font-bold text-white mb-2">Selamat Datang, {{ Auth::user()->name }}!</h1>
        <p class="text-neutral-300">Platform edukasi Buddhis dan praktik latihan Dharma harian</p>
    </div>

    <!-- Stats Cards -->
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
        <div class="bg-white rounded-xl p-6 border border-neutral-200">
            <div class="flex items-center justify-between mb-3">
                <div class="w-12 h-12 rounded-xl bg-amber-100 flex items-center justify-center">
                    <svg class="w-6 h-6 text-amber-700" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path>
                    </svg>
                </div>
            </div>
            <p class="text-sm text-neutral-600 mb-1">Total Konten</p>
            <p class="text-3xl font-bold text-neutral-800">{{ $totalDhammaVachana ?? 0 }}</p>
        </div>

        <div class="bg-white rounded-xl p-6 border border-neutral-200">
            <div class="flex items-center justify-between mb-3">
                <div class="w-12 h-12 rounded-xl bg-green-100 flex items-center justify-center">
                    <svg class="w-6 h-6 text-green-700" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                </div>
            </div>
            <p class="text-sm text-neutral-600 mb-1">Published</p>
            <p class="text-3xl font-bold text-neutral-800">{{ $publishedCount ?? 0 }}</p>
        </div>

        <div class="bg-white rounded-xl p-6 border border-neutral-200">
            <div class="flex items-center justify-between mb-3">
                <div class="w-12 h-12 rounded-xl bg-yellow-100 flex items-center justify-center">
                    <svg class="w-6 h-6 text-yellow-700" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z"></path>
                    </svg>
                </div>
            </div>
            <p class="text-sm text-neutral-600 mb-1">Draft</p>
            <p class="text-3xl font-bold text-neutral-800">{{ $draftCount ?? 0 }}</p>
        </div>
    </div>

    <!-- Quick Actions -->
    <div class="mb-8">
        <h2 class="text-xl font-bold text-neutral-800 mb-4">Aksi Cepat</h2>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
            <a href="{{ route('dhammavachana.create') }}" class="bg-white rounded-xl p-5 flex items-center border border-neutral-200 hover:border-amber-700 hover:shadow-md transition">
                <div class="w-14 h-14 rounded-xl bg-amber-100 flex items-center justify-center mr-4">
                    <svg class="w-7 h-7 text-amber-700" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                    </svg>
                </div>
                <div class="flex-1">
                    <p class="text-base font-bold text-neutral-800 mb-1">Tambah Konten Baru</p>
                    <p class="text-sm text-neutral-600">Buat Dhamma Vācanā baru</p>
                </div>
                <svg class="w-5 h-5 text-neutral-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                </svg>
            </a>

            <a href="{{ route('dhammavachana.index') }}" class="bg-white rounded-xl p-5 flex items-center border border-neutral-200 hover:border-amber-700 hover:shadow-md transition">
                <div class="w-14 h-14 rounded-xl bg-amber-100 flex items-center justify-center mr-4">
                    <svg class="w-7 h-7 text-amber-700" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 10h16M4 14h16M4 18h16"></path>
                    </svg>
                </div>
                <div class="flex-1">
                    <p class="text-base font-bold text-neutral-800 mb-1">Kelola Konten</p>
                    <p class="text-sm text-neutral-600">Lihat dan edit semua konten</p>
                </div>
                <svg class="w-5 h-5 text-neutral-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                </svg>
            </a>
        </div>
    </div>

    <!-- Recent Content -->
    @if(isset($recentContent) && count($recentContent) > 0)
    <div class="mb-8">
        <div class="flex items-center justify-between mb-4">
            <h2 class="text-xl font-bold text-neutral-800">Konten Terbaru</h2>
            <a href="{{ route('dhammavachana.index') }}" class="text-sm text-amber-700 font-semibold hover:text-amber-800">Lihat Semua →</a>
        </div>

        <div class="bg-white rounded-xl border border-neutral-200 overflow-hidden">
            @foreach($recentContent as $index => $content)
            <div class="p-5 flex items-center {{ $index > 0 ? 'border-t border-neutral-200' : '' }} hover:bg-neutral-50 transition">
                <div class="w-12 h-12 rounded-xl bg-amber-100 flex items-center justify-center mr-4 flex-shrink-0">
                    <span class="text-amber-700 font-bold text-lg">{{ substr($content->title, 0, 1) }}</span>
                </div>
                <div class="flex-1 min-w-0">
                    <p class="text-base font-bold text-neutral-800 mb-1 truncate">{{ $content->title }}</p>
                    <div class="flex items-center space-x-3">
                        <span class="px-2 py-1 text-xs rounded-full {{ $content->is_published ? 'bg-green-100 text-green-800' : 'bg-yellow-100 text-yellow-800' }}">
                            {{ $content->is_published ? 'Published' : 'Draft' }}
                        </span>
                        <span class="text-xs text-neutral-500">{{ $content->updated_at->diffForHumans() }}</span>
                    </div>
                </div>
                <a href="{{ route('dhammavachana.edit', $content) }}" class="ml-4 text-amber-700 hover:text-amber-800">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z"></path>
                    </svg>
                </a>
            </div>
            @endforeach
        </div>
    </div>
    @else
    <div class="bg-neutral-50 rounded-2xl p-12 text-center border border-neutral-200">
        <div class="w-16 h-16 rounded-full bg-amber-100 flex items-center justify-center mx-auto mb-4">
            <svg class="w-8 h-8 text-amber-700" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path>
            </svg>
        </div>
        <p class="text-lg font-bold text-neutral-800 mb-2">Belum Ada Konten</p>
        <p class="text-neutral-600 mb-6">Mulai dengan membuat Dhamma Vācanā pertama Anda</p>
        <a href="{{ route('dhammavachana.create') }}" class="inline-flex items-center px-6 py-3 bg-amber-700 text-white rounded-xl hover:bg-amber-800 transition font-semibold">
            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
            </svg>
            Buat Konten Pertama
        </a>
    </div>
    @endif

    <!-- Footer Quote -->
    <div class="bg-neutral-50 rounded-2xl p-8 text-center border border-neutral-200 mt-8">
        <svg class="w-8 h-8 text-amber-700 mx-auto mb-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6V4m0 2a2 2 0 100 4m0-4a2 2 0 110 4m-6 8a2 2 0 100-4m0 4a2 2 0 110-4m0 4v2m0-6V4m6 6v10m6-2a2 2 0 100-4m0 4a2 2 0 110-4m0 4v2m0-6V4"></path>
        </svg>
        <p class="text-lg font-bold text-neutral-800 mb-1">Sabbe Satta Bhavantu Sukhitatta</p>
        <p class="text-sm text-neutral-600">Semoga semua makhluk berbahagia</p>
    </div>
</div>
@endsection
