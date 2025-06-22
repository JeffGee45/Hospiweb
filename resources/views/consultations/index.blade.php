@extends('layouts.app')

@section('content')
<div class="container mx-auto px-4 py-8">
    <div class="flex justify-between items-center mb-6">
        <h1 class="text-2xl font-bold text-gray-800">Consultations de {{ $patient->nom }} {{ $patient->prenom }}</h1>
        <div>
            <a href="{{ route('patients.consultations.create', $patient) }}" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                Nouvelle Consultation
            </a>
            <a href="{{ route('patients.show', $patient) }}" class="bg-gray-500 hover:bg-gray-700 text-white font-bold py-2 px-4 rounded">
                Retour au Patient
            </a>
        </div>
    </div>

    <div class="bg-white shadow-md rounded-lg p-6">
        @if($consultations->isEmpty())
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
                                <td class="py-3 px-6 text-left whitespace-nowrap">{{ $consultation->date_consultation->format('d/m/Y H:i') }}</td>
                                <td class="py-3 px-6 text-left">Dr. {{ $consultation->medecin->prenom }} {{ $consultation->medecin->nom }}</td>
                                <td class="py-3 px-6 text-left">{{ $consultation->diagnostic ?? 'N/A' }}</td>
                                <td class="py-3 px-6 text-center">
                                    <div class="flex item-center justify-center">
                                        <a href="#" class="w-4 mr-2 transform hover:text-purple-500 hover:scale-110">...</a>
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
