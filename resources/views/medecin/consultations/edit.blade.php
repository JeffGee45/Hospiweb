@extends('layouts.app')

@section('title', 'Modifier la consultation')

@section('content')
<div class="container mx-auto px-4 py-8">
    <div class="flex justify-between items-center mb-6">
        <div>
            <h1 class="text-2xl font-bold text-gray-800">
                Modifier la consultation
            </h1>
            <p class="text-gray-600">
                {{ $patient->prenom }} {{ $patient->nom }} - {{ $patient->date_naissance->format('d/m/Y') }} ({{ $patient->age }} ans)
            </p>
            <p class="text-sm text-gray-500 mt-1">
                Consultation du {{ $consultation->date_consultation->format('d/m/Y H:i') }}
            </p>
        </div>
        <div>
            <a href="{{ route('medecin.patients.consultations.show', [$patient, $consultation]) }}" 
               class="inline-flex items-center px-4 py-2 bg-gray-200 border border-gray-300 rounded-md font-semibold text-xs text-gray-700 uppercase tracking-widest hover:bg-gray-300 focus:bg-gray-300 active:bg-gray-400 focus:outline-none focus:ring-2 focus:ring-gray-500 focus:ring-offset-2 transition ease-in-out duration-150">
                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                </svg>
                Annuler
            </a>
        </div>
    </div>

    <div class="bg-white shadow overflow-hidden sm:rounded-lg">
        <form action="{{ route('medecin.patients.consultations.update', [$patient, $consultation]) }}" method="POST">
            @csrf
            @method('PUT')
            <div class="px-4 py-5 sm:p-6">
                <div class="grid grid-cols-1 gap-6">
                    <div class="col-span-1">
                        <label for="date_consultation" class="block text-sm font-medium text-gray-700">
                            Date et heure de la consultation <span class="text-red-500">*</span>
                        </label>
                        <input type="datetime-local" name="date_consultation" id="date_consultation" 
                               value="{{ old('date_consultation', $consultation->date_consultation->format('Y-m-d\TH:i')) }}"
                               class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm py-2 px-3 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm"
                               required>
                        @error('date_consultation')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="col-span-1">
                        <label for="motif" class="block text-sm font-medium text-gray-700">
                            Motif de la consultation <span class="text-red-500">*</span>
                        </label>
                        <input type="text" name="motif" id="motif" 
                               value="{{ old('motif', $consultation->motif) }}" 
                               class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm py-2 px-3 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm"
                               placeholder="Ex: Consultation de suivi, douleur, etc." required>
                        @error('motif')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="col-span-1">
                        <label for="diagnostic" class="block text-sm font-medium text-gray-700">
                            Diagnostic
                        </label>
                        <textarea name="diagnostic" id="diagnostic" rows="4"
                                  class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm py-2 px-3 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm"
                                  placeholder="Décrivez le diagnostic posé">{{ old('diagnostic', $consultation->diagnostic) }}</textarea>
                        @error('diagnostic')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="col-span-1">
                        <label for="traitement" class="block text-sm font-medium text-gray-700">
                            Traitement prescrit
                        </label>
                        <textarea name="traitement" id="traitement" rows="4"
                                  class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm py-2 px-3 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm"
                                  placeholder="Décrivez le traitement prescrit">{{ old('traitement', $consultation->traitement) }}</textarea>
                        @error('traitement')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="col-span-1">
                        <label for="notes" class="block text-sm font-medium text-gray-700">
                            Notes complémentaires
                        </label>
                        <textarea name="notes" id="notes" rows="3"
                                  class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm py-2 px-3 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm"
                                  placeholder="Ajoutez des notes complémentaires si nécessaire">{{ old('notes', $consultation->notes) }}</textarea>
                        @error('notes')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>
                </div>
            </div>
            <div class="px-4 py-3 bg-gray-50 text-right sm:px-6">
                <a href="{{ route('medecin.patients.consultations.show', [$patient, $consultation]) }}" 
                   class="inline-flex items-center px-4 py-2 border border-gray-300 shadow-sm text-sm font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                    Annuler
                </a>
                <button type="submit" 
                        class="ml-3 inline-flex justify-center py-2 px-4 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                    Mettre à jour la consultation
                </button>
            </div>
        </form>
    </div>

    <div class="mt-8 bg-white shadow overflow-hidden sm:rounded-lg">
        <div class="px-4 py-5 sm:px-6 border-b border-gray-200">
            <h3 class="text-lg leading-6 font-medium text-gray-900">
                Zone de danger
            </h3>
            <p class="mt-1 max-w-2xl text-sm text-gray-500">
                Actions irréversibles
            </p>
        </div>
        <div class="px-4 py-5 sm:p-6">
            <div class="flex justify-between items-center">
                <div>
                    <h4 class="text-sm font-medium text-gray-900">Supprimer cette consultation</h4>
                    <p class="text-sm text-gray-500">
                        Cette action est irréversible. Toutes les données associées seront définitivement supprimées.
                    </p>
                </div>
                <form action="{{ route('medecin.patients.consultations.destroy', [$patient, $consultation]) }}" method="POST" class="inline">
                    @csrf
                    @method('DELETE')
                    <button type="submit" 
                            class="inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md text-white bg-red-600 hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500"
                            onclick="return confirm('Êtes-vous sûr de vouloir supprimer cette consultation ? Cette action est irréversible.')">
                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                        </svg>
                        Supprimer la consultation
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script>
    // Initialisation des champs de date et d'heure
    document.addEventListener('DOMContentLoaded', function() {
        // Configuration de flatpickr pour un meilleur sélecteur de date/heure
        flatpickr("#date_consultation", {
            enableTime: true,
            dateFormat: "Y-m-d H:i",
            time_24hr: true,
            locale: "fr"
        });
    });
</script>
@endpush
@endsection
