@extends('layouts.app')

@section('title', 'Edit Dhammavachana')
@section('header', 'Edit Dhammavachana')

@section('content')
<div class="bg-white shadow rounded-lg p-6 max-w-2xl">
    <form action="{{ route('dhammavachana.update', $dhammavachana) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')

        <div class="mb-4">
            <label class="block text-gray-700 text-sm font-bold mb-2" for="title">
                Judul <span class="text-red-500">*</span>
            </label>
            <input
                type="text"
                name="title"
                id="title"
                value="{{ old('title', $dhammavachana->title) }}"
                class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline @error('title') border-red-500 @enderror"
                required
            >
            @error('title')
                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
            @enderror
        </div>

        <div class="mb-4">
            <label class="block text-gray-700 text-sm font-bold mb-2" for="description">
                Deskripsi <span class="text-red-500">*</span>
            </label>
            <textarea
                name="description"
                id="description"
                rows="4"
                class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline @error('description') border-red-500 @enderror"
                required
            >{{ old('description', $dhammavachana->description) }}</textarea>
            @error('description')
                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
            @enderror
        </div>

        <div class="mb-4">
            <label class="block text-gray-700 text-sm font-bold mb-2" for="category">
                Kategori <span class="text-red-500">*</span>
            </label>
            <input
                type="text"
                name="category"
                id="category"
                value="{{ old('category', $dhammavachana->category) }}"
                class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline @error('category') border-red-500 @enderror"
                required
            >
            @error('category')
                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
            @enderror
        </div>

        <div class="mb-4">
            <label class="block text-gray-700 text-sm font-bold mb-2" for="language">
                Bahasa <span class="text-red-500">*</span>
            </label>
            <select
                name="language"
                id="language"
                class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline @error('language') border-red-500 @enderror"
                required
            >
                <option value="Indonesia" {{ old('language', $dhammavachana->language) == 'Indonesia' ? 'selected' : '' }}>Indonesia</option>
                <option value="Pali" {{ old('language', $dhammavachana->language) == 'Pali' ? 'selected' : '' }}>Pali</option>
                <option value="English" {{ old('language', $dhammavachana->language) == 'English' ? 'selected' : '' }}>English</option>
            </select>
            @error('language')
                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
            @enderror
        </div>

        <div class="mb-4">
            <label class="block text-gray-700 text-sm font-bold mb-2" for="pages">
                Jumlah Halaman
            </label>
            <input
                type="number"
                name="pages"
                id="pages"
                value="{{ old('pages', $dhammavachana->pages) }}"
                class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline @error('pages') border-red-500 @enderror"
            >
            @error('pages')
                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
            @enderror
        </div>

        @if($dhammavachana->cover_image)
        <div class="mb-4">
            <label class="block text-gray-700 text-sm font-bold mb-2">Cover Saat Ini</label>
            <img src="{{ asset('storage/' . $dhammavachana->cover_image) }}" alt="Cover" class="h-32 w-24 object-cover rounded">
        </div>
        @endif

        <div class="mb-6">
            <label class="block text-gray-700 text-sm font-bold mb-2" for="pdf_file">
                File PDF (opsional - upload jika ingin mengganti)
            </label>
            <input
                type="file"
                name="pdf_file"
                id="pdf_file"
                accept=".pdf"
                class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline @error('pdf_file') border-red-500 @enderror"
            >
            <p class="text-gray-500 text-xs mt-1">Cover akan otomatis diambil dari halaman pertama PDF jika diupload. Max 20MB</p>
            @error('pdf_file')
                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
            @enderror
        </div>

        <div class="flex items-center gap-4">
            <button
                type="submit"
                class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline"
            >
                Update
            </button>
            <a
                href="{{ route('dhammavachana.index') }}"
                class="bg-gray-500 hover:bg-gray-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline"
            >
                Batal
            </a>
        </div>
    </form>
</div>
@endsection
