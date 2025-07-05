@extends('layouts.app')

@section('title', 'Détails de la prescription')

@section('content')
<div class="container mx-auto px-4 py-6">
    <div class="bg-white rounded-lg shadow-md p-6 mb-6">
        <div class="flex justify-between items-center mb-6">
            <h1 class="text-2xl font-semibold text-gray-800">Détails de la prescription</h1>
            <div class="flex space-x-2">
                <a href="{{ route('prescriptions.print', ['consultation' => $consultation, 'prescription' => $prescription]) }}" 
                   class="bg-blue-500 hover:bg-blue-600 text-white px-4 py-2 rounded-md flex items-center"
                   target="_blank">
                    <i class="fas fa-print mr-2"></i> Imprimer
                </a>
                <a href="{{ route('consultations.show', $consultation) }}" 
                   class="bg-gray-500 hover:bg-gray-600 text-white px-4 py-2 rounded-md flex items-center">
                    <i class="fas fa-arrow-left mr-2"></i> Retour
                </a>
            </div>
        </div>

        <!-- En-tête de la prescription -->
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-8">
            <div>
                <h2 class="text-lg font-semibold text-gray-700 mb-2">Médecin prescripteur</h2>
                <p class="text-gray-800">{{ $prescription->medecin->name ?? 'Non spécifié' }}</p>
                <p class="text-gray-600 text-sm">
                    {{ $prescription->medecin->specialite ?? 'Spécialité non spécifiée' }}
                </p>
            </div>
            <div class="text-right">
                <div class="mb-2">
                    <span class="text-gray-700 font-medium">Date de prescription :</span>
                    <span class="text-gray-800">{{ $prescription->date_prescription->format('d/m/Y') }}</span>
                </div>
                <div>
                    <span class="text-gray-700 font-medium">Date d'expiration :</span>
                    <span class="text-gray-800">{{ $prescription->date_expiration->format('d/m/Y') }}</span>
                </div>
                <div class="mt-2">
                    <span class="px-3 py-1 rounded-full text-sm font-semibold 
                        {{ $prescription->statut === 'en_attente' ? 'bg-yellow-100 text-yellow-800' : 
                           ($prescription->statut === 'prete' ? 'bg-green-100 text-green-800' : 'bg-gray-100 text-gray-800') }}">
                        {{ ucfirst(str_replace('_', ' ', $prescription->statut)) }}
                    </span>
                </div>
            </div>
        </div>

        <!-- Informations du patient -->
        <div class="bg-blue-50 p-4 rounded-lg mb-8">
            <h2 class="text-lg font-semibold text-gray-800 mb-3">Informations du patient</h2>
            <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                <div>
                    <p class="text-gray-700 font-medium">Nom complet</p>
                    <p class="text-gray-900">{{ $consultation->patient->nom_complet ?? 'Non spécifié' }}</p>
                </div>
                <div>
                    <p class="text-gray-700 font-medium">Date de naissance</p>
                    <p class="text-gray-900">{{ $consultation->patient->date_naissance->format('d/m/Y') ?? 'Non spécifiée' }}</p>
                </div>
                <div>
                    <p class="text-gray-700 font-medium">Numéro de dossier</p>
                    <p class="text-gray-900">{{ $consultation->patient->numero_dossier ?? 'Non spécifié' }}</p>
                </div>
            </div>
        </div>

        <!-- Liste des médicaments -->
        <div class="mb-8">
            <h2 class="text-lg font-semibold text-gray-800 mb-4">Médicaments prescrits</h2>
            <div class="overflow-x-auto">
                <table class="min-w-full bg-white rounded-lg overflow-hidden">
                    <thead class="bg-gray-100">
                        <tr>
                            <th class="py-3 px-4 text-left text-gray-700 font-semibold">Médicament</th>
                            <th class="py-3 px-4 text-left text-gray-700 font-semibold">Posologie</th>
                            <th class="py-3 px-4 text-left text-gray-700 font-semibold">Durée</th>
                            <th class="py-3 px-4 text-left text-gray-700 font-semibold">Quantité</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-200">
                        @foreach($prescription->medicaments as $medicament)
                        <tr class="hover:bg-gray-50">
                            <td class="py-3 px-4">
                                <div class="font-medium text-gray-900">{{ $medicament->nom_medicament }}</div>
                                <div class="text-sm text-gray-500">{{ $medicament->dosage }}</div>
                            </td>
                            <td class="py-3 px-4">
                                <div class="text-gray-900">{{ $medicament->frequence }}</div>
                                @if($medicament->instructions)
                                <div class="text-sm text-gray-500 italic">{{ $medicament->instructions }}</div>
                                @endif
                            </td>
                            <td class="py-3 px-4 text-gray-700">{{ $medicament->duree }}</td>
                            <td class="py-3 px-4 text-gray-700">{{ $medicament->quantite }}</td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>

        <!-- Instructions supplémentaires -->
        @if($prescription->remarques)
        <div class="bg-yellow-50 p-4 rounded-lg mb-6">
            <h3 class="text-md font-semibold text-yellow-800 mb-2">Instructions supplémentaires</h3>
            <p class="text-yellow-700 whitespace-pre-line">{{ $prescription->remarques }}</p>
        </div>
        @endif

        <!-- Signature -->
        <div class="mt-12 pt-6 border-t border-gray-200">
            <div class="flex justify-end">
                <div class="text-center">
                    <div class="h-16 border-t-2 border-gray-400 w-48 mb-2"></div>
                    <p class="text-gray-700 font-medium">Signature et cachet du médecin</p>
                    <p class="text-sm text-gray-600">Dr. {{ $prescription->medecin->name ?? '' }}</p>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Script pour l'impression -->
@push('scripts')
<script>
    function printPrescription() {
        window.print();
    }
</script>
@endpush

<!-- Style pour l'impression -->
@push('styles')
<style>
    @media print {
        body * {
            visibility: hidden;
        }
        #prescription-print, #prescription-print * {
            visibility: visible;
        }
        #prescription-print {
            position: absolute;
            left: 0;
            top: 0;
            width: 100%;
            padding: 20px;
        }
        .no-print {
            display: none !important;
        }
    }
</style>
@endpush
@endsection
