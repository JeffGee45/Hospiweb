@extends('layouts.app')

@section('content')
    <div class="flex justify-center items-center min-h-[85vh] bg-gray-50 py-8">
        <div class="w-full max-w-xl bg-white rounded-2xl shadow-lg p-8">
            <h1 class="text-3xl font-bold text-center text-blue-700 mb-8">Modifier un patient</h1>
            @if ($errors->any())
                <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded-lg mb-6" role="alert">
                    <ul class="list-disc pl-5">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            @php
    $updateRoute = auth()->user()->role === 'Admin' ? route('admin.patients.update', $patient->id) : (auth()->user()->role === 'Secretaire' ? route('secretary.patients.update', $patient->id) : null);
@endphp

@if($updateRoute)
    <form action="{{ $updateRoute }}" method="POST" class="space-y-5">
        @csrf
                @method('PUT')

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label for="nom" class="block font-semibold text-gray-700 mb-1">Nom</label>
                        <input type="text" name="nom" id="nom" class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-300 focus:border-blue-500 transition" value="{{ old('nom', $patient->nom) }}" required>
                    </div>
                    <div>
                        <label for="prenom" class="block font-semibold text-gray-700 mb-1">Prénom</label>
                        <input type="text" name="prenom" id="prenom" class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-300 focus:border-blue-500 transition" value="{{ old('prenom', $patient->prenom) }}" required>
                    </div>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label for="date_naissance" class="block font-semibold text-gray-700 mb-1">Date de naissance</label>
                        <input type="date" name="date_naissance" id="date_naissance" class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-300 focus:border-blue-500 transition" value="{{ old('date_naissance', $patient->date_naissance ? $patient->date_naissance->format('Y-m-d') : '') }}" required>
                    </div>
                    <div>
                        <label for="sexe" class="block font-semibold text-gray-700 mb-1">Sexe</label>
                        <select name="sexe" id="sexe" class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-300 focus:border-blue-500 transition" required>
                            <option value="" disabled>Sélectionner...</option>
                            <option value="Homme" {{ old('sexe', $patient->sexe) == 'Homme' ? 'selected' : '' }}>Homme</option>
                            <option value="Femme" {{ old('sexe', $patient->sexe) == 'Femme' ? 'selected' : '' }}>Femme</option>
                            <option value="Autre" {{ old('sexe', $patient->sexe) == 'Autre' ? 'selected' : '' }}>Autre</option>
                        </select>
                    </div>
                </div>

                <div>
                    <label for="adresse" class="block font-semibold text-gray-700 mb-1">Adresse</label>
                    <input type="text" name="adresse" id="adresse" class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-300 focus:border-blue-500 transition" value="{{ old('adresse', $patient->adresse) }}" required>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label for="telephone" class="block font-semibold text-gray-700 mb-1">Téléphone</label>
                        <input type="tel" name="telephone" id="telephone" class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-300 focus:border-blue-500 transition" value="{{ old('telephone', $patient->telephone) }}" required>
                    </div>
                    <div>
                        <label for="email" class="block font-semibold text-gray-700 mb-1">Email</label>
                        <input type="email" name="email" id="email" class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-300 focus:border-blue-500 transition" value="{{ old('email', $patient->email) }}">
                    </div>
                </div>

                <div>
                    <label for="groupe_sanguin" class="block font-semibold text-gray-700 mb-1">Groupe Sanguin</label>
                    <select name="groupe_sanguin" id="groupe_sanguin" class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-300 focus:border-blue-500 transition">
                        <option value="">Non spécifié</option>
                        <option value="A+" {{ old('groupe_sanguin', $patient->groupe_sanguin) == 'A+' ? 'selected' : '' }}>A+</option>
                        <option value="A-" {{ old('groupe_sanguin', $patient->groupe_sanguin) == 'A-' ? 'selected' : '' }}>A-</option>
                        <option value="B+" {{ old('groupe_sanguin', $patient->groupe_sanguin) == 'B+' ? 'selected' : '' }}>B+</option>
                        <option value="B-" {{ old('groupe_sanguin', $patient->groupe_sanguin) == 'B-' ? 'selected' : '' }}>B-</option>
                        <option value="AB+" {{ old('groupe_sanguin', $patient->groupe_sanguin) == 'AB+' ? 'selected' : '' }}>AB+</option>
                        <option value="AB-" {{ old('groupe_sanguin', $patient->groupe_sanguin) == 'AB-' ? 'selected' : '' }}>AB-</option>
                        <option value="O+" {{ old('groupe_sanguin', $patient->groupe_sanguin) == 'O+' ? 'selected' : '' }}>O+</option>
                        <option value="O-" {{ old('groupe_sanguin', $patient->groupe_sanguin) == 'O-' ? 'selected' : '' }}>O-</option>
                    </select>
                </div>

                <div>
                    <label for="antecedents_medicaux" class="block font-semibold text-gray-700 mb-1">Antécédents médicaux</label>
                    <textarea name="antecedents_medicaux" id="antecedents_medicaux" rows="3" class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-300 focus:border-blue-500 transition">{{ old('antecedents_medicaux', $patient->antecedents_medicaux) }}</textarea>
                </div>

                <div>
                    <label for="allergies" class="block font-semibold text-gray-700 mb-1">Allergies</label>
                    <textarea name="allergies" id="allergies" rows="3" class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-300 focus:border-blue-500 transition">{{ old('allergies', $patient->allergies) }}</textarea>
                </div>

                <h2 class="text-xl font-bold text-blue-700 mt-6 pt-4 border-t">Contact d'urgence</h2>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label for="nom_contact_urgence" class="block font-semibold text-gray-700 mb-1">Nom du contact</label>
                        <input type="text" name="nom_contact_urgence" id="nom_contact_urgence" class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-300 focus:border-blue-500 transition" value="{{ old('nom_contact_urgence', $patient->nom_contact_urgence) }}">
                    </div>
                    <div>
                        <label for="telephone_contact_urgence" class="block font-semibold text-gray-700 mb-1">Téléphone du contact</label>
                        <input type="tel" name="telephone_contact_urgence" id="telephone_contact_urgence" class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-300 focus:border-blue-500 transition" value="{{ old('telephone_contact_urgence', $patient->telephone_contact_urgence) }}">
                    </div>
                </div>

                <div class="flex gap-4 mt-8">
                    <button type="submit" class="inline-flex items-center justify-center gap-2 px-6 py-3 rounded-lg bg-blue-600 text-white text-base font-semibold shadow hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-300 transition duration-150 w-full md:w-auto">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7" />
                        </svg>
                        Mettre à jour
                    </button>
                    @php
                        $indexRoute = auth()->user()->role === 'Admin' ? route('admin.patients.index') : (auth()->user()->role === 'Secretaire' ? route('secretary.patients.index') : route('dashboard'));
                    @endphp
                    <a href="{{ $indexRoute }}" class="inline-flex items-center justify-center gap-2 px-6 py-3 rounded-lg bg-gray-100 text-gray-600 text-base font-semibold shadow hover:bg-gray-200 focus:outline-none focus:ring-2 focus:ring-gray-300 transition duration-150 w-full md:w-auto">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M15 19l-7-7 7-7" />
                        </svg>
                        Annuler
                    </a>
                </div>
            </form>
        @else
            <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative" role="alert">
                <strong class="font-bold">Accès non autorisé.</strong>
                <span class="block sm:inline">Vous n'avez pas les permissions nécessaires pour modifier ce patient.</span>
            </div>
        @endif
        </div>
    </div>
@endsection
