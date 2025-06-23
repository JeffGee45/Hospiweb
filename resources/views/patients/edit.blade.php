@extends('layouts.app')

@section('content')
    <div class="flex justify-center items-center min-h-[85vh] bg-gray-50 py-8">
        <div class="w-full max-w-xl bg-white rounded-2xl shadow-lg p-8">
            <h1 class="text-3xl font-bold text-center text-blue-700 mb-8">Modifier un patient</h1>
            <a href="{{ route('patients.index') }}" class="inline-flex items-center gap-2 px-6 py-3 rounded-lg bg-gray-100 text-gray-600 text-base font-semibold shadow hover:bg-gray-200 focus:outline-none focus:ring-2 focus:ring-gray-300 transition duration-150 mb-4">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M15 19l-7-7 7-7" />
                </svg>
                Retour à la liste
            </a>

            @if ($errors->any())
                <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative m-4" role="alert">
                    <strong class="font-bold">Oups!</strong>
                    <span class="block sm:inline">Il y avait quelques problèmes avec votre saisie.</span>
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form action="{{ route('patients.update', $patient->id) }}" method="POST" class="bg-white shadow-md rounded px-8 pt-6 pb-8 mb-4">
                @csrf
                @method('PUT')

                <div class="mb-4">
                    <label class="block text-gray-700 text-sm font-bold mb-2" for="nom">
                        Nom
                    </label>
                    <input
                        class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"
                        id="nom" name="nom" type="text" value="{{ old('nom', $patient->nom) }}" required>
                </div>

                <div class="mb-4">
                    <label class="block text-gray-700 text-sm font-bold mb-2" for="prenom">
                        Prénom
                    </label>
                    <input
                        class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"
                        id="prenom" name="prenom" type="text" value="{{ old('prenom', $patient->prenom) }}" required>
                </div>

                <div class="mb-4">
                    <label class="block text-gray-700 text-sm font-bold mb-2" for="date_of_birth">
                        Date de Naissance
                    </label>
                    <input
                        class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"
                        id="date_of_birth" name="date_of_birth" type="date"
                        value="{{ old('date_of_birth', $patient->date_of_birth) }}" required>
                </div>

                <div class="mb-4">
                    <label class="block text-gray-700 text-sm font-bold mb-2" for="adresse">
                        Adresse
                    </label>
                    <input
                        class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"
                        id="adresse" name="adresse" type="text" value="{{ old('adresse', $patient->adresse) }}" required>
                </div>

                <div class="mb-4">
                    <label class="block text-gray-700 text-sm font-bold mb-2" for="gender">
                        Genre
                    </label>
                    <select
                        class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"
                        id="gender" name="gender">
                        <option value="" {{ old('gender', $patient->gender) == '' ? 'selected' : '' }}>Sélectionner...
                        </option>
                        <option value="Masculin" {{ old('gender', $patient->gender) == 'Masculin' ? 'selected' : '' }}>Masculin
                        </option>
                        <option value="Féminin" {{ old('gender', $patient->gender) == 'Féminin' ? 'selected' : '' }}>Féminin
                        </option>
                    </select>
                </div>

                <div class="mb-4">
                    <label for="blood_group" class="block font-semibold text-gray-700 mb-1">Groupe Sanguin</label>
                    <select name="blood_group" id="blood_group" class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-300 focus:border-blue-500 transition">
                        <option value="">Sélectionner...</option>
                        <option value="A+" {{ old('blood_group', $patient->blood_group) == 'A+' ? 'selected' : '' }}>A+</option>
                        <option value="A-" {{ old('blood_group', $patient->blood_group) == 'A-' ? 'selected' : '' }}>A-</option>
                        <option value="B+" {{ old('blood_group', $patient->blood_group) == 'B+' ? 'selected' : '' }}>B+</option>
                        <option value="B-" {{ old('blood_group', $patient->blood_group) == 'B-' ? 'selected' : '' }}>B-</option>
                        <option value="AB+" {{ old('blood_group', $patient->blood_group) == 'AB+' ? 'selected' : '' }}>AB+</option>
                        <option value="AB-" {{ old('blood_group', $patient->blood_group) == 'AB-' ? 'selected' : '' }}>AB-</option>
                        <option value="O+" {{ old('blood_group', $patient->blood_group) == 'O+' ? 'selected' : '' }}>O+</option>
                        <option value="O-" {{ old('blood_group', $patient->blood_group) == 'O-' ? 'selected' : '' }}>O-</option>
                    </select>
                </div>

                <div class="mb-6">
                    <label class="block text-gray-700 text-sm font-bold mb-2" for="antecedents">
                        Antécédents
                    </label>
                    <textarea
                        class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"
                        id="antecedents" name="antecedents" rows="4">{{ old('antecedents', $patient->antecedents) }}</textarea>
                </div>

                <div class="mb-4">
                    <label class="block text-gray-700 text-sm font-bold mb-2" for="status">
                        Statut du patient
                    </label>
                    <select
                        class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"
                        id="status" name="status">
                        <option value="Actif" {{ old('status', $patient->status) == 'Actif' ? 'selected' : '' }}>Actif
                        </option>
                        <option value="Inactif" {{ old('status', $patient->status) == 'Inactif' ? 'selected' : '' }}>Inactif
                        </option>
                        <option value="Décédé" {{ old('status', $patient->status) == 'Décédé' ? 'selected' : '' }}>Décédé
                        </option>
                    </select>
                </div>
                <div class="flex items-center justify-between">
                    <button
                        class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline"
                        type="submit">
                        Mettre à jour
                    </button>
                </div>
            </form>
        </div>
    </div>
@endsection
