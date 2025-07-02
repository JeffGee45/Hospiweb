@extends('layouts.app')

@section('content')
    <div class="container mx-auto px-4 py-8">
        <div class="flex justify-between items-center mb-6">
            <h1 class="text-2xl font-bold text-gray-800">Mes Rendez-vous</h1>
            <div class="flex space-x-4">
                <a href="{{ route('medecin.rendez-vous.export.ical') }}" 
                   class="flex items-center px-4 py-2 bg-green-600 text-white rounded hover:bg-green-700 transition-colors mr-2">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7v8l4-4m0 0l4 4m-4-4H3m16 0a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                    Exporter tous
                </a>
                <a href="{{ route('medecin.rendez-vous.index', ['vue' => 'calendrier']) }}" 
                   class="flex items-center px-4 py-2 bg-blue-600 text-white rounded hover:bg-blue-700 transition-colors">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                    </svg>
                    Voir en calendrier
                </a>
            </div>
        </div>

        @if (session('success'))
            <div class="bg-green-100 border-l-4 border-green-500 text-green-700 p-4 mb-6" role="alert">
                <p>{{ session('success') }}</p>
            </div>
        @endif

        <div class="bg-white shadow-md rounded-lg overflow-hidden">
            <table class="min-w-full bg-white">
                <thead class="bg-gray-200 text-gray-600 uppercase text-sm leading-normal">
                    <tr>
                        <th class="py-3 px-6 text-left">Date et Heure</th>
                        <th class="py-3 px-6 text-left">Patient</th>
                        <th class="py-3 px-6 text-left">Téléphone</th>
                        <th class="py-3 px-6 text-left">Motif</th>
                        <th class="py-3 px-6 text-center">Statut</th>
                        <th class="py-3 px-6 text-center">Actions</th>
                    </tr>
                </thead>
                <tbody class="text-gray-600 text-sm font-light">
                    @forelse ($rendezVous as $rdv)
                        <tr class="border-b border-gray-200 hover:bg-gray-100">
                            <td class="py-3 px-6 text-left whitespace-nowrap">
                                {{ $rdv->date_rendez_vous->format('d/m/Y à H:i') }}
                            </td>
                            <td class="py-3 px-6 text-left">
                                {{ $rdv->patient->prenom }} {{ $rdv->patient->nom }}
                            </td>
                            <td class="py-3 px-6 text-left">
                                {{ $rdv->patient->telephone ?? 'N/A' }}
                            </td>
                            <td class="py-3 px-6 text-left">
                                {{ Str::limit($rdv->motif, 30) }}
                            </td>
                            <td class="py-3 px-6 text-center">
                                @php
                                    $badgeClasses = match ($rdv->statut) {
                                        'Confirmé' => 'bg-green-100 text-green-700',
                                        'En attente' => 'bg-yellow-100 text-yellow-700',
                                        'Annulé' => 'bg-red-100 text-red-700',
                                        'Terminé' => 'bg-gray-200 text-gray-700',
                                        default => 'bg-blue-200 text-blue-700',
                                    };
                                @endphp
                                <span class="py-1 px-3 rounded-full text-xs font-semibold {{ $badgeClasses }}">
                                    {{ $rdv->statut }}
                                </span>
                            </td>
                            <td class="py-3 px-6 text-center">
                                <div class="flex item-center justify-center">
                                    <a href="{{ route('medecin.rendez-vous.show', $rdv->id) }}" 
                                       class="w-6 mr-2 transform hover:text-blue-500 hover:scale-110"
                                       title="Voir les détails">
                                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                        </svg>
                                    </a>
                                    @if ($rdv->statut !== 'Annulé')
                                        <form action="{{ route('medecin.rendez-vous.annuler', $rdv->id) }}" method="POST"
                                            onsubmit="return confirm('Confirmer l\'annulation de ce rendez-vous ?');">
                                            @csrf
                                            <button type="submit" class="w-6 text-red-600 hover:text-red-800 ml-2"
                                                title="Annuler le rendez-vous">
                                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                                                </svg>
                                            </button>
                                        </form>
                                    @endif
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="text-center py-6">Aucun rendez-vous trouvé.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
            <div class="p-4">
                {{ $rendezVous->links() }}
            </div>
        </div>
    </div>
@endsection
