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
                    <p class="text-gray-600">Dr. {{ $consultation->medecin->prenom }} {{ $consultation->medecin->nom }}
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
                        <p class="mb-4"><strong>Date de prescription :</strong>
                            {{ \Carbon\Carbon::parse($prescription->date_prescription)->format('d/m/Y') }}</p>
                        <h4 class="text-lg font-semibold mb-2">Médicaments prescrits :</h4>
                        <ul class="list-disc list-inside space-y-2">
                            @foreach ($prescription->medicaments as $medicament)
                                <li>
                                    <span class="font-semibold">{{ $medicament->nom_medicament }}</span> -
                                    <span>{{ $medicament->dosage }}</span>,
                                    <span>pendant {{ $medicament->duree }}</span>.
                                </li>
                            @endforeach
                        </ul>
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
