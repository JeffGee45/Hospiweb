@extends('layouts.app')

@section('content')
    <div class="layout-content-container flex flex-col max-w-[960px] flex-1">


        <div class="bg-white shadow-xl rounded-2xl p-8 mb-6">
            <!-- En-tête Patient -->
            <div class="flex flex-col md:flex-row items-center gap-6 border-b pb-6 mb-6">
                <div class="h-24 w-24 rounded-full bg-blue-100 flex items-center justify-center text-blue-700 text-4xl font-bold shadow-md">
                    {{ strtoupper(substr($patient->prenom, 0, 1)) }}{{ strtoupper(substr($patient->nom, 0, 1)) }}
                </div>
                <div class="flex-1 text-center md:text-left">
                    <h2 class="text-3xl font-bold text-gray-800">{{ $patient->prenom }} {{ $patient->nom }}</h2>
                    <div class="flex items-center justify-center md:justify-start gap-4 mt-2 text-gray-600">
                        <span>{{ $patient->sexe }}</span>
                        <span>&bull;</span>
                        <span>{{ $patient->date_naissance ? \Carbon\Carbon::parse($patient->date_naissance)->age : 'N/A' }} ans</span>
                        <span>&bull;</span>
                        @php
                            $statutClasses = match ($patient->statut) {
                                'Actif' => 'bg-green-100 text-green-800',
                                'Inactif' => 'bg-yellow-100 text-yellow-800',
                                'Décédé' => 'bg-red-100 text-red-800',
                                default => 'bg-gray-100 text-gray-800',
                            };
                        @endphp
                        <span class="px-3 py-1 text-sm font-semibold rounded-full {{ $statutClasses }}">
                            {{ $patient->statut ?? 'Inconnu' }}
                        </span>
                    </div>
                </div>
                                <div class="flex gap-2 mt-4 md:mt-0">
                    @php
                        $userRole = auth()->user()->role;
                        $rolePrefix = null;
                        if (in_array($userRole, ['Admin', 'Secretaire', 'Medecin'])) {
                            $rolePrefix = strtolower($userRole);
                        }
                    @endphp

                    @if($rolePrefix)
                        {{-- Seuls Admin et Secrétaire peuvent modifier --}}
                        @if(in_array($userRole, ['Admin', 'Secretaire']))
                            <a href="{{ route($rolePrefix . '.patients.edit', $patient->id) }}" class="inline-flex items-center gap-2 px-4 py-2 rounded-lg bg-yellow-500 text-white font-semibold shadow hover:bg-yellow-600 focus:outline-none focus:ring-2 focus:ring-yellow-300 transition duration-150" title="Modifier">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.5L14.732 3.732z" /></svg>
                                Modifier
                            </a>
                        @endif

                        <a href="{{ route($rolePrefix . '.patients.index') }}" class="inline-flex items-center gap-2 px-4 py-2 rounded-lg bg-gray-200 text-gray-700 font-semibold shadow hover:bg-gray-300 focus:outline-none focus:ring-2 focus:ring-gray-300 transition duration-150" title="Retour à la liste">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M15 19l-7-7 7-7" /></svg>
                            Retour
                        </a>
                    @else
                        <a href="{{ route('dashboard') }}" class="inline-flex items-center gap-2 px-4 py-2 rounded-lg bg-gray-200 text-gray-700 font-semibold shadow hover:bg-gray-300 focus:outline-none focus:ring-2 focus:ring-gray-300 transition duration-150" title="Retour au tableau de bord">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M15 19l-7-7 7-7" /></svg>
                            Retour
                        </a>
                    @endif
                </div>
            </div>

            <!-- Détails du Patient -->
            <div class="grid grid-cols-1 md:grid-cols-2 gap-x-12 gap-y-6">
                <!-- Section Informations Personnelles -->
                <div class="space-y-4">
                    <h3 class="text-xl font-semibold text-blue-700 border-b pb-2">Informations Personnelles</h3>
                    <div class="flex justify-between"><span class="font-medium text-gray-600">Date de naissance:</span> <span class="text-gray-800">{{ $patient->date_naissance ? \Carbon\Carbon::parse($patient->date_naissance)->format('d/m/Y') : 'N/A' }}</span></div>
                    <div class="flex justify-between"><span class="font-medium text-gray-600">Téléphone:</span> <span class="text-gray-800">{{ $patient->telephone ?? 'N/A' }}</span></div>
                    <div class="flex justify-between"><span class="font-medium text-gray-600">Email:</span> <span class="text-gray-800">{{ $patient->email ?? 'N/A' }}</span></div>
                    <div class="flex justify-between"><span class="font-medium text-gray-600">Adresse:</span> <span class="text-gray-800">{{ $patient->adresse ?? 'N/A' }}</span></div>
                </div>

                <!-- Section Informations Médicales -->
                <div class="space-y-4">
                    <h3 class="text-xl font-semibold text-blue-700 border-b pb-2">Informations Médicales</h3>
                    <div class="flex justify-between"><span class="font-medium text-gray-600">Groupe Sanguin:</span> <span class="text-red-600 font-bold">{{ $patient->groupe_sanguin ?? 'N/A' }}</span></div>
                    <div>
                        <h4 class="font-medium text-gray-600 mb-1">Antécédents Médicaux:</h4>
                        <p class="text-gray-800 bg-gray-50 p-3 rounded-lg">{{ $patient->antecedents_medicaux ?? 'Aucun antécédent médical fourni.' }}</p>
                    </div>
                    <div>
                        <h4 class="font-medium text-gray-600 mb-1">Allergies:</h4>
                        <p class="text-gray-800 bg-gray-50 p-3 rounded-lg">{{ $patient->allergies ?? 'Aucune allergie connue.' }}</p>
                    </div>
                </div>

                <!-- Section Contact d'Urgence -->
                <div class="md:col-span-2 space-y-4 pt-6 border-t mt-6">
                    <h3 class="text-xl font-semibold text-blue-700 border-b pb-2">Contact d'Urgence</h3>
                    @if($patient->nom_contact_urgence)
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-x-12">
                            <div class="flex justify-between"><span class="font-medium text-gray-600">Nom:</span> <span class="text-gray-800">{{ $patient->nom_contact_urgence }}</span></div>
                            <div class="flex justify-between"><span class="font-medium text-gray-600">Téléphone:</span> <span class="text-gray-800">{{ $patient->telephone_contact_urgence ?? 'N/A' }}</span></div>
                        </div>
                    @else
                        <p class="text-gray-500">Aucun contact d'urgence fourni.</p>
                    @endif
                </div>
            </div>
        </div>
    </div>
@endsection
