@extends('layouts.app')

@section('content')
<div>
    <h1 class="text-3xl font-bold text-gray-800 mb-4">Tableau de bord Secrétaire</h1>
    <p class="text-lg text-gray-600 mb-8">Bienvenue, {{ $user->name }} ! Prête à organiser la journée ?</p>

    <!-- Grille de widgets -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
        
        <!-- Widget Rendez-vous du jour -->
        <div class="bg-white p-6 rounded-lg shadow-md flex items-center gap-4 col-span-1 md:col-span-2">
            <div class="bg-blue-100 p-3 rounded-full">
                <svg class="h-6 w-6 text-blue-600" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
            </div>
            <div>
                <p class="text-sm text-gray-500">Rendez-vous Aujourd'hui</p>
                <p class="text-2xl font-bold text-gray-800">{{ $todayAppointmentsCount }}</p>
            </div>
        </div>

        <!-- Widget Nouveaux Patients -->
        <div class="bg-white p-6 rounded-lg shadow-md flex items-center gap-4 col-span-1 md:col-span-2">
            <div class="bg-green-100 p-3 rounded-full">
                <svg class="h-6 w-6 text-green-600" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18 9v3m0 0v3m0-3h3m-3 0h-3m-2-5a4 4 0 11-8 0 4 4 0 018 0zM3 20a6 6 0 0112 0v1H3v-1z"></path></svg>
            </div>
            <div>
                <p class="text-sm text-gray-500">Nouveaux Patients (Aujourd'hui)</p>
                <p class="text-2xl font-bold text-gray-800">{{ $newPatientsCount }}</p>
            </div>
        </div>
    </div>

    <!-- Section principale -->
    <div class="mt-10 grid grid-cols-1 lg:grid-cols-3 gap-10">
        <!-- Liste des prochains rendez-vous -->
        <div class="lg:col-span-2 bg-white p-6 rounded-lg shadow-md">
            <h2 class="text-xl font-bold text-gray-800 mb-4">Prochains Rendez-vous</h2>
            <div class="overflow-x-auto">
                <table class="min-w-full bg-white">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="py-3 px-4 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Patient</th>
                            <th class="py-3 px-4 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Médecin</th>
                            <th class="py-3 px-4 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Date et Heure</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-200">
                        @forelse ($upcomingAppointments as $rdv)
                            <tr>
                                <td class="py-4 px-4 whitespace-nowrap">{{ $rdv->patient->name ?? 'N/A' }}</td>
                                <td class="py-4 px-4 whitespace-nowrap">Dr. {{ $rdv->medecin->name ?? 'N/A' }}</td>
                                <td class="py-4 px-4 whitespace-nowrap">{{ \Carbon\Carbon::parse($rdv->date_heure)->format('d/m/Y à H:i') }}</td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="3" class="py-4 px-4 text-center text-gray-500">Aucun rendez-vous à venir.</td>
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
                <a href="{{ route('rendez-vous.index') }}" class="block w-full text-center bg-blue-600 text-white py-3 px-4 rounded-lg hover:bg-blue-700 transition-colors duration-300">
                    Gérer les Rendez-vous
                </a>
                <a href="{{ route('patients.create') }}" class="block w-full text-center bg-green-600 text-white py-3 px-4 rounded-lg hover:bg-green-700 transition-colors duration-300">
                    Inscrire un Patient
                </a>
                <a href="{{ route('patients.index') }}" class="block w-full text-center bg-gray-200 text-gray-800 py-3 px-4 rounded-lg hover:bg-gray-300 transition-colors duration-300">
                    Voir tous les Patients
                </a>
            </div>
        </div>
    </div>
</div>
@endsection
