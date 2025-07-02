@extends('layouts.app')

@section('content')
<div>
    <h1 class="text-3xl font-bold text-gray-800 mb-4">Tableau de bord Médecin</h1>
    <p class="text-lg text-gray-600 mb-8">Bienvenue, Dr. {{ $user->name }}. Voici votre journée en un coup d'œil.</p>

    <!-- Grille de widgets -->
    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
        
        <!-- Widget Rendez-vous du jour -->
        <div class="bg-white p-6 rounded-lg shadow-md flex items-center gap-4">
            <div class="bg-blue-100 p-3 rounded-full">
                <svg class="h-6 w-6 text-blue-600" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
            </div>
            <div>
                <p class="text-sm text-gray-500">Rendez-vous Aujourd'hui</p>
                <p class="text-2xl font-bold text-gray-800">{{ $stats['todayAppointmentsCount'] }}</p>
            </div>
        </div>

        <!-- Widget Patients Hospitalisés -->
        <div class="bg-white p-6 rounded-lg shadow-md flex items-center gap-4">
            <div class="bg-red-100 p-3 rounded-full">
                <svg class="h-6 w-6 text-red-600" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path></svg>
            </div>
            <div>
                <p class="text-sm text-gray-500">Patients Hospitalisés</p>
                <p class="text-2xl font-bold text-gray-800">{{ $stats['hospitalizedPatientsCount'] }}</p>
            </div>
        </div>
    </div>

    <!-- Section principale -->
    <div class="mt-10 grid grid-cols-1 lg:grid-cols-3 gap-10">
        <!-- Liste des prochains rendez-vous -->
        <div class="lg:col-span-2 bg-white p-6 rounded-lg shadow-md">
            <h2 class="text-xl font-bold text-gray-800 mb-4">Vos Prochains Rendez-vous</h2>
            <div class="overflow-x-auto">
                <table class="min-w-full bg-white">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="py-3 px-4 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Patient</th>
                            <th class="py-3 px-4 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Heure</th>
                            <th class="py-3 px-4 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Action</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-200">
                        @forelse ($stats['upcomingAppointments'] as $rdv)
                            <tr>
                                <td class="py-4 px-4 whitespace-nowrap font-medium text-gray-900">{{ $rdv->patient->name ?? 'N/A' }}</td>
                                <td class="py-4 px-4 whitespace-nowrap text-gray-500">{{ \Carbon\Carbon::parse($rdv->date_heure)->format('H:i') }}</td>
                                <td class="py-4 px-4 whitespace-nowrap">
                                    <a href="{{ route('dossiers.show', ['patient' => $rdv->patient->id]) }}" class="text-blue-600 hover:text-blue-800">Voir Dossier</a>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="3" class="py-4 px-4 text-center text-gray-500">Aucun rendez-vous à venir pour le moment.</td>
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
                <a href="{{ route('medecin.patients.index') }}" class="block w-full text-center bg-blue-600 text-white py-3 px-4 rounded-lg hover:bg-blue-700 transition-colors duration-300">
                    Gérer les Patients
                </a>
                <a href="{{ route('medecin.rendez-vous.index') }}" class="block w-full text-center bg-gray-200 text-gray-800 py-3 px-4 rounded-lg hover:bg-gray-300 transition-colors duration-300">
                    Voir mes Rendez-vous
                </a>
            </div>
        </div>
    </div>
</div>
@endsection
