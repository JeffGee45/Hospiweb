@extends('layouts.app')

@section('content')
<div class="container mx-auto px-4 py-6">
    <h1 class="text-2xl font-bold mb-6">Mes prochains rendez-vous</h1>

    @if (session('success'))
        <div class="bg-green-100 border-l-4 border-green-500 text-green-700 p-4 mb-6" role="alert">
            <p>{{ session('success') }}</p>
        </div>
    @endif

    <div class="bg-white rounded-lg shadow overflow-hidden">
        <div class="divide-y divide-gray-200">
            @forelse ($rendezVous as $rdv)
                <div class="p-4 hover:bg-gray-50">
                    <div class="flex justify-between items-center">
                        <div>
                            <div class="font-medium">
                                {{ $rdv->patient->prenom }} {{ $rdv->patient->nom }}
                            </div>
                            <div class="text-sm text-gray-500">
                                {{ $rdv->date_rendez_vous->format('d/m/Y H:i') }}
                            </div>
                            <div class="mt-1">
                                <span class="px-2 py-1 text-xs rounded-full 
                                    @if($rdv->statut === 'Confirmé') bg-green-100 text-green-800
                                    @elseif($rdv->statut === 'Annulé') bg-red-100 text-red-800
                                    @else bg-yellow-100 text-yellow-800 @endif">
                                    {{ $rdv->statut }}
                                </span>
                            </div>
                        </div>
                        <div class="flex space-x-2">
                            <a href="{{ route('medecin.simple.rendez-vous.show', $rdv->id) }}" 
                               class="px-3 py-1 bg-blue-500 text-white text-sm rounded hover:bg-blue-600">
                                Voir
                            </a>
                            @if($rdv->statut !== 'Annulé')
                                <form action="{{ route('medecin.simple.rendez-vous.annuler', $rdv->id) }}" method="POST"
                                      onsubmit="return confirm('Annuler ce rendez-vous ?')">
                                    @csrf
                                    <button type="submit" class="px-3 py-1 bg-red-500 text-white text-sm rounded hover:bg-red-600">
                                        Annuler
                                    </button>
                                </form>
                            @endif
                        </div>
                    </div>
                </div>
            @empty
                <div class="p-6 text-center text-gray-500">
                    Aucun rendez-vous à venir
                </div>
            @endforelse
        </div>
        
        @if($rendezVous->hasPages())
            <div class="px-4 py-3 bg-gray-50 border-t border-gray-200">
                {{ $rendezVous->links() }}
            </div>
        @endif
    </div>
</div>
@endsection
