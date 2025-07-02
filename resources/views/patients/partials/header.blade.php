@props(['patient'])

<div class="bg-white rounded-lg shadow-md overflow-hidden mb-6">
    <div class="px-6 py-4 bg-gradient-to-r from-blue-600 to-blue-800 text-white">
        <div class="flex flex-col md:flex-row md:items-center md:justify-between">
            <div>
                <h1 class="text-2xl font-bold">{{ $patient->prenom }} {{ $patient->nom }}</h1>
                <div class="flex items-center mt-2 space-x-4 text-sm">
                    <span>Né(e) le: {{ $patient->date_naissance->format('d/m/Y') }} ({{ $patient->age }} ans)</span>
                    <span>•</span>
                    <span>Sexe: {{ $patient->sexe }}</span>
                    <span>•</span>
                    <span>Groupe sanguin: {{ $patient->groupe_sanguin ?? 'Non renseigné' }}</span>
                </div>
            </div>
            <div class="mt-4 md:mt-0">
                <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium {{ $patient->getStatusColor() }}">
                    {{ ucfirst($patient->statut) ?? 'Inconnu' }}
                </span>
            </div>
        </div>
    </div>
</div>
