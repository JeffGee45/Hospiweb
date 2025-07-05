@extends('layouts.app')

@section('content')
    <div class="container mx-auto px-4 py-8">
        <div class="max-w-4xl mx-auto bg-white rounded-lg shadow-md p-8">
            <div class="flex justify-between items-center mb-6">
                <h1 class="text-2xl font-bold text-gray-800">Détails de la Consultation</h1>
                <a href="{{ route('patients.consultations.index', $consultation->patient_id) }}"
                    class="text-blue-500 hover:text-blue-700 font-semibold">
                    &larr; Retour aux consultations du patient
                </a>
            </div>

            @if (session('success'))
                <div class="bg-green-100 border-l-4 border-green-500 text-green-700 p-4 mb-6" role="alert">
                    <p class="font-bold">Succès</p>
                    <p>{{ session('success') }}</p>
                </div>
            @endif

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                <div>
                    <h3 class="text-lg font-semibold text-gray-700">Patient</h3>
                    <p class="text-gray-600">{{ $consultation->patient->prenom }} {{ $consultation->patient->nom }}</p>
                </div>
                <div>
                    <h3 class="text-lg font-semibold text-gray-700">Médecin</h3>
                    <p class="text-gray-600">Dr. {{ $consultation->medecin->name }}
                        ({{ $consultation->medecin->specialite }})</p>
                </div>
                <div>
                    <h3 class="text-lg font-semibold text-gray-700">Date de la consultation</h3>
                    <p class="text-gray-600">{{ \Carbon\Carbon::parse($consultation->date_consultation)->format('d/m/Y') }}
                    </p>
                </div>
            </div>

            <div class="mb-6">
                <h3 class="text-lg font-semibold text-gray-700">Diagnostic</h3>
                <p class="text-gray-600 bg-gray-50 p-4 rounded-md">{{ $consultation->diagnostic ?? 'Non spécifié' }}</p>
            </div>

            <div class="mb-6">
                <h3 class="text-lg font-semibold text-gray-700">Notes</h3>
                <p class="text-gray-600 bg-gray-50 p-4 rounded-md">{{ $consultation->notes ?? 'Aucune note' }}</p>
            </div>

            <hr class="my-8">

            <!-- Section Prescription -->
            <div>
                <h2 class="text-xl font-bold text-gray-800 mb-4">Prescription Médicale</h2>
                @if ($consultation->prescription)
                    @php
                        $prescription = $consultation->prescription;
                    @endphp
                    <div class="bg-blue-50 border border-blue-200 rounded-lg p-6">
                        <div class="flex justify-between items-start mb-4">
                            <div>
                                <p class="mb-1"><strong>Date de prescription :</strong>
                                    {{ \Carbon\Carbon::parse($prescription->date_prescription)->format('d/m/Y') }}</p>
                                <p class="mb-1"><strong>Date d'expiration :</strong>
                                    {{ \Carbon\Carbon::parse($prescription->date_expiration)->format('d/m/Y') }}</p>
                                <p class="mb-1">
                                    <strong>Statut :</strong>
                                    <span class="px-2 py-1 text-xs font-semibold rounded-full 
                                        {{ $prescription->statut === 'en_attente' ? 'bg-yellow-100 text-yellow-800' : 
                                           ($prescription->statut === 'prete' ? 'bg-green-100 text-green-800' : 'bg-blue-100 text-blue-800') }}">
                                        {{ ucfirst(str_replace('_', ' ', $prescription->statut)) }}
                                    </span>
                                </p>
                            </div>
                            <div class="flex space-x-2">
                                <a href="{{ route('consultations.prescriptions.show', ['consultation' => $consultation, 'prescription' => $prescription]) }}" 
                                   class="bg-blue-600 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline">
                                    Voir la prescription
                                </a>
                                <a href="{{ route('consultations.prescriptions.print', ['consultation' => $consultation, 'prescription' => $prescription]) }}" 
                                   target="_blank"
                                   class="bg-white hover:bg-gray-100 text-gray-800 font-semibold py-2 px-4 border border-gray-400 rounded shadow">
                                    <i class="fas fa-print mr-1"></i> Imprimer
                                </a>
                            </div>
                        </div>
                        
                        <h4 class="text-lg font-semibold mb-2">Médicaments prescrits :</h4>
                        <div class="overflow-x-auto">
                            <table class="min-w-full bg-white rounded-lg overflow-hidden">
                                <thead class="bg-gray-100">
                                    <tr>
                                        <th class="py-2 px-4 text-left text-gray-700">Médicament</th>
                                        <th class="py-2 px-4 text-left text-gray-700">Posologie</th>
                                        <th class="py-2 px-4 text-left text-gray-700">Durée</th>
                                        <th class="py-2 px-4 text-left text-gray-700">Quantité</th>
                                    </tr>
                                </thead>
                                <tbody class="divide-y divide-gray-200">
                                    @foreach($prescription->medicaments as $medicament)
                                    <tr class="hover:bg-gray-50">
                                        <td class="py-2 px-4">
                                            <div class="font-medium text-gray-900">{{ $medicament->nom_medicament }}</div>
                                            <div class="text-sm text-gray-500">{{ $medicament->dosage }}</div>
                                        </td>
                                        <td class="py-2 px-4">
                                            <div>{{ $medicament->frequence }}</div>
                                            @if($medicament->instructions)
                                            <div class="text-sm text-gray-500 italic">{{ $medicament->instructions }}</div>
                                            @endif
                                        </td>
                                        <td class="py-2 px-4">{{ $medicament->duree }}</td>
                                        <td class="py-2 px-4">{{ $medicament->quantite }}</td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                        
                        @if($prescription->remarques)
                        <div class="mt-4 p-3 bg-yellow-50 border-l-4 border-yellow-400">
                            <h5 class="font-semibold text-yellow-800">Instructions supplémentaires :</h5>
                            <p class="text-yellow-700">{{ $prescription->remarques }}</p>
                        </div>
                        @endif
                    </div>
                @else
                    <div class="text-center py-6 px-4 border-2 border-dashed border-gray-300 rounded-lg">
                        <p class="text-gray-500 mb-4">Aucune prescription n'a été ajoutée pour cette consultation.</p>
                        <a href="{{ route('consultations.prescriptions.create', $consultation) }}"
                            class="bg-blue-600 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline">
                            Ajouter une Prescription
                        </a>
                    </div>
                @endif
            </div>

        </div>
    </div>
@endsection
