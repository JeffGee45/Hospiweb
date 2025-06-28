@extends('layouts.app')

@section('content')
<div>
    <h1 class="text-3xl font-bold text-gray-800 mb-4">Tableau de bord Caisse</h1>
    <p class="text-lg text-gray-600 mb-8">Bienvenue, {{ $user->name }}. Prêt(e) à gérer les finances ?</p>

    <!-- Grille de widgets -->
    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
        
        <!-- Widget Factures en attente -->
        <div class="bg-white p-6 rounded-lg shadow-md flex items-center gap-4">
            <div class="bg-red-100 p-3 rounded-full">
                <svg class="h-6 w-6 text-red-600" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
            </div>
            <div>
                <p class="text-sm text-gray-500">Factures en attente</p>
                <p class="text-2xl font-bold text-gray-800">{{ $pendingInvoicesCount }}</p>
            </div>
        </div>

        <!-- Widget Revenus du jour -->
        <div class="bg-white p-6 rounded-lg shadow-md flex items-center gap-4">
            <div class="bg-green-100 p-3 rounded-full">
                <svg class="h-6 w-6 text-green-600" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v.01M12 6v-1m0-1V4m0 2.01V5M12 20v-1m0-1v-1m0-1v-1m0-1v-1m0-1v-1m0-1v-1"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 12h.01M12 12a2 2 0 012 2h-4a2 2 0 012-2z"></path></svg>
            </div>
            <div>
                <p class="text-sm text-gray-500">Revenus du Jour</p>
                <p class="text-2xl font-bold text-gray-800">{{ number_format($todayRevenue, 2, ',', ' ') }} €</p>
            </div>
        </div>
    </div>

    <!-- Section principale -->
    <div class="mt-10 grid grid-cols-1 lg:grid-cols-3 gap-10">
        <!-- Liste des dernières factures à encaisser -->
        <div class="lg:col-span-2 bg-white p-6 rounded-lg shadow-md">
            <h2 class="text-xl font-bold text-gray-800 mb-4">Dernières Factures à Encaisser</h2>
            <div class="overflow-x-auto">
                <table class="min-w-full bg-white">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="py-3 px-4 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Patient</th>
                            <th class="py-3 px-4 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Montant</th>
                            <th class="py-3 px-4 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Date d'émission</th>
                            <th class="py-3 px-4 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Action</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-200">
                        @forelse ($latestInvoices as $invoice)
                            <tr>
                                <td class="py-4 px-4 whitespace-nowrap font-medium text-gray-900">{{ $invoice->patient->name ?? 'N/A' }}</td>
                                <td class="py-4 px-4 whitespace-nowrap text-gray-500">{{ number_format($invoice->montant, 2, ',', ' ') }} €</td>
                                <td class="py-4 px-4 whitespace-nowrap text-gray-500">{{ $invoice->created_at->format('d/m/Y') }}</td>
                                <td class="py-4 px-4 whitespace-nowrap">
                                    <a href="#" class="text-blue-600 hover:text-blue-800">Encaisser</a>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="4" class="py-4 px-4 text-center text-gray-500">Aucune facture en attente.</td>
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
                <a href="{{ route('facturation.index') }}" class="block w-full text-center bg-red-600 text-white py-3 px-4 rounded-lg hover:bg-red-700 transition-colors duration-300">
                    Gérer la Facturation
                </a>
            </div>
        </div>
    </div>
</div>
@endsection
