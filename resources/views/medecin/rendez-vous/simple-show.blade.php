@extends('layouts.app')

@section('content')
<div class="container mx-auto px-4 py-6 max-w-3xl">
    <div class="flex justify-between items-center mb-6">
        <h1 class="text-2xl font-bold">Détails du rendez-vous</h1>
        <a href="{{ route('medecin.simple.rendez-vous.index') }}" 
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
                <form action="{{ route('medecin.simple.rendez-vous.annuler', $rendezVous->id) }}" 
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
