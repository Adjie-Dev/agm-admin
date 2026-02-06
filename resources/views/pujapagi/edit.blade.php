@extends('layouts.app')

@section('title', 'Edit Puja Pagi')

@section('header', 'Edit Puja Pagi')

@section('content')
<div class="max-w-4xl mx-auto">
    <!-- Back Button -->
    <div class="mb-6">
        <a href="{{ route('puja-pagi.index') }}"
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

            <form action="{{ route('puja-pagi.update', $pujaPagi) }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')

                <!-- Urutan & Judul -->
                <div class="grid grid-cols-1 md:grid-cols-4 gap-6 mb-6">
                    <div>
                        <label for="urutan" class="block text-sm font-medium text-gray-300 mb-2">
                            Urutan <span class="text-red-400">*</span>
                        </label>
                        <input type="number"
                               name="urutan"
                               id="urutan"
                               min="1"
                               value="{{ old('urutan', $pujaPagi->urutan) }}"
                               required
                               class="w-full px-4 py-3 bg-slate-900/50 border border-slate-700/50 rounded-xl text-white placeholder-gray-500 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all duration-200 @error('urutan') border-red-500 @enderror">
                        @error('urutan')
                        <p class="mt-1 text-sm text-red-400">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="md:col-span-3">
                        <label for="judul" class="block text-sm font-medium text-gray-300 mb-2">
                            Judul <span class="text-red-400">*</span>
                        </label>
                        <input type="text"
                               name="judul"
                               id="judul"
                               maxlength="150"
                               value="{{ old('judul', $pujaPagi->judul) }}"
                               required
                               placeholder="Contoh: Vandanā"
                               class="w-full px-4 py-3 bg-slate-900/50 border border-slate-700/50 rounded-xl text-white placeholder-gray-500 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all duration-200 @error('judul') border-red-500 @enderror">
                        @error('judul')
                        <p class="mt-1 text-sm text-red-400">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <!-- Current Audio Info -->
                @if($pujaPagi->audio_path)
                <div class="mb-6">
                    <label class="block text-sm font-medium text-gray-300 mb-3">
                        Audio Saat Ini
                    </label>
                    <div class="bg-slate-900/50 border border-slate-700/50 rounded-xl p-4">
                        <div class="flex items-center justify-between">
                            <div class="flex items-center space-x-3">
                                <div class="flex-shrink-0">
                                    <svg class="w-10 h-10 text-blue-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19V6l12-3v13M9 19c0 1.105-1.343 2-3 2s-3-.895-3-2 1.343-2 3-2 3 .895 3 2zm12-3c0 1.105-1.343 2-3 2s-3-.895-3-2 1.343-2 3-2 3 .895 3 2zM9 10l12-3"></path>
                                    </svg>
                                </div>
                                <div class="flex-1">
                                    <p class="text-white font-medium">{{ $pujaPagi->audio_nama_asli }}</p>
                                    <div class="flex items-center space-x-3 mt-1 text-sm text-gray-400">
                                        @if($pujaPagi->durasi)
                                        <span class="flex items-center space-x-1">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                            </svg>
                                            <span>{{ $pujaPagi->durasi }}</span>
                                        </span>
                                        @endif
                                        <span class="flex items-center space-x-1">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 21h10a2 2 0 002-2V9.414a1 1 0 00-.293-.707l-5.414-5.414A1 1 0 0012.586 3H7a2 2 0 00-2 2v14a2 2 0 002 2z"></path>
                                            </svg>
                                            <span>{{ $pujaPagi->audio_ukuran_formatted }}</span>
                                        </span>
                                    </div>
                                </div>
                            </div>
                            <div>
                                <audio controls class="h-10">
                                    <source src="{{ asset('storage/' . $pujaPagi->audio_path) }}" type="{{ $pujaPagi->audio_mime }}">
                                    Browser Anda tidak mendukung audio player.
                                </audio>
                            </div>
                        </div>
                    </div>
                </div>
                @endif

                <!-- Audio Upload -->
                <div class="mb-6">
                    <label for="audio" class="block text-sm font-medium text-gray-300 mb-2">
                        {{ $pujaPagi->audio_path ? 'Ganti File Audio' : 'Tambah File Audio' }}
                    </label>
                    <div class="relative">
                        <input type="file"
                               name="audio"
                               id="audio"
                               accept=".mp3,.wav,.ogg"
                               class="hidden"
                               onchange="updateFileName(this)">
                        <label for="audio"
                               class="flex items-center justify-center w-full px-4 py-8 bg-slate-900/50 border-2 border-dashed border-slate-700/50 rounded-xl cursor-pointer hover:border-blue-500/50 transition-all duration-200">
                            <div class="text-center">
                                <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19V6l12-3v13M9 19c0 1.105-1.343 2-3 2s-3-.895-3-2 1.343-2 3-2 3 .895 3 2zm12-3c0 1.105-1.343 2-3 2s-3-.895-3-2 1.343-2 3-2 3 .895 3 2zM9 10l12-3"></path>
                                </svg>
                                <p class="mt-2 text-sm text-gray-400">
                                    <span class="font-semibold text-blue-400">Klik untuk upload</span> atau drag & drop
                                </p>
                                <p class="text-xs text-gray-500 mt-1">MP3, WAV, OGG hingga 50MB</p>
                                @if($pujaPagi->audio_path)
                                <p class="text-xs text-amber-400 mt-2">Upload file baru akan mengganti audio yang ada</p>
                                @endif
                                <p id="file-name" class="text-sm text-green-400 mt-2 hidden"></p>
                            </div>
                        </label>
                    </div>
                    @error('audio')
                    <p class="mt-1 text-sm text-red-400">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Deskripsi -->
                <div class="mb-6">
                    <label for="deskripsi" class="block text-sm font-medium text-gray-300 mb-2">
                        Deskripsi
                    </label>
                    <textarea name="deskripsi"
                              id="deskripsi"
                              rows="4"
                              placeholder="Masukkan deskripsi singkat (opsional)..."
                              class="w-full px-4 py-3 bg-slate-900/50 border border-slate-700/50 rounded-xl text-white placeholder-gray-500 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all duration-200 @error('deskripsi') border-red-500 @enderror">{{ old('deskripsi', $pujaPagi->deskripsi) }}</textarea>
                    @error('deskripsi')
                    <p class="mt-1 text-sm text-red-400">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Teks Pali -->
                <div class="mb-6">
                    <label for="teks_pali" class="block text-sm font-medium text-gray-300 mb-2">
                        Teks Pali
                    </label>
                    <textarea name="teks_pali"
                              id="teks_pali"
                              rows="6"
                              placeholder="Masukkan teks dalam bahasa Pali..."
                              class="w-full px-4 py-3 bg-slate-900/50 border border-slate-700/50 rounded-xl text-white placeholder-gray-500 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all duration-200 font-mono @error('teks_pali') border-red-500 @enderror">{{ old('teks_pali', $pujaPagi->teks_pali) }}</textarea>
                    @error('teks_pali')
                    <p class="mt-1 text-sm text-red-400">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Terjemahan -->
                <div class="mb-6">
                    <label for="terjemahan" class="block text-sm font-medium text-gray-300 mb-2">
                        Terjemahan
                    </label>
                    <textarea name="terjemahan"
                              id="terjemahan"
                              rows="6"
                              placeholder="Masukkan terjemahan dalam bahasa Indonesia..."
                              class="w-full px-4 py-3 bg-slate-900/50 border border-slate-700/50 rounded-xl text-white placeholder-gray-500 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all duration-200 @error('terjemahan') border-red-500 @enderror">{{ old('terjemahan', $pujaPagi->terjemahan) }}</textarea>
                    @error('terjemahan')
                    <p class="mt-1 text-sm text-red-400">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Status Aktif -->
                <div class="mb-6">
                    <label class="flex items-center space-x-3 cursor-pointer">
                        <input type="checkbox"
                               name="aktif"
                               id="aktif"
                               value="1"
                               {{ old('aktif', $pujaPagi->aktif) ? 'checked' : '' }}
                               class="w-5 h-5 bg-slate-900/50 border-slate-700/50 rounded text-blue-600 focus:ring-2 focus:ring-blue-500">
                        <span class="text-gray-300 font-medium">Aktifkan section ini</span>
                    </label>
                </div>

                <!-- Divider -->
                <div class="border-t border-slate-700/50 my-6"></div>

                <!-- Actions -->
                <div class="flex items-center justify-end space-x-4">
                    <a href="{{ route('puja-pagi.index') }}"
                       class="px-6 py-3 bg-slate-700 hover:bg-slate-600 text-white font-semibold rounded-xl transition-all duration-300">
                        Batal
                    </a>
                    <button type="submit"
                            class="px-6 py-3 bg-blue-600 hover:bg-blue-700 text-white font-semibold rounded-xl transition-all duration-300 shadow-lg hover:shadow-xl flex items-center space-x-2">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                        </svg>
                        <span>Update</span>
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
function updateFileName(input) {
    const fileName = document.getElementById('file-name');
    if (input.files && input.files[0]) {
        fileName.textContent = '📁 ' + input.files[0].name;
        fileName.classList.remove('hidden');
    } else {
        fileName.classList.add('hidden');
    }
}
</script>
@endsection
