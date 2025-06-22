@extends('layouts.app')

@section('content')
<div class="container mx-auto px-4 py-8">
    <div class="flex justify-between items-center mb-6">
        <h1 class="text-2xl font-bold text-gray-800">Hospitalisations de {{ $patient->nom }} {{ $patient->prenom }}</h1>
        <div>
            <a href="{{ route('patients.hospitalisations.create', $patient) }}" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                Nouvelle Hospitalisation
            </a>
            <a href="{{ route('patients.show', $patient) }}" class="bg-gray-500 hover:bg-gray-700 text-white font-bold py-2 px-4 rounded">
                Retour au Patient
            </a>
        </div>
    </div>

    <div class="bg-white shadow-md rounded-lg p-6">
        @if($hospitalisations->isEmpty())
            <p class="text-gray-600">Aucune hospitalisation enregistrée pour ce patient.</p>
        @else
            <div class="overflow-x-auto">
                <table class="min-w-full bg-white">
                    <thead class="bg-gray-200 text-gray-600 uppercase text-sm leading-normal">
                        <tr>
                            <th class="py-3 px-6 text-left">Date d'entrée</th>
                            <th class="py-3 px-6 text-left">Date de sortie</th>
                            <th class="py-3 px-6 text-left">Chambre</th>
                            <th class="py-3 px-6 text-center">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="text-gray-600 text-sm font-light">
                        @foreach ($hospitalisations as $hospitalisation)
                            <tr class="border-b border-gray-200 hover:bg-gray-100">
                                <td class="py-3 px-6 text-left whitespace-nowrap">{{ \Carbon\Carbon::parse($hospitalisation->date_entree)->format('d/m/Y') }}</td>
                                <td class="py-3 px-6 text-left whitespace-nowrap">{{ $hospitalisation->date_sortie ? \Carbon\Carbon::parse($hospitalisation->date_sortie)->format('d/m/Y') : 'En cours' }}</td>
                                <td class="py-3 px-6 text-left">{{ $hospitalisation->chambre ?? 'N/A' }}</td>
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
                {{ $hospitalisations->links() }}
            </div>
        @endif
    </div>
</div>
@endsection
