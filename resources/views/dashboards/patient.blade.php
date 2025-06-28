@extends('layouts.app')

@section('content')
<div class="container mx-auto px-4 py-8">
    <div class="flex justify-between items-center mb-8">
        <div>
            <h1 class="text-3xl font-bold text-gray-800">Tableau de Bord Patient</h1>
            <p class="text-gray-600 mt-2">Bienvenue, {{ $user->name }}. Gérez vos rendez-vous médicaux.</p>
        </div>
        <a href="{{ route('patient.rendez-vous.create') }}" class="inline-flex items-center px-4 py-2 bg-blue-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-blue-700 active:bg-blue-800 focus:outline-none focus:border-blue-900 focus:ring focus:ring-blue-300 disabled:opacity-25 transition">
            <i class="fas fa-calendar-plus mr-2"></i> Prendre rendez-vous
        </a>
    </div>

    <!-- Cartes de statistiques -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
        <!-- Carte Rendez-vous à venir -->
        <div class="bg-white rounded-lg shadow-md p-6 flex items-center">
            <div class="p-3 rounded-full bg-blue-100 text-blue-600 mr-4">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                </svg>
            </div>
            <div>
                <p class="text-sm font-medium text-gray-500">Rendez-vous à venir</p>
                <p class="text-2xl font-semibold text-gray-800">{{ $stats['upcomingAppointmentsCount'] }}</p>
            </div>
        </div>

        <!-- Carte Historique -->
        <div class="bg-white rounded-lg shadow-md p-6 flex items-center">
            <div class="p-3 rounded-full bg-green-100 text-green-600 mr-4">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2" />
                </svg>
            </div>
            <div>
                <p class="text-sm font-medium text-gray-500">Rendez-vous passés</p>
                <p class="text-2xl font-semibold text-gray-800">{{ $stats['pastAppointmentsCount'] }}</p>
            </div>
        </div>
    </div>

    <!-- Sections principales -->
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6 mb-8">
        <!-- Section Prochains rendez-vous -->
        <div class="bg-white rounded-lg shadow-md p-6">
            <div class="flex justify-between items-center mb-4">
                <h2 class="text-xl font-semibold text-gray-800">Prochains rendez-vous</h2>
                <a href="{{ route('patient.rendez-vous.index') }}" class="text-sm text-blue-600 hover:text-blue-800">Voir tout</a>
            </div>
            <div class="space-y-4">
                @forelse($upcomingAppointments as $rdv)
                    <a href="{{ route('patient.rendez-vous.show', $rdv->id) }}" class="flex items-center p-3 bg-gray-50 hover:bg-gray-100 rounded-lg transition">
                        <div class="p-2 bg-blue-100 rounded-lg mr-3">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-blue-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                            </svg>
                        </div>
                        <div class="flex-1">
                            <p class="font-medium text-gray-800">Dr. {{ $rdv->medecin->user->name ?? 'N/A' }}</p>
                            <p class="text-sm text-gray-500">{{ $rdv->date_rendez_vous->format('d/m/Y \à H:i') }}</p>
                            @if($rdv->motif)
                                <p class="text-sm text-gray-600 mt-1">
                                    <span class="font-medium">Motif :</span> {{ Str::limit($rdv->motif, 50) }}
                                </p>
                            @endif
                        </div>
                        <span class="px-2 py-1 text-xs font-semibold rounded-full {{ 
                            $rdv->statut === 'confirmé' ? 'bg-green-100 text-green-800' : 
                            ($rdv->statut === 'en_attente' ? 'bg-yellow-100 text-yellow-800' : 
                            'bg-red-100 text-red-800') 
                        }}">
                            {{ ucfirst(str_replace('_', ' ', $rdv->statut)) }}
                        </span>
                    </a>
                @empty
                    <div class="text-center py-4">
                        <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-6 9l2 2 4-4" />
                        </svg>
                        <p class="mt-2 text-sm text-gray-500">Aucun rendez-vous à venir</p>
                    </div>
                @endforelse
            </div>
        </div>

        <!-- Section Informations Médicales -->
        <div class="bg-white rounded-lg shadow-md p-6">
            <div class="flex justify-between items-center mb-4">
                <h2 class="text-xl font-semibold text-gray-800">Mes Informations Médicales</h2>
                <a href="#" class="text-sm text-blue-600 hover:text-blue-800">Modifier</a>
            </div>
            
            @if($patient)
                <div class="space-y-4">
                    <div class="p-4 bg-gray-50 rounded-lg">
                        <h3 class="text-sm font-medium text-gray-500">Groupe Sanguin</h3>
                        <p class="mt-1 text-lg font-semibold text-gray-900">
                            {{ $patient->groupe_sanguin ?: 'Non renseigné' }}
                        </p>
                    </div>
                    <div class="p-4 bg-gray-50 rounded-lg">
                        <h3 class="text-sm font-medium text-gray-500">Allergies</h3>
                        <p class="mt-1 text-gray-900">
                            {{ $patient->allergies ? (is_array($patient->allergies) ? implode(', ', $patient->allergies) : $patient->allergies) : 'Aucune déclarée' }}
                        </p>
                    </div>
                    <div class="p-4 bg-gray-50 rounded-lg">
                        <h3 class="text-sm font-medium text-gray-500">Traitements en cours</h3>
                        <p class="mt-1 text-gray-900">
                            {{ $patient->traitements_en_cours ? (is_array($patient->traitements_en_cours) ? implode(', ', $patient->traitements_en_cours) : $patient->traitements_en_cours) : 'Aucun déclaré' }}
                        </p>
                    </div>
                </div>
            @else
                <div class="text-center py-8">
                    <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                    </svg>
                    <h3 class="mt-2 text-sm font-medium text-gray-900">Aucune information médicale</h3>
                    <p class="mt-1 text-sm text-gray-500">Vos informations médicales n'ont pas encore été complétées.</p>
                    <div class="mt-6">
                        <a href="#" class="inline-flex items-center px-4 py-2 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                            <svg class="-ml-1 mr-2 h-5 w-5" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                                <path fill-rule="evenodd" d="M10 5a1 1 0 011 1v3h3a1 1 0 110 2h-3v3a1 1 0 11-2 0v-3H6a1 1 0 110-2h3V6a1 1 0 011-1z" clip-rule="evenodd" />
                            </svg>
                            Ajouter des informations
                        </a>
                    </div>
                </div>
            @endif
        </div>
    </div>
</div>
@endsection
