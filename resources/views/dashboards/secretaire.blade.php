@extends('layouts.app')

@section('content')
<div class="container mx-auto px-4 py-6">
    <div class="flex flex-col md:flex-row justify-between items-start md:items-center mb-8">
        <div>
            <h1 class="text-3xl font-bold text-gray-800">Tableau de bord Secrétaire</h1>
            <p class="text-lg text-gray-600 mt-2">Bienvenue, {{ $user->name }} ! Prête à organiser la journée ?</p>
        </div>
        <div class="mt-4 md:mt-0
        ">
            <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-blue-100 text-blue-800">
                <svg class="h-4 w-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                </svg>
                {{ now()->translatedFormat('l d F Y') }}
            </span>
        </div>
    </div>

    <!-- Grille de statistiques -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
        <!-- Total des patients -->
        <div class="bg-white p-6 rounded-xl shadow-sm border border-gray-100 hover:shadow-md transition-shadow duration-300">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm font-medium text-gray-500">Total Patients</p>
                    <p class="text-2xl font-bold text-gray-800 mt-1">{{ number_format($stats['total'], 0, ',', ' ') }}</p>
                </div>
                <div class="p-3 rounded-full bg-blue-50 text-blue-600">
                    <svg class="h-8 w-8" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path>
                    </svg>
                </div>
            </div>
            <div class="mt-4 flex items-center text-sm text-green-600">
                <span>+{{ $stats['newPatientsCount'] }} aujourd'hui</span>
            </div>
        </div>

        <!-- Rendez-vous du jour -->
        <div class="bg-white p-6 rounded-xl shadow-sm border border-gray-100 hover:shadow-md transition-shadow duration-300">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm font-medium text-gray-500">RDV aujourd'hui</p>
                    <p class="text-2xl font-bold text-gray-800">{{ $stats['todayAppointmentsCount'] }}</p>
                </div>
                <div class="p-3 rounded-full bg-purple-50 text-purple-600">
                    <svg class="h-8 w-8" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                    </svg>
                </div>
            </div>
            <div class="mt-4">
                <a href="{{ route('secretaire.rendez-vous.index') }}" class="text-sm text-purple-600 hover:text-purple-800 font-medium">Voir le calendrier →</a>
            </div>
        </div>

        <!-- Rendez-vous de la semaine -->
        <div class="bg-white p-6 rounded-xl shadow-sm border border-gray-100 hover:shadow-md transition-shadow duration-300">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm font-medium text-gray-500">RDV de la semaine</p>
                    <p class="text-2xl font-bold text-gray-800">{{ $stats['thisWeekAppointmentsCount'] }}</p>
                </div>
                <div class="p-3 rounded-full bg-orange-50 text-orange-600">
                    <svg class="h-8 w-8" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                </div>
            </div>
            <div class="mt-4">
                <a href="{{ route('secretaire.rendez-vous.index') }}" class="text-sm text-orange-600 hover:text-orange-800 font-medium">Voir le calendrier →</a>
            </div>
        </div>

        <!-- Nouveaux patients -->
        <div class="bg-white p-6 rounded-xl shadow-sm border border-gray-100 hover:shadow-md transition-shadow duration-300">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm font-medium text-gray-500">Nouveaux patients (aujourd'hui)</p>
                    <p class="text-2xl font-bold text-gray-800">{{ $stats['newPatientsCount'] }}</p>
                </div>
                <div class="p-3 rounded-full bg-green-50 text-green-600">
                    <svg class="h-8 w-8" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18 9v3m0 0v3m0-3h3m-3 0h-3m-2-5a4 4 0 11-8 0 4 4 0 018 0zM3 20a6 6 0 0112 0v1H3v-1z"></path>
                    </svg>
                </div>
            </div>
            <div class="mt-4">
                <a href="{{ route('secretaire.patients.index') }}" class="text-sm text-green-600 hover:text-green-800 font-medium">Voir tous les patients →</a>
            </div>
        </div>

        <!-- Actions rapides -->
        <div class="bg-white p-6 rounded-xl shadow-sm border border-gray-100 hover:shadow-md transition-shadow duration-300">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm font-medium text-gray-500">Actions Rapides</p>
                    <p class="text-2xl font-bold text-gray-800 mt-1">+</p>
                </div>
                <div class="h-12 w-12 rounded-full bg-green-100 flex items-center justify-center text-green-600">
                    <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                </div>
            </div>
            <div class="mt-4 flex space-x-2">
                <a href="{{ route('secretaire.patients.create') }}" class="text-sm bg-blue-600 hover:bg-blue-700 text-white px-3 py-1 rounded-md font-medium transition-colors duration-300">Nouveau Patient</a>
                <a href="{{ route('secretaire.rendez-vous.create') }}" class="text-sm bg-green-600 hover:bg-green-700 text-white px-3 py-1 rounded-md font-medium transition-colors duration-300">Nouveau RDV</a>
            </div>
        </div>
    </div>

    <!-- Section principale -->
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        <!-- Liste des prochains rendez-vous -->
        <div class="lg:col-span-2 bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
            <div class="p-6 border-b border-gray-100">
                <div class="flex items-center justify-between">
                    <h2 class="text-xl font-bold text-gray-800">Prochains Rendez-vous</h2>
                    <a href="{{ route('secretaire.rendez-vous.index') }}" class="text-sm text-blue-600 hover:text-blue-800 font-medium">Voir tout</a>
                </div>
            </div>
            <div class="divide-y divide-gray-100">
                @forelse ($stats['upcomingAppointments'] as $rdv)
                    @php
                        $isToday = \Carbon\Carbon::parse($rdv->date_rendez_vous)->isToday();
                        $isPast = \Carbon\Carbon::parse($rdv->date_rendez_vous)->isPast();
                        $statusClass = $isPast ? 'bg-yellow-50 border-l-4 border-yellow-400' : 'bg-white';
                    @endphp
                    <div class="p-4 hover:bg-gray-50 transition-colors duration-200 {{ $statusClass }}">
                        <div class="flex items-center justify-between">
                            <div class="flex items-center space-x-4">
                                <div class="flex-shrink-0">
                                    @if($rdv->patient && $rdv->patient->user && $rdv->patient->user->photo)
                                        <img class="h-10 w-10 rounded-full object-cover" src="{{ asset('storage/' . $rdv->patient->user->photo) }}" alt="{{ $rdv->patient->user->name }}">
                                    @else
                                        <div class="h-10 w-10 rounded-full bg-blue-100 flex items-center justify-center text-blue-600">
                                            <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                                            </svg>
                                        </div>
                                    @endif
                                </div>
                                <div class="min-w-0">
                                    <div class="flex items-center space-x-2">
                                        @if($isToday)
                                            <span class="px-2 py-0.5 text-xs font-medium bg-blue-100 text-blue-800 rounded-full">Aujourd'hui</span>
                                        @endif
                                        @if($rdv->consultation)
                                            <span class="px-2 py-0.5 text-xs font-medium bg-green-100 text-green-800 rounded-full">Consultation</span>
                                        @endif
                                    </div>
                                    <p class="text-sm font-medium text-gray-900 truncate mt-1">
                                        {{ $rdv->patient->user->name ?? 'Patient inconnu' }}
                                    </p>
                                    <div class="flex items-center text-sm text-gray-500">
                                        <svg class="flex-shrink-0 mr-1.5 h-4 w-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                                        </svg>
                                        <span>Dr. {{ $rdv->medecin->name ?? 'Médecin non attribué' }}</span>
                                    </div>
                                </div>
                            </div>
                            <div class="text-right">
                                <p class="text-sm font-medium text-gray-900 whitespace-nowrap">
                                    {{ \Carbon\Carbon::parse($rdv->date_rendez_vous)->format('H:i') }}
                                </p>
                                <p class="text-xs text-gray-500 whitespace-nowrap">
                                    {{ \Carbon\Carbon::parse($rdv->date_rendez_vous)->translatedFormat('d M Y') }}
                                </p>
                            </div>
                        </div>
                    </div>
                @empty
                    <div class="p-6 text-center">
                        <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                        </svg>
                        <h3 class="mt-2 text-sm font-medium text-gray-900">Aucun rendez-vous à venir</h3>
                        <p class="mt-1 text-sm text-gray-500">Commencez par planifier un nouveau rendez-vous.</p>
                        <div class="mt-6">
                            <a href="{{ route('secretaire.rendez-vous.create') }}" class="inline-flex items-center px-4 py-2 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                                <svg class="-ml-1 mr-2 h-5 w-5" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6" />
                                </svg>
                                Nouveau rendez-vous
                            </a>
                        </div>
                    </div>
                @endforelse
            </div>
        </div>

        <!-- Derniers patients inscrits -->
        <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
            <div class="p-6 border-b border-gray-100">
                <div class="flex items-center justify-between">
                    <h2 class="text-xl font-bold text-gray-800">Derniers Patients</h2>
                    <a href="{{ route('secretaire.patients.index') }}" class="text-sm text-blue-600 hover:text-blue-800 font-medium">Voir tout</a>
                </div>
            </div>
            <div class="divide-y divide-gray-100">
                @forelse ($stats['recentPatients'] as $patient)
                    @if($patient->user)
                        <div class="p-4 hover:bg-gray-50 transition-colors duration-200">
                            <div class="flex items-center space-x-4">
                                <div class="flex-shrink-0">
                                    @if($patient->user->photo)
                                        <img class="h-10 w-10 rounded-full" src="{{ asset('storage/' . $patient->user->photo) }}" alt="{{ $patient->user->name }}">
                                    @else
                                        <div class="h-10 w-10 rounded-full bg-gray-200 flex items-center justify-center text-gray-500">
                                            <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                                            </svg>
                                        </div>
                                    @endif
                                </div>
                                <div class="flex-1 min-w-0">
                                    <p class="text-sm font-medium text-gray-900 truncate">
                                        {{ $patient->user->name }}
                                    </p>
                                    <p class="text-sm text-gray-500 truncate">
                                        {{ $patient->numero_securite_sociale ?? 'N° SS non renseigné' }}
                                    </p>
                                </div>
                                <div>
                                    <a href="{{ route('secretaire.patients.show', $patient) }}" class="inline-flex items-center px-3 py-1 border border-gray-300 shadow-sm text-sm leading-4 font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                                        Voir
                                    </a>
                                </div>
                            </div>
                        </div>
                    @endif
                @empty
                    <div class="p-6 text-center">
                        <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z" />
                        </svg>
                        <h3 class="mt-2 text-sm font-medium text-gray-900">Aucun patient enregistré</h3>
                        <p class="mt-1 text-sm text-gray-500">Commencez par enregistrer un nouveau patient.</p>
                        <div class="mt-6">
                            <a href="{{ route('secretaire.patients.create') }}" class="inline-flex items-center px-4 py-2 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                                <svg class="-ml-1 mr-2 h-5 w-5" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6" />
                                </svg>
                                Nouveau patient
                            </a>
                        </div>
                    </div>
                @endforelse
            </div>
        </div>
    </div>
</div>
@endsection
