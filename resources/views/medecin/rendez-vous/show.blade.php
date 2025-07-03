@extends('layouts.app')

@section('content')
<div class="container mx-auto px-4 py-8 max-w-2xl">
    <div class="mb-6 flex items-center justify-between">
        <h1 class="text-2xl font-bold text-gray-800">Détails du rendez-vous</h1>
        <a href="{{ route('medecin.rendez-vous.index') }}" class="text-blue-600 hover:underline">&larr; Retour à la liste</a>
    </div>
    <div class="bg-white shadow rounded-lg p-6 mb-6">
        <h2 class="text-lg font-semibold text-gray-700 mb-4">Informations Patient</h2>
        <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-4">
            <div>
                <span class="font-medium">Nom :</span> {{ $rendezVous->patient->prenom }} {{ $rendezVous->patient->nom }}
            </div>
            <div>
                <span class="font-medium">Téléphone :</span> {{ $rendezVous->patient->telephone ?? '—' }}
            </div>
            <div>
                <span class="font-medium">Date de naissance :</span> {{ $rendezVous->patient->date_naissance ?? '—' }}
            </div>
        </div>
    </div>
    <div class="bg-white shadow rounded-lg p-6 mb-6">
        <h2 class="text-lg font-semibold text-gray-700 mb-4">Détails du rendez-vous</h2>
        <div class="mb-2"><span class="font-medium">Date et heure :</span> {{ $rendezVous->date_rendez_vous->format('d/m/Y H:i') }}</div>
        <div class="mb-2"><span class="font-medium">Motif :</span> {{ $rendezVous->motif }}</div>
        <div class="mb-2"><span class="font-medium">Statut :</span>
            @php
                $badge = match($rendezVous->statut) {
                    'Confirmé' => 'bg-green-100 text-green-700',
                    'Annulé' => 'bg-red-100 text-red-700',
                    'En attente' => 'bg-yellow-100 text-yellow-800',
                    default => 'bg-gray-100 text-gray-700',
                };
            @endphp
            <span class="px-3 py-1 rounded-full text-xs font-semibold {{ $badge }}">{{ $rendezVous->statut }}</span>
        </div>
        @if($rendezVous->statut !== 'Annulé')
        <form action="{{ route('medecin.rendez-vous.annuler', $rendezVous->id) }}" method="POST" class="mt-4" onsubmit="return confirm('Annuler ce rendez-vous ?')">
            @csrf
            <button type="submit" class="px-4 py-2 bg-red-500 text-white rounded hover:bg-red-700">Annuler ce rendez-vous</button>
        </form>
        @endif
    </div>
</div>
@endsection

@section('content')
<div class="container mx-auto px-4 py-6 max-w-3xl">
    <div class="flex justify-between items-center mb-6">
        <h1 class="text-2xl font-bold">Détails du rendez-vous</h1>
        <a href="{{ route('medecin.rendez-vous.index') }}" 
           class="text-blue-500 hover:text-blue-700">
            &larr; Retour à la liste
        </a>
    </div>

    <div class="bg-white rounded-lg shadow overflow-hidden">
        <div class="p-6">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <h2 class="text-lg font-medium text-gray-900 mb-2">Patient</h2>
                    <p class="text-gray-700">
                        {{ $rendezVous->patient->prenom }} {{ $rendezVous->patient->nom }}
                    </p>
                    <p class="text-gray-500 text-sm mt-1">
                        {{ $rendezVous->patient->telephone ?? 'Téléphone non renseigné' }}
                    </p>
                </div>
                
                <div>
                    <h2 class="text-lg font-medium text-gray-900 mb-2">Date et heure</h2>
                    <p class="text-gray-700">
                        {{ $rendezVous->date_rendez_vous->format('d/m/Y à H:i') }}
                    </p>
                    <span class="inline-block mt-2 px-3 py-1 text-sm rounded-full 
                        @if($rendezVous->statut === 'Confirmé') bg-green-100 text-green-800
                        @elseif($rendezVous->statut === 'Annulé') bg-red-100 text-red-800
                        @else bg-yellow-100 text-yellow-800 @endif">
                        {{ $rendezVous->statut }}
                    </span>
                </div>
            </div>

            <div class="mt-6">
                <h2 class="text-lg font-medium text-gray-900 mb-2">Motif</h2>
                <p class="text-gray-700">
                    {{ $rendezVous->motif ?? 'Aucun motif spécifié' }}
                </p>
            </div>

            @if($rendezVous->notes)
            <div class="mt-6">
                <h2 class="text-lg font-medium text-gray-900 mb-2">Notes</h2>
                <p class="text-gray-700 whitespace-pre-line">
                    {{ $rendezVous->notes }}
                </p>
            </div>
            @endif
        </div>

        <div class="px-6 py-4 bg-gray-50 border-t border-gray-200 flex justify-end space-x-3">
            @if($rendezVous->statut !== 'Annulé')
                <form action="{{ route('medecin.rendez-vous.annuler', $rendezVous->id) }}" 
                      method="POST" 
                      onsubmit="return confirm('Annuler ce rendez-vous ?')">
                    @csrf
                    <button type="submit" class="px-4 py-2 bg-red-500 text-white rounded hover:bg-red-600">
                        Annuler le rendez-vous
                    </button>
                </form>
            @endif
        </div>
    </div>
</div>
@endsection
