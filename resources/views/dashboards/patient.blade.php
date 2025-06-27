@extends('layouts.app')

@section('content')
<div class="container mx-auto px-4 py-8">
    <div class="mb-8">
        <h1 class="text-3xl font-bold text-gray-800 mb-2">Tableau de bord Patient</h1>
        <p class="text-gray-600">Bienvenue, {{ $user->name }}. Voici un aperçu de vos rendez-vous et informations.</p>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
        <!-- Prochains rendez-vous -->
        <div class="bg-white rounded-lg shadow-md overflow-hidden">
            <div class="bg-blue-600 px-6 py-4">
                <h2 class="text-lg font-semibold text-white">Prochains rendez-vous</h2>
            </div>
            <div class="p-6">
                @if($upcomingAppointments->count() > 0)
                    <div class="space-y-4">
                        @foreach($upcomingAppointments as $appointment)
                            <div class="border-b border-gray-100 pb-4 last:border-0 last:pb-0">
                                <div class="flex justify-between items-start">
                                    <div>
                                        <p class="font-medium text-gray-900">Dr. {{ $appointment->medecin->name ?? 'Médecin non spécifié' }}</p>
                                        <p class="text-sm text-gray-600">
                                            {{ $appointment->date_heure->format('d/m/Y H:i') }}
                                        </p>
                                        @if($appointment->motif)
                                            <p class="mt-1 text-sm text-gray-500">
                                                <span class="font-medium">Motif :</span> {{ $appointment->motif }}
                                            </p>
                                        @endif
                                    </div>
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-blue-100 text-blue-800">
                                        À venir
                                    </span>
                                </div>
                            </div>
                        @endforeach
                    </div>
                @else
                    <p class="text-gray-500 text-center py-4">Aucun rendez-vous à venir.</p>
                @endif
                
                <div class="mt-6">
                    <a href="{{ route('rendezvous.create') }}" class="inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md shadow-sm text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                        <svg class="-ml-1 mr-2 h-5 w-5" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                            <path fill-rule="evenodd" d="M10 5a1 1 0 011 1v3h3a1 1 0 110 2h-3v3a1 1 0 11-2 0v-3H6a1 1 0 110-2h3V6a1 1 0 011-1z" clip-rule="evenodd" />
                        </svg>
                        Prendre rendez-vous
                    </a>
                </div>
            </div>
        </div>

        <!-- Historique des rendez-vous -->
        <div class="bg-white rounded-lg shadow-md overflow-hidden">
            <div class="bg-gray-600 px-6 py-4">
                <h2 class="text-lg font-semibold text-white">Historique des rendez-vous</h2>
            </div>
            <div class="p-6">
                @if($pastAppointments->count() > 0)
                    <div class="space-y-4">
                        @foreach($pastAppointments as $appointment)
                            <div class="border-b border-gray-100 pb-4 last:border-0 last:pb-0">
                                <div class="flex justify-between items-start">
                                    <div>
                                        <p class="font-medium text-gray-900">Dr. {{ $appointment->medecin->name ?? 'Médecin non spécifié' }}</p>
                                        <p class="text-sm text-gray-600">
                                            {{ $appointment->date_heure->format('d/m/Y H:i') }}
                                        </p>
                                        @if($appointment->motif)
                                            <p class="mt-1 text-sm text-gray-500">
                                                <span class="font-medium">Motif :</span> {{ $appointment->motif }}
                                            </p>
                                        @endif
                                    </div>
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-gray-100 text-gray-800">
                                        Terminé
                                    </span>
                                </div>
                                @if($appointment->consultation && $appointment->consultation->diagnostic)
                                    <div class="mt-2 p-3 bg-gray-50 rounded-md">
                                        <p class="text-sm font-medium text-gray-700">Diagnostic :</p>
                                        <p class="text-sm text-gray-600">{{ Str::limit($appointment->consultation->diagnostic, 100) }}</p>
                                    </div>
                                @endif
                            </div>
                        @endforeach
                    </div>
                @else
                    <p class="text-gray-500 text-center py-4">Aucun rendez-vous passé.</p>
                @endif
                
                @if($pastAppointments->count() > 0)
                    <div class="mt-6">
                        <a href="{{ route('rendezvous.historique') }}" class="text-sm font-medium text-blue-600 hover:text-blue-800">
                            Voir tout l'historique <span aria-hidden="true">&rarr;</span>
                        </a>
                    </div>
                @endif
            </div>
        </div>
    </div>

    <!-- Informations médicales -->
    <div class="mt-8 bg-white rounded-lg shadow-md overflow-hidden">
        <div class="bg-green-600 px-6 py-4">
            <h2 class="text-lg font-semibold text-white">Mes informations médicales</h2>
        </div>
        <div class="p-6">
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                <div class="bg-blue-50 p-4 rounded-lg">
                    <h3 class="font-medium text-blue-800 mb-2">Groupe sanguin</h3>
                    <p class="text-blue-600">Non renseigné</p>
                </div>
                <div class="bg-green-50 p-4 rounded-lg">
                    <h3 class="font-medium text-green-800 mb-2">Allergies connues</h3>
                    <p class="text-green-600">Aucune allergie déclarée</p>
                </div>
                <div class="bg-purple-50 p-4 rounded-lg">
                    <h3 class="font-medium text-purple-800 mb-2">Traitements en cours</h3>
                    <p class="text-purple-600">Aucun traitement en cours</p>
                </div>
            </div>
            <div class="mt-6">
                <a href="{{ route('dossier-medical.show', $user->id) }}" class="inline-flex items-center text-sm font-medium text-green-600 hover:text-green-800">
                    Voir mon dossier médical complet
                    <svg class="ml-1 w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                    </svg>
                </a>
            </div>
        </div>
    </div>
</div>
@endsection
