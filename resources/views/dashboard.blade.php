@extends('layouts.app')

@section('title', 'Dashboard')

@section('header', 'Dashboard')

@section('content')
<div class="max-w-7xl mx-auto">
    <!-- Stats Cards - PASTI 1 KOLOM DI MOBILE -->
    <div class="block lg:grid lg:grid-cols-4 gap-6 mb-6">
        <!-- Total E-Books Card -->
        <div class="mb-6 lg:mb-0 bg-gradient-to-br from-blue-600/20 to-blue-800/20 backdrop-blur-sm rounded-2xl p-6 border border-blue-500/30 shadow-xl hover:shadow-2xl hover:scale-105 transition-all duration-300">
            <div class="flex items-center justify-between mb-4">
                <div class="w-14 h-14 rounded-2xl bg-blue-600/30 flex items-center justify-center">
                    <svg class="w-7 h-7 text-blue-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path>
                    </svg>
                </div>
                <div class="text-right">
                    <p class="text-3xl font-bold text-white">{{ $totalEbooks }}</p>
                    <p class="text-xs text-blue-300 font-medium mt-1">E-Books</p>
                </div>
            </div>
            <a href="{{ route('ebooks.index') }}" class="flex items-center justify-between text-xs text-blue-300 hover:text-blue-200 font-semibold group">
                <span>Lihat Semua</span>
                <svg class="w-4 h-4 group-hover:translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                </svg>
            </a>
        </div>

        <!-- Total Dhamma Vācanā Card -->
        <div class="mb-6 lg:mb-0 bg-gradient-to-br from-purple-600/20 to-purple-800/20 backdrop-blur-sm rounded-2xl p-6 border border-purple-500/30 shadow-xl hover:shadow-2xl hover:scale-105 transition-all duration-300">
            <div class="flex items-center justify-between mb-4">
                <div class="w-14 h-14 rounded-2xl bg-purple-600/30 flex items-center justify-center">
                    <svg class="w-7 h-7 text-purple-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                    </svg>
                </div>
                <div class="text-right">
                    <p class="text-3xl font-bold text-white">{{ $totalDhammavachana }}</p>
                    <p class="text-xs text-purple-300 font-medium mt-1">Dhamma Vācanā</p>
                </div>
            </div>
            <a href="{{ route('dhammavachana.index') }}" class="flex items-center justify-between text-xs text-purple-300 hover:text-purple-200 font-semibold group">
                <span>Lihat Semua</span>
                <svg class="w-4 h-4 group-hover:translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                </svg>
            </a>
        </div>

        <!-- Total Artikel Card -->
        <div class="mb-6 lg:mb-0 bg-gradient-to-br from-amber-600/20 to-amber-800/20 backdrop-blur-sm rounded-2xl p-6 border border-amber-500/30 shadow-xl hover:shadow-2xl hover:scale-105 transition-all duration-300">
            <div class="flex items-center justify-between mb-4">
                <div class="w-14 h-14 rounded-2xl bg-amber-600/30 flex items-center justify-center">
                    <svg class="w-7 h-7 text-amber-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 20H5a2 2 0 01-2-2V6a2 2 0 012-2h10a2 2 0 012 2v1m2 13a2 2 0 01-2-2V7m2 13a2 2 0 002-2V9a2 2 0 00-2-2h-2m-4-3H9M7 16h6M7 8h6v4H7V8z"></path>
                    </svg>
                </div>
                <div class="text-right">
                    <p class="text-3xl font-bold text-white">{{ $totalArticles ?? 0 }}</p>
                    <p class="text-xs text-amber-300 font-medium mt-1">Artikel</p>
                </div>
            </div>
            <a href="{{ route('articles.index') }}" class="flex items-center justify-between text-xs text-amber-300 hover:text-amber-200 font-semibold group">
                <span>Lihat Semua</span>
                <svg class="w-4 h-4 group-hover:translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                </svg>
            </a>
        </div>

        <!-- Total Acara Buddhist Card -->
        <div class="mb-6 lg:mb-0 bg-gradient-to-br from-emerald-600/20 to-emerald-800/20 backdrop-blur-sm rounded-2xl p-6 border border-emerald-500/30 shadow-xl hover:shadow-2xl hover:scale-105 transition-all duration-300">
            <div class="flex items-center justify-between mb-4">
                <div class="w-14 h-14 rounded-2xl bg-emerald-600/30 flex items-center justify-center">
                    <svg class="w-7 h-7 text-emerald-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                    </svg>
                </div>
                <div class="text-right">
                    <p class="text-3xl font-bold text-white">{{ $totalAcara }}</p>
                    <p class="text-xs text-emerald-300 font-medium mt-1">Acara Buddhist</p>
                </div>
            </div>
            <a href="{{ route('kalender-buddhist.index') }}" class="flex items-center justify-between text-xs text-emerald-300 hover:text-emerald-200 font-semibold group">
                <span>Lihat Kalender</span>
                <svg class="w-4 h-4 group-hover:translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                </svg>
            </a>
        </div>
    </div>

    <!-- Grid 2 Kolom: Kalender & Acara -->
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        <!-- Kalender Buddhist - Kiri (1/3) dengan Alpine.js -->
        <div class="lg:col-span-1">
            <div class="bg-slate-800/70 backdrop-blur-sm rounded-2xl p-5 border border-slate-700/50 shadow-xl sticky top-6" x-data="dashboardMiniCalendar()">
                <div class="flex items-center justify-between mb-4">
                    <h3 class="text-lg font-bold text-white">Kalender</h3>
                    <div class="flex items-center space-x-2">
                        <button @click="prevMonth()"
                                class="p-1.5 rounded-lg bg-slate-700/50 hover:bg-slate-700 transition">
                            <svg class="w-4 h-4 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path>
                            </svg>
                        </button>
                        <button @click="nextMonth()"
                                class="p-1.5 rounded-lg bg-slate-700/50 hover:bg-slate-700 transition">
                            <svg class="w-4 h-4 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                            </svg>
                        </button>
                    </div>
                </div>

                <p class="text-sm text-gray-400 mb-4" x-text="displayMonth">{{ $tanggalPertama->locale('id')->isoFormat('MMMM YYYY') }}</p>

                <!-- Mini Legend -->
                <div class="grid grid-cols-2 gap-2 mb-4">
                    <div class="flex items-center space-x-1.5">
                        <div class="w-2 h-2 rounded-full bg-cyan-500"></div>
                        <span class="text-[10px] text-gray-300">Uposatha</span>
                    </div>
                    <div class="flex items-center space-x-1.5">
                        <div class="w-2 h-2 rounded-full bg-amber-500"></div>
                        <span class="text-[10px] text-gray-300">Waisak</span>
                    </div>
                    <div class="flex items-center space-x-1.5">
                        <div class="w-2 h-2 rounded-full bg-purple-500"></div>
                        <span class="text-[10px] text-gray-300">Magha Puja</span>
                    </div>
                    <div class="flex items-center space-x-1.5">
                        <div class="w-2 h-2 rounded-full bg-emerald-500"></div>
                        <span class="text-[10px] text-gray-300">Asalha Puja</span>
                    </div>
                </div>

                <!-- Mini Calendar -->
                <div>
                    <!-- Header Hari -->
                    <div class="grid grid-cols-7 gap-1 mb-2">
                        @foreach(['Min', 'Sen', 'Sel', 'Rab', 'Kam', 'Jum', 'Sab'] as $hari)
                        <div class="text-center py-1 text-[10px] font-bold text-gray-500">
                            {{ $hari }}
                        </div>
                        @endforeach
                    </div>

                    <!-- Tanggal - Dynamic dengan Alpine.js -->
                    <div class="grid grid-cols-7 gap-1">
                        <template x-for="day in calendarDays" :key="day.date">
                            <div class="relative rounded-md border transition overflow-hidden aspect-square"
                                 :class="{
                                     'bg-slate-700/30 border-slate-600/50': day.isCurrentMonth,
                                     'bg-slate-900/20 border-slate-800/50': !day.isCurrentMonth,
                                     'ring-1 ring-indigo-500': day.isToday
                                 }"
                                 @click="navigateToDate(day.fullDate)">

                                <template x-if="day.hasEvent">
                                    <div class="absolute inset-0 rounded-[inherit]"
                                         :style="'background-color: ' + day.color + '; opacity: 0.6;'">
                                    </div>
                                </template>

                                <div class="absolute inset-0 flex items-center justify-center cursor-pointer">
                                    <span class="text-[10px] font-semibold"
                                          :class="day.isCurrentMonth ? 'text-white' : 'text-gray-600'"
                                          x-text="day.day"></span>
                                </div>
                            </div>
                        </template>
                    </div>
                </div>

                <a href="{{ route('kalender-buddhist.index') }}"
                   class="mt-4 block text-center px-4 py-2 bg-indigo-600 hover:bg-indigo-700 text-white rounded-lg font-semibold transition text-sm">
                    Lihat Detail
                </a>
            </div>
        </div>

        <!-- Acara & Quick Stats - Kanan (2/3) -->
        <div class="lg:col-span-2 flex flex-col space-y-6">
            <!-- Quick Actions -->
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <a href="{{ route('ebooks.create') }}" class="bg-slate-800/70 backdrop-blur-sm rounded-xl p-5 border border-slate-700/50 hover:border-blue-500/50 shadow-lg hover:shadow-xl transition-all duration-300 group">
                    <div class="flex items-center space-x-3">
                        <div class="w-12 h-12 rounded-lg bg-blue-600/20 flex items-center justify-center group-hover:bg-blue-600/30 transition">
                            <svg class="w-6 h-6 text-blue-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                            </svg>
                        </div>
                        <div>
                            <p class="text-sm font-semibold text-white">Tambah E-Book</p>
                            <p class="text-xs text-gray-400">Upload buku digital baru</p>
                        </div>
                    </div>
                </a>

                <a href="{{ route('dhammavachana.create') }}" class="bg-slate-800/70 backdrop-blur-sm rounded-xl p-5 border border-slate-700/50 hover:border-purple-500/50 shadow-lg hover:shadow-xl transition-all duration-300 group">
                    <div class="flex items-center space-x-3">
                        <div class="w-12 h-12 rounded-lg bg-purple-600/20 flex items-center justify-center group-hover:bg-purple-600/30 transition">
                            <svg class="w-6 h-6 text-purple-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                            </svg>
                        </div>
                        <div>
                            <p class="text-sm font-semibold text-white">Tambah Dhamma Vācanā</p>
                            <p class="text-xs text-gray-400">Upload bacaan dhamma</p>
                        </div>
                    </div>
                </a>

                <a href="{{ route('articles.create') }}" class="bg-slate-800/70 backdrop-blur-sm rounded-xl p-5 border border-slate-700/50 hover:border-amber-500/50 shadow-lg hover:shadow-xl transition-all duration-300 group">
                    <div class="flex items-center space-x-3">
                        <div class="w-12 h-12 rounded-lg bg-amber-600/20 flex items-center justify-center group-hover:bg-amber-600/30 transition">
                            <svg class="w-6 h-6 text-amber-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                            </svg>
                        </div>
                        <div>
                            <p class="text-sm font-semibold text-white">Tambah Artikel</p>
                            <p class="text-xs text-gray-400">Buat artikel baru</p>
                        </div>
                    </div>
                </a>

                <a href="{{ route('kalender-buddhist.create') }}" class="bg-slate-800/70 backdrop-blur-sm rounded-xl p-5 border border-slate-700/50 hover:border-emerald-500/50 shadow-lg hover:shadow-xl transition-all duration-300 group">
                    <div class="flex items-center space-x-3">
                        <div class="w-12 h-12 rounded-lg bg-emerald-600/20 flex items-center justify-center group-hover:bg-emerald-600/30 transition">
                            <svg class="w-6 h-6 text-emerald-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                            </svg>
                        </div>
                        <div>
                            <p class="text-sm font-semibold text-white">Tambah Acara</p>
                            <p class="text-xs text-gray-400">Buat acara Buddhist baru</p>
                        </div>
                    </div>
                </a>
            </div>

            <!-- Recent Activity / Stats -->
            <div class="bg-slate-800/70 backdrop-blur-sm rounded-2xl p-6 border border-slate-700/50 shadow-xl">
                <h3 class="text-lg font-bold text-white mb-6">Ringkasan</h3>
                <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
                    <div class="text-center p-6 rounded-xl bg-slate-700/30 flex flex-col justify-center">
                        <p class="text-4xl font-bold text-blue-400 mb-2">{{ $totalEbooks }}</p>
                        <p class="text-sm text-gray-400">E-Books</p>
                    </div>
                    <div class="text-center p-6 rounded-xl bg-slate-700/30 flex flex-col justify-center">
                        <p class="text-4xl font-bold text-purple-400 mb-2">{{ $totalDhammavachana }}</p>
                        <p class="text-sm text-gray-400">Dhamma Vācanā</p>
                    </div>
                    <div class="text-center p-6 rounded-xl bg-slate-700/30 flex flex-col justify-center">
                        <p class="text-4xl font-bold text-amber-400 mb-2">{{ $totalArticles ?? 0 }}</p>
                        <p class="text-sm text-gray-400">Artikel</p>
                    </div>
                    <div class="text-center p-6 rounded-xl bg-slate-700/30 flex flex-col justify-center">
                        <p class="text-4xl font-bold text-emerald-400 mb-2">{{ $totalAcara }}</p>
                        <p class="text-sm text-gray-400">Acara</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
// Alpine.js Component untuk Mini Calendar di Dashboard
function dashboardMiniCalendar() {
    return {
        miniYear: {{ $tahun }},
        miniMonth: {{ $bulan }},
        calendarDays: [],
        displayMonth: '',

        init() {
            this.generateCalendar();
        },

        prevMonth() {
            this.miniMonth--;
            if (this.miniMonth < 1) {
                this.miniMonth = 12;
                this.miniYear--;
            }
            this.generateCalendar();
        },

        nextMonth() {
            this.miniMonth++;
            if (this.miniMonth > 12) {
                this.miniMonth = 1;
                this.miniYear++;
            }
            this.generateCalendar();
        },

        async generateCalendar() {
            // Update display month
            const monthNames = ['Januari', 'Februari', 'Maret', 'April', 'Mei', 'Juni',
                               'Juli', 'Agustus', 'September', 'Oktober', 'November', 'Desember'];
            this.displayMonth = `${monthNames[this.miniMonth - 1]} ${this.miniYear}`;

            const firstDay = new Date(this.miniYear, this.miniMonth - 1, 1);
            const lastDay = new Date(this.miniYear, this.miniMonth, 0);

            // Get day of week (0 = Sunday, 1 = Monday, etc.) - keep Sunday as 0
            let dayOfWeek = firstDay.getDay();

            const daysInMonth = lastDay.getDate();
            const today = new Date();

            this.calendarDays = [];

            // Previous month days
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

            // Current month days
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

            // Next month days to fill the grid
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
            const year = date.getFullYear();
            const month = date.getMonth() + 1;
            const url = `{{ route('kalender-buddhist.index') }}?tahun=${year}&bulan=${month}`;
            window.location.href = url;
        }
    }
}
</script>
@endsection
