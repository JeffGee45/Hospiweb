@extends('layouts.app')

@section('content')
<div class="container mx-auto px-4 py-8">
    <h1 class="text-3xl font-bold text-gray-800 mb-6">Tableau de Bord Administrateur</h1>
    <p class="text-gray-600 mb-8">Vue d'ensemble du système et gestion des utilisateurs.</p>

    <!-- Section des statistiques globales -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
        <div class="bg-white p-6 rounded-lg shadow-md">
            <h2 class="text-xl font-semibold text-gray-700">Utilisateurs Actifs</h2>
            <p class="text-4xl font-bold text-green-600 mt-2">{{ $userCount ?? 0 }}</p>
        </div>
        <div class="bg-white p-6 rounded-lg shadow-md">
            <h2 class="text-xl font-semibold text-gray-700">Médecins</h2>
            <p class="text-4xl font-bold text-green-600 mt-2">{{ $doctorCount ?? 0 }}</p>
        </div>
        <div class="bg-white p-6 rounded-lg shadow-md">
            <h2 class="text-xl font-semibold text-gray-700">Patients Enregistrés</h2>
            <p class="text-4xl font-bold text-green-600 mt-2">{{ $patientCount ?? 0 }}</p>
        </div>
        <div class="bg-white p-6 rounded-lg shadow-md">
            <h2 class="text-xl font-semibold text-gray-700">Rendez-vous du jour</h2>
            <p class="text-4xl font-bold text-green-600 mt-2">{{ $appointmentCount ?? 0 }}</p>
        </div>
    </div>

    <!-- Section de gestion des utilisateurs -->
    <div class="bg-white p-6 rounded-lg shadow-md">
        <h2 class="text-2xl font-semibold text-gray-800 mb-4">Gestion des Utilisateurs</h2>
        <p class="text-gray-600 mb-4">Ajouter, modifier ou supprimer des comptes utilisateurs.</p>
        <a href="#" class="bg-blue-600 text-white font-bold py-2 px-4 rounded hover:bg-blue-700">
            Gérer les utilisateurs
        </a>
    </div>
</div>
@endsection
