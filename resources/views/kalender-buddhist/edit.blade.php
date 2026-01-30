@extends('layouts.app')

@section('title', 'Edit Acara Buddhist')

@section('header', 'Edit Acara Buddhist')

@section('content')
<div class="max-w-3xl mx-auto">
    <div class="bg-slate-800/70 backdrop-blur-sm rounded-2xl p-8 border border-slate-700/50 shadow-xl">
        <form action="{{ route('kalender-buddhist.update', $acaraBuddhist) }}" method="POST">
            @csrf
            @method('PUT')

            <!-- Tipe Acara -->
            <div class="mb-6">
                <label class="block text-sm font-semibold text-gray-300 mb-2">Tipe Acara</label>
                <select name="tipe_acara" required
                        class="w-full px-4 py-3 bg-slate-700/50 border border-slate-600 rounded-xl text-white focus:ring-2 focus:ring-indigo-500 focus:border-transparent transition">
                    <option value="">Pilih Tipe Acara</option>
                    <option value="waisak" {{ $acaraBuddhist->tipe_acara == 'waisak' ? 'selected' : '' }}>Hari Raya Waisak</option>
                    <option value="magha_puja" {{ $acaraBuddhist->tipe_acara == 'magha_puja' ? 'selected' : '' }}>Magha Puja</option>
                    <option value="asalha_puja" {{ $acaraBuddhist->tipe_acara == 'asalha_puja' ? 'selected' : '' }}>Asalha Puja</option>
                    <option value="kathina" {{ $acaraBuddhist->tipe_acara == 'kathina' ? 'selected' : '' }}>Kathina</option>
                    <option value="vassa_mulai" {{ $acaraBuddhist->tipe_acara == 'vassa_mulai' ? 'selected' : '' }}>Awal Vassa</option>
                    <option value="vassa_selesai" {{ $acaraBuddhist->tipe_acara == 'vassa_selesai' ? 'selected' : '' }}>Akhir Vassa</option>
                    <option value="pavarana" {{ $acaraBuddhist->tipe_acara == 'pavarana' ? 'selected' : '' }}>Pavarana</option>
                    <option value="custom" {{ $acaraBuddhist->tipe_acara == 'custom' ? 'selected' : '' }}>Khusus</option>
                </select>
                @error('tipe_acara')
                <p class="text-red-400 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <!-- Nama Acara -->
            <div class="mb-6">
                <label class="block text-sm font-semibold text-gray-300 mb-2">Nama Acara</label>
                <input type="text" name="nama" value="{{ old('nama', $acaraBuddhist->nama) }}" required
                       class="w-full px-4 py-3 bg-slate-700/50 border border-slate-600 rounded-xl text-white placeholder-gray-500 focus:ring-2 focus:ring-indigo-500 focus:border-transparent transition"
                       placeholder="Contoh: Hari Raya Waisak 2026">
                @error('nama')
                <p class="text-red-400 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <!-- Deskripsi -->
            <div class="mb-6">
                <label class="block text-sm font-semibold text-gray-300 mb-2">Deskripsi</label>
                <textarea name="deskripsi" rows="4"
                          class="w-full px-4 py-3 bg-slate-700/50 border border-slate-600 rounded-xl text-white placeholder-gray-500 focus:ring-2 focus:ring-indigo-500 focus:border-transparent transition"
                          placeholder="Deskripsi singkat tentang acara ini...">{{ old('deskripsi', $acaraBuddhist->deskripsi) }}</textarea>
                @error('deskripsi')
                <p class="text-red-400 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <!-- Tanggal -->
            <div class="mb-6">
                <label class="block text-sm font-semibold text-gray-300 mb-2">Tanggal</label>
                <input type="date" name="tanggal" value="{{ old('tanggal', $acaraBuddhist->tanggal->format('Y-m-d')) }}" required
                       class="w-full px-4 py-3 bg-slate-700/50 border border-slate-600 rounded-xl text-white focus:ring-2 focus:ring-indigo-500 focus:border-transparent transition">
                @error('tanggal')
                <p class="text-red-400 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <!-- Warna -->
            <div class="mb-6">
                <label class="block text-sm font-semibold text-gray-300 mb-2">Warna Highlight</label>
                <div class="flex items-center space-x-4">
                    <input type="color" name="warna" value="{{ old('warna', $acaraBuddhist->warna) }}"
                           class="h-12 w-20 bg-slate-700/50 border border-slate-600 rounded-xl cursor-pointer">
                    <span class="text-sm text-gray-400">Pilih warna untuk highlight di kalender</span>
                </div>
                @error('warna')
                <p class="text-red-400 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <!-- Berulang -->
            <div class="mb-6">
                <label class="flex items-center space-x-3 cursor-pointer">
                    <input type="checkbox" name="berulang" value="1" {{ old('berulang', $acaraBuddhist->berulang) ? 'checked' : '' }}
                           class="w-5 h-5 bg-slate-700/50 border-slate-600 rounded text-indigo-600 focus:ring-2 focus:ring-indigo-500">
                    <span class="text-sm text-gray-300">Acara berulang setiap tahun</span>
                </label>
                @error('berulang')
                <p class="text-red-400 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <!-- Status Aktif -->
            <div class="mb-8">
                <label class="flex items-center space-x-3 cursor-pointer">
                    <input type="checkbox" name="aktif" value="1" {{ old('aktif', $acaraBuddhist->aktif) ? 'checked' : '' }}
                           class="w-5 h-5 bg-slate-700/50 border-slate-600 rounded text-indigo-600 focus:ring-2 focus:ring-indigo-500">
                    <span class="text-sm text-gray-300">Acara aktif (ditampilkan di kalender)</span>
                </label>
                @error('aktif')
                <p class="text-red-400 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <!-- Tombol -->
            <div class="flex items-center justify-end space-x-4">
                <a href="{{ route('kalender-buddhist.index') }}"
                   class="px-6 py-3 bg-slate-700/50 hover:bg-slate-700 text-white rounded-xl font-semibold transition">
                    Batal
                </a>
                <button type="submit"
                        class="px-6 py-3 bg-indigo-600 hover:bg-indigo-700 text-white rounded-xl font-semibold transition">
                    Update Acara
                </button>
            </div>
        </form>
    </div>
</div>
@endsection
