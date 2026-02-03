@extends('layouts.app')

@section('title', 'Profile')

@section('header', 'Profile')

@section('content')
<div class="max-w-4xl mx-auto">
    <!-- Profile Header -->
    <div class="bg-gradient-to-br from-indigo-600/20 to-indigo-800/20 backdrop-blur-sm rounded-2xl p-8 border border-indigo-500/30 shadow-xl mb-6">
        <div class="flex items-center justify-between">
            <div class="flex items-center space-x-6">
                @if(Auth::user()->profile_photo)
                    <img src="{{ asset('storage/' . Auth::user()->profile_photo) }}?t={{ time() }}"
                        alt="Profile Photo"
                        class="w-24 h-24 rounded-2xl object-cover border-2 border-indigo-500/50">
                @else
                    <div class="w-24 h-24 rounded-2xl bg-indigo-600/30 flex items-center justify-center">
                        <span class="text-4xl font-bold text-indigo-300">{{ strtoupper(substr(Auth::user()->name, 0, 2)) }}</span>
                    </div>
                @endif
                <div>
                    <h2 class="text-3xl font-bold text-white mb-2">{{ Auth::user()->name }}</h2>
                    <p class="text-indigo-300 mb-2">{{ Auth::user()->email }}</p>
                </div>
            </div>
            <a href="{{ route('profile.edit') }}" class="px-6 py-3 bg-amber-600 hover:bg-amber-700 text-white rounded-xl font-semibold transition-all duration-300 shadow-lg hover:shadow-xl flex items-center space-x-2">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                </svg>
                <span>Edit Profile</span>
            </a>
        </div>
    </div>

    <!-- Profile Info -->
    <div class="bg-slate-800/70 backdrop-blur-sm rounded-2xl p-6 border border-slate-700/50 shadow-xl">
        <h3 class="text-xl font-bold text-white mb-6">Informasi Profile</h3>

        <div class="space-y-4">
            <div>
                <label class="block text-sm font-semibold text-gray-400 mb-2">Nama</label>
                <div class="px-4 py-3 bg-slate-700/30 border border-slate-600/30 rounded-xl">
                    <p class="text-white font-medium">{{ Auth::user()->name }}</p>
                </div>
            </div>

            <div>
                <label class="block text-sm font-semibold text-gray-400 mb-2">Email</label>
                <div class="px-4 py-3 bg-slate-700/30 border border-slate-600/30 rounded-xl">
                    <p class="text-white font-medium">{{ Auth::user()->email }}</p>
                </div>
            </div>

            <div>
                <label class="block text-sm font-semibold text-gray-400 mb-2">Role</label>
                <div class="px-4 py-3 bg-slate-700/30 border border-slate-600/30 rounded-xl">
                    <p class="text-white font-medium capitalize">{{ Auth::user()->role ?? 'User' }}</p>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
