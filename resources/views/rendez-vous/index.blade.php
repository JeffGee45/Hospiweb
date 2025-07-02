@extends('layouts.app')

@section('content')
    <div class="container mx-auto px-4 py-8">
        <div class="flex justify-between items-center mb-6">
            <h1 class="text-2xl font-bold text-gray-800">Gestion des Rendez-vous</h1>
            @if(in_array(auth()->user()->role, ['Admin', 'Secretaire']))
                <a href="{{ route(auth()->user()->role === 'Secretaire' ? 'secretaire.rendez-vous.create' : 'admin.rendez-vous.create') }}"
                    class="inline-flex items-center gap-2 px-6 py-3 rounded-lg bg-blue-600 text-white text-base font-semibold shadow hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-300 transition duration-150">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"
                        stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round"
                            d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                    </svg>
                    Ajouter un rendez-vous
                </a>
            @endif
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
                        <th class="py-3 px-6 text-left">Utilisateur</th>
                        <th class="py-3 px-6 text-left">Motif</th>
                        <th class="py-3 px-6 text-center">Statut</th>
                        <th class="py-3 px-6 text-center">Actions</th>
                    </tr>
                </thead>
                <tbody class="text-gray-600 text-sm font-light">
                    @forelse ($rendezVous as $rdv)
                        <tr class="border-b border-gray-200 hover:bg-gray-100">
                            <td class="py-3 px-6 text-left whitespace-nowrap">
                                {{ $rdv->date_rendez_vous->format('d/m/Y à H:i') }}</td>
                            <td class="py-3 px-6 text-left">{{ $rdv->patient->prenom }} {{ $rdv->patient->nom }}</td>
                            <td class="py-3 px-6 text-left">{{ $rdv->user->name }}</td>
                            <td class="py-3 px-6 text-left">{{ Str::limit($rdv->motif, 50) }}</td>
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
                                <span
                                    class="py-1 px-3 rounded-full text-xs font-semibold {{ $badgeClasses }}">{{ $rdv->statut }}</span>
                            </td>
                            <td class="py-3 px-6 text-center">
                                <div class="flex item-center justify-center">
                                    @if(in_array(auth()->user()->role, ['Admin', 'Secretaire']))
                                        <a href="{{ route(auth()->user()->role === 'Secretaire' ? 'secretaire.rendez-vous.edit' : 'admin.rendez-vous.edit', $rdv->id) }}"
                                            class="w-6 mr-2 transform hover:text-purple-500 hover:scale-110">
                                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                                stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.5L14.732 3.732z" />
                                            </svg>
                                        </a>
                                        <form action="{{ route(auth()->user()->role === 'Secretaire' ? 'secretaire.rendez-vous.destroy' : 'admin.rendez-vous.destroy', $rdv->id) }}" method="POST"
                                            onsubmit="return confirm('Êtes-vous sûr de vouloir supprimer ce rendez-vous ?');">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit"
                                                class="w-6 mr-2 transform hover:text-red-500 hover:scale-110 cursor-pointer">
                                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                                    stroke="currentColor">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                        d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                                </svg>
                                            </button>
                                        </form>
                                    @endif
                                    
                                    @if ($rdv->statut !== 'Annulé' && in_array(auth()->user()->role, ['Admin', 'Secretaire', 'Médecin']))
                                        @php
                                            $routeName = 'secretaire.rendez-vous.annuler';
                                            if (auth()->user()->role === 'Admin') {
                                                $routeName = 'admin.rendez-vous.annuler';
                                            } elseif (auth()->user()->role === 'Médecin') {
                                                $routeName = 'medecin.rendez-vous.annuler';
                                            }
                                        @endphp
                                        <form action="{{ route($routeName, $rdv->id) }}" method="POST"
                                            onsubmit="return confirm('Confirmer l\'annulation de ce rendez-vous ?');">
                                            @csrf
                                            <button type="submit" class="w-6 text-red-600 hover:text-red-800 ml-2"
                                                title="Annuler">
                                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                                    stroke="currentColor">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                        d="M6 18L18 6M6 6l12 12" />
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
