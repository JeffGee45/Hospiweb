@extends('layouts.app')

@section('title', 'Dossier Médical - ' . $patient->prenom . ' ' . $patient->nom)

@section('content')
<div class="container mx-auto px-4 py-6">
    <!-- En-tête du patient -->
    <x-patients.partials.header :patient="$patient" />

    <!-- Messages de succès -->
    @if (session('success'))
        <div class="bg-green-100 border-l-4 border-green-500 text-green-700 p-4 mb-6 rounded" role="alert">
            <p class="font-bold">Succès</p>
            <p>{{ session('success') }}</p>
        </div>
    @endif

    <!-- Navigation par onglets -->
    <x-patients.partials.medical-tabs :patient="$patient" active="overview" />

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        <!-- Colonne de gauche - Informations -->
        <div class="space-y-6">
            <x-patients.partials.personal-info :patient="$patient" />
            <x-patients.partials.medical-info :patient="$patient" />
        </div>

        <!-- Colonne de droite - Observations et historique -->
        <div class="lg:col-span-2 space-y-6">
            <div class="bg-white rounded-lg shadow p-6">
                <div class="flex justify-between items-center mb-4">
                    <h2 class="text-lg font-semibold text-gray-800">Observations générales</h2>
                    <button type="button" class="text-blue-600 hover:text-blue-800 text-sm font-medium"
                            onclick="document.getElementById('editObservations').classList.toggle('hidden');">
                        <i class="fas fa-edit mr-1"></i> Modifier
                    </button>
                </div>
                <!-- Vue des observations -->
                <div id="viewObservations">
                    @if($dossier->observation_globale)
                        <div class="prose max-w-none">
                            {!! nl2br(e($dossier->observation_globale)) !!}
                        </div>
                    @else
                        <p class="text-gray-500 italic">Aucune observation pour le moment.</p>
                    @endif
                </div>
                <!-- Formulaire d'édition -->
                <div id="editObservations" class="hidden mt-4">
                    <form action="{{ route('dossiers.update', $patient) }}" method="POST">
                        @csrf
                        @method('PUT')
                        <div>
                            <label for="observation_globale" class="block text-sm font-medium text-gray-700">Observations</label>
                            <textarea id="observation_globale" name="observation_globale" rows="6" class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm py-2 px-3 focus:outline-none focus:ring-blue-500 focus:border-blue-500 sm:text-sm">{{ old('observation_globale', $dossier->observation_globale) }}</textarea>
                            @error('observation_globale')
                                <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>
                        <div class="flex justify-end space-x-3 pt-4">
                            <button type="button" onclick="document.getElementById('editObservations').classList.add('hidden');" class="bg-white py-2 px-4 border border-gray-300 rounded-md shadow-sm text-sm font-medium text-gray-700 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">Annuler</button>
                            <button type="submit" class="inline-flex justify-center py-2 px-4 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">Enregistrer</button>
                        </div>
                    </form>
                </div>
            </div>
            <!-- Historique simplifié (consultations, etc. à compléter selon besoin) -->
        </div>
    </div>
</div>
@endsection
