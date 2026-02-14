<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - AGM Admin</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="min-h-screen flex items-center justify-center p-4" style="background: linear-gradient(rgba(0, 0, 0, 0.5), rgba(0, 0, 0, 0.5)), url('{{ asset('images/bg.webp') }}') center/cover no-repeat fixed;">
    <div class="w-full max-w-md">
        <div class="flex flex-col items-center mb-8">
            <div class="w-40 h-40 rounded-full bg-black flex items-center justify-center p-6 mb-4">
                <img src="{{ asset('images/agm.webp') }}" alt="AGM Digital" class="w-full h-full object-cover">
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
                    class="w-full pl-14 pr-14 py-4 bg-white rounded-full text-gray-700 placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-white/50 shadow-lg"
                    required
                >
                <button
                    type="button"
                    id="togglePassword"
                    class="absolute right-5 top-1/2 transform -translate-y-1/2 text-gray-400 hover:text-gray-600 focus:outline-none"
                >
                    <!-- Eye Icon (Show) -->
                    <svg id="eyeIcon" class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                    </svg>
                    <!-- Eye Slash Icon (Hide) - Hidden by default -->
                    <svg id="eyeSlashIcon" class="w-5 h-5 hidden" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.543-7a9.97 9.97 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.88 9.88l-3.29-3.29m7.532 7.532l3.29 3.29M3 3l3.59 3.59m0 0A9.953 9.953 0 0112 5c4.478 0 8.268 2.943 9.543 7a10.025 10.025 0 01-4.132 5.411m0 0L21 21"/>
                    </svg>
                </button>
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

    <script>
        const togglePassword = document.getElementById('togglePassword');
        const passwordInput = document.getElementById('password');
        const eyeIcon = document.getElementById('eyeIcon');
        const eyeSlashIcon = document.getElementById('eyeSlashIcon');

        togglePassword.addEventListener('click', function() {
            // Toggle password visibility
            const type = passwordInput.getAttribute('type') === 'password' ? 'text' : 'password';
            passwordInput.setAttribute('type', type);

            // Toggle icon visibility
            eyeIcon.classList.toggle('hidden');
            eyeSlashIcon.classList.toggle('hidden');
        });
    </script>
</body>
</html>
