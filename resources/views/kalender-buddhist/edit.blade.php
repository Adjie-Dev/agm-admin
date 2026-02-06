@extends('layouts.app')

@section('title', 'Kalender Buddhist')

@section('header', 'Kalender Buddhist')

@section('content')
<div class="max-w-7xl mx-auto" x-data="kalenderData()" x-init="init()">
    <!-- TOP HEADER dengan Navigasi Bulan dan Tombol Action -->
    <div class="bg-slate-800/70 backdrop-blur-sm rounded-2xl p-6 mb-6 border border-slate-700/50 shadow-xl">
        <div class="flex items-center justify-between mb-4">
            <!-- Judul Bulan dengan Navigasi -->
            <div class="flex items-center space-x-4">
                <button @click="navigatePrevMonth()"
                        class="p-2 rounded-lg bg-slate-700/50 hover:bg-slate-700 transition">
                    <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path>
                    </svg>
                </button>

                <h2 class="text-2xl font-bold text-white" x-text="getHeaderTitle()">
                    {{ $tanggalPertama->locale('id')->isoFormat('MMMM YYYY') }}
                </h2>

                <button @click="navigateNextMonth()"
                        class="p-2 rounded-lg bg-slate-700/50 hover:bg-slate-700 transition">
                    <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                    </svg>
                </button>

                <span class="px-3 py-1 rounded-lg bg-slate-700/50 text-white text-sm font-semibold">
                    New Schedule
                </span>
            </div>

            <!-- Tombol Action Kanan -->
            <div class="flex items-center space-x-3">
                <a href="{{ route('kalender-buddhist.create') }}"
                    class="px-5 py-2.5 bg-indigo-600 hover:bg-indigo-700 text-white rounded-xl font-semibold transition flex items-center space-x-2">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                    </svg>
                    <span>Tambah Acara</span>
                </a>
            </div>
        </div>

        <!-- Tab Filter View -->
        <div class="flex items-center space-x-2">
            <button @click="changeView('daily')"
                    :class="currentView === 'daily' ? 'bg-indigo-600 shadow-md' : 'bg-slate-700/50 hover:bg-slate-700'"
                    class="px-4 py-2 rounded-lg text-white text-sm font-semibold transition">
                Daily
            </button>
            <button @click="changeView('weekly')"
                    :class="currentView === 'weekly' ? 'bg-indigo-600 shadow-md' : 'bg-slate-700/50 hover:bg-slate-700'"
                    class="px-4 py-2 rounded-lg text-white text-sm font-semibold transition">
                Weekly
            </button>
            <button @click="changeView('monthly')"
                    :class="currentView === 'monthly' ? 'bg-indigo-600 shadow-md' : 'bg-slate-700/50 hover:bg-slate-700'"
                    class="px-4 py-2 rounded-lg text-white text-sm font-semibold transition">
                Monthly
            </button>
            <button @click="changeView('yearly')"
                    :class="currentView === 'yearly' ? 'bg-indigo-600 shadow-md' : 'bg-slate-700/50 hover:bg-slate-700'"
                    class="px-4 py-2 rounded-lg text-white text-sm font-semibold transition">
                Yearly
            </button>
        </div>
    </div>

    <!-- HEADER Tanggal Minggu - Tampil untuk Weekly dan Monthly -->
    <div x-show="currentView === 'weekly' || currentView === 'monthly'"
         x-transition
         x-data="weekHeaderData()"
         x-init="generateWeekDates()"
         class="bg-slate-800/70 backdrop-blur-sm rounded-xl mb-4 border border-slate-700/50 shadow-xl">
        <div class="grid grid-cols-7 gap-2 p-3">
            <template x-for="(day, index) in weekDates" :key="index">
                <div class="text-center p-2 rounded-lg transition-all duration-300 cursor-pointer"
                     :class="day.isToday ? 'border-2 border-indigo-500 text-white' : 'bg-slate-700/30 text-white hover:bg-slate-700/50'"
                     @click="navigateToDate(day.fullDate)">
                    <div class="text-lg font-bold" x-text="day.date"></div>
                    <div class="text-xs uppercase font-semibold tracking-wider" x-text="day.name"></div>
                </div>
            </template>
        </div>
    </div>

    <!-- Grid 2 Kolom: Kalender Utama + Sidebar -->
    <div class="grid grid-cols-1 lg:grid-cols-4 gap-6">
        <!-- KALENDER UTAMA - 3 Kolom (KIRI) -->
        <div class="lg:col-span-3">
            <div class="bg-slate-800/70 backdrop-blur-sm rounded-2xl p-6 border border-slate-700/50 shadow-xl">

                <!-- DAILY VIEW - Google Calendar Style -->
                <div x-show="currentView === 'daily'" x-transition>
                    <!-- Header Tanggal - Dynamic with Alpine -->
                    <div class="mb-4 pb-3 border-b border-slate-600/50">
                        <h3 class="text-xl font-bold text-white" x-text="getHeaderTitle()"></h3>
                    </div>

                    <!-- Grid dengan Time Sidebar -->
                    <div class="flex max-h-[700px] overflow-y-auto">
                        <!-- Sidebar Waktu -->
                        <div class="w-16 flex-shrink-0 border-r border-slate-600/30 pr-2">
                            <template x-for="hour in 24" :key="hour">
                                <div class="h-12 flex items-start justify-end text-xs text-gray-500 font-medium">
                                    <span x-text="String(hour - 1).padStart(2, '0') + ':00'"></span>
                                </div>
                            </template>
                        </div>

                        <!-- Area Event -->
                        <div class="flex-1 pl-4 relative">
                            <template x-for="hour in 24" :key="hour">
                                <div class="h-12 border-b border-slate-700/30"></div>
                            </template>

                            <!-- Event Display - Dynamic based on currentDate -->
                            @php
                                // Prepare events data untuk JavaScript
                                $eventsForJs = [];

                                // Cek tipe data $acaraBuddhist
                                if ($acaraBuddhist instanceof \Illuminate\Support\Collection) {
                                    // Jika Collection, loop langsung
                                    foreach($acaraBuddhist as $acara) {
                                        $tanggalKey = $acara->tanggal instanceof \Carbon\Carbon
                                            ? $acara->tanggal->format('Y-m-d')
                                            : (string)$acara->tanggal;

                                        $eventsForJs[$tanggalKey] = [
                                            'nama' => $acara->nama,
                                            'deskripsi' => $acara->deskripsi ?? '',
                                            'waktu_mulai' => $acara->waktu_mulai ?? '',
                                            'waktu_selesai' => $acara->waktu_selesai ?? '',
                                            'warna' => $acara->warna
                                        ];
                                    }
                                } else {
                                    // Jika array dengan key tanggal
                                    foreach($acaraBuddhist as $tanggal => $acara) {
                                        if (is_object($acara)) {
                                            $eventsForJs[$tanggal] = [
                                                'nama' => $acara->nama,
                                                'deskripsi' => $acara->deskripsi ?? '',
                                                'waktu_mulai' => $acara->waktu_mulai ?? '',
                                                'waktu_selesai' => $acara->waktu_selesai ?? '',
                                                'warna' => $acara->warna
                                            ];
                                        }
                                    }
                                }
                            @endphp

                            <div x-data="dailyEventDisplay()"
                                 data-events='@json($eventsForJs)'
                                 x-init="loadEvents()">
                                <template x-if="currentEvent">
                                    <div class="absolute left-4 right-4 rounded-lg p-4 shadow-lg cursor-pointer hover:shadow-xl transition"
                                         :style="'background-color: ' + currentEvent.warna + '; top: ' + getEventPosition(currentEvent) + 'px;'">
                                        <template x-if="currentEvent.waktu_mulai">
                                            <div class="text-xs text-white/80 mb-1">
                                                <span x-text="currentEvent.waktu_mulai.substring(0, 5)"></span>
                                                <template x-if="currentEvent.waktu_selesai">
                                                    <span> - <span x-text="currentEvent.waktu_selesai.substring(0, 5)"></span></span>
                                                </template>
                                            </div>
                                        </template>
                                        <h4 class="text-lg font-bold text-white mb-1" x-text="currentEvent.nama"></h4>
                                        <template x-if="currentEvent.deskripsi">
                                            <p class="text-sm text-white/90" x-text="currentEvent.deskripsi"></p>
                                        </template>
                                    </div>
                                </template>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- WEEKLY VIEW - Google Calendar Style -->
                <div x-show="currentView === 'weekly'" x-transition x-data="weeklyViewData()" x-init="initWeekly()">
                    <!-- Header Hari -->
                    <div class="flex border-b border-slate-600/50 mb-4 pb-2">
                        <div class="w-16"></div>
                        <template x-for="(day, index) in weekDays" :key="index">
                            <div class="flex-1 text-center">
                                <div class="text-xs text-gray-400 uppercase font-semibold" x-text="day.dayName"></div>
                                <div class="text-2xl font-bold mt-1"
                                     :class="day.isToday ? 'text-indigo-400' : 'text-white'"
                                     x-text="day.day"></div>
                            </div>
                        </template>
                    </div>

                    <!-- Grid dengan Time Sidebar -->
                    <div class="flex max-h-[600px] overflow-y-auto">
                        <!-- Sidebar Waktu -->
                        <div class="w-16 flex-shrink-0 border-r border-slate-600/30 pr-2">
                            <template x-for="hour in 24" :key="hour">
                                <div class="h-12 flex items-start justify-end text-xs text-gray-500 font-medium">
                                    <span x-text="String(hour - 1).padStart(2, '0') + ':00'"></span>
                                </div>
                            </template>
                        </div>

                        <!-- Area Event per Hari -->
                        <div class="flex-1 flex">
                            <template x-for="(day, index) in weekDays" :key="index">
                                <div class="flex-1 border-r border-slate-700/30 relative">
                                    <template x-for="hour in 24" :key="hour">
                                        <div class="h-12 border-b border-slate-700/30"></div>
                                    </template>

                                    <!-- Event Display -->
                                    <template x-if="day.event">
                                        <div class="absolute left-1 right-1 rounded p-2 text-xs cursor-pointer hover:shadow-lg transition"
                                             :style="'background-color: ' + day.event.warna + '; top: ' + getEventPosition(day.event) + 'px;'">
                                            <template x-if="day.event.waktu_mulai">
                                                <div class="text-[10px] text-white/80 mb-0.5">
                                                    <span x-text="day.event.waktu_mulai.substring(0, 5)"></span>
                                                </div>
                                            </template>
                                            <div class="font-bold text-white truncate" x-text="day.event.nama"></div>
                                        </div>
                                    </template>
                                </div>
                            </template>
                        </div>
                    </div>
                </div>

                <!-- MONTHLY VIEW -->
                <div x-show="currentView === 'monthly'" x-transition x-data="monthlyViewData()" x-init="initMonthly()">
                    <div class="grid grid-cols-7 gap-3">
                        <template x-for="(dayData, index) in monthDays" :key="index">
                            <div class="min-h-[140px] rounded-xl border overflow-hidden"
                                 :class="[
                                     dayData.isToday ? 'ring-2 ring-indigo-500/70' : '',
                                     dayData.isCurrentMonth ? 'border-slate-600/50' : 'border-slate-800/50'
                                 ]">
                                <template x-if="dayData.event">
                                    <div class="h-full flex flex-col cursor-pointer hover:scale-105 transition-transform"
                                         :style="'background-color: ' + dayData.event.warna">
                                        <div class="p-3 pb-2">
                                            <div class="text-base font-bold text-white/90 mb-2" x-text="dayData.day"></div>
                                        </div>
                                        <div class="flex-1 px-3 pb-3">
                                            <template x-if="dayData.event.waktu_mulai">
                                                <div class="text-[10px] text-white/80 mb-1">
                                                    <span x-text="dayData.event.waktu_mulai.substring(0, 5)"></span>
                                                    <template x-if="dayData.event.waktu_selesai">
                                                        <span> - <span x-text="dayData.event.waktu_selesai.substring(0, 5)"></span></span>
                                                    </template>
                                                </div>
                                            </template>
                                            <div class="font-semibold text-white text-sm leading-tight mb-1" x-text="dayData.event.nama"></div>
                                            <template x-if="dayData.event.deskripsi">
                                                <div class="text-white/90 text-xs leading-tight line-clamp-2" x-text="dayData.event.deskripsi"></div>
                                            </template>
                                        </div>
                                    </div>
                                </template>
                                <template x-if="!dayData.event">
                                    <div class="h-full p-3"
                                         :class="dayData.isCurrentMonth ? 'bg-slate-700/40' : 'bg-slate-900/20'">
                                        <div class="text-base font-bold"
                                             :class="dayData.isCurrentMonth ? 'text-white' : 'text-gray-600'"
                                             x-text="dayData.day"></div>
                                    </div>
                                </template>
                            </div>
                        </template>
                    </div>
                </div>

                <!-- YEARLY VIEW - Google Calendar Style -->
                <div x-show="currentView === 'yearly'" x-transition x-data="yearlyViewData()" x-init="initYearly()">
                    <div class="grid grid-cols-4 gap-4">
                        <template x-for="(monthData, mIndex) in yearMonths" :key="mIndex">
                            <div class="bg-slate-700/40 rounded-xl p-4 border border-slate-600/50 hover:bg-slate-700/60 transition cursor-pointer"
                                @click="navigateToMonth(monthData.year, monthData.month, true)">
                                <!-- Header Bulan -->
                                <h4 class="text-sm font-bold text-white mb-3 text-center" x-text="monthData.name"></h4>

                                <!-- Mini Calendar Grid -->
                                <div class="grid grid-cols-7 gap-1">
                                    <!-- Header Hari -->
                                    <template x-for="dayName in ['S', 'S', 'R', 'K', 'J', 'S', 'M']">
                                        <div class="text-center text-[9px] font-semibold text-gray-500" x-text="dayName"></div>
                                    </template>

                                    <!-- Empty cells before first day -->
                                    <template x-for="i in monthData.startDayOfWeek" :key="'empty-' + i">
                                        <div class="aspect-square"></div>
                                    </template>

                                    <!-- Days -->
                                    <template x-for="day in monthData.days" :key="day.dateStr">
                                        <div class="aspect-square flex items-center justify-center">
                                            <template x-if="day.hasEvent">
                                                <div class="w-6 h-6 rounded-full flex items-center justify-center text-[10px] font-bold text-white"
                                                     :style="'background-color: ' + day.eventColor">
                                                    <span x-text="day.day"></span>
                                                </div>
                                            </template>
                                            <template x-if="!day.hasEvent && day.isToday">
                                                <div class="w-6 h-6 rounded-full flex items-center justify-center text-[10px] font-bold border-2 border-indigo-500/70 text-indigo-400">
                                                    <span x-text="day.day"></span>
                                                </div>
                                            </template>
                                            <template x-if="!day.hasEvent && !day.isToday">
                                                <span class="text-[10px] font-semibold text-gray-400" x-text="day.day"></span>
                                            </template>
                                        </div>
                                    </template>
                                </div>
                            </div>
                        </template>
                    </div>
                </div>

            </div>
        </div>

        <!-- SIDEBAR KANAN - 1 Kolom -->
        <div class="lg:col-span-1">
            <div class="space-y-6 sticky top-6">
                <!-- Mini Kalender -->
                <div class="bg-slate-800/70 backdrop-blur-sm rounded-2xl p-5 border border-slate-700/50 shadow-xl" x-data="miniCalendar()">
                    <!-- Header dengan navigasi -->
                    <div class="flex items-center justify-between mb-4">
                        <button @click="prevMonth()"
                                class="p-1 text-white/80 hover:text-white transition">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path>
                            </svg>
                        </button>

                        <h3 class="text-base font-bold text-white text-center" x-text="displayMonth">
                            {{ $tanggalPertama->locale('id')->isoFormat('MMM YYYY') }}
                        </h3>

                        <button @click="nextMonth()"
                                class="p-1 text-white/80 hover:text-white transition">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                            </svg>
                        </button>
                    </div>

                    <!-- Mini Calendar Header -->
                    <div class="grid grid-cols-7 gap-1 mb-2">
                        @foreach(['SEN', 'SEL', 'RAB', 'KAM', 'JUM', 'SAB', 'MIN'] as $hari)
                        <div class="text-center text-[10px] font-semibold text-gray-400">
                            {{ $hari }}
                        </div>
                        @endforeach
                    </div>

                    <!-- Mini Calendar Grid - Dynamic -->
                    <div class="grid grid-cols-7 gap-1.5">
                        <template x-for="day in calendarDays" :key="day.date">
                            <div class="aspect-square flex items-center justify-center">
                                <template x-if="day.hasEvent">
                                    <div class="w-8 h-8 rounded-full flex items-center justify-center transition cursor-pointer"
                                         :style="'background-color: ' + day.color"
                                         @click="navigateToDate(day.fullDate)">
                                        <span class="text-xs font-semibold"
                                              :class="day.isCurrentMonth ? 'text-white' : 'text-white/50'"
                                              x-text="day.day"></span>
                                    </div>
                                </template>
                                <template x-if="!day.hasEvent && day.isToday">
                                    <div class="w-8 h-8 rounded-full flex items-center justify-center border-2 border-dashed border-indigo-500/70 transition cursor-pointer"
                                         @click="navigateToDate(day.fullDate)">
                                        <span class="text-xs font-semibold text-white" x-text="day.day"></span>
                                    </div>
                                </template>
                                <template x-if="!day.hasEvent && !day.isToday">
                                    <span class="text-xs font-semibold hover:text-indigo-400 transition cursor-pointer"
                                          :class="day.isCurrentMonth ? 'text-white' : 'text-gray-600'"
                                          @click="navigateToDate(day.fullDate)"
                                          x-text="day.day"></span>
                                </template>
                            </div>
                        </template>
                    </div>
                </div>

                <!-- Daftar Acara Bulan Ini -->
                <div class="bg-slate-800/70 backdrop-blur-sm rounded-2xl p-5 border border-slate-700/50 shadow-xl">
                    <h3 class="text-base font-bold text-white mb-4">Acara Bulan Ini</h3>

                    @if($acaraBuddhist->count() > 0)
                        <div class="space-y-3 max-h-[600px] overflow-y-auto pr-2">
                            @foreach($acaraBuddhist->sortBy('tanggal') as $acara)
                                <div class="rounded-xl p-3 bg-slate-700/30 border border-slate-600/50 hover:bg-slate-700/50 transition cursor-pointer">
                                    <!-- Header Event dengan Badge Tanggal -->
                                    <div class="flex items-start space-x-3 mb-2">
                                        <div class="flex-shrink-0 w-11 h-11 rounded-lg flex flex-col items-center justify-center"
                                             style="background-color: {{ $acara->warna }};">
                                            <span class="text-[9px] text-white/80 font-semibold uppercase">
                                                {{ $acara->tanggal->format('M') }}
                                            </span>
                                            <span class="text-base text-white font-bold leading-none">
                                                {{ $acara->tanggal->format('d') }}
                                            </span>
                                        </div>
                                        <div class="flex-1 min-w-0">
                                            <p class="font-semibold text-white text-sm truncate">{{ $acara->nama }}</p>
                                            <p class="text-xs text-gray-400">
                                                {{ $acara->tanggal->locale('id')->isoFormat('dddd') }}
                                            </p>
                                            @if($acara->waktu_mulai)
                                                <p class="text-xs text-gray-400 mt-0.5">
                                                    {{ substr($acara->waktu_mulai, 0, 5) }}@if($acara->waktu_selesai) - {{ substr($acara->waktu_selesai, 0, 5) }}@endif
                                                </p>
                                            @endif
                                        </div>
                                    </div>

                                    @if($acara->deskripsi)
                                        <p class="text-xs text-gray-400 mb-3 line-clamp-2">{{ $acara->deskripsi }}</p>
                                    @endif>

                                    <!-- Action Buttons -->
                                    <div class="flex items-center gap-2">
                                        <a href="{{ route('kalender-buddhist.edit', $acara) }}"
                                           class="flex-1 px-3 py-1.5 rounded-lg bg-blue-600/20 hover:bg-blue-600/40 text-blue-400 transition text-center text-xs font-medium">
                                            Edit
                                        </a>

                                        <form action="{{ route('kalender-buddhist.destroy', $acara) }}" method="POST" class="flex-1">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit"
                                                    onclick="return confirm('Yakin ingin menghapus acara ini?')"
                                                    class="w-full px-3 py-1.5 rounded-lg bg-red-600/20 hover:bg-red-600/40 text-red-400 transition text-xs font-medium">
                                                Hapus
                                            </button>
                                        </form>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    @else
                        <p class="text-center text-gray-500 py-8 text-sm">Tidak ada acara di bulan ini</p>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>

@if(session('success'))
<div x-data="{ show: true }" x-show="show" x-init="setTimeout(() => show = false, 3000)"
     class="fixed bottom-4 right-4 bg-green-600 text-white px-6 py-3 rounded-xl shadow-xl z-50">
    {{ session('success') }}
</div>
@endif

<script>
// Data events dari PHP - inject ke JavaScript
window.calendarEvents = {};
@php
    // Prepare events data untuk JavaScript
    if ($acaraBuddhist instanceof \Illuminate\Support\Collection) {
        foreach($acaraBuddhist as $acara) {
            $tanggalKey = $acara->tanggal instanceof \Carbon\Carbon
                ? $acara->tanggal->format('Y-m-d')
                : (string)$acara->tanggal;

            echo "window.calendarEvents['{$tanggalKey}'] = " . json_encode([
                'nama' => $acara->nama,
                'deskripsi' => $acara->deskripsi ?? '',
                'waktu_mulai' => $acara->waktu_mulai ?? '',
                'waktu_selesai' => $acara->waktu_selesai ?? '',
                'warna' => $acara->warna
            ]) . ";\n";
        }
    }
@endphp

window.faseBulanData = @json($faseBulan);
window.aturanUposathaData = @json($aturanUposatha);

console.log('Calendar Events Loaded:', window.calendarEvents);

// Fungsi untuk daily event display - FIXED VERSION
function dailyEventDisplay() {
    return {
        events: {},
        currentEvent: null,

        loadEvents() {
            // Ambil data dari data attribute
            const eventsData = this.$el.getAttribute('data-events');
            if (eventsData) {
                try {
                    this.events = JSON.parse(eventsData);
                } catch (e) {
                    console.error('Failed to parse events:', e);
                    this.events = {};
                }
            }

            // Update event immediately
            this.updateEvent();

            // Watch untuk perubahan currentDate di parent
            this.$watch('$root.currentDate', () => {
                this.updateEvent();
            });
        },

        updateEvent() {
            // PERBAIKAN UTAMA: Ambil tanggal dari URL parameter terlebih dahulu
            const urlParams = new URLSearchParams(window.location.search);
            const dateParam = urlParams.get('date');

            let dateStr;

            if (dateParam) {
                // Gunakan tanggal dari URL (ini yang dipencet dari mini calendar)
                dateStr = dateParam;
            } else {
                // Fallback ke currentDate dari root component atau hari ini
                const currentDate = this.$root.currentDate;

                if (!currentDate) {
                    const now = new Date();
                    const year = now.getFullYear();
                    const month = String(now.getMonth() + 1).padStart(2, '0');
                    const day = String(now.getDate()).padStart(2, '0');
                    dateStr = `${year}-${month}-${day}`;
                } else {
                    const year = currentDate.getFullYear();
                    const month = String(currentDate.getMonth() + 1).padStart(2, '0');
                    const day = String(currentDate.getDate()).padStart(2, '0');
                    dateStr = `${year}-${month}-${day}`;
                }
            }

            // Set current event berdasarkan dateStr yang sudah benar
            this.currentEvent = this.events[dateStr] || null;

            console.log('Date from URL:', dateParam);
            console.log('Using date:', dateStr);
            console.log('Current event:', this.currentEvent);
        },

        getEventPosition(event) {
            if (!event || !event.waktu_mulai) return 24;
            const parts = event.waktu_mulai.split(':');
            const hour = parseInt(parts[0]);
            const minute = parseInt(parts[1]);
            return (hour * 48) + (minute * 0.8);
        }
    }
}

// Fungsi untuk week header data
function weekHeaderData() {
    return {
        weekDates: [],

        generateWeekDates() {
            const today = new Date();
            const dayOfWeek = today.getDay();
            const mondayOffset = dayOfWeek === 0 ? -6 : 1 - dayOfWeek;
            const monday = new Date(today);
            monday.setDate(today.getDate() + mondayOffset);

            const dayNames = ['SENIN', 'SELASA', 'RABU', 'KAMIS', 'JUMAT', 'SABTU', 'MINGGU'];

            this.weekDates = [];

            for (let i = 0; i < 7; i++) {
                const currentDate = new Date(monday);
                currentDate.setDate(monday.getDate() + i);
                const isToday = currentDate.toDateString() === today.toDateString();

                this.weekDates.push({
                    date: currentDate.getDate(),
                    name: dayNames[i],
                    fullDate: currentDate,
                    isToday: isToday
                });
            }
        },

        navigateToDate(date) {
            // Emit event untuk update main calendar tanpa reload
            window.dispatchEvent(new CustomEvent('navigate-to-date', {
                detail: { date: date }
            }));
        }
    }
}

// Fungsi untuk weekly view data
function weeklyViewData() {
    return {
        weekDays: [],

        initWeekly() {
            this.generateWeekDays();
        },

        generateWeekDays() {
            const today = new Date();
            const dayOfWeek = today.getDay();
            const mondayOffset = dayOfWeek === 0 ? -6 : 1 - dayOfWeek;
            const monday = new Date(today);
            monday.setDate(today.getDate() + mondayOffset);

            const dayNamesShort = ['Sen', 'Sel', 'Rab', 'Kam', 'Jum', 'Sab', 'Min'];

            this.weekDays = [];

            for (let i = 0; i < 7; i++) {
                const currentDate = new Date(monday);
                currentDate.setDate(monday.getDate() + i);
                const isToday = currentDate.toDateString() === today.toDateString();

                const year = currentDate.getFullYear();
                const month = String(currentDate.getMonth() + 1).padStart(2, '0');
                const day = String(currentDate.getDate()).padStart(2, '0');
                const dateStr = `${year}-${month}-${day}`;

                // Cek apakah ada event di tanggal ini
                const event = window.calendarEvents[dateStr] || null;

                this.weekDays.push({
                    day: currentDate.getDate(),
                    dayName: dayNamesShort[i],
                    fullDate: currentDate,
                    dateStr: dateStr,
                    isToday: isToday,
                    event: event
                });
            }
        },

        getEventPosition(event) {
            if (!event || !event.waktu_mulai) return 24;
            const parts = event.waktu_mulai.split(':');
            const hour = parseInt(parts[0]);
            const minute = parseInt(parts[1]);
            return (hour * 48) + (minute * 0.8);
        }
    }
}

// ============================================================================
// PERBAIKAN UTAMA: MONTHLY VIEW - Gunakan waktu real-time untuk deteksi hari ini
// ============================================================================
function monthlyViewData() {
    return {
        monthDays: [],

        initMonthly() {
            this.generateMonthDays();

            // Watch untuk perubahan bulan/tahun agar regenerate
            this.$watch('$root.currentYear', () => this.generateMonthDays());
            this.$watch('$root.currentMonth', () => this.generateMonthDays());
        },

        generateMonthDays() {
            const currentYear = this.$root.currentYear;
            const currentMonth = this.$root.currentMonth;

            // PERBAIKAN: Gunakan waktu real-time untuk deteksi hari ini
            const now = new Date();
            const todayStr = `${now.getFullYear()}-${String(now.getMonth() + 1).padStart(2, '0')}-${String(now.getDate()).padStart(2, '0')}`;

            // First day of the month
            const firstDay = new Date(currentYear, currentMonth - 1, 1);

            // Start from Monday of the week containing the first day
            let startDayOfWeek = firstDay.getDay();
            startDayOfWeek = startDayOfWeek === 0 ? 6 : startDayOfWeek - 1;

            const startDate = new Date(firstDay);
            startDate.setDate(firstDay.getDate() - startDayOfWeek);

            // Last day of the month
            const lastDay = new Date(currentYear, currentMonth, 0);

            // End on Sunday of the week containing the last day
            let endDayOfWeek = lastDay.getDay();
            endDayOfWeek = endDayOfWeek === 0 ? 0 : 6 - endDayOfWeek;

            const endDate = new Date(lastDay);
            endDate.setDate(lastDay.getDate() + endDayOfWeek);

            this.monthDays = [];

            // Generate all days from start to end
            const currentDate = new Date(startDate);
            while (currentDate <= endDate) {
                const year = currentDate.getFullYear();
                const month = currentDate.getMonth() + 1;
                const day = currentDate.getDate();
                const dateStr = `${year}-${String(month).padStart(2, '0')}-${String(day).padStart(2, '0')}`;

                // PERBAIKAN: Compare dengan string tanggal hari ini yang real-time
                const isToday = dateStr === todayStr;
                const isCurrentMonth = month === currentMonth;

                // Get event from window.calendarEvents
                let event = null;
                if (window.calendarEvents && typeof window.calendarEvents === 'object') {
                    event = window.calendarEvents[dateStr] || null;
                }

                this.monthDays.push({
                    day: day,
                    dateStr: dateStr,
                    isToday: isToday,
                    isCurrentMonth: isCurrentMonth,
                    event: event
                });

                currentDate.setDate(currentDate.getDate() + 1);
            }

            console.log('Monthly Days Generated:', this.monthDays.length, 'days');
            console.log('Today is:', todayStr);
            console.log('Today check:', this.monthDays.filter(d => d.isToday));
        }
    }
}

// ============================================================================
// PERBAIKAN UTAMA: YEARLY VIEW - Gunakan waktu real-time untuk deteksi hari ini
// ============================================================================
function yearlyViewData() {
    return {
        yearMonths: [],

        initYearly() {
            this.generateYearMonths();

            // Watch untuk perubahan tahun agar regenerate
            this.$watch('$root.currentYear', () => this.generateYearMonths());
        },

        generateYearMonths() {
            const currentYear = this.$root.currentYear;

            // PERBAIKAN: Gunakan waktu real-time untuk deteksi hari ini
            const now = new Date();
            const todayStr = `${now.getFullYear()}-${String(now.getMonth() + 1).padStart(2, '0')}-${String(now.getDate()).padStart(2, '0')}`;

            const monthNames = ['Januari', 'Februari', 'Maret', 'April', 'Mei', 'Juni',
                               'Juli', 'Agustus', 'September', 'Oktober', 'November', 'Desember'];

            this.yearMonths = [];

            for (let m = 1; m <= 12; m++) {
                const firstDay = new Date(currentYear, m - 1, 1);
                const lastDay = new Date(currentYear, m, 0);
                const daysInMonth = lastDay.getDate();

                let startDayOfWeek = firstDay.getDay();
                startDayOfWeek = startDayOfWeek === 0 ? 6 : startDayOfWeek - 1;

                const days = [];
                for (let day = 1; day <= daysInMonth; day++) {
                    const currentDate = new Date(currentYear, m - 1, day);
                    const dateStr = `${currentYear}-${String(m).padStart(2, '0')}-${String(day).padStart(2, '0')}`;

                    // PERBAIKAN: Compare dengan string tanggal hari ini yang real-time
                    const isToday = dateStr === todayStr;

                    // Get event from window.calendarEvents
                    let event = null;
                    if (window.calendarEvents && typeof window.calendarEvents === 'object') {
                        event = window.calendarEvents[dateStr] || null;
                    }

                    days.push({
                        day: day,
                        dateStr: dateStr,
                        isToday: isToday,
                        hasEvent: !!event,
                        eventColor: event ? event.warna : null
                    });
                }

                this.yearMonths.push({
                    month: m,
                    year: currentYear,
                    name: monthNames[m - 1],
                    startDayOfWeek: startDayOfWeek,
                    days: days
                });
            }

            console.log('Yearly Months Generated:', this.yearMonths.length, 'months');
            console.log('Today is:', todayStr);
        },

        navigateToMonth(year, month, changeToMonthly) {
            this.$root.navigateToMonth(year, month, changeToMonthly);
        }
    }
}

// Fungsi untuk kalender utama
function kalenderData() {
    return {
        currentYear: {{ $tahun }},
        currentMonth: {{ $bulan }},
        currentView: 'monthly',
        currentDate: null,

        init() {
            const savedView = localStorage.getItem('kalenderView');
            if (savedView) {
                this.currentView = savedView;
            }

            const urlParams = new URLSearchParams(window.location.search);
            const dateParam = urlParams.get('date');
            if (dateParam) {
                this.currentDate = new Date(dateParam);
            } else {
                this.currentDate = new Date();
            }

            window.addEventListener('date-changed', (e) => {
                this.currentDate = e.detail.date;
            });
        },

        changeView(view) {
            this.currentView = view;
            localStorage.setItem('kalenderView', view);
        },

        getCurrentDateString() {
            if (!this.currentDate) {
                const now = new Date();
                const year = now.getFullYear();
                const month = String(now.getMonth() + 1).padStart(2, '0');
                const day = String(now.getDate()).padStart(2, '0');
                return `${year}-${month}-${day}`;
            }
            const year = this.currentDate.getFullYear();
            const month = String(this.currentDate.getMonth() + 1).padStart(2, '0');
            const day = String(this.currentDate.getDate()).padStart(2, '0');
            return `${year}-${month}-${day}`;
        },

        getHeaderTitle() {
            const monthNames = ['Januari', 'Februari', 'Maret', 'April', 'Mei', 'Juni',
                               'Juli', 'Agustus', 'September', 'Oktober', 'November', 'Desember'];
            const dayNames = ['Minggu', 'Senin', 'Selasa', 'Rabu', 'Kamis', 'Jumat', 'Sabtu'];

            switch(this.currentView) {
                case 'daily':
                    if (this.currentDate) {
                        const dayName = dayNames[this.currentDate.getDay()];
                        return `${dayName}, ${this.currentDate.getDate()} ${monthNames[this.currentDate.getMonth()]} ${this.currentDate.getFullYear()}`;
                    }
                    const today = new Date();
                    return `${today.getDate()} ${monthNames[today.getMonth()]} ${today.getFullYear()}`;
                case 'weekly':
                    return `Minggu Ini - ${monthNames[this.currentMonth - 1]} ${this.currentYear}`;
                case 'yearly':
                    return `Tahun ${this.currentYear}`;
                default:
                    return `${monthNames[this.currentMonth - 1]} ${this.currentYear}`;
            }
        },

        navigatePrevMonth() {
            if (this.currentView === 'daily') {
                this.navigatePrevDay();
            } else if (this.currentView === 'yearly') {
                this.currentYear--;
                this.navigateToMonth(this.currentYear, this.currentMonth, false);
            } else {
                let newMonth = this.currentMonth - 1;
                let newYear = this.currentYear;

                if (newMonth < 1) {
                    newMonth = 12;
                    newYear = this.currentYear - 1;
                }

                this.navigateToMonth(newYear, newMonth, false);
            }
        },

        navigateNextMonth() {
            if (this.currentView === 'daily') {
                this.navigateNextDay();
            } else if (this.currentView === 'yearly') {
                this.currentYear++;
                this.navigateToMonth(this.currentYear, this.currentMonth, false);
            } else {
                let newMonth = this.currentMonth + 1;
                let newYear = this.currentYear;

                if (newMonth > 12) {
                    newMonth = 1;
                    newYear = this.currentYear + 1;
                }

                this.navigateToMonth(newYear, newMonth, false);
            }
        },

        navigatePrevDay() {
            const prevDate = new Date(this.currentDate);
            prevDate.setDate(prevDate.getDate() - 1);

            const year = prevDate.getFullYear();
            const month = prevDate.getMonth() + 1;
            const day = prevDate.getDate();
            const dateStr = `${year}-${String(month).padStart(2, '0')}-${String(day).padStart(2, '0')}`;

            const url = `{{ route('kalender-buddhist.index') }}?tahun=${year}&bulan=${month}&date=${dateStr}`;
            window.location.href = url;
        },

        navigateNextDay() {
            const nextDate = new Date(this.currentDate);
            nextDate.setDate(nextDate.getDate() + 1);

            const year = nextDate.getFullYear();
            const month = nextDate.getMonth() + 1;
            const day = nextDate.getDate();
            const dateStr = `${year}-${String(month).padStart(2, '0')}-${String(day).padStart(2, '0')}`;

            const url = `{{ route('kalender-buddhist.index') }}?tahun=${year}&bulan=${month}&date=${dateStr}`;
            window.location.href = url;
        },

        navigateToMonth(year, month, changeToMonthly = true) {
            if (changeToMonthly) {
                localStorage.setItem('kalenderView', 'monthly');
            }
            const url = `{{ route('kalender-buddhist.index') }}?tahun=${year}&bulan=${month}`;
            window.location.href = url;
        }
    }
}

// Fungsi untuk mini kalender
function miniCalendar() {
    return {
        miniYear: {{ $tahun }},
        miniMonth: {{ $bulan }},
        calendarDays: [],
        displayMonth: '',

        init() {
            this.generateSimpleCalendar();
        },

        prevMonth() {
            this.miniMonth--;
            if (this.miniMonth < 1) {
                this.miniMonth = 12;
                this.miniYear--;
            }
            this.generateSimpleCalendar();
        },

        nextMonth() {
            this.miniMonth++;
            if (this.miniMonth > 12) {
                this.miniMonth = 1;
                this.miniYear++;
            }
            this.generateSimpleCalendar();
        },

        changeViewFromSidebar(view) {
            window.dispatchEvent(new CustomEvent('change-calendar-view', { detail: view }));
        },

        generateSimpleCalendar() {
            const monthNames = ['Januari', 'Februari', 'Maret', 'April', 'Mei', 'Juni',
                               'Juli', 'Agustus', 'September', 'Oktober', 'November', 'Desember'];
            this.displayMonth = `${monthNames[this.miniMonth - 1]} ${this.miniYear}`;

            const firstDay = new Date(this.miniYear, this.miniMonth - 1, 1);
            const lastDay = new Date(this.miniYear, this.miniMonth, 0);
            let dayOfWeek = firstDay.getDay();
            dayOfWeek = dayOfWeek === 0 ? 6 : dayOfWeek - 1;

            const daysInMonth = lastDay.getDate();
            const today = new Date();

            this.calendarDays = [];

            const prevMonthLastDay = new Date(this.miniYear, this.miniMonth - 1, 0).getDate();
            for (let i = dayOfWeek - 1; i >= 0; i--) {
                const day = prevMonthLastDay - i;
                const prevMonth = this.miniMonth === 1 ? 12 : this.miniMonth - 1;
                const prevYear = this.miniMonth === 1 ? this.miniYear - 1 : this.miniYear;

                this.calendarDays.push({
                    day: day,
                    date: `${prevYear}-${String(prevMonth).padStart(2, '0')}-${String(day).padStart(2, '0')}`,
                    fullDate: new Date(prevYear, prevMonth - 1, day),
                    isCurrentMonth: false,
                    isToday: false,
                    hasEvent: false,
                    color: ''
                });
            }

            for (let day = 1; day <= daysInMonth; day++) {
                const currentDate = new Date(this.miniYear, this.miniMonth - 1, day);
                const isToday = currentDate.toDateString() === today.toDateString();

                this.calendarDays.push({
                    day: day,
                    date: `${this.miniYear}-${String(this.miniMonth).padStart(2, '0')}-${String(day).padStart(2, '0')}`,
                    fullDate: currentDate,
                    isCurrentMonth: true,
                    isToday: isToday,
                    hasEvent: false,
                    color: ''
                });
            }

            const totalCells = Math.ceil(this.calendarDays.length / 7) * 7;
            const remainingCells = totalCells - this.calendarDays.length;

            for (let day = 1; day <= remainingCells; day++) {
                const nextMonth = this.miniMonth === 12 ? 1 : this.miniMonth + 1;
                const nextYear = this.miniMonth === 12 ? this.miniYear + 1 : this.miniYear;

                this.calendarDays.push({
                    day: day,
                    date: `${nextYear}-${String(nextMonth).padStart(2, '0')}-${String(day).padStart(2, '0')}`,
                    fullDate: new Date(nextYear, nextMonth - 1, day),
                    isCurrentMonth: false,
                    isToday: false,
                    hasEvent: false,
                    color: ''
                });
            }
        },

        navigateToDate(date) {
            const clickedYear = date.getFullYear();
            const clickedMonth = date.getMonth() + 1;
            const clickedDay = date.getDate();

            localStorage.setItem('kalenderView', 'daily');
            const dateStr = `${clickedYear}-${String(clickedMonth).padStart(2, '0')}-${String(clickedDay).padStart(2, '0')}`;
            const url = `{{ route('kalender-buddhist.index') }}?tahun=${clickedYear}&bulan=${clickedMonth}&date=${dateStr}`;
            window.location.href = url;
        }
    }
}

window.addEventListener('change-calendar-view', (e) => {
    const view = e.detail;
    localStorage.setItem('kalenderView', view);
    window.location.reload();
});
</script>
@endsection
