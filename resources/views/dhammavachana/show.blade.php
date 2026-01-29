@extends('layouts.app')

@section('title', $dhammavachana->title)
@section('header', $dhammavachana->title)

@section('content')
<div class="bg-white shadow rounded-lg p-6">
    <div class="mb-6">
        <a href="{{ route('dhammavachana.index') }}" class="text-blue-600 hover:text-blue-800">← Kembali</a>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
        <div class="md:col-span-1">
            @if($dhammavachana->cover_image)
                <img src="{{ asset('storage/' . $dhammavachana->cover_image) }}" alt="{{ $dhammavachana->title }}" class="w-full rounded shadow">
            @else
                <div class="w-full h-96 bg-gray-200 rounded flex items-center justify-center">
                    <span class="text-6xl">📄</span>
                </div>
            @endif
        </div>

        <div class="md:col-span-2">
            <h2 class="text-2xl font-bold mb-4">{{ $dhammavachana->title }}</h2>

            <div class="space-y-3 mb-6">
                <p><strong>Author:</strong> {{ $dhammavachana->author ?? 'Unknown' }}</p>
                <p><strong>Kategori:</strong> {{ $dhammavachana->category ?? '-' }}</p>
                <p><strong>Bahasa:</strong> {{ $dhammavachana->language ?? '-' }}</p>
                <p><strong>Halaman:</strong> {{ $dhammavachana->page_count }} halaman</p>
                <p><strong>Diupload oleh:</strong> {{ $dhammavachana->uploader->name ?? 'Unknown' }}</p>
                <p><strong>Tanggal:</strong> {{ $dhammavachana->created_at->format('d M Y') }}</p>
            </div>

            @if($dhammavachana->description)
            <div class="mb-6">
                <h3 class="font-bold mb-2">Deskripsi:</h3>
                <p class="text-gray-700">{{ $dhammavachana->description }}</p>
            </div>
            @endif

            <div class="flex space-x-3">
                <a href="{{ asset('storage/' . $dhammavachana->pdf_path) }}" target="_blank" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                    Buka PDF
                </a>
                <a href="{{ route('dhammavachana.edit', $dhammavachana) }}" class="bg-green-500 hover:bg-green-700 text-white font-bold py-2 px-4 rounded">
                    Edit
                </a>
            </div>
        </div>
    </div>
</div>
@endsection
