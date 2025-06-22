@extends('layouts.app')

@section('content')
    <div class="layout-content-container flex flex-col max-w-[960px] flex-1">
        <div class="flex flex-wrap justify-between gap-3 p-4">
            <p class="text-[#111518] tracking-light text-[32px] font-bold leading-tight min-w-72">Patients</p>
            <a href="{{ route('patients.create') }}"
                class="inline-flex items-center gap-2 px-6 py-3 rounded-lg bg-blue-600 text-white text-base font-semibold shadow hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-300 transition duration-150">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"
                    stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 4v16m8-8H4" />
                </svg>
                Ajouter un patient
            </a>
        </div>
        <div class="px-4 py-3">
            <label class="flex flex-col min-w-40 h-12 w-full">
                <div class="flex w-full flex-1 items-stretch rounded-lg h-full">

                    <form method="GET" action="{{ route('patients.index') }}"
                        class="flex items-center justify-center w-full max-w-xl mx-auto mt-6 mb-8">
                        <div class="relative flex w-full">
                            <span class="absolute inset-y-0 left-0 flex items-center pl-3">
                                <!-- Heroicons MagnifyingGlass -->
                                <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 text-blue-500" fill="none"
                                    viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                    <path stroke-linecap="round" stroke-linejoin="round"
                                        d="M21 21l-4.35-4.35M16.65 16.65A7.5 7.5 0 1116.65 2a7.5 7.5 0 010 14.65z" />
                                </svg>
                            </span>
                            <input type="text" name="q" placeholder="Rechercher un patient"
                                value="{{ request('q') }}" autocomplete="off"
                                class="block w-full pl-10 pr-24 py-3 text-lg rounded-l-lg border border-blue-400 shadow focus:ring-2 focus:ring-blue-300 focus:border-blue-500 bg-white placeholder-gray-400" />
                            <button type="submit"
                                class="inline-flex items-center px-6 py-3 bg-blue-600 text-white text-lg font-semibold rounded-r-lg hover:bg-blue-700 transition duration-150 shadow">
                                Rechercher
                            </button>
                        </div>
                    </form>
                </div>
            </label>
        </div>
        <div class="flex justify-between items-center px-4 py-3">
            <h2 class="text-xl font-semibold text-[#111518]">Liste des patients</h2>
            {{-- <a href="{{ route('patients.create') }}" class="bg-blue-500 text-white px-4 py-2 rounded-lg hover:bg-blue-600">Ajouter un patient</a> --}}
        </div>

        @if ($message = Session::get('success'))
            <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative m-4" role="alert">
                <span class="block sm:inline">{{ $message }}</span>
            </div>
        @endif

        <div class="px-4 py-3 @container">
            <div class="flex overflow-hidden rounded-lg border border-[#dce1e5] bg-white">
                <table class="flex-1">
                    <thead>
                        <tr class="bg-white">
                            <th class="px-4 py-3 text-left text-sm font-medium leading-normal text-[#111518]">Nom</th>
                            <th class="px-4 py-3 text-left text-sm font-medium leading-normal text-[#111518]">Date de
                                naissance</th>
                            <th class="px-4 py-3 text-left text-sm font-medium leading-normal text-[#111518]">Genre</th>
                            <th class="px-4 py-3 text-left text-sm font-medium leading-normal text-[#111518]">Dernière
                                consultation</th>
                            <th class="px-4 py-3 text-left text-sm font-medium leading-normal text-[#111518]">Status</th>
                            <th class="px-4 py-3 text-left text-sm font-medium leading-normal text-[#111518]">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($patients as $patient)
                            <tr class="border-t border-t-[#dce1e5]">
                                <td class="h-[72px] px-4 py-2 text-sm font-normal leading-normal text-[#111518]">
                                    {{ $patient->prenom }} {{ $patient->nom }}
                                </td>
                                <td class="h-[72px] px-4 py-2 text-sm font-normal leading-normal text-[#637988]">
                                    {{ $patient->date_of_birth ? \Carbon\Carbon::parse($patient->date_of_birth)->format('d/m/Y') : 'N/D' }}
                                </td>
                                <td class="h-[72px] px-4 py-2 text-sm font-normal leading-normal text-[#637988]">
                                    {{ $patient->gender }}
                                </td>
                                <td class="h-[72px] px-4 py-2 text-sm font-normal leading-normal text-[#637988]">
                                    @if ($patient->latestConsultation)
                                        {{ \Carbon\Carbon::parse($patient->latestConsultation->date_consultation)->format('d/m/Y') }}
                                    @else
                                        <span class="text-gray-400">Aucune</span>
                                    @endif
                                </td>
                                <td class="h-[72px] px-4 py-2 text-sm font-normal leading-normal text-[#637988]">
                                    @php
                                        $statusClasses = match ($patient->status) {
                                            'Actif' => 'bg-green-100 text-green-800',
                                            'Décédé' => 'bg-gray-400 text-white',
                                            'Inactif' => 'bg-yellow-100 text-yellow-800',
                                            default => 'bg-blue-100 text-blue-800',
                                        };
                                    @endphp
                                    <span class="px-2 py-1 text-xs font-semibold rounded-full {{ $statusClasses }}">
                                        {{ $patient->status ?? 'Inactif' }}
                                    </span>
                                </td>
                                <td class="h-[72px] px-4 py-2 text-sm font-normal leading-normal">
                                    <div class="flex items-center gap-4">


                                        <a href="{{ route('patients.show', $patient->id) }}"
                                            class="inline-flex items-center justify-center p-2 bg-blue-50 text-blue-600 rounded-lg shadow-sm hover:bg-blue-100 hover:text-blue-800 focus:outline-none focus:ring-2 focus:ring-blue-300 transition duration-150"
                                            title="Voir le patient">
                                            <!-- Heroicons Eye -->
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none"
                                                viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                                <path stroke-linecap="round" stroke-linejoin="round"
                                                    d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                                <path stroke-linecap="round" stroke-linejoin="round"
                                                    d="M2.458 12C3.732 7.943 7.522 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.478 0-8.268-2.943-9.542-7z" />
                                            </svg>
                                        </a>
                                        <a href="{{ route('patients.edit', $patient->id) }}"
                                            class="inline-flex items-center justify-center p-2 bg-green-50 text-green-600 rounded-lg shadow-sm hover:bg-green-100 hover:text-green-800 focus:outline-none focus:ring-2 focus:ring-green-300 transition duration-150"
                                            title="Modifier le patient">
                                            <!-- Heroicons Pencil -->
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none"
                                                viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                                <path stroke-linecap="round" stroke-linejoin="round"
                                                    d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2a2 2 0 01-2-2 2 2 0 012-2 2 2 0 012 2v2h1.414a2 2 0 011.414 1.414l1.414-1.414a2 2 0 01.828-2.828V5z" />
                                            </svg>
                                        </a>
                                        <form action="{{ route('patients.destroy', $patient->id) }}" method="POST"
                                            onsubmit="return confirm('Êtes-vous sûr de vouloir supprimer ce patient ?');">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit"
                                                class="inline-flex items-center justify-center p-2 bg-red-50 text-red-600 rounded-lg shadow-sm hover:bg-red-100 hover:text-red-800 focus:outline-none focus:ring-2 focus:ring-red-300 transition duration-150"
                                                title="Supprimer le patient">
                                                <!-- Heroicons Trash -->
                                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none"
                                                    viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                                    <path stroke-linecap="round" stroke-linejoin="round"
                                                        d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                                </svg>
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            <style>
                @container(max-width:120px)

                    {
                    .table-d0cf809f-0ebf-4f15-9b1c-e4c56bb135c1-column-120 {
                        display: none;
                    }
                }

                @container(max-width:240px)

                    {
                    .table-d0cf809f-0ebf-4f15-9b1c-e4c56bb135c1-column-240 {
                        display: none;
                    }
                }

                @container(max-width:360px)

                    {
                    .table-d0cf809f-0ebf-4f15-9b1c-e4c56bb135c1-column-360 {
                        display: none;
                    }
                }

                @container(max-width:480px)

                    {
                    .table-d0cf809f-0ebf-4f15-9b1c-e4c56bb135c1-column-480 {
                        display: none;
                    }
                }

                @container(max-width:600px)

                    {
                    .table-d0cf809f-0ebf-4f15-9b1c-e4c56bb135c1-column-600 {
                        display: none;
                    }
                }
            </style>
        </div>
    </div>
@endsection
