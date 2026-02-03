@extends('layouts.app')

@section('title', 'Edit Profile')

@section('header', 'Edit Profile')

@section('content')
<div class="max-w-4xl mx-auto">
    <!-- Header -->
    <div class="bg-gradient-to-br from-indigo-600/20 to-indigo-800/20 backdrop-blur-sm rounded-2xl p-6 border border-indigo-500/30 shadow-xl mb-6">
        <div class="flex items-center space-x-4">
            <div class="w-16 h-16 rounded-2xl bg-indigo-600/30 flex items-center justify-center">
                <span class="text-2xl font-bold text-indigo-300">{{ strtoupper(substr(Auth::user()->name, 0, 2)) }}</span>
            </div>
            <div>
                <h2 class="text-2xl font-bold text-white">{{ Auth::user()->name }}</h2>
                <p class="text-indigo-300">{{ Auth::user()->email }}</p>
            </div>
        </div>
    </div>

    @if(session('success'))
    <div class="mb-6 p-4 bg-emerald-600/20 border border-emerald-500/30 rounded-xl">
        <div class="flex items-center space-x-2">
            <svg class="w-5 h-5 text-emerald-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
            </svg>
            <p class="text-emerald-300 font-medium">{{ session('success') }}</p>
        </div>
    </div>
    @endif

    <!-- Form Update Profile -->
    <div class="bg-slate-800/70 backdrop-blur-sm rounded-2xl p-6 border border-slate-700/50 shadow-xl mb-6">
        <h3 class="text-xl font-bold text-white mb-6">Update Informasi Profile</h3>

        <form method="POST" action="{{ route('profile.update') }}" class="space-y-6">
            @csrf
            @method('PATCH')

            <div>
                <label for="name" class="block text-sm font-semibold text-gray-300 mb-2">Nama</label>
                <input type="text"
                       name="name"
                       id="name"
                       value="{{ old('name', Auth::user()->name) }}"
                       class="w-full px-4 py-3 bg-slate-700/50 border border-slate-600/50 rounded-xl text-white placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent transition"
                       required>
                @error('name')
                <p class="mt-2 text-sm text-red-400">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <label for="email" class="block text-sm font-semibold text-gray-300 mb-2">Email</label>
                <input type="email"
                       name="email"
                       id="email"
                       value="{{ old('email', Auth::user()->email) }}"
                       class="w-full px-4 py-3 bg-slate-700/50 border border-slate-600/50 rounded-xl text-white placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent transition"
                       required>
                @error('email')
                <p class="mt-2 text-sm text-red-400">{{ $message }}</p>
                @enderror
            </div>

            <div class="flex justify-end">
                <button type="submit"
                        class="px-6 py-3 bg-blue-600 hover:bg-blue-700 text-white rounded-xl font-semibold transition-all duration-300 shadow-lg hover:shadow-xl flex items-center space-x-2">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                    </svg>
                    <span>Simpan</span>
                </button>
            </div>
        </form>
    </div>

    <!-- Form Update Password -->
    <div class="bg-slate-800/70 backdrop-blur-sm rounded-2xl p-6 border border-slate-700/50 shadow-xl">
        <h3 class="text-xl font-bold text-white mb-6">Update Password</h3>

        @if(session('password_success'))
        <div class="mb-4 p-4 bg-emerald-600/20 border border-emerald-500/30 rounded-xl">
            <div class="flex items-center space-x-2">
                <svg class="w-5 h-5 text-emerald-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                </svg>
                <p class="text-emerald-300 font-medium">{{ session('password_success') }}</p>
            </div>
        </div>
        @endif

        <form method="POST" action="{{ route('password.update') }}" class="space-y-6">
            @csrf
            @method('PUT')

            <div>
                <label for="current_password" class="block text-sm font-semibold text-gray-300 mb-2">Password Saat Ini</label>
                <input type="password"
                       name="current_password"
                       id="current_password"
                       class="w-full px-4 py-3 bg-slate-700/50 border border-slate-600/50 rounded-xl text-white placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-purple-500 focus:border-transparent transition"
                       required>
                @error('current_password')
                <p class="mt-2 text-sm text-red-400">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <label for="password" class="block text-sm font-semibold text-gray-300 mb-2">Password Baru</label>
                <input type="password"
                       name="password"
                       id="password"
                       class="w-full px-4 py-3 bg-slate-700/50 border border-slate-600/50 rounded-xl text-white placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-purple-500 focus:border-transparent transition"
                       required>
                @error('password')
                <p class="mt-2 text-sm text-red-400">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <label for="password_confirmation" class="block text-sm font-semibold text-gray-300 mb-2">Konfirmasi Password Baru</label>
                <input type="password"
                       name="password_confirmation"
                       id="password_confirmation"
                       class="w-full px-4 py-3 bg-slate-700/50 border border-slate-600/50 rounded-xl text-white placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-purple-500 focus:border-transparent transition"
                       required>
            </div>

            <div class="flex justify-end">
                <button type="submit"
                        class="px-6 py-3 bg-purple-600 hover:bg-purple-700 text-white rounded-xl font-semibold transition-all duration-300 shadow-lg hover:shadow-xl flex items-center space-x-2">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"></path>
                    </svg>
                    <span>Update Password</span>
                </button>
            </div>
        </form>
    </div>
</div>
@endsection
