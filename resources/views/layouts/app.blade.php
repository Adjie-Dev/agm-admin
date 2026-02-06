<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title') - Aggajinamitto Admin</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    @stack('styles')
    <style>
        * {
            font-family: 'Outfit', sans-serif;
        }

        /* Custom Scrollbar */
        ::-webkit-scrollbar {
            width: 6px;
            height: 6px;
        }

        ::-webkit-scrollbar-track {
            background: rgba(30, 41, 59, 0.3);
        }

        ::-webkit-scrollbar-thumb {
            background: rgba(148, 163, 184, 0.5);
            border-radius: 3px;
        }

        ::-webkit-scrollbar-thumb:hover {
            background: rgba(148, 163, 184, 0.8);
        }
    </style>
</head>
<body class="overflow-hidden" style="background: linear-gradient(rgba(0, 0, 0, 0.7), rgba(0, 0, 0, 0.7)), url('{{ asset('images/bg.jpg') }}') center/cover no-repeat fixed;" x-data="{ sidebarOpen: false }">
    <div class="flex h-screen">
        <!-- Mobile sidebar backdrop -->
        <div x-show="sidebarOpen"
             @click="sidebarOpen = false"
             x-transition:enter="transition-opacity ease-linear duration-300"
             x-transition:enter-start="opacity-0"
             x-transition:enter-end="opacity-100"
             x-transition:leave="transition-opacity ease-linear duration-300"
             x-transition:leave-start="opacity-100"
             x-transition:leave-end="opacity-0"
             class="fixed inset-0 bg-black/60 z-40 lg:hidden backdrop-blur-sm"
             style="display: none;">
        </div>

        <!-- Sidebar -->
        <aside :class="sidebarOpen ? 'translate-x-0' : '-translate-x-full'"
               class="fixed lg:static inset-y-0 left-0 z-50 w-64 bg-gray-900/50 backdrop-blur-md border-r border-gray-700/50 transition-transform duration-300 ease-in-out lg:translate-x-0 flex flex-col shadow-2xl">

            <!-- Logo -->
            <div class="p-6 border-b border-gray-700/50">
                <div class="flex items-center justify-between">
                    <div class="flex flex-col items-center w-full">
                        <img src="{{ asset('images/agmDigital.png') }}" alt="Logo" class="w-17 h-16 object-cover mb-3 drop-shadow-2xl">
                        <h1 class="text-lg font-bold text-white tracking-tight">Agm Digital</h1>
                    </div>
                    <button @click="sidebarOpen = false" class="lg:hidden text-gray-400 hover:text-white absolute top-6 right-6 transition">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                        </svg>
                    </button>
                </div>
            </div>

            <!-- Navigation -->
            <nav class="flex-1 mt-4 px-3 space-y-1 overflow-y-auto">
                <p class="px-3 text-xs font-semibold text-gray-500 uppercase tracking-wider mb-3">MENU</p>


                {{-- Dashboard --}}
                <a href="{{ route('dashboard') }}"
                   class="group flex items-center space-x-3 px-3 py-3 rounded-xl transition-all {{ request()->routeIs('dashboard') ? 'bg-slate-700 text-white' : 'text-gray-300 hover:bg-gray-800 hover:text-white' }}"
                   @click="sidebarOpen = false">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"></path>
                    </svg>
                    <span class="font-medium">Dashboard</span>
                </a>


                {{-- Articles --}}
                <a href="{{ route('articles.index') }}"
                   class="group flex items-center space-x-3 px-3 py-3 rounded-xl transition-all {{ request()->routeIs('articles.*') ? 'bg-slate-700 text-white' : 'text-gray-300 hover:bg-gray-800 hover:text-white' }}"
                   @click="sidebarOpen = false">
                     <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M9 12h6M9 16h6M5 7h14a2 2 0 012 2v10a2 2 0 01-2 2H5a2 2 0 01-2-2V9a2 2 0 012-2z" />
                    </svg>
                    <span class="font-medium">Artikel</span>
                </a>

                {{-- digital book --}}
                <div x-data="{ formsOpen: localStorage.getItem('digitalBookOpen') === 'true' }">
                    <button @click.stop="formsOpen = !formsOpen; localStorage.setItem('digitalBookOpen', formsOpen)" class="w-full group flex items-center justify-between space-x-3 px-3 py-3 rounded-xl transition-all {{ request()->routeIs('dhammavachana.*') || request()->routeIs('ebooks.*') ? ' text-white' : 'text-gray-300 hover:bg-gray-800 hover:text-white' }}">
                        <div class="flex items-center space-x-3">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path>
                            </svg>
                            <span class="font-medium">Digital Book</span>
                        </div>
                        <svg class="w-4 h-4 transition-transform" :class="{ 'rotate-180': formsOpen }" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                        </svg>
                    </button>
                    <div x-show="formsOpen"
                         x-transition:enter="transition ease-out duration-200"
                         x-transition:enter-start="opacity-0 transform -translate-y-2"
                         x-transition:enter-end="opacity-100 transform translate-y-0"
                         x-transition:leave="transition ease-in duration-150"
                         x-transition:leave-start="opacity-100 transform translate-y-0"
                         x-transition:leave-end="opacity-0 transform -translate-y-2"
                         class="ml-6 mt-2 space-y-2"
                         style="display: none;"
                         @click.stop>
                        <a href="{{ route('dhammavachana.index') }}"
                            class="block px-3 py-2 text-sm rounded-lg transition {{ request()->routeIs('dhammavachana.*') ? ' text-white' : 'text-gray-400 hover:text-white' }}">
                            <span class="font-medium">Dhamma Vācanā</span>
                        </a>
                        <a href="{{ route('ebooks.index') }}"
                            class="block px-3 py-2 text-sm rounded-lg transition {{ request()->routeIs('ebooks.*') ? ' text-white' : 'text-gray-400 hover:text-white' }}">
                            <span class="font-medium">E-Book</span>
                        </a>
                    </div>
                </div>

                {{-- pali vãcanā --}}
                <div x-data="{ formsOpen: localStorage.getItem('paliVacanaOpen') === 'true' }">
                    <button @click.stop="formsOpen = !formsOpen; localStorage.setItem('paliVacanaOpen', formsOpen)" class="w-full group flex items-center justify-between space-x-3 px-3 py-3 rounded-xl transition-all {{ request()->routeIs('pathama-puja.*') || request()->routeIs('puja-pagi.*') ? ' text-white' : 'text-gray-300 hover:bg-gray-800 hover:text-white' }}">
                        <div class="flex items-center space-x-3">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path>
                            </svg>
                            <span class="font-medium">Pali Vãcanã</span>
                        </div>
                        <svg class="w-4 h-4 transition-transform" :class="{ 'rotate-180': formsOpen }" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                        </svg>
                    </button>
                    <div x-show="formsOpen"
                         x-transition:enter="transition ease-out duration-200"
                         x-transition:enter-start="opacity-0 transform -translate-y-2"
                         x-transition:enter-end="opacity-100 transform translate-y-0"
                         x-transition:leave="transition ease-in duration-150"
                         x-transition:leave-start="opacity-100 transform translate-y-0"
                         x-transition:leave-end="opacity-0 transform -translate-y-2"
                         class="ml-6 mt-2 space-y-2"
                         style="display: none;"
                         @click.stop>
                        <a href="{{ route('pathama-puja.index') }}"
                            class="block px-3 py-2 text-sm rounded-lg transition {{ request()->routeIs('pathama-puja.*') ? ' text-white' : 'text-gray-400 hover:text-white' }}">
                            <span class="font-medium">Pathama Puja</span>
                        </a>
                        <a href="{{ route('puja-pagi.index') }}"
                            class="block px-3 py-2 text-sm rounded-lg transition {{ request()->routeIs('puja-pagi.*') ? ' text-white' : 'text-gray-400 hover:text-white' }}">
                            <span class="font-medium">Puja Pagi</span>
                        </a>
                    </div>
                </div>



                <a href="{{ route('kalender-buddhist.index') }}"
                   class="group flex items-center space-x-3 px-3 py-3 rounded-xl transition-all {{ request()->routeIs('kalender-buddhist.*') ? 'bg-slate-700 text-white' : 'text-gray-300 hover:bg-gray-800 hover:text-white' }}"
                   @click="sidebarOpen = false">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                    </svg>
                    <span class="font-medium">Kalendar Buddhist</span>
                </a>

                <p class="px-3 text-xs font-semibold text-gray-500 uppercase tracking-wider mb-3 mt-6">OTHERS</p>

                <a href="#"
                   class="group flex items-center space-x-3 px-3 py-3 rounded-xl transition-all text-gray-300 hover:bg-gray-800 hover:text-white"
                   @click="sidebarOpen = false">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"></path>
                    </svg>
                    <span class="font-medium">Media Library</span>
                </a>
            </nav>
        </aside>

        <!-- Main Content -->
        <div class="flex-1 flex flex-col overflow-hidden">
            <header class="bg-gray-900/70 backdrop-blur-md border-b border-gray-700/70 px-6 py-4 shadow-lg relative z-50">
                <div class="flex items-center justify-between">
                    <div class="flex items-center space-x-4">
                        <button @click="sidebarOpen = !sidebarOpen" class="lg:hidden p-2 rounded-xl text-gray-400 hover:bg-gray-800 hover:text-white transition">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"></path>
                            </svg>
                        </button>
                        <h2 class="text-2xl font-bold text-white">@yield('header')</h2>
                    </div>

                    <div class="flex items-center space-x-3">
                        <!-- Date Display with Real-time -->
                        <div class="hidden sm:flex items-center space-x-2 px-4 py-2">
                            <svg class="w-4 h-4 text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                            </svg>
                            <span class="text-sm text-gray-300 font-medium" id="currentDate"></span>
                        </div>

                        <div x-data="{ userMenuOpen: false }" class="relative">
                            <button @click="userMenuOpen = !userMenuOpen" class="flex items-center space-x-3 px-3 py-2 hover:border-white rounded-xl transition">
                                @if(Auth::user()->profile_photo)
                                    <img src="{{ asset('storage/' . Auth::user()->profile_photo) }}?t={{ time() }}" alt="User" class="w-8 h-8 rounded-full object-cover">
                                @else
                                    <div class="w-8 h-8 rounded-full bg-indigo-600 flex items-center justify-center">
                                        <span class="text-xs font-bold text-white">{{ strtoupper(substr(Auth::user()->name, 0, 2)) }}</span>
                                    </div>
                                @endif
                                <div class="hidden md:block text-start">
                                    <p class="text-sm font-semibold text-white">{{ Auth::user()->name }}</p>
                                    <p class="text-xs text-gray-400">{{ Auth::user()->role === 'admin' ? 'Administrator' : 'User' }}</p>
                                </div>
                                <svg class="w-4 h-4 text-gray-400 transition-transform" :class="{ 'rotate-180': userMenuOpen }" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                                </svg>
                            </button>

                            <div x-show="userMenuOpen"
                                 @click.away="userMenuOpen = false"
                                 x-transition:enter="transition ease-out duration-100"
                                 x-transition:enter-start="transform opacity-0 scale-95"
                                 x-transition:enter-end="transform opacity-100 scale-100"
                                 x-transition:leave="transition ease-in duration-75"
                                 x-transition:leave-start="transform opacity-100 scale-100"
                                 x-transition:leave-end="transform opacity-0 scale-95"
                                 class="absolute right-0 mt-2 w-48 bg-gray-700/50 backdrop-blur-md rounded-xl shadow-2xl py-2 z-[9999] border border-gray-700/50"
                                 style="display: none;">
                                <a href="{{ route('profile.show') }}" class="flex items-center space-x-3 px-4 py-2.5 text-sm text-gray-400 hover:text-white transition">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                                    </svg>
                                    <span>Profile</span>
                                </a>
                                <div class="h-px bg-gray-700/50 my-2"></div>
                                <form method="POST" action="{{ route('logout') }}">
                                    @csrf
                                    <button type="submit" class="w-full flex items-center space-x-3 px-4 py-2.5 text-sm text-red-400 hover:text-red-300 transition">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"></path>
                                        </svg>
                                        <span>Logout</span>
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </header>

            <!-- Content Area -->
            <main class="flex-1 overflow-y-auto p-6">
                @yield('content')
            </main>
        </div>
    </div>

    <script>
        // Function buat update tanggal secara real-time
        function updateDate() {
            const now = new Date();
            const options = { day: '2-digit', month: 'short', year: 'numeric' };
            const formattedDate = now.toLocaleDateString('en-GB', options);
            document.getElementById('currentDate').textContent = formattedDate;
        }

        updateDate();
        setInterval(updateDate, 1000);
    </script>
    @stack('scripts')
</body>
</html>
