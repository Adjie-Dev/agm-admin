@extends('layouts.app')

@section('title', 'Edit E-Book')

@section('header', 'Edit E-Book')

@section('content')
<div class="max-w-4xl mx-auto">
    <!-- Back Button -->
    <div class="mb-6">
        <a href="{{ route('ebooks.index') }}"
           class="inline-flex items-center space-x-2 text-gray-400 hover:text-white transition-colors duration-200">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
            </svg>
            <span class="font-medium">Kembali ke E-Book</span>
        </a>
    </div>

    <!-- Form Card -->
    <div class="bg-slate-800/70 backdrop-blur-sm rounded-2xl p-8 border border-slate-700/50 shadow-xl">
        <form action="{{ route('ebooks.update', $ebook) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')

            <!-- Title -->
            <div class="mb-6">
                <label for="title" class="block text-sm font-semibold text-gray-300 mb-2">
                    Judul <span class="text-red-400">*</span>
                </label>
                <input type="text"
                       name="title"
                       id="title"
                       value="{{ old('title', $ebook->title) }}"
                       class="w-full px-4 py-3 bg-slate-900/50 border border-slate-700 rounded-xl text-white placeholder-gray-500 focus:outline-none focus:border-indigo-500 focus:ring-2 focus:ring-indigo-500/20 transition-all duration-200"
                       placeholder="Masukkan judul e-book"
                       required>
                @error('title')
                <p class="mt-2 text-sm text-red-400">{{ $message }}</p>
                @enderror
            </div>

            <!-- Description -->
            <div class="mb-6">
                <label for="description" class="block text-sm font-semibold text-gray-300 mb-2">
                    Deskripsi (Opsional)
                </label>
                <textarea name="description"
                          id="description"
                          rows="6"
                          class="w-full px-4 py-3 bg-slate-900/50 border border-slate-700 rounded-xl text-white placeholder-gray-500 focus:outline-none focus:border-indigo-500 focus:ring-2 focus:ring-indigo-500/20 transition-all duration-200"
                          placeholder="Masukkan deskripsi e-book">{{ old('description', $ebook->description) }}</textarea>
                @error('description')
                <p class="mt-2 text-sm text-red-400">{{ $message }}</p>
                @enderror
            </div>

            <!-- Current Cover -->
            @if($ebook->cover_image)
            <div class="mb-4">
                <label class="block text-sm font-semibold text-gray-300 mb-2">Cover Saat Ini</label>
                <div class="w-48 aspect-[3/4] bg-slate-700 rounded-xl border border-slate-600 overflow-hidden">
                    <img src="{{ asset('storage/' . $ebook->cover_image) }}"
                        alt="{{ $ebook->title }}"
                        class="w-full h-full object-cover" />
                </div>
            </div>
            @endif

            <!-- PDF File -->
            <div class="mb-8">
                <label for="pdf_file" class="block text-sm font-semibold text-gray-300 mb-2">
                    Ganti File PDF (Opsional)
                </label>
                <div class="relative">
                    <input type="file"
                           name="pdf_file"
                           id="pdf_file"
                           accept=".pdf"
                           class="hidden"
                           onchange="previewFile(event)">
                    <label for="pdf_file"
                           class="flex items-center justify-center w-full px-4 py-8 bg-slate-900/50 border-2 border-dashed border-slate-700 rounded-xl cursor-pointer hover:border-indigo-500 transition-all duration-200">
                        <div class="text-center" id="upload-placeholder">
                            <svg class="mx-auto w-12 h-12 text-gray-500 mb-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M15 13l-3-3m0 0l-3 3m3-3v12"></path>
                            </svg>
                            <p class="text-sm text-gray-400 mb-1">Klik untuk upload file PDF baru</p>
                            <p class="text-xs text-gray-500">Cover dan halaman akan otomatis diupdate jika PDF diganti</p>
                            <p class="text-xs text-gray-500 mt-1">Maksimal 50MB</p>
                        </div>
                        <div class="hidden" id="file-preview">
                            <div class="flex items-center space-x-3">
                                <svg class="w-8 h-8 text-red-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 21h10a2 2 0 002-2V9.414a1 1 0 00-.293-.707l-5.414-5.414A1 1 0 0012.586 3H7a2 2 0 00-2 2v14a2 2 0 002 2z"></path>
                                </svg>
                                <div>
                                    <p class="text-sm text-white font-medium" id="filename"></p>
                                    <p class="text-xs text-gray-400" id="filesize"></p>
                                </div>
                            </div>
                        </div>
                    </label>
                </div>
                <div class="mt-3 p-4 bg-blue-500/10 border border-blue-500/50 rounded-xl">
                    <p class="text-sm text-blue-400">
                        <strong>File PDF saat ini:</strong> {{ basename($ebook->pdf_file) }}
                    </p>
                    <p class="text-sm text-blue-400 mt-1">
                        <strong>Halaman:</strong> {{ $ebook->page_count }} halaman
                    </p>
                </div>
                @error('pdf_file')
                <p class="mt-2 text-sm text-red-400">{{ $message }}</p>
                @enderror
            </div>

            <!-- Action Buttons -->
            <div class="flex items-center justify-end space-x-4">
                <a href="{{ route('ebooks.index') }}"
                   class="px-6 py-3 bg-slate-700 hover:bg-slate-600 text-white font-semibold rounded-xl transition-all duration-300">
                    Batal
                </a>
                <button type="submit"
                        class="px-6 py-3 bg-indigo-600 hover:bg-indigo-700 text-white font-semibold rounded-xl transition-all duration-300 shadow-lg hover:shadow-xl flex items-center space-x-2">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                    </svg>
                    <span>Perbarui E-Book</span>
                </button>
            </div>
        </form>
    </div>
</div>

<script>
function previewFile(event) {
    const file = event.target.files[0];
    if (file) {
        const filename = file.name;
        const filesize = (file.size / 1024 / 1024).toFixed(2) + ' MB';

        document.getElementById('filename').textContent = filename;
        document.getElementById('filesize').textContent = filesize;
        document.getElementById('upload-placeholder').classList.add('hidden');
        document.getElementById('file-preview').classList.remove('hidden');
    }
}
</script>
@endsection
