@extends('layouts.app')

@section('content')
    <div class="container mx-auto px-4 py-8">
        <div class="flex justify-between items-center mb-6">
            <h1 class="text-2xl font-bold text-gray-800">Détails du Rendez-vous</h1>
            <a href="{{ route('medecin.rendez-vous.index') }}" class="text-blue-600 hover:text-blue-800">
                &larr; Retour à la liste
            </a>
        </div>

        <div class="bg-white shadow-md rounded-lg overflow-hidden">
            <div class="p-6">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <h2 class="text-lg font-semibold text-gray-700 mb-2">Informations du Patient</h2>
                        <div class="space-y-2">
                            <p><span class="font-medium">Nom complet :</span> {{ $rendezVous->patient->prenom }} {{ $rendezVous->patient->nom }}</p>
                            <p><span class="font-medium">Date de naissance :</span> {{ $rendezVous->patient->date_naissance->format('d/m/Y') }}</p>
                            <p><span class="font-medium">Téléphone :</span> {{ $rendezVous->patient->telephone ?? 'Non renseigné' }}</p>
                            <p><span class="font-medium">Email :</span> {{ $rendezVous->patient->email ?? 'Non renseigné' }}</p>
                        </div>
                    </div>
                    
                    <div>
                        <h2 class="text-lg font-semibold text-gray-700 mb-2">Détails du Rendez-vous</h2>
                        <div class="space-y-2">
                            <p><span class="font-medium">Date et heure :</span> {{ $rendezVous->date_rendez_vous->format('d/m/Y à H:i') }}</p>
                            <p><span class="font-medium">Médecin :</span> Dr. {{ $rendezVous->user->name }}</p>
                            <p><span class="font-medium">Statut :</span> 
                                @php
                                    $badgeClasses = match ($rendezVous->statut) {
                                        'Confirmé' => 'bg-green-100 text-green-800',
                                        'En attente' => 'bg-yellow-100 text-yellow-800',
                                        'Annulé' => 'bg-red-100 text-red-800',
                                        'Terminé' => 'bg-gray-100 text-gray-800',
                                        default => 'bg-blue-100 text-blue-800',
                                    };
                                @endphp
                                <span class="px-2 py-1 text-xs font-medium rounded-full {{ $badgeClasses }}">
                                    {{ $rendezVous->statut }}
                                </span>
                            </p>
                            <p class="mt-4"><span class="font-medium">Motif :</span></p>
                            <p class="bg-gray-50 p-3 rounded">{{ $rendezVous->motif ?? 'Aucun motif renseigné' }}</p>
                            
                            @if($rendezVous->notes)
                                <p class="mt-4"><span class="font-medium">Notes :</span></p>
                                <p class="bg-gray-50 p-3 rounded">{{ $rendezVous->notes }}</p>
                            @endif
                        </div>
                    </div>
                </div>

                <div class="mt-8 pt-6 border-t border-gray-200 flex justify-between items-center">
                    <div>
                        <a href="{{ route('medecin.rendez-vous.show.ical', $rendezVous->id) }}" 
                           class="inline-flex items-center px-4 py-2 bg-blue-100 text-blue-700 rounded hover:bg-blue-200 transition-colors">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7v8l4-4m0 0l4 4m-4-4H3m16 0a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                            Exporter vers le calendrier
                        </a>
                    </div>
                    <div class="flex space-x-3">
                        @if($rendezVous->statut !== 'Annulé' && $rendezVous->statut !== 'Terminé')
                            <form action="{{ route('medecin.rendez-vous.annuler', $rendezVous->id) }}" method="POST" 
                                  onsubmit="return confirm('Êtes-vous sûr de vouloir annuler ce rendez-vous ?');">
                                @csrf
                                <button type="submit" class="px-4 py-2 bg-red-600 text-white rounded hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-red-500 focus:ring-offset-2">
                                    Annuler le rendez-vous
                                </button>
                            </form>
                        
                        @if($rendezVous->statut === 'Confirmé')
                            <a href="{{ route('medecin.consultations.create', ['patient' => $rendezVous->patient_id, 'rendez_vous' => $rendezVous->id]) }}" 
                               class="px-4 py-2 bg-blue-600 text-white rounded hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2">
                                Créer une consultation
                            </a>
                        @endif
                    @endif
                </div>
            </div>
        </div>
    </div>
@endsection
