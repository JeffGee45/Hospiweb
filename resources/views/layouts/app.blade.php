<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Hospiweb') }}</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />
    
    <!-- Font Awesome pour les icônes -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" />

    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <script src="https://cdn.jsdelivr.net/gh/alpinejs/alpine@v2.x.x/dist/alpine.min.js" defer></script>
</head>
<body class="font-sans antialiased bg-gray-100">
    <div x-data="{ sidebarOpen: false }" class="flex h-screen bg-gray-200">
        <!-- Sidebar -->
        <aside :class="sidebarOpen ? 'block' : 'hidden'" @click.away="sidebarOpen = false" class="fixed inset-y-0 left-0 z-30 w-64 overflow-y-auto bg-gray-800 transition duration-300 transform lg:translate-x-0 lg:static lg:inset-0">
            <div class="flex items-center justify-center mt-8">
                <div class="flex items-center">
                    <i class="fas fa-hospital-user fa-2x text-white"></i>
                    <span class="mx-2 text-2xl font-semibold text-white">Hospiweb</span>
                    </div>
                    <nav class="mt-4">
                        <a href="{{ route('dashboard') }}"
                            class="flex items-center gap-3 px-4 py-2 text-gray-700 rounded-lg transition-colors duration-200 {{ request()->routeIs('dashboard') ? 'bg-blue-100 text-blue-700' : 'hover:bg-gray-100' }}">
                            <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                                xmlns="http://www.w3.org/2000/svg">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6">
                                </path>
                            </svg>
                            <span>Tableau de bord</span>
                        </a>
                        <a href="{{ route('patients.index') }}"
                            class="flex items-center gap-3 px-4 py-2 mt-2 text-gray-700 rounded-lg transition-colors duration-200 {{ request()->routeIs('patients.*') ? 'bg-blue-100 text-blue-700' : 'hover:bg-gray-100' }}">
                            <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                                xmlns="http://www.w3.org/2000/svg">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.653-.124-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.653.124-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z">
                                </path>
                            </svg>
                            <span>Patients</span>
                        </a>
                        <a href="{{ route('medecins.index') }}"
                            class="flex items-center gap-3 px-4 py-2 mt-2 text-gray-700 rounded-lg transition-colors duration-200 {{ request()->routeIs('medecins.*') ? 'bg-blue-100 text-blue-700' : 'hover:bg-gray-100' }}">
                            <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                                xmlns="http://www.w3.org/2000/svg">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M21 13.255A23.931 23.931 0 0112 15c-3.183 0-6.22-.62-9-1.745M16 6V4a2 2 0 00-2-2h-4a2 2 0 00-2 2v2m4 6h.01M5 20h14a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z">
                                </path>
                            </svg>
                            <span>Médecins</span>
                        </a>
                        <a href="{{ route('rendez-vous.index') }}"
                            class="flex items-center gap-3 px-4 py-2 mt-2 text-gray-700 rounded-lg transition-colors duration-200 {{ request()->routeIs('rendez-vous.*') ? 'bg-blue-100 text-blue-700' : 'hover:bg-gray-100' }}">
                            <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                                xmlns="http://www.w3.org/2000/svg">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z">
                                </path>
                            </svg>
                            <span>Rendez-vous</span>
                    </nav>
                </div>
                <div class="p-4 border-t">
                    <div class="flex items-center gap-3 mb-3">
                        <div class="bg-center bg-no-repeat aspect-square bg-cover rounded-full size-10"
                            style='background-image: url("https://lh3.googleusercontent.com/a/ACg8ocJ-92yI_iWk5qKx_Y5S...=s96-c");'>
                            {{-- Placeholder --}}
                        </div>
                        <div>
                            <p class="font-semibold text-gray-800">{{ Auth::user()->name }}</p>
                        </div>
                    </div>
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button type="submit"
                            class="w-full flex items-center gap-3 px-4 py-2 text-left text-sm text-red-600 hover:bg-red-100 rounded-lg transition-colors duration-200">
                            <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                                xmlns="http://www.w3.org/2000/svg">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1">
                                </path>
                            </svg>
                            <span>Se déconnecter</span>
                        </button>
                    </form>
                </div>
            </aside>

            <!-- Main Content -->
            <div class="container mx-auto px-6 py-8">
                @if (session('error'))
                    <div class="bg-red-500 text-white font-bold rounded-t px-4 py-2 mb-4">
                        Erreur
                    </div>
                    <div class="border border-t-0 border-red-400 rounded-b bg-red-100 px-4 py-3 text-red-700 mb-4">
                        <p>{{ session('error') }}</p>
                    </div>
                @endif
                @yield('content')
            </div>
        </div>
    </div>
</body>

</html>
