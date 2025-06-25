@extends('layouts.app')

@section('content')
<div class="container mx-auto px-4 py-8">
    <h1 class="text-3xl font-bold text-gray-800 mb-6">Tableau de Bord Docteur</h1>
    <p class="text-gray-600 mb-8">Gestion des consultations, ordonnances et dossiers patients.</p>

    <!-- Section des statistiques -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6 mb-8">
        <div class="bg-white p-6 rounded-lg shadow-md">
            <h2 class="text-xl font-semibold text-gray-700">Consultations à venir</h2>
            <p class="text-4xl font-bold text-blue-600 mt-2">{{ $consultationsAVenir ?? 0 }}</p>
        </div>
        <div class="bg-white p-6 rounded-lg shadow-md">
            <h2 class="text-xl font-semibold text-gray-700">Ordonnances émises</h2>
            <p class="text-4xl font-bold text-blue-600 mt-2">{{ $ordonnances ?? 0 }}</p>
        </div>
        <div class="bg-white p-6 rounded-lg shadow-md">
            <h2 class="text-xl font-semibold text-gray-700">Patients du jour</h2>
            <p class="text-4xl font-bold text-blue-600 mt-2">{{ $patientsDuJour ?? 0 }}</p>
        </div>
    </div>

    <!-- Section des actions rapides -->
    <div class="bg-white p-6 rounded-lg shadow-md">
        <h2 class="text-2xl font-semibold text-gray-800 mb-4">Accès Rapide</h2>
        <div class="flex space-x-4">
            <a href="#" class="bg-blue-600 text-white font-bold py-2 px-4 rounded hover:bg-blue-700">
                Voir les dossiers patients
            </a>
            <a href="#" class="bg-green-600 text-white font-bold py-2 px-4 rounded hover:bg-green-700">
                Nouvelle consultation
            </a>
        </div>
    </div>
</div>
@endsection
