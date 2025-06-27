@extends('layouts.app')

@section('content')
<div>
    <h1 class="text-3xl font-bold text-gray-800 mb-4">Tableau de bord Infirmier(e)</h1>
    <p class="text-lg text-gray-600 mb-8">Bienvenue, {{ $user->name }}. Prêt(e) pour votre service ?</p>

    <!-- Grille de widgets -->
    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
        
        <!-- Widget Patients Hospitalisés -->
        <div class="bg-white p-6 rounded-lg shadow-md flex items-center gap-4">
            <div class="bg-purple-100 p-3 rounded-full">
                 <svg class="h-6 w-6 text-purple-600" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5.121 17.804A13.937 13.937 0 0112 16c2.5 0 4.847.655 6.879 1.804M15 10a3 3 0 11-6 0 3 3 0 016 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 21a9 9 0 100-18 9 9 0 000 18z"></path></svg>
            </div>
            <div>
                <p class="text-sm text-gray-500">Patients Hospitalisés</p>
                <p class="text-2xl font-bold text-gray-800">{{ $hospitalizedPatientsCount }}</p>
            </div>
        </div>

        <!-- Widget Soins à prodiguer -->
        <div class="bg-white p-6 rounded-lg shadow-md flex items-center gap-4">
            <div class="bg-cyan-100 p-3 rounded-full">
                <svg class="h-6 w-6 text-cyan-600" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"></path></svg>
            </div>
            <div>
                <p class="text-sm text-gray-500">Soins prévus (Aujourd'hui)</p>
                <p class="text-2xl font-bold text-gray-800">{{ $todayCaresCount }}</p>
            </div>
        </div>
    </div>

    <!-- Section principale -->
    <div class="mt-10 grid grid-cols-1 lg:grid-cols-3 gap-10">
        <!-- Liste des derniers patients admis -->
        <div class="lg:col-span-2 bg-white p-6 rounded-lg shadow-md">
            <h2 class="text-xl font-bold text-gray-800 mb-4">Derniers Patients Admis</h2>
            <div class="overflow-x-auto">
                <table class="min-w-full bg-white">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="py-3 px-4 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Nom du Patient</th>
                            <th class="py-3 px-4 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Date d'admission</th>
                            <th class="py-3 px-4 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Action</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-200">
                        @forelse ($recentlyAdmittedPatients as $patient)
                            <tr>
                                <td class="py-4 px-4 whitespace-nowrap font-medium text-gray-900">{{ $patient->name }}</td>
                                <td class="py-4 px-4 whitespace-nowrap text-gray-500">{{ $patient->created_at->format('d/m/Y') }}</td>
                                <td class="py-4 px-4 whitespace-nowrap">
                                    <a href="{{ route('dossiers.show', ['patient' => $patient->id]) }}" class="text-blue-600 hover:text-blue-800">Consulter le Dossier</a>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="3" class="py-4 px-4 text-center text-gray-500">Aucun patient récemment admis.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        <!-- Accès Rapide -->
        <div class="bg-white p-6 rounded-lg shadow-md">
            <h2 class="text-xl font-bold text-gray-800 mb-4">Accès Rapide</h2>
            <div class="space-y-4">
                <a href="{{ route('soins.index') }}" class="block w-full text-center bg-cyan-600 text-white py-3 px-4 rounded-lg hover:bg-cyan-700 transition-colors duration-300">
                    Gestion des Soins
                </a>
                <a href="{{ route('patients.index') }}" class="block w-full text-center bg-gray-200 text-gray-800 py-3 px-4 rounded-lg hover:bg-gray-300 transition-colors duration-300">
                    Voir tous les Patients
                </a>
            </div>
        </div>
    </div>
</div>
@endsection
