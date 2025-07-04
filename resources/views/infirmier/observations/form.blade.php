@php
    $isEdit = isset($observation);
    $action = $isEdit 
        ? route('infirmier.observations.update', $observation)
        : route('infirmier.observations.store');
    $method = $isEdit ? 'PUT' : 'POST';
    $title = $isEdit ? "Modifier l'observation" : "Nouvelle observation";
    $buttonText = $isEdit ? 'Mettre à jour' : 'Enregistrer';

    // Valeurs par défaut pour la création
    $selectedPatientId = old('patient_id', $selectedPatient->id ?? null);
    $typeObservation = old('type_observation', $observation->type_observation ?? '');
    $valeur = old('valeur', $observation->valeur ?? '');
    $unite = old('unite', $observation->unite ?? '');
    $commentaire = old('commentaire', $observation->commentaire ?? '');
    $estUrgent = old('est_urgent', $observation->est_urgent ?? false);
    
    // Gestion des dates
    $now = now();
    $dateObservation = old('date_observation', $observation->date_observation ?? $now->format('Y-m-d'));
    $heureObservation = old('heure_observation', $observation->heure_observation ?? $now->format('H:i'));
@endphp

@extends('layouts.app')

@section('title', $title)

@section('content')
<div class="container mx-auto px-4 py-6">
    <div class="mb-6">
        <h1 class="text-2xl font-semibold text-gray-900">{{ $title }}</h1>
        <p class="mt-1 text-sm text-gray-500">
            Remplissez le formulaire ci-dessous pour {{ $isEdit ? 'modifier' : 'créer' }} une observation.
        </p>
    </div>

    <div class="bg-white shadow overflow-hidden sm:rounded-lg">
        <form action="{{ $action }}" method="POST">
            @csrf
            @method($method)
            
            <div class="px-4 py-5 sm:p-6">
                @if($errors->any())
                    <div class="mb-6 bg-red-50 border-l-4 border-red-400 p-4">
                        <div class="flex">
                            <div class="flex-shrink-0">
                                <svg class="h-5 w-5 text-red-400" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd" />
                                </svg>
                            </div>
                            <div class="ml-3">
                                <h3 class="text-sm font-medium text-red-800">
                                    Veuillez corriger les erreurs ci-dessous avant de continuer.
                                </h3>
                            </div>
                        </div>
                    </div>
                @endif

                <div class="space-y-6">
                    <!-- Sélection du patient -->
                    <div>
                        <label for="patient_id" class="block text-sm font-medium text-gray-700">Patient <span class="text-red-500">*</span></label>
                        @if(isset($selectedPatient))
                            <input type="hidden" name="patient_id" value="{{ $selectedPatient->id }}">
                            <div class="mt-1 p-2 bg-gray-50 rounded border border-gray-200">
                                {{ $selectedPatient->nom_complet }}
                            </div>
                        @else
                            <select id="patient_id" name="patient_id" class="mt-1 block w-full pl-3 pr-10 py-2 text-base border-gray-300 focus:outline-none focus:ring-blue-500 focus:border-blue-500 sm:text-sm rounded-md {{ $errors->has('patient_id') ? 'border-red-300' : '' }}" required>
                                <option value="">Sélectionnez un patient</option>
                                @foreach($patients as $patient)
                                    <option value="{{ $patient->id }}" {{ $selectedPatientId == $patient->id ? 'selected' : '' }}>
                                        {{ $patient->nom_complet }}
                                    </option>
                                @endforeach
                            </select>
                            @error('patient_id')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        @endif
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <!-- Type d'observation -->
                        <div>
                            <label for="type_observation" class="block text-sm font-medium text-gray-700">Type d'observation <span class="text-red-500">*</span></label>
                            <select id="type_observation" name="type_observation" class="mt-1 block w-full pl-3 pr-10 py-2 text-base border-gray-300 focus:outline-none focus:ring-blue-500 focus:border-blue-500 sm:text-sm rounded-md {{ $errors->has('type_observation') ? 'border-red-300' : '' }}" required>
                                <option value="">Sélectionnez un type</option>
                                <option value="Tension artérielle" {{ $typeObservation == 'Tension artérielle' ? 'selected' : '' }}>Tension artérielle</option>
                                <option value="Température" {{ $typeObservation == 'Température' ? 'selected' : '' }}>Température</option>
                                <option value="Fréquence cardiaque" {{ $typeObservation == 'Fréquence cardiaque' ? 'selected' : '' }}>Fréquence cardiaque</option>
                                <option value="Saturation en O2" {{ $typeObservation == 'Saturation en O2' ? 'selected' : '' }}>Saturation en O2</option>
                                <option value="Glycémie" {{ $typeObservation == 'Glycémie' ? 'selected' : '' }}>Glycémie</option>
                                <option value="Poids" {{ $typeObservation == 'Poids' ? 'selected' : '' }}>Poids</option>
                                <option value="Taille" {{ $typeObservation == 'Taille' ? 'selected' : '' }}>Taille</option>
                                <option value="Douleur" {{ $typeObservation == 'Douleur' ? 'selected' : '' }}>Douleur (échelle EVA)</option>
                                <option value="Autre" {{ $typeObservation == 'Autre' ? 'selected' : '' }}>Autre</option>
                            </select>
                            @error('type_observation')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Valeur -->
                        <div>
                            <label for="valeur" class="block text-sm font-medium text-gray-700">Valeur <span class="text-red-500">*</span></label>
                            <div class="mt-1 flex rounded-md shadow-sm">
                                <input type="text" name="valeur" id="valeur" value="{{ $valeur }}" class="focus:ring-blue-500 focus:border-blue-500 flex-1 block w-full rounded-none rounded-l-md sm:text-sm border-gray-300 {{ $errors->has('valeur') ? 'border-red-300' : '' }}" required>
                                <span class="inline-flex items-center px-3 rounded-r-md border border-l-0 border-gray-300 bg-gray-50 text-gray-500 text-sm">
                                    <span id="unite_affichee">{{ $unite ?: 'unité' }}</span>
                                </span>
                            </div>
                            @error('valeur')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                        <!-- Unité -->
                        <div>
                            <label for="unite" class="block text-sm font-medium text-gray-700">Unité</label>
                            <input type="text" name="unite" id="unite" value="{{ $unite }}" class="mt-1 focus:ring-blue-500 focus:border-blue-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md {{ $errors->has('unite') ? 'border-red-300' : '' }}">
                            @error('unite')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Date d'observation -->
                        <div>
                            <label for="date_observation" class="block text-sm font-medium text-gray-700">Date <span class="text-red-500">*</span></label>
                            <input type="date" name="date_observation" id="date_observation" value="{{ $dateObservation }}" class="mt-1 focus:ring-blue-500 focus:border-blue-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md {{ $errors->has('date_observation') ? 'border-red-300' : '' }}" required>
                            @error('date_observation')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Heure d'observation -->
                        <div>
                            <label for="heure_observation" class="block text-sm font-medium text-gray-700">Heure <span class="text-red-500">*</span></label>
                            <input type="time" name="heure_observation" id="heure_observation" value="{{ $heureObservation }}" class="mt-1 focus:ring-blue-500 focus:border-blue-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md {{ $errors->has('heure_observation') ? 'border-red-300' : '' }}" required>
                            @error('heure_observation')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>

                    <!-- Commentaire -->
                    <div>
                        <label for="commentaire" class="block text-sm font-medium text-gray-700">Commentaire</label>
                        <div class="mt-1">
                            <textarea id="commentaire" name="commentaire" rows="3" class="shadow-sm focus:ring-blue-500 focus:border-blue-500 block w-full sm:text-sm border border-gray-300 rounded-md {{ $errors->has('commentaire') ? 'border-red-300' : '' }}">{{ $commentaire }}</textarea>
                        </div>
                        @error('commentaire')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Urgence -->
                    <div class="flex items-start">
                        <div class="flex items-center h-5">
                            <input id="est_urgent" name="est_urgent" type="checkbox" value="1" {{ $estUrgent ? 'checked' : '' }} class="focus:ring-blue-500 h-4 w-4 text-blue-600 border-gray-300 rounded">
                        </div>
                        <div class="ml-3 text-sm">
                            <label for="est_urgent" class="font-medium text-gray-700">Marquer comme urgent</label>
                            <p class="text-gray-500">Cochez cette case si cette observation nécessite une attention particulière.</p>
                        </div>
                    </div>
                </div>
            </div>

            <div class="px-4 py-3 bg-gray-50 text-right sm:px-6">
                <a href="{{ route('infirmier.observations.index') }}" class="inline-flex justify-center py-2 px-4 border border-gray-300 shadow-sm text-sm font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                    Annuler
                </a>
                <button type="submit" class="ml-3 inline-flex justify-center py-2 px-4 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                    {{ $buttonText }}
                </button>
            </div>
        </form>
    </div>
</div>

@push('scripts')
<script>
    // Mise à jour dynamique de l'unité en fonction du type d'observation
    document.getElementById('type_observation').addEventListener('change', function() {
        const type = this.value;
        const uniteInput = document.getElementById('unite');
        const uniteAffichee = document.getElementById('unite_affichee');
        
        const unites = {
            'Tension artérielle': 'mmHg',
            'Température': '°C',
            'Fréquence cardiaque': 'bpm',
            'Saturation en O2': '%',
            'Glycémie': 'g/L',
            'Poids': 'kg',
            'Taille': 'cm',
            'Douleur': '/10',
            'Autre': ''
        };
        
        const unite = unites[type] || '';
        uniteInput.value = unite;
        uniteAffichee.textContent = unite || 'unité';
    });

    // Déclenche l'événement au chargement pour définir l'unité initiale
    document.addEventListener('DOMContentLoaded', function() {
        document.getElementById('type_observation').dispatchEvent(new Event('change'));
    });
</script>
@endpush
@endsection
