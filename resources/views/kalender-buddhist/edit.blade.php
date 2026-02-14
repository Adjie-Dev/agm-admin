@extends('layouts.app')

@section('title', 'Edit Acara Buddhist')

@section('header', 'Edit Acara Buddhist')

@section('content')
<style>
    /* Ganti warna ikon date dan time picker */
    input[type="date"]::-webkit-calendar-picker-indicator,
    input[type="time"]::-webkit-calendar-picker-indicator {
        filter: invert(1);
        cursor: pointer;
    }
</style>

<div class="max-w-3xl mx-auto">
    <div class="bg-slate-800/70 backdrop-blur-sm rounded-2xl p-8 border border-slate-700/50 shadow-xl">
        <form action="{{ route('kalender-buddhist.update', $acaraBuddhist->id) }}" method="POST">
            @csrf
            @method('PUT')

            <!-- Tipe Acara -->
            <div class="mb-6">
                <label class="block text-sm font-semibold text-gray-300 mb-2">Tipe Acara</label>
                <div class="relative">
                    <select name="tipe_acara" id="tipe_acara" required
                            class="w-full px-4 py-3 pr-12 bg-slate-700/50 border border-slate-600 rounded-xl text-white focus:ring-2 focus:ring-indigo-500 focus:border-transparent transition appearance-none">
                        <option value="" disabled>Pilih Tipe Acara</option>
                        <option value="waisak" {{ old('tipe_acara', $acaraBuddhist->tipe_acara) == 'waisak' ? 'selected' : '' }}>Hari Raya Waisak</option>
                        <option value="magha_puja" {{ old('tipe_acara', $acaraBuddhist->tipe_acara) == 'magha_puja' ? 'selected' : '' }}>Magha Puja</option>
                        <option value="asadha_puja" {{ old('tipe_acara', $acaraBuddhist->tipe_acara) == 'asadha_puja' ? 'selected' : '' }}>Asadha Puja</option>
                        <option value="kathina" {{ old('tipe_acara', $acaraBuddhist->tipe_acara) == 'kathina' ? 'selected' : '' }}>Kathina</option>
                        <option value="vassa_mulai" {{ old('tipe_acara', $acaraBuddhist->tipe_acara) == 'vassa_mulai' ? 'selected' : '' }}>Awal Vassa</option>
                        <option value="vassa_selesai" {{ old('tipe_acara', $acaraBuddhist->tipe_acara) == 'vassa_selesai' ? 'selected' : '' }}>Akhir Vassa</option>
                        <option value="pavarana" {{ old('tipe_acara', $acaraBuddhist->tipe_acara) == 'pavarana' ? 'selected' : '' }}>Pavarana</option>
                        <option value="custom" {{ old('tipe_acara', $acaraBuddhist->tipe_acara) == 'custom' ? 'selected' : '' }}>Khusus</option>
                    </select>
                    <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center pr-4 text-gray-400">
                        <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                        </svg>
                    </div>
                </div>
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
                <input type="date" name="tanggal" value="{{ old('tanggal', \Carbon\Carbon::parse($acaraBuddhist->tanggal)->format('Y-m-d')) }}" required
                       class="w-full px-4 py-3 bg-slate-700/50 border border-slate-600 rounded-xl text-white focus:ring-2 focus:ring-indigo-500 focus:border-transparent transition">
                @error('tanggal')
                <p class="text-red-400 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <!-- Waktu Mulai -->
            <div class="mb-6">
                <label class="block text-sm font-semibold text-gray-300 mb-2">Waktu Mulai</label>
                <input type="time" name="waktu_mulai" value="{{ old('waktu_mulai', $acaraBuddhist->waktu_mulai ? \Carbon\Carbon::parse($acaraBuddhist->waktu_mulai)->format('H:i') : '') }}"
                       class="w-full px-4 py-3 bg-slate-700/50 border border-slate-600 rounded-xl text-white focus:ring-2 focus:ring-indigo-500 focus:border-transparent transition">
                @error('waktu_mulai')
                <p class="text-red-400 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <!-- Waktu Selesai -->
            <div class="mb-6">
                <label class="block text-sm font-semibold text-gray-300 mb-2">Waktu Selesai</label>
                <input type="time" name="waktu_selesai" value="{{ old('waktu_selesai', $acaraBuddhist->waktu_selesai ? \Carbon\Carbon::parse($acaraBuddhist->waktu_selesai)->format('H:i') : '') }}"
                       class="w-full px-4 py-3 bg-slate-700/50 border border-slate-600 rounded-xl text-white focus:ring-2 focus:ring-indigo-500 focus:border-transparent transition">
                @error('waktu_selesai')
                <p class="text-red-400 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <!-- Warna -->
            <div class="mb-6" id="warna_container">
                <label class="block text-sm font-semibold text-gray-300 mb-2">Warna Highlight</label>
                <div class="flex items-center space-x-4">
                    <input type="color" id="warna_input" value="{{ old('warna', $acaraBuddhist->warna) }}"
                           class="h-12 w-20 bg-slate-700/50 border border-slate-600 rounded-xl cursor-pointer"
                           disabled>
                    <input type="hidden" name="warna" id="warna_hidden" value="{{ old('warna', $acaraBuddhist->warna) }}">
                    <span class="text-sm text-gray-400" id="warna_info">Pilih tipe acara untuk menentukan warna</span>
                </div>
                @error('warna')
                <p class="text-red-400 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <!-- Berulang -->
            <div class="mb-8">
                <label class="flex items-center space-x-3 cursor-pointer">
                    <input type="checkbox" name="berulang" value="1" {{ old('berulang', $acaraBuddhist->berulang) ? 'checked' : '' }}
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
                    Update Acara
                </button>
            </div>
        </form>
    </div>
</div>

<script>
    const DEVELOPER_OPACITY = 0.2;

    function hexToRgba(hex, opacity) {
        hex = hex.replace('#', '');

        let r, g, b;
        if (hex.length === 3) {
            r = parseInt(hex[0] + hex[0], 16);
            g = parseInt(hex[1] + hex[1], 16);
            b = parseInt(hex[2] + hex[2], 16);
        } else {
            r = parseInt(hex.substring(0, 2), 16);
            g = parseInt(hex.substring(2, 4), 16);
            b = parseInt(hex.substring(4, 6), 16);
        }

        return `rgba(${r}, ${g}, ${b}, ${opacity})`;
    }

    // TAMBAHAN: Fungsi untuk convert rgba ke hex
    function rgbaToHex(rgba) {
        // Extract rgb values from rgba string
        const match = rgba.match(/rgba?\((\d+),\s*(\d+),\s*(\d+)/);
        if (match) {
            const r = parseInt(match[1]);
            const g = parseInt(match[2]);
            const b = parseInt(match[3]);
            return "#" + ((1 << 24) + (r << 16) + (g << 8) + b).toString(16).slice(1);
        }
        return rgba; // Return original if not rgba format
    }

    const warnaAcara = {
        'waisak': '#fbbf24',
        'magha_puja': '#a78bfa',
        'asadha_puja': '#34d399',
        'kathina': '#f87171',
        'vassa_mulai': '#60a5fa',
        'vassa_selesai': '#fb923c',
        'pavarana': '#ec4899',
        'custom': '#6366f1'
    };

    const namaAcara = {
        'waisak': 'Hari Raya Waisak',
        'magha_puja': 'Magha Puja',
        'asadha_puja': 'Asadha Puja',
        'kathina': 'Kathina',
        'vassa_mulai': 'Awal Vassa',
        'vassa_selesai': 'Akhir Vassa',
        'pavarana': 'Pavarana'
    };

    const tipeAcaraSelect = document.getElementById('tipe_acara');
    const warnaInput = document.getElementById('warna_input');
    const warnaHidden = document.getElementById('warna_hidden');
    const warnaInfo = document.getElementById('warna_info');
    const namaInput = document.querySelector('input[name="nama"]');

    function updateWarna() {
        const currentHex = warnaInput.value;
        warnaHidden.value = hexToRgba(currentHex, DEVELOPER_OPACITY);
    }

    // Set initial state when page loads
    window.addEventListener('DOMContentLoaded', function() {
        const currentTipe = tipeAcaraSelect.value;

        // PERBAIKAN: Convert warna dari database (rgba) ke hex untuk color picker
        const currentWarnaHidden = warnaHidden.value;
        if (currentWarnaHidden.startsWith('rgba')) {
            warnaInput.value = rgbaToHex(currentWarnaHidden);
        }

        if (currentTipe === 'custom') {
            warnaInput.disabled = false;
            warnaInfo.textContent = 'Pilih warna custom untuk acara khusus';
            namaInput.readOnly = false;
        } else if (currentTipe !== '') {
            // PERBAIKAN: Set warna sesuai tipe acara yang sudah ada
            if (warnaAcara[currentTipe]) {
                warnaInput.value = warnaAcara[currentTipe];
            }
            warnaInput.disabled = true;
            warnaInfo.textContent = 'Warna otomatis berdasarkan tipe acara';
            namaInput.readOnly = true;
        }

        updateWarna();
    });

    tipeAcaraSelect.addEventListener('change', function() {
        const tipeAcara = this.value;

        if (tipeAcara === '') {
            warnaInput.value = '#6366f1';
            warnaInput.disabled = true;
            warnaInfo.textContent = 'Pilih tipe acara untuk menentukan warna';

            namaInput.readOnly = false;
            namaInput.placeholder = 'Contoh: Hari Raya Waisak 2026';

        } else if (tipeAcara === 'custom') {
            warnaInput.value = '#6366f1';
            warnaInput.disabled = false;
            warnaInfo.textContent = 'Pilih warna custom untuk acara khusus';

            namaInput.readOnly = false;
            namaInput.placeholder = 'Masukkan nama acara khusus';

        } else {
            warnaInput.value = warnaAcara[tipeAcara];
            warnaInput.disabled = true;
            warnaInfo.textContent = 'Warna otomatis berdasarkan tipe acara';

            namaInput.value = namaAcara[tipeAcara];
            namaInput.readOnly = true;
        }

        updateWarna();
    });

    warnaInput.addEventListener('input', function() {
        updateWarna();
    });
</script>
@endsection
