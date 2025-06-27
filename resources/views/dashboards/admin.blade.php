@extends('layouts.app')

@section('content')
<div>
    <h1 class="text-3xl font-bold text-gray-800 mb-4">Tableau de bord Administrateur</h1>
    <p class="text-lg text-gray-600 mb-8">Bienvenue, {{ $user->name }} ! Voici un aperçu de l'activité de l'hôpital.</p>

    <!-- Grille de widgets -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
        
        <!-- Widget Utilisateurs -->
        <div class="bg-white p-6 rounded-lg shadow-md flex items-center gap-4">
            <div class="bg-blue-100 p-3 rounded-full">
                <svg class="h-6 w-6 text-blue-600" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.653-.124-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.653.124-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path></svg>
            </div>
            <div>
                <p class="text-sm text-gray-500">Utilisateurs Actifs</p>
                <p class="text-2xl font-bold text-gray-800">{{ $totalUsers }}</p>
            </div>
        </div>

        <!-- Widget Patients -->
        <div class="bg-white p-6 rounded-lg shadow-md flex items-center gap-4">
            <div class="bg-green-100 p-3 rounded-full">
                <svg class="h-6 w-6 text-green-600" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M15 21a6 6 0 00-9-5.197m0 0A5.995 5.995 0 0012 12.75a5.995 5.995 0 00-3-5.197m0 0A4 4 0 0112 4.354m0 5.292a4 4 0 010-5.292"></path></svg>
            </div>
            <div>
                <p class="text-sm text-gray-500">Total des Patients</p>
                <p class="text-2xl font-bold text-gray-800">{{ $totalPatients }}</p>
            </div>
        </div>

        <!-- Widget Médecins -->
        <div class="bg-white p-6 rounded-lg shadow-md flex items-center gap-4">
            <div class="bg-indigo-100 p-3 rounded-full">
                <svg class="h-6 w-6 text-indigo-600" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 13.255A23.931 23.931 0 0112 15c-3.183 0-6.22-.62-9-1.745M16 6V4a2 2 0 00-2-2h-4a2 2 0 00-2 2v2m4 6h.01M5 20h14a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path></svg>
            </div>
            <div>
                <p class="text-sm text-gray-500">Médecins</p>
                <p class="text-2xl font-bold text-gray-800">{{ $totalMedecins }}</p>
            </div>
        </div>

        <!-- Widget Rendez-vous du jour -->
        <div class="bg-white p-6 rounded-lg shadow-md flex items-center gap-4">
            <div class="bg-red-100 p-3 rounded-full">
                <svg class="h-6 w-6 text-red-600" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
            </div>
            <div>
                <p class="text-sm text-gray-500">Rendez-vous (Aujourd'hui)</p>
                <p class="text-2xl font-bold text-gray-800">{{ $todayAppointments }}</p>
            </div>
        </div>

    </div>

    <!-- Section d'accès rapide -->
    <div class="mt-10">
        <h2 class="text-2xl font-bold text-gray-800 mb-4">Accès Rapide</h2>
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
            <a href="{{ route('users.index') }}" class="bg-white p-6 rounded-lg shadow-md hover:shadow-lg transition-shadow duration-300">
                <h3 class="text-lg font-semibold text-gray-900">Gérer les Utilisateurs</h3>
                <p class="text-gray-600 mt-2">Ajouter, modifier ou désactiver des comptes utilisateurs.</p>
            </a>
            <a href="{{ route('rapports.index') }}" class="bg-white p-6 rounded-lg shadow-md hover:shadow-lg transition-shadow duration-300">
                <h3 class="text-lg font-semibold text-gray-900">Consulter les Rapports</h3>
                <p class="text-gray-600 mt-2">Visualiser les statistiques et rapports détaillés.</p>
            </a>
        </div>
    </div>
</div>
@endsection
