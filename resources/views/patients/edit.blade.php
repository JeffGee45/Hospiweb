@extends('layouts.app')

@section('content')
    <div class="layout-content-container flex flex-col max-w-[960px] flex-1">
        <div class="flex justify-between items-center p-4">
            <h2 class="text-2xl font-bold">Modifier le Patient</h2>
            <a href="{{ route('patients.index') }}" class="bg-gray-500 text-white px-4 py-2 rounded hover:bg-gray-600">Retour
                à la liste</a>
        </div>

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

        <form action="{{ route('patients.update', $patient->id) }}" method="POST"
            class="bg-white shadow-md rounded px-8 pt-6 pb-8 mb-4">
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
                <label class="block text-gray-700 text-sm font-bold mb-2" for="blood_group">
                    Groupe Sanguin
                </label>
                <input
                    class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"
                    id="blood_group" name="blood_group" type="text"
                    value="{{ old('blood_group', $patient->blood_group) }}">
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
@endsection
