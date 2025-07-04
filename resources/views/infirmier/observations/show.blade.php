@extends('layouts.app')

@section('title', "Observation #{$observation->id}")

@section('content')
<div class="container mx-auto px-4 py-6">
    <div class="flex justify-between items-center mb-6">
        <div>
            <h1 class="text-2xl font-semibold text-gray-900">Observation #{{ $observation->id }}</h1>
            <p class="text-sm text-gray-500">Créée le {{ $observation->created_at->format('d/m/Y à H:i') }}</p>
        </div>
        <div class="flex space-x-2">
            <a href="{{ route('infirmier.observations.index') }}" class="px-4 py-2 border border-gray-300 rounded-md text-gray-700 hover:bg-gray-50">
                Retour à la liste
            </a>
            @if($observation->peutEtreModifieePar(auth()->user()))
                <a href="{{ route('infirmier.observations.edit', $observation) }}" class="px-4 py-2 bg-indigo-600 text-white rounded-md hover:bg-indigo-700">
                    Modifier
                </a>
            @endif
        </div>
    </div>

    <div class="bg-white shadow overflow-hidden sm:rounded-lg">
        <div class="px-4 py-5 sm:px-6 {{ $observation->estUrgente() ? 'bg-red-50' : 'bg-white' }}">
            <h3 class="text-lg leading-6 font-medium text-gray-900">
                Détails de l'observation
            </h3>
            @if($observation->estUrgente())
                <p class="mt-1 max-w-2xl text-sm text-red-600">
                    Cette observation est marquée comme urgente.
                </p>
            @endif
        </div>
        <div class="border-t border-gray-200">
            <dl>
                <div class="bg-gray-50 px-4 py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                    <dt class="text-sm font-medium text-gray-500">Patient</dt>
                    <dd class="mt-1 text-sm text-gray-900 sm:mt-0 sm:col-span-2">
                        {{ $observation->patient->nom_complet }}
                    </dd>
                </div>
                <div class="bg-white px-4 py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                    <dt class="text-sm font-medium text-gray-500">Type d'observation</dt>
                    <dd class="mt-1 text-sm text-gray-900 sm:mt-0 sm:col-span-2">
                        {{ $observation->type_observation }}
                    </dd>
                </div>
                <div class="bg-gray-50 px-4 py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                    <dt class="text-sm font-medium text-gray-500">Valeur</dt>
                    <dd class="mt-1 text-sm text-gray-900 sm:mt-0 sm:col-span-2">
                        {{ $observation->valeur }} 
                        @if($observation->unite)
                            {{ $observation->unite }}
                        @endif
                    </dd>
                </div>
                <div class="bg-white px-4 py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                    <dt class="text-sm font-medium text-gray-500">Date et heure</dt>
                    <dd class="mt-1 text-sm text-gray-900 sm:mt-0 sm:col-span-2">
                        {{ $observation->dateHeureFormatee }}
                    </dd>
                </div>
                @if($observation->commentaire)
                    <div class="bg-gray-50 px-4 py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                        <dt class="text-sm font-medium text-gray-500">Commentaire</dt>
                        <dd class="mt-1 text-sm text-gray-900 sm:mt-0 sm:col-span-2 whitespace-pre-line">
                            {{ $observation->commentaire }}
                        </dd>
                    </div>
                @endif
                <div class="bg-white px-4 py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                    <dt class="text-sm font-medium text-gray-500">Saisie par</dt>
                    <dd class="mt-1 text-sm text-gray-900 sm:mt-0 sm:col-span-2">
                        {{ $observation->infirmier->name }}
                    </dd>
                </div>
            </dl>
        </div>
    </div>

    <div class="mt-6 flex justify-end space-x-4">
        @if($observation->peutEtreModifieePar(auth()->user()))
            <form action="{{ route('infirmier.observations.destroy', $observation) }}" method="POST" onsubmit="return confirm('Êtes-vous sûr de vouloir supprimer cette observation ? Cette action est irréversible.');">
                @csrf
                @method('DELETE')
                <button type="submit" class="inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md text-red-700 bg-red-100 hover:bg-red-200 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500">
                    Supprimer l'observation
                </button>
            </form>
        @endif
    </div>
</div>
@endsection
