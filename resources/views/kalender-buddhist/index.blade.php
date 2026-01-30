@extends('layouts.app')

@section('title', 'Kalender Buddhist')

@section('header', 'Kalender Buddhist')

@section('content')
<div class="max-w-7xl mx-auto">
    <!-- Header dengan navigasi bulan -->
    <div class="bg-slate-800/70 backdrop-blur-sm rounded-2xl p-6 mb-6 border border-slate-700/50 shadow-xl">
        <div class="flex items-center justify-between">
            <!-- Navigasi Bulan -->
            <div class="flex items-center space-x-4">
                <a href="{{ route('kalender-buddhist.index', ['tahun' => $bulan == 1 ? $tahun - 1 : $tahun, 'bulan' => $bulan == 1 ? 12 : $bulan - 1]) }}"
                   class="p-2 rounded-lg bg-slate-700/50 hover:bg-slate-700 transition">
                    <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path>
                    </svg>
                </a>

                <h2 class="text-2xl font-bold text-white">
                    {{ $tanggalPertama->locale('id')->isoFormat('MMMM YYYY') }}
                </h2>

                <a href="{{ route('kalender-buddhist.index', ['tahun' => $bulan == 12 ? $tahun + 1 : $tahun, 'bulan' => $bulan == 12 ? 1 : $bulan + 1]) }}"
                   class="p-2 rounded-lg bg-slate-700/50 hover:bg-slate-700 transition">
                    <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                    </svg>
                </a>
            </div>

            <!-- Tombol Tambah Acara -->
            <a href="{{ route('kalender-buddhist.create') }}"
               class="px-6 py-3 bg-indigo-600 hover:bg-indigo-700 text-white rounded-xl font-semibold transition flex items-center space-x-2">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                </svg>
                <span>Tambah Acara</span>
            </a>
        </div>
    </div>

    <!-- Legend -->
    <div class="bg-slate-800/70 backdrop-blur-sm rounded-2xl p-6 mb-6 border border-slate-700/50 shadow-xl">
        <h3 class="text-lg font-bold text-white mb-4">Keterangan</h3>
        <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
            <div class="flex items-center space-x-2">
                <div class="w-4 h-4 rounded-full bg-cyan-500"></div>
                <span class="text-sm text-gray-300">Hari Uposatha (Purnama)</span>
            </div>
            <div class="flex items-center space-x-2">
                <div class="w-4 h-4 rounded-full bg-amber-500"></div>
                <span class="text-sm text-gray-300">Hari Raya Waisak</span>
            </div>
            <div class="flex items-center space-x-2">
                <div class="w-4 h-4 rounded-full bg-purple-500"></div>
                <span class="text-sm text-gray-300">Magha Puja</span>
            </div>
            <div class="flex items-center space-x-2">
                <div class="w-4 h-4 rounded-full bg-emerald-500"></div>
                <span class="text-sm text-gray-300">Asalha Puja</span>
            </div>
        </div>
    </div>

    <!-- Kalender -->
    <div class="bg-slate-800/70 backdrop-blur-sm rounded-2xl p-6 border border-slate-700/50 shadow-xl max-w-4xl mx-auto">
        <!-- Header Hari -->
        <div class="grid grid-cols-7 gap-1.5 mb-3">
            @foreach(['Minggu', 'Senin', 'Selasa', 'Rabu', 'Kamis', 'Jumat', 'Sabtu'] as $hari)
            <div class="text-center py-1.5 text-xs font-bold text-gray-400">
                {{ $hari }}
            </div>
            @endforeach
        </div>

        <!-- Tanggal -->
        <div class="grid grid-cols-7 gap-1.5">
            @php
                $tanggalSekarang = $tanggalPertama->copy()->startOfWeek(Carbon\Carbon::SUNDAY);
                $tanggalAkhir = $tanggalPertama->copy()->endOfMonth()->endOfWeek(Carbon\Carbon::SATURDAY);
            @endphp

            @while($tanggalSekarang <= $tanggalAkhir)
                @php
                    $tanggalStr = $tanggalSekarang->format('Y-m-d');
                    $adaDiBulanIni = $tanggalSekarang->month == $bulan;
                    $hariIni = $tanggalSekarang->isToday();
                    $faseBulanHariIni = $faseBulan->get($tanggalStr);
                    $acaraHariIni = $acaraBuddhist->get($tanggalStr);

                    // Cek apakah ada Uposatha
                    $uposathaHariIni = null;
                    if ($faseBulanHariIni && $faseBulanHariIni->adalahHariUposatha()) {
                        $uposathaHariIni = $aturanUposatha->get($faseBulanHariIni->fase);
                    }
                @endphp

                <div class="relative rounded-xl border transition overflow-hidden"
                     style="aspect-ratio: 1/1;"
                     class="{{ $adaDiBulanIni ? 'bg-slate-700/30 border-slate-600/50' : 'bg-slate-900/20 border-slate-800/50' }}
                    {{ $hariIni ? 'ring-2 ring-indigo-500' : '' }}">

                    @if($uposathaHariIni || $acaraHariIni)
                        <!-- Jika ada acara, background FULL -->
                        <div class="absolute inset-0 rounded-[inherit] flex items-center justify-center"
                             style="background-color: {{ $acaraHariIni ? $acaraHariIni->warna : $uposathaHariIni->warna }};">
                            <span class="text-sm font-bold text-white text-center px-2">
                                {{ $acaraHariIni ? $acaraHariIni->nama : $uposathaHariIni->nama_acara }}
                            </span>
                        </div>

                        <!-- Nomor tanggal di pojok kiri atas dengan background semi-transparan -->
                        <div class="absolute top-2 left-2 right-2 flex items-center justify-between z-10">
                            <span class="text-sm font-bold bg-black/40 px-2 py-1 rounded {{ $adaDiBulanIni ? 'text-white' : 'text-gray-400' }}">
                                {{ $tanggalSekarang->day }}
                            </span>
                            @if($faseBulanHariIni)
                            <span class="text-xs bg-black/40 px-1.5 py-0.5 rounded" title="{{ $faseBulanHariIni->nama_tampilan }}">
                                {{ ['bulan_baru' => '🌑', 'paruh_pertama' => '🌓', 'purnama' => '🌕', 'paruh_akhir' => '🌗'][$faseBulanHariIni->fase] ?? '' }}
                            </span>
                            @endif
                        </div>
                    @else
                        <!-- Jika tidak ada acara, tampilan normal -->
                        <div class="absolute top-2 left-2 right-2 flex items-center justify-between">
                            <span class="text-sm font-bold {{ $adaDiBulanIni ? 'text-white' : 'text-gray-600' }}">
                                {{ $tanggalSekarang->day }}
                            </span>
                            @if($faseBulanHariIni)
                            <span class="text-xs" title="{{ $faseBulanHariIni->nama_tampilan }}">
                                {{ ['bulan_baru' => '🌑', 'paruh_pertama' => '🌓', 'purnama' => '🌕', 'paruh_akhir' => '🌗'][$faseBulanHariIni->fase] ?? '' }}
                            </span>
                            @endif
                        </div>
                    @endif
                </div>

                @php $tanggalSekarang->addDay(); @endphp
            @endwhile
        </div>
    </div>

    <!-- Daftar Acara Bulan Ini -->
    <div class="bg-slate-800/70 backdrop-blur-sm rounded-2xl p-6 mt-6 border border-slate-700/50 shadow-xl">
        <h3 class="text-lg font-bold text-white mb-4">Daftar Acara Bulan Ini</h3>

        @if($acaraBuddhist->count() > 0)
        <div class="space-y-3">
            @foreach($acaraBuddhist->sortBy('tanggal') as $acara)
            <div class="flex items-center justify-between p-4 rounded-xl bg-slate-700/30 border border-slate-600/50 hover:bg-slate-700/50 transition">
                <div class="flex items-center space-x-4">
                    <div class="w-3 h-3 rounded-full" style="background-color: {{ $acara->warna }};"></div>
                    <div>
                        <p class="font-semibold text-white">{{ $acara->nama }}</p>
                        <p class="text-sm text-gray-400">{{ $acara->tanggal->locale('id')->isoFormat('dddd, D MMMM YYYY') }}</p>
                        @if($acara->deskripsi)
                        <p class="text-xs text-gray-500 mt-1">{{ $acara->deskripsi }}</p>
                        @endif
                    </div>
                </div>

                <div class="flex items-center space-x-2">
                    <a href="{{ route('kalender-buddhist.edit', $acara) }}"
                       class="p-2 rounded-lg bg-blue-600/20 hover:bg-blue-600/40 text-blue-400 transition">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                        </svg>
                    </a>

                    <form action="{{ route('kalender-buddhist.destroy', $acara) }}" method="POST" class="inline">
                        @csrf
                        @method('DELETE')
                        <button type="submit"
                                onclick="return confirm('Yakin ingin menghapus acara ini?')"
                                class="p-2 rounded-lg bg-red-600/20 hover:bg-red-600/40 text-red-400 transition">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                            </svg>
                        </button>
                    </form>
                </div>
            </div>
            @endforeach
        </div>
        @else
        <p class="text-center text-gray-500 py-8">Tidak ada acara di bulan ini</p>
        @endif
    </div>
</div>

@if(session('success'))
<div x-data="{ show: true }" x-show="show" x-init="setTimeout(() => show = false, 3000)"
     class="fixed bottom-4 right-4 bg-green-600 text-white px-6 py-3 rounded-xl shadow-xl">
    {{ session('success') }}
</div>
@endif
@endsection
