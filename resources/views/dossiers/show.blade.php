@extends('layouts.app')

@section('content')
    <div class="container mx-auto px-4 py-8">
        <div class="bg-white shadow-md rounded-lg p-6">
            <h1 class="text-2xl font-bold text-gray-800 mb-4">Dossier Médical de : {{ $patient->nom }} {{ $patient->prenom }}
            </h1>

            @if (session('success'))
                <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative mb-4"
                    role="alert">
                    <span class="block sm:inline">{{ session('success') }}</span>
                </div>
            @endif

            <form action="{{ route('dossiers.store', $patient) }}" method="POST">
                @csrf
                <div class="mb-6">
                    <label for="observation_globale" class="block text-gray-700 text-sm font-bold mb-2">Observation Globale
                        :</label>
                    <textarea id="observation_globale" name="observation_globale" rows="10"
                        class="shadow-sm appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline @error('observation_globale') border-red-500 @enderror">{{ old('observation_globale', $dossier->observation_globale) }}</textarea>
                    @error('observation_globale')
                        <p class="text-red-500 text-xs italic mt-2">{{ $message }}</p>
                    @enderror
                </div>

                <div class="flex items-center justify-between">
                    <button type="submit"
                        class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline">
                        Enregistrer les modifications
                    </button>
                    <a href="{{ route('patients.show', $patient) }}"
                        class="inline-block align-baseline font-bold text-sm text-blue-500 hover:text-blue-800">
                        Retour au patient
                    </a>
                </div>
            </form>
        </div>
    </div>
@endsection
