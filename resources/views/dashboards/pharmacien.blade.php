@extends('layouts.app')

@section('content')
<div>
    <h1 class="text-3xl font-bold text-gray-800 mb-4">Tableau de bord Pharmacie</h1>
    <p class="text-lg text-gray-600 mb-8">Bienvenue, {{ $user->name }}. Gérez les prescriptions et les stocks.</p>

    <!-- Grille de widgets -->
    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
        
        <!-- Widget Prescriptions en attente -->
        <div class="bg-white p-6 rounded-lg shadow-md flex items-center gap-4">
            <div class="bg-orange-100 p-3 rounded-full">
                <svg class="h-6 w-6 text-orange-600" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01"></path></svg>
            </div>
            <div>
                <p class="text-sm text-gray-500">Prescriptions en attente</p>
                <p class="text-2xl font-bold text-gray-800">{{ $stats['pendingPrescriptionsCount'] }}</p>
            </div>
        </div>

        <!-- Widget Stock Faible -->
        <div class="bg-white p-6 rounded-lg shadow-md flex items-center gap-4">
            <div class="bg-yellow-100 p-3 rounded-full">
                <svg class="h-6 w-6 text-yellow-600" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20.618 5.984A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01"></path></svg>
            </div>
            <div>
                <p class="text-sm text-gray-500">Médicaments en stock faible</p>
                <p class="text-2xl font-bold text-gray-800">{{ $stats['lowStockMedicationsCount'] }}</p>
            </div>
        </div>
    </div>

    <!-- Section principale -->
    <div class="mt-10 grid grid-cols-1 lg:grid-cols-3 gap-10">
        <!-- Liste des dernières prescriptions -->
        <div class="lg:col-span-2 bg-white p-6 rounded-lg shadow-md">
            <h2 class="text-xl font-bold text-gray-800 mb-4">Dernières Prescriptions à Traiter</h2>
            <div class="overflow-x-auto">
                <table class="min-w-full bg-white">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="py-3 px-4 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Patient</th>
                            <th class="py-3 px-4 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Médecin Prescripteur</th>
                            <th class="py-3 px-4 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Date</th>
                            <th class="py-3 px-4 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Action</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-200">
                        @forelse ($stats['latestPrescriptions'] as $prescription)
                            <tr>
                                <td class="py-4 px-4 whitespace-nowrap font-medium text-gray-900">{{ $prescription->patient->name ?? 'N/A' }}</td>
                                <td class="py-4 px-4 whitespace-nowrap text-gray-500">Dr. {{ $prescription->medecin->name ?? 'N/A' }}</td>
                                <td class="py-4 px-4 whitespace-nowrap text-gray-500">{{ $prescription->created_at->format('d/m/Y') }}</td>
                                <td class="py-4 px-4 whitespace-nowrap">
                                    <a href="#" class="text-blue-600 hover:text-blue-800">Traiter</a>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="4" class="py-4 px-4 text-center text-gray-500">Aucune prescription en attente.</td>
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
                <a href="{{ route('pharmacien.pharmacie.index') }}" class="block w-full text-center bg-orange-600 text-white py-3 px-4 rounded-lg hover:bg-orange-700 transition-colors duration-300">
                    Gérer la Pharmacie
                </a>
            </div>
        </div>
    </div>
</div>
@endsection
