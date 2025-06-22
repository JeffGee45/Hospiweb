@extends('layouts.app')

@section('content')
<div class="container mx-auto px-4 py-8">
    <h1 class="text-3xl font-bold text-gray-800 mb-8">Rapports et Statistiques</h1>

    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
        <!-- Total Patients -->
        <div class="bg-white p-6 rounded-lg shadow-md">
            <h2 class="text-lg font-semibold text-gray-600 mb-2">Total des Patients</h2>
            <p class="text-4xl font-bold text-blue-600">{{ $stats['total_patients'] }}</p>
        </div>

        <!-- Hospitalisations en cours -->
        <div class="bg-white p-6 rounded-lg shadow-md">
            <h2 class="text-lg font-semibold text-gray-600 mb-2">Hospitalisations Actives</h2>
            <p class="text-4xl font-bold text-green-600">{{ $stats['hospitalisations_en_cours'] }}</p>
        </div>
    </div>

    <div class="mt-10 bg-white p-6 rounded-lg shadow-md">
        <h2 class="text-xl font-bold text-gray-800 mb-4">Télécharger les Rapports</h2>
        <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-4 gap-4">
            <a href="{{ route('rapports.export.consultations') }}" class="bg-blue-500 hover:bg-blue-600 text-white font-bold py-3 px-4 rounded text-center transition duration-300">
                Consultations / Médecin
            </a>
            <a href="{{ route('rapports.export.hospitalisations') }}" class="bg-green-500 hover:bg-green-600 text-white font-bold py-3 px-4 rounded text-center transition duration-300">
                Hospitalisations en Cours
            </a>
            <a href="{{ route('rapports.export.medicaments') }}" class="bg-purple-500 hover:bg-purple-600 text-white font-bold py-3 px-4 rounded text-center transition duration-300">
                Médicaments Prescrits
            </a>
            <a href="{{ route('rapports.export.patients') }}" class="bg-red-500 hover:bg-red-600 text-white font-bold py-3 px-4 rounded text-center transition duration-300">
                Statistiques Patients
            </a>
        </div>
    </div>

    <div class="mt-10 grid grid-cols-1 lg:grid-cols-2 gap-10">
        <!-- Consultations par médecin -->
        <div class="bg-white p-6 rounded-lg shadow-md">
            <h3 class="text-lg font-semibold text-gray-700 mb-4">Consultations par Médecin</h3>
            <ul class="space-y-2">
                @forelse($stats['consultations_par_medecin'] as $medecin)
                    <li class="flex justify-between items-center">
                        <span>Dr. {{ $medecin->prenom }} {{ $medecin->nom }}</span>
                        <span class="font-bold text-blue-600">{{ $medecin->consultations_count }}</span>
                    </li>
                @empty
                    <li>Aucune consultation enregistrée.</li>
                @endforelse
            </ul>
        </div>

        <!-- Médicaments les plus prescrits -->
        <div class="bg-white p-6 rounded-lg shadow-md">
            <h3 class="text-lg font-semibold text-gray-700 mb-4">Top 5 des Médicaments Prescrits</h3>
            <ul class="space-y-2">
                @forelse($stats['medicaments_plus_prescrits'] as $medicament)
                    <li class="flex justify-between items-center">
                        <span>{{ $medicament->nom_medicament }}</span>
                        <span class="font-bold text-purple-600">{{ $medicament->total }}</span>
                    </li>
                @empty
                    <li>Aucun médicament prescrit.</li>
                @endforelse
            </ul>
        </div>
    </div>
</div>
@endsection
