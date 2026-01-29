<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - AGM Admin</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="min-h-screen flex items-center justify-center p-4" style="background: linear-gradient(rgba(0, 0, 0, 0.5), rgba(0, 0, 0, 0.5)), url('{{ asset('images/bg.jpg') }}') center/cover no-repeat fixed;">
    <div class="w-full max-w-md">
        <div class="flex flex-col items-center mb-8">
            <div class="w-40 h-40 rounded-full bg-black flex items-center justify-center p-6 mb-4">
                <img src="{{ asset('images/agm.png') }}" alt="AGM Digital" class="w-full h-full object-cover">
            </div>
            <h2 class="text-white text-2xl font-bold">AGM Digital</h2>
        </div>

        <!-- Error Message -->
        @if($errors->any())
        <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded-full mb-4 text-center">
            {{ $errors->first() }}
        </div>
        @endif

        <!-- Login Form -->
        <form method="POST" action="{{ url('/login') }}" class="space-y-4">
            @csrf

            <!-- Username Input -->
            <div class="relative">
                <span class="absolute left-5 top-1/2 transform -translate-y-1/2 text-gray-400">
                    <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M10 9a3 3 0 100-6 3 3 0 000 6zm-7 9a7 7 0 1114 0H3z" clip-rule="evenodd"/>
                    </svg>
                </span>
                <input
                    type="email"
                    id="email"
                    name="email"
                    value="{{ old('email') }}"
                    placeholder="Username"
                    class="w-full pl-14 pr-6 py-4 bg-white rounded-full text-gray-700 placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-white/50 shadow-lg"
                    required
                    autofocus
                >
            </div>

            <!-- Password Input -->
            <div class="relative">
                <span class="absolute left-5 top-1/2 transform -translate-y-1/2 text-gray-400">
                    <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M5 9V7a5 5 0 0110 0v2a2 2 0 012 2v5a2 2 0 01-2 2H5a2 2 0 01-2-2v-5a2 2 0 012-2zm8-2v2H7V7a3 3 0 016 0z" clip-rule="evenodd"/>
                    </svg>
                </span>
                <input
                    type="password"
                    id="password"
                    name="password"
                    placeholder="Password"
                    class="w-full pl-14 pr-6 py-4 bg-white rounded-full text-gray-700 placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-white/50 shadow-lg"
                    required
                >
            </div>

            <!-- Login Button -->
            <button
                type="submit"
                class="w-full bg-gray-800 hover:bg-gray-900 text-white font-semibold py-4 rounded-full transition duration-300 shadow-lg text-lg"
            >
                Login
            </button>
        </form>

        <!-- Forgot Password Link -->
        <div class="text-center mt-6">
            <a href="{{ url('/forgot-password') }}" class="text-white hover:text-gray-200 transition duration-300 text-sm">
                Forgot Username / Password?
            </a>
        </div>

        <!-- Register Link -->
        {{-- <div class="text-center mt-8">
            <span class="text-white">Belum punya akun?</span>
            <a href="{{ url('/register') }}" class="text-white hover:text-gray-200 font-semibold ml-1 underline transition duration-300">
                Daftar
            </a>
        </div> --}}
    </div>
</body>
</html>
