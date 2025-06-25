@extends('layouts.app')

@section('content')
<div class="container mx-auto px-4 py-8">
    <h1 class="text-3xl font-bold text-gray-800 mb-6">Tableau de Bord Secrétaire</h1>
    <p class="text-gray-600 mb-8">Gestion des rendez-vous et enregistrement des patients.</p>

    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6 mb-8">
        <div class="bg-white p-6 rounded-lg shadow-md">
            <h2 class="text-xl font-semibold text-gray-700">Rendez-vous du jour</h2>
            <p class="text-4xl font-bold text-purple-600 mt-2">{{ $rendezVousDuJour ?? 0 }}</p>
        </div>
        <div class="bg-white p-6 rounded-lg shadow-md">
            <h2 class="text-xl font-semibold text-gray-700">Nouveaux patients</h2>
            <p class="text-4xl font-bold text-purple-600 mt-2">{{ $nouveauxPatients ?? 0 }}</p>
        </div>
        <div class="bg-white p-6 rounded-lg shadow-md">
            <h2 class="text-xl font-semibold text-gray-700">Appels en attente</h2>
            <p class="text-4xl font-bold text-purple-600 mt-2">{{ $appelsEnAttente ?? 0 }}</p>
        </div>
    </div>

    <div class="bg-white p-6 rounded-lg shadow-md">
        <h2 class="text-2xl font-semibold text-gray-800 mb-4">Accès Rapide</h2>
        <div class="flex space-x-4">
            <a href="#" class="bg-purple-600 text-white font-bold py-2 px-4 rounded hover:bg-purple-700">
                Gérer les rendez-vous
            </a>
            <a href="#" class="bg-indigo-600 text-white font-bold py-2 px-4 rounded hover:bg-indigo-700">
                Enregistrer un patient
            </a>
        </div>
    </div>
</div>
@endsection
