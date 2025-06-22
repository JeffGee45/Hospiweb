@extends('layouts.app')

@section('content')
<div class="container mx-auto">
    <h1 class="text-2xl font-bold mb-4">Ajouter un nouveau patient</h1>

    @if ($errors->any())
        <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative mb-4" role="alert">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('patients.store') }}" method="POST">
        @csrf
        <div class="mb-4">
            <label for="nom" class="block text-gray-700">Nom</label>
            <input type="text" name="nom" id="nom" class="w-full border-gray-300 rounded" value="{{ old('nom') }}" required>
        </div>

        <div class="mb-4">
            <label for="prenom" class="block text-gray-700">Prénom</label>
            <input type="text" name="prenom" id="prenom" class="w-full border-gray-300 rounded" value="{{ old('prenom') }}" required>
        </div>

        <div class="mb-4">
            <label for="date_of_birth" class="block text-gray-700">Date de naissance</label>
            <input type="date" name="date_of_birth" id="date_of_birth" class="w-full border-gray-300 rounded" value="{{ old('date_of_birth') }}">
        </div>

        <div class="mb-4">
            <label for="adresse" class="block text-gray-700">Adresse</label>
            <input type="text" name="adresse" id="adresse" class="w-full border-gray-300 rounded" value="{{ old('adresse') }}">
        </div>

        <div class="mb-4">
            <label for="gender" class="block text-gray-700">Genre</label>
            <select name="gender" id="gender" class="w-full border-gray-300 rounded">
                <option value="">Sélectionner...</option>
                <option value="Male" {{ old('gender') == 'Male' ? 'selected' : '' }}>Homme</option>
                <option value="Female" {{ old('gender') == 'Female' ? 'selected' : '' }}>Femme</option>
            </select>
        </div>

        <div class="mb-4">
            <label for="blood_group" class="block text-gray-700">Groupe Sanguin</label>
            <input type="text" name="blood_group" id="blood_group" class="w-full border-gray-300 rounded" value="{{ old('blood_group') }}">
        </div>

        <div class="mb-4">
            <label for="antecedents" class="block text-gray-700">Antécédents</label>
            <textarea name="antecedents" id="antecedents" rows="4" class="w-full border-gray-300 rounded">{{ old('antecedents') }}</textarea>
        </div>

        <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded">Enregistrer</button>
        <a href="{{ route('patients.index') }}" class="text-gray-500 ml-4">Annuler</a>
    </form>
</div>
@endsection
