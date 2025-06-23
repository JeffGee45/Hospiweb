@extends('layouts.app')

@section('content')
    <div class="layout-content-container flex flex-col max-w-[960px] flex-1">
        {{-- <div class="flex justify-between items-center p-4">
            <h2 class="text-2xl font-bold">Détails du Patient</h2>
            <a href="{{ route('patients.index') }}" class="bg-gray-500 text-white px-4 py-2 rounded hover:bg-gray-600">Retour
                à la liste</a>
        </div> --}}

        <div class="bg-white shadow-xl rounded-2xl px-8 pt-8 pb-8 mb-6 flex flex-col gap-6 md:flex-row md:gap-10">
            <!-- Bloc identité et statut -->
            <div class="flex-1 flex flex-col gap-4 min-w-[260px]">
                <div class="flex items-center gap-4">
                    <div class="h-16 w-16 rounded-full bg-blue-100 flex items-center justify-center text-blue-700 text-3xl font-bold shadow">
                        {{ strtoupper(substr($patient->prenom, 0, 1)) }}{{ strtoupper(substr($patient->nom, 0, 1)) }}
                    </div>
                    <div>
                        <div class="text-2xl font-bold text-[#111518]">{{ $patient->prenom }} {{ $patient->nom }}</div>
                        <div class="flex items-center gap-2 mt-1">
                            @php
                                $statusClasses = match ($patient->status) {
                                    'Actif' => 'bg-green-100 text-green-800',
                                    'Décédé' => 'bg-gray-400 text-white',
                                    'Inactif' => 'bg-yellow-100 text-yellow-800',
                                    default => 'bg-blue-100 text-blue-800',
                                };
                            @endphp
                            <span class="px-3 py-1 text-xs font-semibold rounded-full {{ $statusClasses }}">
                                {{ $patient->status ?? 'Inactif' }}
                            </span>
                        </div>
                    </div>
                </div>
                <div class="flex items-center gap-3 mt-2 text-[#637988]">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-[#9db1bf]" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M5.121 17.804A13.937 13.937 0 0112 15c2.5 0 4.847.655 6.879 1.804M15 11a3 3 0 11-6 0 3 3 0 016 0zm6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                    <span>{{ $patient->gender ?? 'N/A' }}</span>
                </div>
                <div class="flex items-center gap-3 text-[#637988]">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-[#9db1bf]" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M8 7V3m8 4V3m-9 8h10m-7 4h4m-9 5h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                    </svg>
                    <span>{{ $patient->date_of_birth ? \Carbon\Carbon::parse($patient->date_of_birth)->format('d/m/Y') : 'N/A' }}</span>
                </div>
            </div>
            <!-- Bloc infos complémentaires -->
            <div class="flex-1 flex flex-col gap-3">
                <div class="flex items-center gap-3">
                    <span class="font-semibold text-gray-700">Adresse :</span>
                    <span class="text-gray-700">{{ $patient->adresse }}</span>
                </div>
                <div class="flex items-center gap-3">
                    <span class="font-semibold text-gray-700">Groupe sanguin :</span>
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-[#e11d48]" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 22c4.418 0 8-4.03 8-9 0-3.866-2.239-7-5-7-1.657 0-3 1.343-3 3 0 1.657 1.343 3 3 3 1.657 0 3-1.343 3-3" />
                    </svg>
                    <span>{{ $patient->blood_group ?? 'N/A' }}</span>
                </div>
                <div class="flex items-center gap-3">
                    <span class="font-semibold text-gray-700">Antécédents :</span>
                    <span class="text-gray-700">{{ $patient->antecedents ?? 'N/A' }}</span>
                </div>
            </div>
            <!-- Bloc actions -->
            <div class="flex flex-col gap-4 items-end justify-between min-w-[180px]">
                <div class="flex gap-2">
                    <a href="{{ route('patients.edit', $patient->id) }}" class="inline-flex items-center gap-2 px-4 py-2 rounded-lg bg-yellow-500 text-white font-semibold shadow hover:bg-yellow-600 focus:outline-none focus:ring-2 focus:ring-yellow-300 transition duration-150" title="Modifier">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2a2 2 0 01-2-2 2 2 0 012-2 2 2 0 012 2v2h1.414a2 2 0 011.414 1.414l1.414-1.414a2 2 0 01.828-2.828V5z" />
                        </svg>
                        Modifier
                    </a>
                    <a href="{{ route('dossiers.show', $patient->id) }}" class="inline-flex items-center gap-2 px-4 py-2 rounded-lg bg-blue-500 text-white font-semibold shadow hover:bg-blue-600 focus:outline-none focus:ring-2 focus:ring-blue-300 transition duration-150" title="Dossier Médical">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M9 17v-2a2 2 0 012-2h2a2 2 0 012 2v2m-6 4h6a2 2 0 002-2V7a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
                        </svg>
                        Dossier Médical
                    </a>
                </div>
                <div class="flex flex-col gap-2 w-full">
                    <a href="{{ route('patients.consultations.index', $patient->id) }}" class="inline-flex items-center gap-2 px-4 py-2 rounded-lg bg-purple-500 text-white font-semibold shadow hover:bg-purple-600 focus:outline-none focus:ring-2 focus:ring-purple-300 transition duration-150 w-full text-center justify-center" title="Consultations">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M8 7V3m8 4V3m-9 8h10m-7 4h4m-9 5h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                        </svg>
                        Consultations
                    </a>
                    <a href="{{ route('patients.hospitalisations.index', $patient->id) }}" class="inline-flex items-center gap-2 px-4 py-2 rounded-lg bg-red-500 text-white font-semibold shadow hover:bg-red-600 focus:outline-none focus:ring-2 focus:ring-red-300 transition duration-150 w-full text-center justify-center" title="Hospitalisations">
                        <!-- Icône lit d'hôpital -->
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M3 10v8m0-8h18v8M7 18v-4a2 2 0 012-2h6a2 2 0 012 2v4" />
                            <circle cx="7" cy="14" r="1.5" fill="currentColor" />
                        </svg>
                        Hospitalisations
                    </a>
                </div>
                <a href="{{ route('patients.index') }}" class="mt-4 inline-flex items-center gap-2 px-4 py-2 rounded-lg bg-gray-100 text-gray-600 font-semibold shadow hover:bg-gray-200 focus:outline-none focus:ring-2 focus:ring-gray-300 transition duration-150" title="Retour à la liste">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M15 19l-7-7 7-7" />
                    </svg>
                    Retour à la liste
                </a>
            </div>
        </div>
    </div>
@endsection
