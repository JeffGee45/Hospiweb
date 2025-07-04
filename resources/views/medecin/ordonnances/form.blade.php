@props([
    'ordonnance' => null,
    'patients' => collect(),
    'consultations' => collect(),
    'selectedPatient' => null,
    'consultation' => null
])

@php
    $isEdit = isset($ordonnance);
    $action = $isEdit 
        ? route('medecin.ordonnances.update', $ordonnance)
        : route('medecin.ordonnances.store');
    $method = $isEdit ? 'PUT' : 'POST';
    $title = $isEdit ? 'Modifier l\'ordonnance' : 'Créer une nouvelle ordonnance';
    $buttonText = $isEdit ? 'Mettre à jour' : 'Créer l\'ordonnance';
@endphp

@extends('layouts.app')

@section('title', $title)

@section('content')
<div class="container mx-auto px-4 py-6">
    <div class="flex justify-between items-center mb-6">
        <h1 class="text-2xl font-semibold text-gray-900">{{ $title }}</h1>
        <a href="{{ route('medecin.ordonnances.index') }}" class="px-4 py-2 bg-gray-200 text-gray-800 rounded-md hover:bg-gray-300 transition-colors">
            <i class="fas fa-arrow-left mr-2"></i>Retour
        </a>
    </div>

    @if($errors->any())
        <div class="mb-4 p-4 bg-red-100 border-l-4 border-red-500 text-red-700">
            <p class="font-bold">Erreur</p>
            <ul class="list-disc list-inside">
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ $action }}" method="POST" id="ordonnanceForm">
        @csrf
        @method($method)

        <div class="bg-white shadow overflow-hidden sm:rounded-lg mb-6">
            <div class="px-4 py-5 sm:px-6 border-b border-gray-200">
                <h3 class="text-lg leading-6 font-medium text-gray-900">
                    Informations générales
                </h3>
            </div>
            <div class="px-4 py-5 sm:p-6">
                @if(!$isEdit)
                    <div class="mb-4">
                        <label for="patient_id" class="block text-sm font-medium text-gray-700">Patient</label>
                        <select id="patient_id" name="patient_id" class="mt-1 block w-full pl-3 pr-10 py-2 text-base border-gray-300 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm rounded-md" {{ $selectedPatient ? 'disabled' : '' }}>
                            @if($patients->count() > 0)
                                @foreach($patients as $patient)
                                    <option value="{{ $patient->id }}" {{ $selectedPatient && $selectedPatient->id == $patient->id ? 'selected' : '' }}>
                                        {{ $patient->prenom }} {{ $patient->nom }} ({{ $patient->date_naissance->format('d/m/Y') }})
                                    </option>
                                @endforeach
                            @else
                                <option value="">Aucun patient disponible</option>
                            @endif
                        </select>
                        @if($selectedPatient)
                            <input type="hidden" name="patient_id" value="{{ $selectedPatient->id }}">
                        @endif
                    </div>

                    <div class="mb-4">
                        <label for="consultation_id" class="block text-sm font-medium text-gray-700">Consultation (optionnel)</label>
                        <select id="consultation_id" name="consultation_id" class="mt-1 block w-full pl-3 pr-10 py-2 text-base border-gray-300 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm rounded-md">
                            <option value="">Sélectionner une consultation</option>
                            @if(isset($consultations) && $consultations->count() > 0)
                                @foreach($consultations as $consult)
                                    <option value="{{ $consult->id }}" {{ $consultation && $consultation->id == $consult->id ? 'selected' : '' }}>
                                        Consultation du {{ $consult->date_consultation->format('d/m/Y') }}
                                    </option>
                                @endforeach
                            @endif
                        </select>
                    </div>
                @endif

                <div class="mb-4">
                    <label for="date_ordonnance" class="block text-sm font-medium text-gray-700">Date de l'ordonnance</label>
                    <input type="date" name="date_ordonnance" id="date_ordonnance" 
                           value="{{ old('date_ordonnance', $ordonnance->date_ordonnance->format('Y-m-d') ?? now()->format('Y-m-d')) }}"
                           class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm py-2 px-3 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
                </div>

                <div>
                    <label for="commentaire" class="block text-sm font-medium text-gray-700">Commentaires (optionnel)</label>
                    <textarea id="commentaire" name="commentaire" rows="3" 
                              class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm py-2 px-3 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">{{ old('commentaire', $ordonnance->commentaire ?? '') }}</textarea>
                </div>
            </div>
        </div>

        <div class="bg-white shadow overflow-hidden sm:rounded-lg mb-6">
            <div class="px-4 py-5 sm:px-6 border-b border-gray-200 flex justify-between items-center">
                <h3 class="text-lg leading-6 font-medium text-gray-900">
                    Médicaments prescrits
                </h3>
                <button type="button" id="addMedicament" class="px-3 py-1 bg-green-600 text-white text-sm rounded-md hover:bg-green-700">
                    <i class="fas fa-plus mr-1"></i> Ajouter un médicament
                </button>
            </div>
            <div class="px-4 py-5 sm:p-6">
                <div id="medicaments-container">
                    @if($isEdit && $ordonnance->medicaments->count() > 0)
                        @foreach($ordonnance->medicaments as $index => $medicament)
                            <div class="medicament-item border border-gray-200 rounded-md p-4 mb-4">
                                <div class="flex justify-between items-start mb-3">
                                    <h4 class="text-md font-medium">Médicament #{{ $index + 1 }}</h4>
                                    <button type="button" class="text-red-600 hover:text-red-800 remove-medicament">
                                        <i class="fas fa-times"></i>
                                    </button>
                                </div>
                                <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                                    <div>
                                        <label class="block text-sm font-medium text-gray-700">Nom du médicament</label>
                                        <input type="text" name="medicaments[{{ $index }}][nom]" 
                                               value="{{ old('medicaments.' . $index . '.nom', $medicament->nom) }}" 
                                               class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm py-2 px-3 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm" required>
                                    </div>
                                    <div>
                                        <label class="block text-sm font-medium text-gray-700">Posologie</label>
                                        <input type="text" name="medicaments[{{ $index }}][posologie]" 
                                               value="{{ old('medicaments.' . $index . '.posologie', $medicament->posologie) }}" 
                                               class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm py-2 px-3 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm" required>
                                    </div>
                                    <div>
                                        <label class="block text-sm font-medium text-gray-700">Durée du traitement</label>
                                        <input type="text" name="medicaments[{{ $index }}][duree]" 
                                               value="{{ old('medicaments.' . $index . '.duree', $medicament->duree) }}" 
                                               class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm py-2 px-3 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm" required>
                                    </div>
                                    <div class="md:col-span-3">
                                        <label class="block text-sm font-medium text-gray-700">Instructions (optionnel)</label>
                                        <input type="text" name="medicaments[{{ $index }}][instructions]" 
                                               value="{{ old('medicaments.' . $index . '.instructions', $medicament->instructions) }}" 
                                               class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm py-2 px-3 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
                                    </div>
                                </div>
                                <input type="hidden" name="medicaments[{{ $index }}][id]" value="{{ $medicament->id }}">
                            </div>
                        @endforeach
                    @else
                        <div id="no-medicaments" class="text-center py-4 text-gray-500">
                            <p>Aucun médicament ajouté pour le moment.</p>
                        </div>
                    @endif
                </div>
            </div>
        </div>

        <div class="flex justify-end">
            <button type="button" onclick="window.history.back()" class="mr-3 px-4 py-2 border border-gray-300 rounded-md shadow-sm text-sm font-medium text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                Annuler
            </button>
            <button type="submit" class="inline-flex justify-center py-2 px-4 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                {{ $buttonText }}
            </button>
        </div>
    </form>
</div>

@push('styles')
<style>
    .medicament-item {
        background-color: #f9fafb;
        transition: all 0.2s ease-in-out;
    }
    .medicament-item:hover {
        background-color: #f3f4f6;
    }
    .remove-medicament {
        cursor: pointer;
        font-size: 1.1rem;
    }
</style>
@endpush

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const container = document.getElementById('medicaments-container');
        const addButton = document.getElementById('addMedicament');
        let medicamentCount = {{ $isEdit && $ordonnance->medicaments->count() > 0 ? $ordonnance->medicaments->count() : 0 }};
        const noMedicaments = document.getElementById('no-medicaments');

        // Ajouter un nouveau médicament
        addButton.addEventListener('click', function() {
            if (noMedicaments) {
                noMedicaments.style.display = 'none';
            }
            
            const newIndex = medicamentCount++;
            const newMedicament = `
                <div class="medicament-item border border-gray-200 rounded-md p-4 mb-4">
                    <div class="flex justify-between items-start mb-3">
                        <h4 class="text-md font-medium">Nouveau médicament</h4>
                        <button type="button" class="text-red-600 hover:text-red-800 remove-medicament">
                            <i class="fas fa-times"></i>
                        </button>
                    </div>
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                        <div>
                            <label class="block text-sm font-medium text-gray-700">Nom du médicament</label>
                            <input type="text" name="medicaments[${newIndex}][nom]" 
                                   class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm py-2 px-3 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm" required>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700">Posologie</label>
                            <input type="text" name="medicaments[${newIndex}][posologie]" 
                                   class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm py-2 px-3 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm" required>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700">Durée du traitement</label>
                            <input type="text" name="medicaments[${newIndex}][duree]" 
                                   class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm py-2 px-3 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm" required>
                        </div>
                        <div class="md:col-span-3">
                            <label class="block text-sm font-medium text-gray-700">Instructions (optionnel)</label>
                            <input type="text" name="medicaments[${newIndex}][instructions]" 
                                   class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm py-2 px-3 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
                        </div>
                    </div>
                </div>
            `;
            
            // Ajouter le nouveau médicament au conteneur
            const temp = document.createElement('div');
            temp.innerHTML = newMedicament.trim();
            container.appendChild(temp.firstChild);
            
            // Ajouter un écouteur d'événement au bouton de suppression
            const removeButton = container.lastElementChild.querySelector('.remove-medicament');
            if (removeButton) {
                removeButton.addEventListener('click', function() {
                    container.removeChild(this.closest('.medicament-item'));
                    if (container.querySelectorAll('.medicament-item').length === 0 && noMedicaments) {
                        noMedicaments.style.display = 'block';
                    }
                });
            }
        });

        // Gérer la suppression des médicaments existants
        document.querySelectorAll('.remove-medicament').forEach(button => {
            button.addEventListener('click', function() {
                const item = this.closest('.medicament-item');
                container.removeChild(item);
                if (container.querySelectorAll('.medicament-item').length === 0 && noMedicaments) {
                    noMedicaments.style.display = 'block';
                }
            });
        });

        // Gérer la soumission du formulaire
        const form = document.getElementById('ordonnanceForm');
        form.addEventListener('submit', function(e) {
            // Vérifier qu'au moins un médicament a été ajouté
            const medicamentItems = container.querySelectorAll('.medicament-item');
            if (medicamentItems.length === 0) {
                e.preventDefault();
                alert('Veuillez ajouter au moins un médicament à l\'ordonnance.');
                return false;
            }
            return true;
        });

        // Si on est en mode édition et qu'il n'y a pas de médicaments, masquer le message "Aucun médicament"
        if ({{ $isEdit ? 'true' : 'false' }} && {{ $ordonnance->medicaments->count() > 0 ? 'true' : 'false' }} && noMedicaments) {
            noMedicaments.style.display = 'none';
        }
    });
</script>
@endpush
@endsection
