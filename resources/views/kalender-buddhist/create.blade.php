@extends('layouts.app')

@section('title', 'Tambah Acara Buddhist')

@section('header', 'Tambah Acara Buddhist')

@section('content')
<div class="max-w-3xl mx-auto">
    <div class="bg-slate-800/70 backdrop-blur-sm rounded-2xl p-8 border border-slate-700/50 shadow-xl">
        <form action="{{ route('kalender-buddhist.store') }}" method="POST">
            @csrf

            <!-- Tipe Acara -->
            <div class="mb-6">
                <label class="block text-sm font-semibold text-gray-300 mb-2">Tipe Acara</label>
                <select name="tipe_acara" required
                        class="w-full px-4 py-3 bg-slate-700/50 border border-slate-600 rounded-xl text-white focus:ring-2 focus:ring-indigo-500 focus:border-transparent transition">
                    <option value="">Pilih Tipe Acara</option>
                    <option value="waisak">Hari Raya Waisak</option>
                    <option value="magha_puja">Magha Puja</option>
                    <option value="asalha_puja">Asalha Puja</option>
                    <option value="kathina">Kathina</option>
                    <option value="vassa_mulai">Awal Vassa</option>
                    <option value="vassa_selesai">Akhir Vassa</option>
                    <option value="pavarana">Pavarana</option>
                    <option value="custom">Khusus</option>
                </select>
                @error('tipe_acara')
                <p class="text-red-400 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <!-- Nama Acara -->
            <div class="mb-6">
                <label class="block text-sm font-semibold text-gray-300 mb-2">Nama Acara</label>
                <input type="text" name="nama" value="{{ old('nama') }}" required
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
                          placeholder="Deskripsi singkat tentang acara ini...">{{ old('deskripsi') }}</textarea>
                @error('deskripsi')
                <p class="text-red-400 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <!-- Tanggal -->
            <div class="mb-6">
                <label class="block text-sm font-semibold text-gray-300 mb-2">Tanggal</label>
                <input type="date" name="tanggal" value="{{ old('tanggal') }}" required
                       class="w-full px-4 py-3 bg-slate-700/50 border border-slate-600 rounded-xl text-white focus:ring-2 focus:ring-indigo-500 focus:border-transparent transition">
                @error('tanggal')
                <p class="text-red-400 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <!-- Warna -->
            <div class="mb-6">
                <label class="block text-sm font-semibold text-gray-300 mb-2">Warna Highlight</label>
                <div class="flex items-center space-x-4">
                    <input type="color" name="warna" value="{{ old('warna', '#6366f1') }}"
                           class="h-12 w-20 bg-slate-700/50 border border-slate-600 rounded-xl cursor-pointer">
                    <span class="text-sm text-gray-400">Pilih warna untuk highlight di kalender</span>
                </div>
                @error('warna')
                <p class="text-red-400 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <!-- Berulang -->
            <div class="mb-8">
                <label class="flex items-center space-x-3 cursor-pointer">
                    <input type="checkbox" name="berulang" value="1" {{ old('berulang') ? 'checked' : '' }}
                           class="w-5 h-5 bg-slate-700/50 border-slate-600 rounded text-indigo-600 focus:ring-2 focus:ring-indigo-500">
                    <span class="text-sm text-gray-300">Acara berulang setiap tahun</span>
                </label>
                @error('berulang')
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
                    Simpan Acara
                </button>
            </div>
        </form>
    </div>
</div>
@endsection
