@extends('layouts.app')

@section('content')
<div class="container mx-auto px-4 py-8">
    <div class="flex justify-between items-center mb-8">
        <div>
            <h1 class="text-3xl font-bold text-gray-800">Tableau de Bord Administrateur</h1>
            <p class="text-gray-600 mt-2">Bienvenue, {{ $user->name }}. Gérez votre plateforme en toute simplicité.</p>
        </div>
    </div>

    <!-- Cartes de statistiques -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
        <!-- Carte Utilisateurs -->
        <div class="bg-white rounded-lg shadow-md p-6 flex items-center">
            <div class="p-3 rounded-full bg-blue-100 text-blue-600 mr-4">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z" />
                </svg>
            </div>
            <div>
                <p class="text-sm font-medium text-gray-500">Utilisateurs</p>
                <p class="text-2xl font-semibold text-gray-800">{{ $totalUsers }}</p>
            </div>
        </div>

        <!-- Carte Médecins -->
        <div class="bg-white rounded-lg shadow-md p-6 flex items-center">
            <div class="p-3 rounded-full bg-green-100 text-green-600 mr-4">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z" />
                </svg>
            </div>
            <div>
                <p class="text-sm font-medium text-gray-500">Médecins</p>
                <p class="text-2xl font-semibold text-gray-800">{{ $totalMedecins }}</p>
            </div>
        </div>

        <!-- Carte Patients -->
        <div class="bg-white rounded-lg shadow-md p-6 flex items-center">
            <div class="p-3 rounded-full bg-purple-100 text-purple-600 mr-4">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z" />
                </svg>
            </div>
            <div>
                <p class="text-sm font-medium text-gray-500">Patients</p>
                <p class="text-2xl font-semibold text-gray-800">{{ $totalPatients }}</p>
            </div>
        </div>

        <!-- Carte Rendez-vous -->
        <div class="bg-white rounded-lg shadow-md p-6 flex items-center">
            <div class="p-3 rounded-full bg-yellow-100 text-yellow-600 mr-4">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                </svg>
            </div>
            <div>
                <p class="text-sm font-medium text-gray-500">RDV Aujourd'hui</p>
                <p class="text-2xl font-semibold text-gray-800">{{ $todayAppointments }}</p>
            </div>
        </div>
    </div>

    <!-- Sections d'actions rapides -->
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6 mb-8">
        <!-- Section Gestion des Utilisateurs -->
        <div class="bg-white rounded-lg shadow-md p-6">
            <div class="flex justify-between items-center mb-4">
                <h2 class="text-xl font-semibold text-gray-800">Gestion des Utilisateurs</h2>
                <a href="{{ route('users.index') }}" class="text-sm text-blue-600 hover:text-blue-800">Voir tout</a>
            </div>
            <div class="space-y-4">
                <a href="{{ route('users.create') }}" class="flex items-center p-3 bg-gray-50 hover:bg-gray-100 rounded-lg transition">
                    <div class="p-2 bg-blue-100 rounded-lg mr-3">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-blue-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18 9v3m0 0v3m0-3h3m-3 0h-3m-2-5a4 4 0 11-8 0 4 4 0 018 0zM3 20a6 6 0 0112 0v1H3v-1z" />
                        </svg>
                    </div>
                    <div>
                        <p class="font-medium text-gray-800">Ajouter un nouvel utilisateur</p>
                        <p class="text-sm text-gray-500">Créer un compte pour un nouveau membre du personnel</p>
                    </div>
                </a>
                <a href="{{ route('users.index') }}?role=medecin" class="flex items-center p-3 bg-gray-50 hover:bg-gray-100 rounded-lg transition">
                    <div class="p-2 bg-green-100 rounded-lg mr-3">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-green-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z" />
                        </svg>
                    </div>
                    <div>
                        <p class="font-medium text-gray-800">Gérer les médecins</p>
                        <p class="text-sm text-gray-500">Voir et gérer les comptes des médecins</p>
                    </div>
                </a>
            </div>
        </div>

        <!-- Section Rapports -->
        <div class="bg-white rounded-lg shadow-md p-6">
            <div class="flex justify-between items-center mb-4">
                <h2 class="text-xl font-semibold text-gray-800">Rapports et Statistiques</h2>
                <a href="{{ route('rapports.index') }}" class="text-sm text-blue-600 hover:text-blue-800">Voir tout</a>
            </div>
            <div class="space-y-4">
                <a href="{{ route('rapports.export.consultations') }}" class="flex items-center p-3 bg-gray-50 hover:bg-gray-100 rounded-lg transition">
                    <div class="p-2 bg-purple-100 rounded-lg mr-3">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-purple-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 17v-2m3 2v-4m3 4v-6m2 10H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                        </svg>
                    </div>
                    <div>
                        <p class="font-medium text-gray-800">Exporter les consultations</p>
                        <p class="text-sm text-gray-500">Générer un rapport des consultations par médecin</p>
                    </div>
                </a>
                <a href="{{ route('rapports.export.hospitalisations') }}" class="flex items-center p-3 bg-gray-50 hover:bg-gray-100 rounded-lg transition">
                    <div class="p-2 bg-yellow-100 rounded-lg mr-3">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-yellow-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10" />
                        </svg>
                    </div>
                    <div>
                        <p class="font-medium text-gray-800">Hospitalisations en cours</p>
                        <p class="text-sm text-gray-500">Voir la liste des patients actuellement hospitalisés</p>
                    </div>
                </a>
            </div>
        </div>
    </div>

    <!-- Dernières activités -->
    <div class="bg-white rounded-lg shadow-md p-6">
        <div class="flex justify-between items-center mb-4">
            <h2 class="text-xl font-semibold text-gray-800">Activité Récente</h2>
            <a href="#" class="text-sm text-blue-600 hover:text-blue-800">Voir tout</a>
        </div>
        <div class="space-y-4">
            <!-- Exemple d'activité -->
            <div class="flex items-start pb-4 border-b border-gray-100">
                <div class="p-2 bg-blue-100 rounded-lg mr-3">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-blue-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z" />
                    </svg>
                </div>
                <div class="flex-1">
                    <p class="font-medium text-gray-800">Nouvel utilisateur enregistré</p>
                    <p class="text-sm text-gray-500">Dr. Jean Dupont a été ajouté comme médecin</p>
                    <p class="text-xs text-gray-400 mt-1">Il y a 2 heures</p>
                </div>
            </div>
            <!-- Autre exemple d'activité -->
            <div class="flex items-start">
                <div class="p-2 bg-green-100 rounded-lg mr-3">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-green-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z" />
                    </svg>
                </div>
                <div class="flex-1">
                    <p class="font-medium text-gray-800">Consultation terminée</p>
                    <p class="text-sm text-gray-500">Le Dr. Martin a terminé une consultation avec M. Bernard</p>
                    <p class="text-xs text-gray-400 mt-1">Il y a 5 heures</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Section d'accès rapide -->
    <div class="bg-white rounded-lg shadow-md p-6 mt-8">
        <h2 class="text-2xl font-semibold text-gray-800 mb-6">Accès Rapide</h2>
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <a href="{{ route('users.index') }}" class="p-6 border border-gray-200 rounded-lg hover:border-blue-500 hover:shadow-md transition-all duration-300">
                <h3 class="text-lg font-semibold text-gray-900 flex items-center">
                    <svg class="h-6 w-6 text-blue-500 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z" />
                    </svg>
                    Gérer les Utilisateurs
                </h3>
                <p class="text-gray-600 mt-2">Ajouter, modifier ou désactiver des comptes utilisateurs.</p>
            </a>
            <a href="{{ route('rapports.index') }}" class="p-6 border border-gray-200 rounded-lg hover:border-blue-500 hover:shadow-md transition-all duration-300">
                <h3 class="text-lg font-semibold text-gray-900 flex items-center">
                    <svg class="h-6 w-6 text-blue-500 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 17v-2m3 2v-4m3 4v-6m2 10H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                    </svg>
                    Consulter les Rapports
                </h3>
                <p class="text-gray-600 mt-2">Visualiser les statistiques et rapports détaillés.</p>
            </a>
        </div>
    </div>
</div>
@endsection
