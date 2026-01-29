@extends('layouts.app')

@section('title', 'Dashboard')

@section('header', 'Dashboard')

@section('content')
<div class="max-w-7xl mx-auto">
    <!-- Stats Cards -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
        <!-- Total Views Card -->
        <div class="bg-slate-800/70 backdrop-blur-sm rounded-2xl p-6 border border-slate-700/50 shadow-xl hover:shadow-2xl transition-all duration-300">
            <div class="flex items-center justify-center mb-4">
                <div class="w-14 h-14 rounded-2xl bg-slate-700/80 flex items-center justify-center">
                    <svg class="w-7 h-7 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                    </svg>
                </div>
            </div>
            <p class="text-4xl font-bold text-white mb-2 text-center">$3,456K</p>
            <p class="text-sm text-gray-400 font-medium mb-2 text-center">Total views</p>
            <div class="flex items-center justify-center space-x-2">
                <span class="text-xs px-2 py-1 rounded-lg bg-green-500/10 text-green-400 font-semibold">
                    <span class="inline-flex items-center">
                        <svg class="w-3 h-3 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 10l7-7m0 0l7 7m-7-7v18"></path>
                        </svg>
                        0.43%
                    </span>
                </span>
            </div>
        </div>

        <!-- Total Profit Card -->
        <div class="bg-slate-800/70 backdrop-blur-sm rounded-2xl p-6 border border-slate-700/50 shadow-xl hover:shadow-2xl transition-all duration-300">
            <div class="flex items-center justify-center mb-4">
                <div class="w-14 h-14 rounded-2xl bg-slate-700/80 flex items-center justify-center">
                    <svg class="w-7 h-7 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z"></path>
                    </svg>
                </div>
            </div>
            <p class="text-4xl font-bold text-white mb-2 text-center">$45.2K</p>
            <p class="text-sm text-gray-400 font-medium mb-2 text-center">Total Profit</p>
            <div class="flex items-center justify-center space-x-2">
                <span class="text-xs px-2 py-1 rounded-lg bg-green-500/10 text-green-400 font-semibold">
                    <span class="inline-flex items-center">
                        <svg class="w-3 h-3 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 10l7-7m0 0l7 7m-7-7v18"></path>
                        </svg>
                        4.35%
                    </span>
                </span>
            </div>
        </div>

        <!-- Total Product Card -->
        <div class="bg-slate-800/70 backdrop-blur-sm rounded-2xl p-6 border border-slate-700/50 shadow-xl hover:shadow-2xl transition-all duration-300">
            <div class="flex items-center justify-center mb-4">
                <div class="w-14 h-14 rounded-2xl bg-slate-700/80 flex items-center justify-center">
                    <svg class="w-7 h-7 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"></path>
                    </svg>
                </div>
            </div>
            <p class="text-4xl font-bold text-white mb-2 text-center">2,450</p>
            <p class="text-sm text-gray-400 font-medium mb-2 text-center">Total Product</p>
            <div class="flex items-center justify-center space-x-2">
                <span class="text-xs px-2 py-1 rounded-lg bg-green-500/10 text-green-400 font-semibold">
                    <span class="inline-flex items-center">
                        <svg class="w-3 h-3 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 10l7-7m0 0l7 7m-7-7v18"></path>
                        </svg>
                        2.59%
                    </span>
                </span>
            </div>
        </div>

        <!-- Total Users Card -->
        <div class="bg-slate-800/70 backdrop-blur-sm rounded-2xl p-6 border border-slate-700/50 shadow-xl hover:shadow-2xl transition-all duration-300">
            <div class="flex items-center justify-center mb-4">
                <div class="w-14 h-14 rounded-2xl bg-slate-700/80 flex items-center justify-center">
                    <svg class="w-7 h-7 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path>
                    </svg>
                </div>
            </div>
            <p class="text-4xl font-bold text-white mb-2 text-center">3,456</p>
            <p class="text-sm text-gray-400 font-medium mb-2 text-center">Total Users</p>
            <div class="flex items-center justify-center space-x-2">
                <span class="text-xs px-2 py-1 rounded-lg bg-blue-500/10 text-blue-400 font-semibold">
                    <span class="inline-flex items-center">
                        <svg class="w-3 h-3 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 14l-7 7m0 0l-7-7m7 7V3"></path>
                        </svg>
                        0.95%
                    </span>
                </span>
            </div>
        </div>
    </div>

    <!-- Charts Section -->
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6 mb-8">
        <!-- Main Chart -->
        <div class="lg:col-span-2 bg-slate-800/70 backdrop-blur-sm rounded-2xl p-6 border border-slate-700/50 shadow-xl">
            <div class="flex items-center justify-between mb-6">
                <div>
                    <h3 class="text-lg font-bold text-white mb-1">Total Revenue</h3>
                    <p class="text-sm text-gray-400">12.04.2022 - 12.05.2022</p>
                </div>
                <div class="flex items-center space-x-2 bg-slate-900/30 rounded-xl p-1">
                    <button class="px-4 py-2 rounded-lg bg-slate-700 text-white text-sm font-semibold transition">Day</button>
                    <button class="px-4 py-2 rounded-lg text-gray-400 hover:text-white text-sm font-semibold transition">Week</button>
                    <button class="px-4 py-2 rounded-lg text-gray-400 hover:text-white text-sm font-semibold transition">Month</button>
                </div>
            </div>

            <div class="flex items-center space-x-6 mb-6">
                <div class="flex items-center space-x-2">
                    <div class="w-3 h-3 rounded-full bg-indigo-500"></div>
                    <span class="text-sm text-gray-400">Total Revenue</span>
                </div>
                <div class="flex items-center space-x-2">
                    <div class="w-3 h-3 rounded-full bg-cyan-500"></div>
                    <span class="text-sm text-gray-400">Total Sales</span>
                </div>
            </div>

            <!-- Chart Placeholder -->
            <div class="relative h-72 bg-slate-900/30 rounded-xl p-4 border border-slate-700/30">
                <svg class="w-full h-full" viewBox="0 0 800 250" preserveAspectRatio="none">
                    <!-- Grid Lines -->
                    <line x1="0" y1="50" x2="800" y2="50" stroke="rgba(148, 163, 184, 0.1)" stroke-width="1"/>
                    <line x1="0" y1="100" x2="800" y2="100" stroke="rgba(148, 163, 184, 0.1)" stroke-width="1"/>
                    <line x1="0" y1="150" x2="800" y2="150" stroke="rgba(148, 163, 184, 0.1)" stroke-width="1"/>
                    <line x1="0" y1="200" x2="800" y2="200" stroke="rgba(148, 163, 184, 0.1)" stroke-width="1"/>

                    <!-- Revenue Line (Cyan/Teal) -->
                    <path d="M 0 180 L 66 160 L 133 165 L 200 150 L 266 110 L 333 140 L 400 95 L 466 125 L 533 85 L 600 115 L 666 135 L 733 105 L 800 90"
                          fill="none" stroke="#06b6d4" stroke-width="3" stroke-linecap="round"/>

                    <!-- Sales Line (Indigo) -->
                    <path d="M 0 200 L 66 190 L 133 185 L 200 180 L 266 165 L 333 175 L 400 155 L 466 170 L 533 150 L 600 165 L 666 175 L 733 160 L 800 145"
                          fill="none" stroke="#6366f1" stroke-width="3" stroke-linecap="round"/>

                    <!-- Area Fill Revenue -->
                    <path d="M 0 180 L 66 160 L 133 165 L 200 150 L 266 110 L 333 140 L 400 95 L 466 125 L 533 85 L 600 115 L 666 135 L 733 105 L 800 90 L 800 250 L 0 250 Z"
                          fill="#06b6d4" opacity="0.15"/>

                    <!-- Area Fill Sales -->
                    <path d="M 0 200 L 66 190 L 133 185 L 200 180 L 266 165 L 333 175 L 400 155 L 466 170 L 533 150 L 600 165 L 666 175 L 733 160 L 800 145 L 800 250 L 0 250 Z"
                          fill="#6366f1" opacity="0.15"/>
                </svg>

                <!-- X-axis labels -->
                <div class="absolute bottom-0 left-0 right-0 flex justify-between px-4 text-xs text-gray-500">
                    <span>Sep</span>
                    <span>Oct</span>
                    <span>Nov</span>
                    <span>Dec</span>
                    <span>Jan</span>
                    <span>Feb</span>
                    <span>Mar</span>
                    <span>Apr</span>
                    <span>May</span>
                    <span>Jun</span>
                    <span>Jul</span>
                    <span>Aug</span>
                </div>
            </div>
        </div>

        <!-- Profit Chart -->
        <div class="bg-slate-800/70 backdrop-blur-sm rounded-2xl p-6 border border-slate-700/50 shadow-xl">
            <div class="flex items-center justify-between mb-6">
                <div>
                    <h3 class="text-lg font-bold text-white mb-1">Profit this week</h3>
                    <p class="text-sm text-gray-400">This Week</p>
                </div>
            </div>

            <div class="flex items-center space-x-6 mb-6">
                <div class="flex items-center space-x-2">
                    <div class="w-3 h-3 rounded-full bg-indigo-500"></div>
                    <span class="text-sm text-gray-400">Sales</span>
                </div>
                <div class="flex items-center space-x-2">
                    <div class="w-3 h-3 rounded-full bg-cyan-500"></div>
                    <span class="text-sm text-gray-400">Revenue</span>
                </div>
            </div>

            <!-- Bar Chart -->
            <div class="relative h-72 flex items-end justify-around space-x-2 px-2">
                @foreach(['M' => [60, 45], 'T' => [75, 55], 'W' => [65, 50], 'T' => [85, 60], 'F' => [50, 35], 'S' => [70, 55], 'S' => [80, 65]] as $day => $values)
                <div class="flex-1 flex flex-col items-center space-y-2">
                    <div class="w-full flex flex-col space-y-1">
                        <div class="w-full bg-indigo-600 rounded-t-lg" style="height: {{ $values[0] * 2 }}px"></div>
                        <div class="w-full bg-cyan-500 rounded-t-lg" style="height: {{ $values[1] * 2 }}px"></div>
                    </div>
                    <span class="text-xs text-gray-500 font-medium">{{ $day }}</span>
                </div>
                @endforeach
            </div>
        </div>
    </div>
</div>
@endsection
