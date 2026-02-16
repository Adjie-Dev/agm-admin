@extends('layouts.app')

@section('title', 'Edit Amituojing')

@section('header', 'Edit Amituojing')

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

    <!-- Form Card -->
    <div class="bg-slate-800/70 backdrop-blur-sm rounded-2xl border border-slate-700/50 shadow-xl overflow-hidden">
        <div class="p-8">
            <h2 class="text-2xl font-bold text-white mb-6">Edit Section</h2>

            <x-puja-form :action="route('amituojing.update', $amituojing)"
                         method="PUT"
                         :backRoute="route('amituojing.index')"
                         submitLabel="Update"
                         :model="$amituojing"
                         :maxUrutan="17"
                         :includeDeskripsi="false" />

        </div>
    </div>
</div>

@endsection
