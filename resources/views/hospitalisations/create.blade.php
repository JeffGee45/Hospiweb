@extends('layouts.app')

@section('content')
    <div class="container mx-auto px-4 py-8">
        <h1 class="text-2xl font-bold text-gray-800 mb-6">Nouvelle Hospitalisation pour {{ $patient->nom }}
            {{ $patient->prenom }}</h1>

        <div class="bg-white shadow-md rounded-lg p-6">
            <form action="{{ route('patients.hospitalisations.store', $patient) }}" method="POST">
                @csrf

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <!-- Date d'entrée -->
                    <div>
                        <label for="date_entree" class="block text-gray-700 text-sm font-bold mb-2">Date d'entrée :</label>
                        <input type="date" id="date_entree" name="date_entree"
                            class="shadow-sm appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"
                            value="{{ old('date_entree') }}" required>
                    </div>

                    <!-- Date de sortie -->
                    <div>
                        <label for="date_sortie" class="block text-gray-700 text-sm font-bold mb-2">Date de sortie :</label>
                        <input type="date" id="date_sortie" name="date_sortie"
                            class="shadow-sm appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"
                            value="{{ old('date_sortie') }}">
                    </div>
                </div>

                <!-- Chambre -->
                <div class="mt-6">
                    <label for="chambre" class="block text-gray-700 text-sm font-bold mb-2">Chambre :</label>
                    <input type="text" id="chambre" name="chambre"
                        class="shadow-sm appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"
                        value="{{ old('chambre') }}">
                </div>

                <!-- Traitement suivi -->
                <div class="mt-6">
                    <label for="traitement_suivi" class="block text-gray-700 text-sm font-bold mb-2">Traitement suivi
                        :</label>
                    <textarea id="traitement_suivi" name="traitement_suivi" rows="5"
                        class="shadow-sm appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">{{ old('traitement_suivi') }}</textarea>
                </div>

                <div class="mt-8 flex justify-end">
                    <a href="{{ route('patients.hospitalisations.index', $patient) }}"
                        class="bg-gray-500 hover:bg-gray-700 text-white font-bold py-2 px-4 rounded mr-2">
                        Annuler
                    </a>
                    <button type="submit" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                        Enregistrer l'Hospitalisation
                    </button>
                </div>
            </form>
        </div>
    </div>
@endsection
