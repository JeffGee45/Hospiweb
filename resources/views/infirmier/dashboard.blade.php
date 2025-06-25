@extends('layouts.app')

@section('content')
<div class="container mx-auto px-4 py-8">
    <h1 class="text-3xl font-bold text-gray-800 mb-6">Tableau de Bord Infirmier</h1>
    <p class="text-gray-600 mb-8">Suivi des soins et gestion des hospitalisations.</p>

    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6 mb-8">
        <div class="bg-white p-6 rounded-lg shadow-md">
            <h2 class="text-xl font-semibold text-gray-700">Soins à prodiguer</h2>
            <p class="text-4xl font-bold text-yellow-600 mt-2">{{ $soinsAPrevoir ?? 0 }}</p>
        </div>
        <div class="bg-white p-6 rounded-lg shadow-md">
            <h2 class="text-xl font-semibold text-gray-700">Patients hospitalisés</h2>
            <p class="text-4xl font-bold text-yellow-600 mt-2">{{ $patientsHospitalises ?? 0 }}</p>
        </div>
        <div class="bg-white p-6 rounded-lg shadow-md">
            <h2 class="text-xl font-semibold text-gray-700">Tâches planifiées</h2>
            <p class="text-4xl font-bold text-yellow-600 mt-2">{{ $tachesPlanifiees ?? 0 }}</p>
        </div>
    </div>

    <div class="bg-white p-6 rounded-lg shadow-md">
        <h2 class="text-2xl font-semibold text-gray-800 mb-4">Accès Rapide</h2>
        <a href="#" class="bg-yellow-500 text-white font-bold py-2 px-4 rounded hover:bg-yellow-600">
            Plan de soins
        </a>
    </div>
</div>
@endsection
