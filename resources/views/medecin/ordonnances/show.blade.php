@extends('layouts.app')

@section('title', 'Détails de l\'ordonnance')

@section('content')
<div class="container mx-auto px-4 py-6">
    <div class="flex justify-between items-center mb-6">
        <div>
            <h1 class="text-2xl font-semibold text-gray-900">Ordonnance #{{ $ordonnance->id }}</h1>
            <p class="text-sm text-gray-500">Créée le {{ $ordonnance->created_at->format('d/m/Y à H:i') }}</p>
        </div>
        <div class="flex space-x-2">
            <a href="{{ route('medecin.ordonnances.edit', $ordonnance) }}" class="px-4 py-2 bg-indigo-600 text-white rounded-md hover:bg-indigo-700 transition-colors">
                <i class="fas fa-edit mr-2"></i>Modifier
            </a>
            <a href="{{ route('medecin.ordonnances.pdf', $ordonnance) }}" class="px-4 py-2 bg-red-600 text-white rounded-md hover:bg-red-700 transition-colors" target="_blank">
                <i class="fas fa-file-pdf mr-2"></i>Générer PDF
            </a>
            <a href="{{ route('medecin.ordonnances.index') }}" class="px-4 py-2 bg-gray-200 text-gray-800 rounded-md hover:bg-gray-300 transition-colors">
                <i class="fas fa-arrow-left mr-2"></i>Retour
            </a>
        </div>
    </div>

    <div class="bg-white shadow overflow-hidden sm:rounded-lg mb-6">
        <div class="px-4 py-5 sm:px-6 border-b border-gray-200">
            <h3 class="text-lg leading-6 font-medium text-gray-900">
                Informations du patient
            </h3>
        </div>
        <div class="px-4 py-5 sm:p-6">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <h4 class="text-sm font-medium text-gray-500">Nom complet</h4>
                    <p class="mt-1 text-sm text-gray-900">{{ $ordonnance->patient->prenom }} {{ $ordonnance->patient->nom }}</p>
                </div>
                <div>
                    <h4 class="text-sm font-medium text-gray-500">Date de naissance</h4>
                    <p class="mt-1 text-sm text-gray-900">
                        {{ $ordonnance->patient->date_naissance->format('d/m/Y') }}
                        ({{ $ordonnance->patient->date_naissance->age }} ans)
                    </p>
                </div>
                <div>
                    <h4 class="text-sm font-medium text-gray-500">Téléphone</h4>
                    <p class="mt-1 text-sm text-gray-900">{{ $ordonnance->patient->telephone ?? 'Non renseigné' }}</p>
                </div>
                <div>
                    <h4 class="text-sm font-medium text-gray-500">Email</h4>
                    <p class="mt-1 text-sm text-gray-900">{{ $ordonnance->patient->email ?? 'Non renseigné' }}</p>
                </div>
            </div>
        </div>
    </div>

    <div class="bg-white shadow overflow-hidden sm:rounded-lg mb-6">
        <div class="px-4 py-5 sm:px-6 border-b border-gray-200">
            <h3 class="text-lg leading-6 font-medium text-gray-900">
                Détails de l'ordonnance
            </h3>
        </div>
        <div class="px-4 py-5 sm:p-6">
            <div class="mb-6">
                <h4 class="text-sm font-medium text-gray-500">Date de l'ordonnance</h4>
                <p class="mt-1 text-sm text-gray-900">
                    {{ $ordonnance->date_ordonnance->format('d/m/Y') }}
                </p>
            </div>

            @if($ordonnance->commentaire)
                <div class="mb-6">
                    <h4 class="text-sm font-medium text-gray-500">Commentaires</h4>
                    <p class="mt-1 text-sm text-gray-900 whitespace-pre-line">{{ $ordonnance->commentaire }}</p>
                </div>
            @endif

            <div>
                <h4 class="text-sm font-medium text-gray-500 mb-4">Médicaments prescrits</h4>
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-gray-50">
                            <tr>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Médicament
                                </th>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Posologie
                                </th>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Durée
                                </th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            @foreach($ordonnance->medicaments as $medicament)
                                <tr>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="text-sm font-medium text-gray-900">{{ $medicament->nom }}</div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="text-sm text-gray-900">{{ $medicament->posologie }}</div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="text-sm text-gray-900">{{ $medicament->duree }}</div>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <div class="bg-white shadow overflow-hidden sm:rounded-lg">
        <div class="px-4 py-5 sm:px-6 border-b border-gray-200">
            <h3 class="text-lg leading-6 font-medium text-gray-900">
                Informations supplémentaires
            </h3>
        </div>
        <div class="px-4 py-5 sm:p-6">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <h4 class="text-sm font-medium text-gray-500">Médecin prescripteur</h4>
                    <p class="mt-1 text-sm text-gray-900">
                        Dr. {{ $ordonnance->medecin->prenom }} {{ $ordonnance->medecin->nom }}
                    </p>
                </div>
                <div>
                    <h4 class="text-sm font-medium text-gray-500">Date de création</h4>
                    <p class="mt-1 text-sm text-gray-900">
                        {{ $ordonnance->created_at->format('d/m/Y à H:i') }}
                    </p>
                </div>
                <div>
                    <h4 class="text-sm font-medium text-gray-500">Dernière mise à jour</h4>
                    <p class="mt-1 text-sm text-gray-900">
                        {{ $ordonnance->updated_at->format('d/m/Y à H:i') }}
                    </p>
                </div>
            </div>
        </div>
    </div>
</div>

@push('styles')
<style>
    /* Styles spécifiques à la page de détail de l'ordonnance */
    .medicament-card {
        transition: all 0.2s ease-in-out;
    }
    .medicament-card:hover {
        transform: translateY(-2px);
        box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1), 0 2px 4px -1px rgba(0, 0, 0, 0.06);
    }
</style>
@endpush

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Scripts spécifiques à la page de détail
        console.log('Page de détail de l\'ordonnance chargée');
    });
</script>
@endpush
@endsection
