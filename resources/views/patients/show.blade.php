@extends('layouts.app')

@section('content')
<div class="layout-content-container flex flex-col max-w-[960px] flex-1">
    <div class="flex justify-between items-center p-4">
        <h2 class="text-2xl font-bold">Détails du Patient</h2>
        <a href="{{ route('patients.index') }}" class="bg-gray-500 text-white px-4 py-2 rounded hover:bg-gray-600">Retour à la liste</a>
    </div>

    <div class="bg-white shadow-md rounded px-8 pt-6 pb-8 mb-4">
        <div class="mb-4">
            <strong class="block text-gray-700 text-sm font-bold mb-2">Nom:</strong>
            <p class="text-gray-700">{{ $patient->nom }}</p>
        </div>
        <div class="mb-4">
            <strong class="block text-gray-700 text-sm font-bold mb-2">Prénom:</strong>
            <p class="text-gray-700">{{ $patient->prenom }}</p>
        </div>
        <div class="mb-4">
            <strong class="block text-gray-700 text-sm font-bold mb-2">Date de Naissance:</strong>
            <p class="text-gray-700">{{ $patient->date_of_birth ? \Carbon\Carbon::parse($patient->date_of_birth)->format('d/m/Y') : 'N/A' }}</p>
        </div>
        <div class="mb-4">
            <strong class="block text-gray-700 text-sm font-bold mb-2">Adresse:</strong>
            <p class="text-gray-700">{{ $patient->adresse }}</p>
        </div>
        <div class="mb-4">
            <strong class="block text-gray-700 text-sm font-bold mb-2">Genre:</strong>
            <p class="text-gray-700">{{ $patient->gender ?? 'N/A' }}</p>
        </div>
        <div class="mb-4">
            <strong class="block text-gray-700 text-sm font-bold mb-2">Groupe Sanguin:</strong>
            <p class="text-gray-700">{{ $patient->blood_group ?? 'N/A' }}</p>
        </div>
        <div class="mb-6">
            <strong class="block text-gray-700 text-sm font-bold mb-2">Antécédents:</strong>
            <p class="text-gray-700">{{ $patient->antecedents ?? 'N/A' }}</p>
        </div>
        <div class="flex items-center justify-start">
             <a href="{{ route('patients.edit', $patient->id) }}" class="bg-green-500 text-white px-4 py-2 rounded hover:bg-green-600 mr-2">Modifier</a>
             <a href="{{ route('dossiers.show', $patient->id) }}" class="bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-600">Voir le dossier médical</a>
        </div>
    </div>
</div>
@endsection
