@extends('layouts.app')

@section('content')
    <div class="container mx-auto px-4 py-8">
        <h1 class="text-2xl font-bold text-gray-800 mb-6">Nouvelle Consultation pour {{ $patient->nom }}
            {{ $patient->prenom }}</h1>

        <div class="bg-white shadow-md rounded-lg p-6">
            <form action="{{ route('patients.consultations.store', $patient) }}" method="POST">
                @csrf

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <!-- Date de Consultation -->
                    <div>
                        <label for="date_consultation" class="block text-gray-700 text-sm font-bold mb-2">Date de la
                            consultation :</label>
                        <input type="datetime-local" id="date_consultation" name="date_consultation"
                            class="shadow-sm appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"
                            value="{{ old('date_consultation') }}" required>
                    </div>

                    <!-- Médecin -->
                    <div>
                        <label for="medecin_id" class="block text-gray-700 text-sm font-bold mb-2">Médecin :</label>
                        <select id="medecin_id" name="medecin_id"
                            class="shadow-sm border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"
                            required>
                            <option value="">Sélectionner un médecin</option>
                            @foreach ($medecins as $medecin)
                                <option value="{{ $medecin->id }}">{{ $medecin->prenom }} {{ $medecin->nom }} -
                                    {{ $medecin->specialite }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>

                <!-- Diagnostic -->
                <div class="mt-6">
                    <label for="diagnostic" class="block text-gray-700 text-sm font-bold mb-2">Diagnostic :</label>
                    <input type="text" id="diagnostic" name="diagnostic"
                        class="shadow-sm appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"
                        value="{{ old('diagnostic') }}">
                </div>

                <!-- Notes -->
                <div class="mt-6">
                    <label for="notes" class="block text-gray-700 text-sm font-bold mb-2">Notes :</label>
                    <textarea id="notes" name="notes" rows="5"
                        class="shadow-sm appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">{{ old('notes') }}</textarea>
                </div>

                <div class="mt-8 flex justify-end">
                    <a href="{{ route('patients.consultations.index', $patient) }}"
                        class="bg-gray-500 hover:bg-gray-700 text-white font-bold py-2 px-4 rounded mr-2">
                        Annuler
                    </a>
                    <button type="submit" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                        Enregistrer la Consultation
                    </button>
                </div>
            </form>
        </div>
    </div>
@endsection
