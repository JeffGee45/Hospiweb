@extends('layouts.app')

@section('content')
    <div class="container mx-auto px-4 py-8">
        <h1 class="text-3xl font-bold text-gray-800 mb-6">{{ __('messages.Dashboard') }}</h1>

        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
            <div class="bg-white p-6 rounded-lg shadow-md">
                <h2 class="text-xl font-semibold text-gray-700">Nombre de Patients</h2>
                <p class="text-4xl font-bold text-blue-600 mt-2">{{ $patients->count() }}</p>
            </div>

            {{-- Widget Rendez-vous --}}
            <div class="bg-white p-6 rounded-lg shadow-md col-span-1 md:col-span-2 lg:col-span-2">
                <div class="flex items-center justify-between mb-4">
                    <h2 class="text-xl font-semibold text-gray-700 flex items-center gap-2">
                        <svg class="h-6 w-6 text-blue-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                            xmlns="http://www.w3.org/2000/svg">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z">
                            </path>
                        </svg>
                        Prochains rendez-vous
                    </h2>
                    <div class="flex gap-2">
                        <a href="{{ route('rendez-vous.index') }}"
                            class="inline-flex items-center px-3 py-1.5 bg-blue-100 text-blue-700 rounded hover:bg-blue-200 text-sm font-medium transition">
                            <svg class="h-4 w-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M15 12H9m6 0a6 6 0 11-12 0 6 6 0 0112 0z" />
                            </svg>
                            Voir tous
                        </a>
                        <a href="{{ route('rendez-vous.create') }}"
                            class="inline-flex items-center px-3 py-1.5 bg-green-100 text-green-700 rounded hover:bg-green-200 text-sm font-medium transition">
                            <svg class="h-4 w-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                            </svg>
                            Ajouter
                        </a>
                    </div>
                </div>
                @if (isset($rendezVousProchains) && $rendezVousProchains->count())
                    <ul class="divide-y divide-gray-200">
                        @foreach ($rendezVousProchains as $rdv)
                            <li class="py-2 flex items-center justify-between">
                                <div>
                                    <div class="font-semibold text-gray-800">
                                        {{ $rdv->date_rendez_vous->format('d/m/Y H:i') }}
                                    </div>
                                    <div class="text-gray-600 text-sm">
                                        Patient : <span class="font-medium">{{ $rdv->patient->nom ?? '-' }}</span>
                                        | Médecin : <span class="font-medium">{{ $rdv->user->name ?? '-' }}</span>
                                    </div>
                                    @if ($rdv->motif)
                                        <div class="text-xs text-gray-500">Motif : {{ $rdv->motif }}</div>
                                    @endif
                                </div>
                                <span
                                    class="inline-block px-2 py-1 rounded text-xs font-semibold
                                @if ($rdv->statut == 'Confirmé') bg-green-100 text-green-700
                                @elseif($rdv->statut == 'Annulé') bg-red-100 text-red-700
                                @else bg-yellow-100 text-yellow-700 @endif">
                                    {{ $rdv->statut }}
                                </span>
                            </li>
                        @endforeach
                    </ul>
                @else
                    <div class="text-gray-500 text-sm italic py-4">Aucun rendez-vous à venir.</div>
                @endif
            </div>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mt-8">
            {{-- Derniers rendez-vous terminés --}}
            <div class="bg-white p-6 rounded-lg shadow-md">
                <div class="flex items-center gap-2 mb-4">
                    <svg class="h-5 w-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M9 17v-2a4 4 0 014-4h3m-7 0a4 4 0 014-4V7m0 0V5a2 2 0 00-2-2h-4a2 2 0 00-2 2v2m2 0h.01" />
                    </svg>
                    <h2 class="text-lg font-semibold text-gray-700">Derniers rendez-vous terminés</h2>
                </div>
                @if (isset($rendezVousTermines) && $rendezVousTermines->count())
                    <ul class="divide-y divide-gray-100">
                        @foreach ($rendezVousTermines as $rdv)
                            <li class="py-2 flex items-center justify-between">
                                <div>
                                    <div class="font-semibold text-gray-700">
                                        {{ $rdv->date_rendez_vous->format('d/m/Y H:i') }}</div>
                                    <div class="text-gray-600 text-sm">
                                        Patient : <span class="font-medium">{{ $rdv->patient->nom ?? '-' }}</span> |
                                        Médecin : <span class="font-medium">{{ $rdv->user->name ?? '-' }}</span>
                                    </div>
                                </div>
                                <span
                                    class="inline-block px-2 py-1 rounded text-xs font-semibold bg-gray-200 text-gray-700">Terminé</span>
                            </li>
                        @endforeach
                    </ul>
                @else
                    <div class="text-gray-400 text-sm italic py-4">Aucun rendez-vous terminé.</div>
                @endif
            </div>

            {{-- Derniers rendez-vous annulés --}}
            <div class="bg-white p-6 rounded-lg shadow-md">
                <div class="flex items-center gap-2 mb-4">
                    <svg class="h-5 w-5 text-red-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                    <h2 class="text-lg font-semibold text-red-600">Derniers rendez-vous annulés</h2>
                </div>
                @if (isset($rendezVousAnnules) && $rendezVousAnnules->count())
                    <ul class="divide-y divide-gray-100">
                        @foreach ($rendezVousAnnules as $rdv)
                            <li class="py-2 flex items-center justify-between">
                                <div>
                                    <div class="font-semibold text-gray-700">
                                        {{ $rdv->date_rendez_vous->format('d/m/Y H:i') }}</div>
                                    <div class="text-gray-600 text-sm">
                                        Patient : <span class="font-medium">{{ $rdv->patient->nom ?? '-' }}</span> |
                                        Médecin : <span class="font-medium">{{ $rdv->user->name ?? '-' }}</span>
                                    </div>
                                </div>
                                <span
                                    class="inline-block px-2 py-1 rounded text-xs font-semibold bg-red-100 text-red-700">Annulé</span>
                            </li>
                        @endforeach
                    </ul>
                @else
                    <div class="text-red-300 text-sm italic py-4">Aucun rendez-vous annulé.</div>
                @endif
            </div>
        </div>

    </div>
@endsection
