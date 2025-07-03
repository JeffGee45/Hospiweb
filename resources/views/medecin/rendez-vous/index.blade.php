@extends('layouts.app')

@section('content')
<div class="container mx-auto px-4 py-8">
    <h1 class="text-2xl font-bold text-gray-800 mb-4">Mes rendez-vous</h1>
    @if (session('success'))
        <div class="bg-green-100 border-l-4 border-green-500 text-green-700 p-4 mb-6 rounded" role="alert">
            <p>{{ session('success') }}</p>
        </div>
    @endif
    <div class="overflow-x-auto bg-white shadow rounded-lg">
        <table class="min-w-full divide-y divide-gray-200">
            <thead class="bg-gray-50">
                <tr>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Date & Heure</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Patient</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Téléphone</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Motif</th>
                    <th class="px-6 py-3 text-center text-xs font-medium text-gray-500 uppercase">Statut</th>
                    <th class="px-6 py-3 text-center text-xs font-medium text-gray-500 uppercase">Actions</th>
                </tr>
            </thead>
            <tbody class="bg-white divide-y divide-gray-200">
                @forelse ($rendezVous as $rdv)
                    <tr class="hover:bg-gray-50">
                        <td class="px-6 py-4 whitespace-nowrap">{{ $rdv->date_rendez_vous->format('d/m/Y H:i') }}</td>
                        <td class="px-6 py-4 whitespace-nowrap">{{ $rdv->patient->prenom }} {{ $rdv->patient->nom }}</td>
                        <td class="px-6 py-4 whitespace-nowrap">{{ $rdv->patient->telephone ?? '—' }}</td>
                        <td class="px-6 py-4 whitespace-nowrap">{{ Str::limit($rdv->motif, 30) }}</td>
                        <td class="px-6 py-4 text-center">
                            @php
                                $badge = match($rdv->statut) {
                                    'Confirmé' => 'bg-green-100 text-green-700',
                                    'Annulé' => 'bg-red-100 text-red-700',
                                    'En attente' => 'bg-yellow-100 text-yellow-800',
                                    default => 'bg-gray-100 text-gray-700',
                                };
                            @endphp
                            <span class="px-3 py-1 rounded-full text-xs font-semibold {{ $badge }}">{{ $rdv->statut }}</span>
                        </td>
                        <td class="px-6 py-4 text-center flex justify-center gap-2">
                            <a href="{{ route('medecin.rendez-vous.show', $rdv->id) }}" class="px-3 py-1 bg-blue-500 text-white rounded hover:bg-blue-600 text-xs">Voir</a>
                            @if($rdv->statut !== 'Annulé')
                                <form action="{{ route('medecin.rendez-vous.annuler', $rdv->id) }}" method="POST" onsubmit="return confirm('Annuler ce rendez-vous ?')">
                                    @csrf
                                    <button type="submit" class="px-3 py-1 bg-red-500 text-white rounded hover:bg-red-700 text-xs">Annuler</button>
                                </form>
                            @endif
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="6" class="text-center py-6 text-gray-500">Aucun rendez-vous à venir</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
        <div class="p-4">{{ $rendezVous->links() }}</div>
    </div>
</div>
@endsection

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
                            <a href="{{ route('medecin.rendez-vous.show', $rdv->id) }}" 
                               class="px-3 py-1 bg-blue-500 text-white text-sm rounded hover:bg-blue-600">
                                Voir
                            </a>
                            @if($rdv->statut !== 'Annulé')
                                <form action="{{ route('medecin.rendez-vous.annuler', $rdv->id) }}" method="POST"
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
