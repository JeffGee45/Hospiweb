<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>Hospiweb</title>

    <!-- Fonts locaux intégrés dans app.css -->
    {{--
    Exemple à ajouter dans resources/css/app.css :
    @font-face {
      font-family: 'Public Sans';
      src: url('/fonts/public-sans/PublicSans-Regular.woff2') format('woff2');
      font-weight: 400;
      font-style: normal;
      font-display: swap;
    }
    body, .font-sans {
      font-family: 'Public Sans', sans-serif;
    }
    --}}

    <!-- CSS/JS compilés locaux -->
            <!-- Google Fonts -->
        <link href="https://fonts.googleapis.com/css2?family=Public+Sans:wght@400;700&display=swap" rel="stylesheet">
        <!-- AlpineJS -->
        <script src="//unpkg.com/alpinejs" defer></script>

        @vite(['resources/css/app.css', 'resources/js/app.js'])

    <!-- Favicon -->
    <link rel="icon" type="image/svg+xml" href="{{ asset('favicon.svg') }}" />

    @stack('styles')
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
                            <img class="h-16 w-auto mx-auto" src="{{ asset('images/hospital-logo.svg') }}" alt="Hospiweb Logo">
                        </a>
                    </div>
                    <nav class="mt-4 flex-grow">
                        {{-- Lien Tableau de bord (commun à tous) --}}
                        <a href="{{ route('dashboard') }}" class="flex items-center gap-3 px-4 py-2 text-gray-700 rounded-lg transition-colors duration-200 {{ request()->routeIs('dashboard') ? 'bg-blue-100 text-blue-700' : 'hover:bg-gray-100' }}">
                            <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"></path></svg>
                            <span>Tableau de bord</span>
                        </a>

                        {{-- Liens pour la Secrétaire --}}
                        @if(Auth::user()->role === 'Secretaire')
                            <a href="{{ route('secretary.patients.index') }}" class="flex items-center gap-3 px-4 py-2 mt-2 text-gray-700 rounded-lg transition-colors duration-200 {{ request()->routeIs('secretary.patients.*') ? 'bg-blue-100 text-blue-700' : 'hover:bg-gray-100' }}">
                                <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.653-.124-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.653.124-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path></svg>
                                <span>Gestion des Patients</span>
                            </a>
                            <a href="{{ route('secretaire.rendez-vous.index') }}" class="flex items-center gap-3 px-4 py-2 mt-2 text-gray-700 rounded-lg transition-colors duration-200 {{ request()->routeIs('secretaire.rendez-vous.*') ? 'bg-blue-100 text-blue-700' : 'hover:bg-gray-100' }}">
                                <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                                <span>Gestion des Rendez-vous</span>
                            </a>
                        @endif

                        {{-- Liens pour le Médecin --}}
                        @if(Auth::user()->role === 'Médecin')
                            <a href="{{ route('medecin.patients.index') }}" class="flex items-center gap-3 px-4 py-2 mt-2 text-gray-700 rounded-lg transition-colors duration-200 {{ request()->routeIs('medecin.patients.*') ? 'bg-blue-100 text-blue-700' : 'hover:bg-gray-100' }}">
                                <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.653-.124-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.653.124-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path></svg>
                                <span>Mes Patients</span>
                            </a>
                            <a href="{{ route('medecin.rendez-vous.index') }}" class="flex items-center gap-3 px-4 py-2 mt-2 text-gray-700 rounded-lg transition-colors duration-200 {{ request()->routeIs('medecin.rendez-vous.*') ? 'bg-blue-100 text-blue-700' : 'hover:bg-gray-100' }}">
                                <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                                <span>Mon Agenda</span>
                            </a>
                        @endif

                        {{-- Lien pour Infirmier(e) --}}
                        @if(Auth::user()->role === 'Infirmier(e)')
                            <a href="{{ route('soins.index') }}" class="flex items-center gap-3 px-4 py-2 mt-2 text-gray-700 rounded-lg transition-colors duration-200 {{ request()->routeIs('soins.*') ? 'bg-blue-100 text-blue-700' : 'hover:bg-gray-100' }}">
                                <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"></path></svg>
                                <span>Soins</span>
                            </a>
                        @endif

                        {{-- Lien pour Pharmacien --}}
                        @if(Auth::user()->role === 'Pharmacien')
                            <a href="{{ route('pharmacie.index') }}" class="flex items-center gap-3 px-4 py-2 mt-2 text-gray-700 rounded-lg transition-colors duration-200 {{ request()->routeIs('pharmacie.*') ? 'bg-blue-100 text-blue-700' : 'hover:bg-gray-100' }}">
                                <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"></path></svg>
                                <span>Pharmacie</span>
                            </a>
                        @endif

                        {{-- Lien pour Caissier --}}
                        @if(Auth::user()->role === 'Caissier')
                            <a href="{{ route('facturation.index') }}" class="flex items-center gap-3 px-4 py-2 mt-2 text-gray-700 rounded-lg transition-colors duration-200 {{ request()->routeIs('facturation.*') ? 'bg-blue-100 text-blue-700' : 'hover:bg-gray-100' }}">
                                <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
                                <span>Facturation</span>
                            </a>
                        @endif

                        {{-- Section Administration (visible uniquement par l'Admin) --}}
                        @if(Auth::user()->role === 'Admin')
                            <div class="mt-4 pt-4 border-t border-gray-200">
                                <span class="px-4 text-xs font-semibold text-gray-500 uppercase">Gestion des patients</span>
                                <a href="{{ route('admin.patients.index') }}" class="flex items-center gap-3 px-4 py-2 mt-2 text-gray-700 rounded-lg transition-colors duration-200 {{ request()->routeIs('admin.patients.*') ? 'bg-blue-100 text-blue-700' : 'hover:bg-gray-100' }}">
                                    <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.653-.124-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.653.124-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path></svg>
                                    <span>Gestion des Patients</span>
                                </a>
                                <span class="px-4 text-xs font-semibold text-gray-500 uppercase">Administration</span>
                                <a href="{{ route('admin.users.index') }}" class="flex items-center gap-3 px-4 py-2 mt-2 text-gray-700 rounded-lg transition-colors duration-200 {{ request()->routeIs('admin.users.*') ? 'bg-blue-100 text-blue-700' : 'hover:bg-gray-100' }}">
                                    <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18 18.72a9.094 9.094 0 0 0 3.741-.479 3 3 0 0 0-4.682-2.72m-7.5-2.962a4.5 4.5 0 1 1 9 0 4.5 4.5 0 0 1-9 0Zm-7.5 2.962c0-1.331.375-2.597 1.032-3.686a9.094 9.094 0 0 1 5.932-3.042m-5.932 6.728a9.092 9.092 0 0 0 3.741.479 3 3 0 0 0-4.682-2.72M12 12.75a4.5 4.5 0 1 1 9 0 4.5 4.5 0 0 1-9 0Z" /></svg>
                                    <span>Gestion des Utilisateurs</span>
                                </a>
                                <a href="{{ route('admin.users.index') }}?role=Médecin" class="flex items-center gap-3 px-4 py-2 mt-2 text-gray-700 rounded-lg transition-colors duration-200 {{ request()->get('role') === 'Médecin' ? 'bg-blue-100 text-blue-700' : 'hover:bg-gray-100' }}">
                                    <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 13.255A23.931 23.931 0 0112 15c-3.183 0-6.22-.62-9-1.745M16 6V4a2 2 0 00-2-2h-4a2 2 0 00-2 2v2m4 6h.01M5 20h14a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path></svg>
                                    <span>Médecins</span>
                                </a>
                                <a href="{{ route('admin.rapports.index') }}" class="flex items-center gap-3 px-4 py-2 mt-2 text-gray-700 rounded-lg transition-colors duration-200 {{ request()->routeIs('admin.rapports.*') ? 'bg-blue-100 text-blue-700' : 'hover:bg-gray-100' }}">
                                    <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"></path></svg>
                                    <span>Rapports</span>
                                </a>
                            </div>
                        @endif
                    </nav>
                </div>
                <div class="p-4 border-t">
                    <!-- Menu déroulant du profil -->
                    <div x-data="{ open: false }" class="relative">
                        <!-- Bouton du menu -->
                        <button @click="open = !open" class="w-full flex items-center justify-between p-2 rounded-lg hover:bg-gray-100 transition-colors duration-200">
                            <div class="flex items-center gap-3">
                                <div class="bg-blue-100 text-blue-700 rounded-full p-2">
                                    <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                                    </svg>
                                </div>
                                <div class="text-left">
                                    <p class="font-semibold text-sm text-gray-800">{{ Auth::user()->name }}</p>
                                    <p class="text-xs text-gray-500">{{ Auth::user()->role }}</p>
                                </div>
                            </div>
                            <svg :class="{ 'transform rotate-180': open }" class="h-5 w-5 text-gray-500 transition-transform duration-200" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
                            </svg>
                        </button>

                        <!-- Menu déroulant -->
                        <div x-show="open" 
                             @click.away="open = false"
                             x-transition:enter="transition ease-out duration-100"
                             x-transition:enter-start="transform opacity-0 scale-95"
                             x-transition:enter-end="transform opacity-100 scale-100"
                             x-transition:leave="transition ease-in duration-75"
                             x-transition:leave-start="transform opacity-100 scale-100"
                             x-transition:leave-end="transform opacity-0 scale-95"
                             class="absolute bottom-full left-0 right-0 mb-2 w-full origin-bottom-left rounded-md bg-white shadow-lg ring-1 ring-black ring-opacity-5 focus:outline-none z-10"
                             style="display: none;">
                            <div class="py-1" role="none">
                                <a href="{{ route('profile.show') }}" class="flex items-center gap-2 px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">
                                    <svg class="h-5 w-5 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                                    </svg>
                                    Mon profil
                                </a>
                                <a href="{{ route('profile.edit') }}" class="flex items-center gap-2 px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">
                                    <svg class="h-5 w-5 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                                    </svg>
                                    Modifier le profil
                                </a>
                                <div class="border-t border-gray-100 my-1"></div>
                                <form method="POST" action="{{ route('logout') }}" class="w-full">
                                    @csrf
                                    <button type="submit" class="w-full flex items-center gap-2 px-4 py-2 text-sm text-red-600 hover:bg-red-50">
                                        <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1" />
                                        </svg>
                                        Se déconnecter
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </aside>

            <!-- Main Content -->
            <main class="flex-1 p-6">
                @yield('content')
            </main>
        </div>
    </div>
    

    @stack('scripts')
</body>

</html>
