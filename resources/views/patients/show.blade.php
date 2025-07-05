@extends('layouts.app')

@section('content')
<div class="min-h-screen bg-gray-50">
    <!-- Bandeau supérieur avec photo de profil -->
    <div class="bg-gradient-to-r from-blue-600 to-indigo-700 h-48 w-full">
        <div class="container mx-auto px-4 md:px-6 pt-6">
            <div class="flex items-center justify-between">
                @php
                    $userRole = auth()->user()->role;
                    $rolePrefix = match($userRole) {
                        'Admin' => 'admin',
                        'Secrétaire' => 'secretaire',
                        'Médecin' => 'medecin',
                        default => null
                    };
                @endphp
                
                <a href="{{ $rolePrefix ? route($rolePrefix . '.patients.index') : route('dashboard') }}" 
                   class="inline-flex items-center text-white hover:text-blue-100 transition-colors duration-200">
                    <svg class="w-5 h-5 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                    </svg>
                    Retour
                </a>
                
                @if($rolePrefix && in_array($userRole, ['Admin', 'Secrétaire']))
                <a href="{{ route($rolePrefix . '.patients.edit', $patient->id) }}" 
                   class="inline-flex items-center px-4 py-2 bg-white/20 hover:bg-white/30 text-white rounded-lg transition-colors duration-200">
                    <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.5L14.732 3.732z" />
                    </svg>
                    Modifier
                </a>
                @endif
            </div>
        </div>
    </div>

    <div class="container mx-auto px-4 md:px-6 -mt-20">
        <!-- Carte principale du profil -->
        <div class="bg-white rounded-xl shadow-lg overflow-hidden mb-8">
            <div class="md:flex">
                <!-- Photo de profil -->
                <div class="md:w-1/4 bg-gray-100 p-6 flex flex-col items-center justify-center">
                    <div class="h-40 w-40 rounded-full bg-gradient-to-br from-blue-500 to-indigo-600 flex items-center justify-center text-white text-5xl font-bold shadow-lg">
                        {{ strtoupper(substr($patient->prenom, 0, 1)) }}{{ strtoupper(substr($patient->nom, 0, 1)) }}
                    </div>
                    
                    @php
                        $statutClasses = [
                            'guéri' => 'bg-gradient-to-r from-green-500 to-emerald-500',
                            'malade' => 'bg-gradient-to-r from-amber-500 to-orange-500',
                            'décédé' => 'bg-gradient-to-r from-red-500 to-rose-500',
                        ][strtolower($patient->statut)] ?? 'bg-gray-500';
                    @endphp
                    
                    <div class="mt-4 px-4 py-1 rounded-full {{ $statutClasses }} text-white text-sm font-semibold shadow-sm">
                        {{ $patient->statut ?? 'Inconnu' }}
                    </div>
                    
                    <div class="mt-6 text-center">
                        <p class="text-lg font-semibold text-gray-800">{{ $patient->prenom }} {{ $patient->nom }}</p>
                        <p class="text-gray-600">{{ $patient->date_naissance ? \Carbon\Carbon::parse($patient->date_naissance)->age . ' ans' : 'Âge non spécifié' }}</p>
                        <p class="text-sm text-gray-500 mt-2">
                            <span class="inline-flex items-center">
                                <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                                </svg>
                                Membre depuis {{ $patient->created_at->format('d/m/Y') }}
                            </span>
                        </p>
                    </div>
                </div>
                
                <!-- Détails du patient -->
                <div class="md:w-3/4 p-8">
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <!-- Carte Informations Personnelles -->
                        <div class="bg-white rounded-lg border border-gray-200 p-6 shadow-sm hover:shadow-md transition-shadow duration-200">
                            <div class="flex items-center mb-4">
                                <div class="p-2 bg-blue-100 rounded-lg text-blue-600">
                                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                                    </svg>
                                </div>
                                <h3 class="ml-3 text-lg font-semibold text-gray-800">Informations Personnelles</h3>
                            </div>
                            <div class="space-y-3">
                                <div class="flex items-start">
                                    <span class="w-1/3 text-sm text-gray-500">Date de naissance</span>
                                    <span class="w-2/3 font-medium">{{ $patient->date_naissance ? \Carbon\Carbon::parse($patient->date_naissance)->format('d/m/Y') : 'Non spécifiée' }}</span>
                                </div>
                                <div class="flex items-start">
                                    <span class="w-1/3 text-sm text-gray-500">Sexe</span>
                                    <span class="w-2/3 font-medium">{{ $patient->sexe ?? 'Non spécifié' }}</span>
                                </div>
                                <div class="flex items-start">
                                    <span class="w-1/3 text-sm text-gray-500">Téléphone</span>
                                    <span class="w-2/3 font-medium">{{ $patient->telephone ?? 'Non spécifié' }}</span>
                                </div>
                                <div class="flex items-start">
                                    <span class="w-1/3 text-sm text-gray-500">Email</span>
                                    <span class="w-2/3 font-medium break-all">{{ $patient->email ?? 'Non spécifié' }}</span>
                                </div>
                                <div class="flex items-start">
                                    <span class="w-1/3 text-sm text-gray-500">Adresse</span>
                                    <span class="w-2/3 font-medium">{{ $patient->adresse ?? 'Non spécifiée' }}</span>
                                </div>
                            </div>
                        </div>
                        
                        <!-- Carte Informations Médicales -->
                        <div class="bg-white rounded-lg border border-gray-200 p-6 shadow-sm hover:shadow-md transition-shadow duration-200">
                            <div class="flex items-center mb-4">
                                <div class="p-2 bg-red-100 rounded-lg text-red-600">
                                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.75 17L9 20l-1 1h8l-1-1-.75-3M3 13h18M5 17h14a2 2 0 002-2V5a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                                    </svg>
                                </div>
                                <h3 class="ml-3 text-lg font-semibold text-gray-800">Informations Médicales</h3>
                            </div>
                            <div class="space-y-3">
                                <div class="flex items-start">
                                    <span class="w-1/3 text-sm text-gray-500">Groupe Sanguin</span>
                                    <span class="w-2/3 font-bold text-red-600">{{ $patient->groupe_sanguin ?? 'Non spécifié' }}</span>
                                </div>
                                <div>
                                    <h4 class="text-sm font-medium text-gray-500 mb-1">Antécédents Médicaux</h4>
                                    <div class="bg-gray-50 p-3 rounded-lg text-sm">
                                        {{ $patient->antecedents_medicaux ?: 'Aucun antécédent médical renseigné.' }}
                                    </div>
                                </div>
                                <div>
                                    <h4 class="text-sm font-medium text-gray-500 mb-1">Allergies</h4>
                                    <div class="bg-gray-50 p-3 rounded-lg text-sm">
                                        {{ $patient->allergies ?: 'Aucune allergie connue.' }}
                                    </div>
                                </div>
                                @if($patient->traitements_en_cours)
                                <div>
                                    <h4 class="text-sm font-medium text-gray-500 mb-1">Traitements en cours</h4>
                                    <div class="bg-gray-50 p-3 rounded-lg text-sm">
                                        {{ $patient->traitements_en_cours }}
                                    </div>
                                </div>
                                @endif
                            </div>
                        </div>
                        
                        <!-- Carte Contact d'Urgence -->
                        <div class="md:col-span-2 bg-white rounded-lg border border-gray-200 p-6 shadow-sm hover:shadow-md transition-shadow duration-200">
                            <div class="flex items-center mb-4">
                                <div class="p-2 bg-yellow-100 rounded-lg text-yellow-600">
                                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 18h.01M8 21h8a2 2 0 002-2V5a2 2 0 00-2-2H8a2 2 0 00-2 2v14a2 2 0 002 2z" />
                                    </svg>
                                </div>
                                <h3 class="ml-3 text-lg font-semibold text-gray-800">Contact d'Urgence</h3>
                            </div>
                            @if($patient->nom_contact_urgence)
                                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                    <div class="bg-gray-50 p-4 rounded-lg">
                                        <div class="text-sm text-gray-500">Nom</div>
                                        <div class="font-medium">{{ $patient->nom_contact_urgence }}</div>
                                    </div>
                                    <div class="bg-gray-50 p-4 rounded-lg">
                                        <div class="text-sm text-gray-500">Lien</div>
                                        <div class="font-medium">{{ $patient->lien_contact_urgence ?? 'Non spécifié' }}</div>
                                    </div>
                                    <div class="bg-gray-50 p-4 rounded-lg md:col-span-2">
                                        <div class="text-sm text-gray-500">Téléphone</div>
                                        <div class="font-medium text-lg text-blue-600">{{ $patient->telephone_contact_urgence }}</div>
                                    </div>
                                </div>
                            @else
                                <p class="text-gray-500 italic">Aucun contact d'urgence renseigné.</p>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
        <!-- Section Notes -->
        @if($patient->notes)
        <div class="bg-white rounded-lg shadow-sm p-6 mb-8">
            <h3 class="text-lg font-semibold text-gray-800 mb-4 flex items-center">
                <svg class="w-5 h-5 text-gray-500 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                </svg>
                Notes
            </h3>
            <div class="bg-yellow-50 border-l-4 border-yellow-400 p-4">
                <p class="text-gray-700">{{ $patient->notes }}</p>
            </div>
        </div>
        @endif
    </div>
</div>
@endsection
