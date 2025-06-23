<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>Hospiweb</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.gstatic.com/" crossorigin="" />
    <link rel="stylesheet" as="style" onload="this.rel='stylesheet'"
        href="https://fonts.googleapis.com/css2?display=swap&amp;family=Public+Sans%3Awght%40400%3B500%3B700%3B900" />

    <!-- Scripts -->
    <script src="https://cdn.tailwindcss.com?plugins=forms,container-queries"></script>

    <!-- Favicon -->
    <link rel="icon" type="image/svg+xml" href="{{ asset('favicon.svg') }}" />
</head>

<body class="font-sans antialiased">
    <div class="min-h-screen bg-gray-100">
        <div class="flex">
            <!-- Sidebar -->
            <aside class="w-64 bg-white shadow-md min-h-screen flex flex-col justify-between">
                <div>
                    <div class="p-4 border-b">
                        <a href="{{ route('dashboard') }}" class="flex items-center gap-3">
                            {{-- <div class="bg-center bg-no-repeat aspect-square bg-cover rounded-full size-10"
                                style='background-image: url("https://lh3.googleusercontent.com/aida-public/AB6AXuCYwS462gNiAu_ZM6yRCstdcK9T-pt8JiZaFMe2TVqtGaw_nASupRNNRT5SDwZEaHrtVcOvdxrYdaAbJokJPHYpf745UywDPvJLocw2FkLCF7xac-atQoVDDSjJiJXQNTiQvIs0MNRz9-zi4texquEf9fzNctIQLebF1-flLFsSVj2ueYRrHAIQA04XyG8itrpA-Wn2fx-8zix1-0ImFwP4V_Y2QProqxwmL24exK54Jh2yqffRpHAygeLLG-qdQa0YF6uwEcT2JzU");'>
                            </div> --}}
                            <span class="flex items-center gap-2">
                                <!-- Logo SVG médical stylisé -->
                                <img src="{{ asset('images/hospital-logo.svg') }}" alt="Logo Hôpital" class="h-8 w-8" />
                                <span class="text-xl font-bold text-gray-800 tracking-tight">Hospiweb</span>
                            </span>
                        </a>
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
                        </a>
                        <a href="{{ route('rapports.index') }}"
                            class="flex items-center gap-3 px-4 py-2 mt-2 text-gray-700 rounded-lg transition-colors duration-200 {{ request()->routeIs('rapports.*') ? 'bg-blue-100 text-blue-700' : 'hover:bg-gray-100' }}">
                            <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                                xmlns="http://www.w3.org/2000/svg">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z">
                                </path>
                            </svg>
                            <span>Rapports</span>
                        </a>
                        {{-- Ajoutez d'autres liens ici --}}
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
            <main class="flex-1 p-6">
                @yield('content')
            </main>
        </div>
    </div>
</body>

</html>
