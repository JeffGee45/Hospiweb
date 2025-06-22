@extends('layouts.app')

@section('content')
    <div class="container mx-auto px-4 py-8">
        <div class="flex justify-between items-center mb-6">
            <h1 class="text-2xl font-bold text-gray-800">Consultations de {{ $patient->nom }} {{ $patient->prenom }}</h1>
            <div>
                <a href="{{ route('patients.consultations.create', $patient) }}"
                    class="inline-flex items-center gap-2 px-6 py-3 rounded-lg bg-blue-600 text-white text-base font-semibold shadow hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-300 transition duration-150">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24"
                        stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round"
                            d="M9 3H5a2 2 0 00-2 2v2a2 2 0 110 4v-2a2 2 0 012-2h6a2 2 0 012 2v2a2 2 0 110 4v-2a2 2 0 012-2h6a2 2 0 012 2v2a2 2 0 110 4v-2a2 2 0 012-2h3a2 2 0 012-2V5a2 2 0 00-2-2h-2a2 2 0 00-2-2v2a2 2 0 110 4v-1h-1a2 2 0 01-2-2z" />
                    </svg>
                    Ajouter une consultation
                </a>
                <a href="{{ route('patients.show', $patient) }}"
                    class="bg-gray-500 hover:bg-gray-700 text-white font-bold py-2 px-4 rounded">
                    Retour au Patient
                </a>
            </div>
        </div>

        <div class="bg-white shadow-md rounded-lg p-6">
            @if ($consultations->isEmpty())
                <p class="text-gray-600">Aucune consultation enregistrée pour ce patient.</p>
            @else
                <div class="overflow-x-auto">
                    <table class="min-w-full bg-white">
                        <thead class="bg-gray-200 text-gray-600 uppercase text-sm leading-normal">
                            <tr>
                                <th class="py-3 px-6 text-left">Date</th>
                                <th class="py-3 px-6 text-left">Médecin</th>
                                <th class="py-3 px-6 text-left">Diagnostic</th>
                                <th class="py-3 px-6 text-center">Actions</th>
                            </tr>
                        </thead>
                        <tbody class="text-gray-600 text-sm font-light">
                            @foreach ($consultations as $consultation)
                                <tr class="border-b border-gray-200 hover:bg-gray-100">
                                    <td class="py-3 px-6 text-left whitespace-nowrap">
                                        {{ $consultation->date_consultation->format('d/m/Y H:i') }}</td>
                                    <td class="py-3 px-6 text-left">
                                        <a href="{{ route('consultations.show', $consultation->id) }}"
                                            class="text-blue-600 hover:underline">
                                            Dr. {{ $consultation->medecin->prenom }} {{ $consultation->medecin->nom }}
                                        </a>
                                    </td>
                                    <td class="py-3 px-6 text-left">{{ $consultation->diagnostic ?? 'N/A' }}</td>
                                    <td class="py-3 px-6 text-center">
                                        <div class="flex item-center justify-center">
                                            <a href="#"
                                                class="w-4 mr-2 transform hover:text-purple-500 hover:scale-110">...</a>
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                <div class="mt-4">
                    {{ $consultations->links() }}
                </div>
            @endif
        </div>
    </div>
@endsection
