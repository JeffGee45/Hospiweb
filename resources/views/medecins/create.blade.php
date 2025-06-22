@extends('layouts.app')

@section('content')
<div class="container mx-auto px-4 py-8">
    <div class="max-w-md mx-auto bg-white rounded-lg shadow-md p-8">
        <h1 class="text-2xl font-bold text-gray-800 mb-6">Ajouter un nouveau Médecin</h1>

        <form action="{{ route('medecins.store') }}" method="POST">
            @csrf
            <div class="mb-4">
                <label for="prenom" class="block text-gray-700 text-sm font-bold mb-2">Prénom</label>
                <input type="text" id="prenom" name="prenom" value="{{ old('prenom') }}" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline @error('prenom') border-red-500 @enderror" required>
                @error('prenom')
                    <p class="text-red-500 text-xs italic mt-2">{{ $message }}</p>
                @enderror
            </div>

            <div class="mb-4">
                <label for="nom" class="block text-gray-700 text-sm font-bold mb-2">Nom</label>
                <input type="text" id="nom" name="nom" value="{{ old('nom') }}" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline @error('nom') border-red-500 @enderror" required>
                @error('nom')
                    <p class="text-red-500 text-xs italic mt-2">{{ $message }}</p>
                @enderror
            </div>

            <div class="mb-6">
    <label for="specialite" class="block text-gray-700 text-sm font-bold mb-2">Spécialité</label>
    <select id="specialite" name="specialite" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:ring-2 focus:ring-blue-300 @error('specialite') border-red-500 @enderror" required>
        <option value="">Sélectionner...</option>
        <option value="Médecin généraliste" {{ old('specialite') == 'Médecin généraliste' ? 'selected' : '' }}>Médecin généraliste</option>
        <option value="Pédiatre" {{ old('specialite') == 'Pédiatre' ? 'selected' : '' }}>Pédiatre (enfants)</option>
        <option value="Gynécologue" {{ old('specialite') == 'Gynécologue' ? 'selected' : '' }}>Gynécologue (femmes)</option>
        <option value="Cardiologue" {{ old('specialite') == 'Cardiologue' ? 'selected' : '' }}>Cardiologue (cœur)</option>
        <option value="Ophtalmologue" {{ old('specialite') == 'Ophtalmologue' ? 'selected' : '' }}>Ophtalmologue (yeux)</option>
        <option value="Dentiste" {{ old('specialite') == 'Dentiste' ? 'selected' : '' }}>Dentiste (dents)</option>
        <option value="Chirurgien" {{ old('specialite') == 'Chirurgien' ? 'selected' : '' }}>Chirurgien</option>
        <option value="Sage-femme" {{ old('specialite') == 'Sage-femme' ? 'selected' : '' }}>Sage-femme</option>
        <option value="Dermatologue" {{ old('specialite') == 'Dermatologue' ? 'selected' : '' }}>Dermatologue (peau)</option>
        <option value="Orthopédiste" {{ old('specialite') == 'Orthopédiste' ? 'selected' : '' }}>Orthopédiste (os)</option>
        <option value="ORL" {{ old('specialite') == 'ORL' ? 'selected' : '' }}>ORL (nez/gorge/oreilles)</option>
        <option value="Urologue" {{ old('specialite') == 'Urologue' ? 'selected' : '' }}>Urologue (urines)</option>
        <option value="Psychiatre" {{ old('specialite') == 'Psychiatre' ? 'selected' : '' }}>Psychiatre (esprit)</option>
        <option value="Autre" {{ old('specialite') == 'Autre' ? 'selected' : '' }}>Autre</option>
    </select>
    @error('specialite')
        <p class="text-red-500 text-xs italic mt-2">{{ $message }}</p>
    @enderror
</div>

            <div class="flex items-center justify-between">
                <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline">
                    Ajouter le Médecin
                </button>
                <a href="{{ route('medecins.index') }}" class="inline-block align-baseline font-bold text-sm text-blue-500 hover:text-blue-800">
                    Annuler
                </a>
            </div>
        </form>
    </div>
</div>
@endsection
