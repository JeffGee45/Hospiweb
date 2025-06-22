@extends('layouts.app')

@section('content')
    <div class="flex justify-center items-center min-h-[85vh] bg-gray-50 py-8">
        <div class="w-full max-w-xl bg-white rounded-2xl shadow-lg p-8">
            <h1 class="text-3xl font-bold text-center text-blue-700 mb-8">Ajouter un nouveau patient</h1>

            @if ($errors->any())
                <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded-lg mb-6" role="alert">
                    <ul class="list-disc pl-5">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form action="{{ route('patients.store') }}" method="POST" class="space-y-5">
                @csrf
                <div>
                    <label for="nom" class="block font-semibold text-gray-700 mb-1">Nom</label>
                    <div class="relative">
                        <span class="absolute inset-y-0 left-0 flex items-center pl-3">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-blue-400" fill="none"
                                viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round"
                                    d="M5.121 17.804A13.937 13.937 0 0112 15c2.485 0 4.847.657 6.879 1.804M15 11a3 3 0 11-6 0 3 3 0 016 0z" />
                            </svg>
                        </span>
                        <input type="text" name="nom" id="nom"
                            class="w-full pl-10 pr-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-300 focus:border-blue-500 transition"
                            value="{{ old('nom') }}" required autocomplete="off">
                    </div>
                </div>

                <div>
                    <label for="prenom" class="block font-semibold text-gray-700 mb-1">Prénom</label>
                    <div class="relative">
                        <span class="absolute inset-y-0 left-0 flex items-center pl-3">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-blue-400" fill="none"
                                viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round"
                                    d="M5.121 17.804A13.937 13.937 0 0112 15c2.485 0 4.847.657 6.879 1.804M15 11a3 3 0 11-6 0 3 3 0 016 0z" />
                            </svg>
                        </span>
                        <input type="text" name="prenom" id="prenom"
                            class="w-full pl-10 pr-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-300 focus:border-blue-500 transition"
                            value="{{ old('prenom') }}" required autocomplete="off">
                    </div>
                </div>

                <div>
                    <label for="date_of_birth" class="block font-semibold text-gray-700 mb-1">Date de naissance</label>
                    <div class="relative">
                        <span class="absolute inset-y-0 left-0 flex items-center pl-3">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-blue-400" fill="none"
                                viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round"
                                    d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                            </svg>
                        </span>
                        <input type="date" name="date_of_birth" id="date_of_birth"
                            class="w-full pl-10 pr-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-300 focus:border-blue-500 transition"
                            value="{{ old('date_of_birth') }}">
                    </div>
                </div>

                <div>
                    <label for="adresse" class="block font-semibold text-gray-700 mb-1">Adresse</label>
                    <div class="relative">
                        <span class="absolute inset-y-0 left-0 flex items-center pl-3">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-blue-400" fill="none"
                                viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round"
                                    d="M17.657 16.657L13.414 12.414a8 8 0 111.414-1.414l4.243 4.243a1 1 0 01-1.414 1.414z" />
                            </svg>
                        </span>
                        <input type="text" name="adresse" id="adresse"
                            class="w-full pl-10 pr-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-300 focus:border-blue-500 transition"
                            value="{{ old('adresse') }}" autocomplete="off">
                    </div>
                </div>

                <div>
                    <label for="gender" class="block font-semibold text-gray-700 mb-1">Genre</label>
                    <select name="gender" id="gender"
                        class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-300 focus:border-blue-500 transition">
                        <option value="">Sélectionner...</option>
                        <option value="Male" {{ old('gender') == 'Male' ? 'selected' : '' }}>Homme</option>
                        <option value="Female" {{ old('gender') == 'Female' ? 'selected' : '' }}>Femme</option>
                    </select>
                </div>

                <div>
                    <label for="blood_group" class="block font-semibold text-gray-700 mb-1">Groupe Sanguin</label>
                    <select name="blood_group" id="blood_group"
                        class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-300 focus:border-blue-500 transition">
                        <option value="">Sélectionner...</option>
                        <option value="A+" {{ old('blood_group') == 'A+' ? 'selected' : '' }}>A+</option>
                        <option value="A-" {{ old('blood_group') == 'A-' ? 'selected' : '' }}>A-</option>
                        <option value="B+" {{ old('blood_group') == 'B+' ? 'selected' : '' }}>B+</option>
                        <option value="B-" {{ old('blood_group') == 'B-' ? 'selected' : '' }}>B-</option>
                        <option value="AB+" {{ old('blood_group') == 'AB+' ? 'selected' : '' }}>AB+</option>
                        <option value="AB-" {{ old('blood_group') == 'AB-' ? 'selected' : '' }}>AB-</option>
                        <option value="O+" {{ old('blood_group') == 'O+' ? 'selected' : '' }}>O+</option>
                        <option value="O-" {{ old('blood_group') == 'O-' ? 'selected' : '' }}>O-</option>
                    </select>
                </div>

                <div>
                    <label for="antecedents" class="block font-semibold text-gray-700 mb-1">Antécédents</label>
                    <textarea name="antecedents" id="antecedents" rows="4"
                        class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-300 focus:border-blue-500 transition">{{ old('antecedents') }}</textarea>
                </div>

                <div class="flex gap-4 mt-6">
                    <button type="submit"
                        class="inline-flex items-center justify-center gap-2 px-6 py-3 rounded-lg bg-blue-600 text-white text-base font-semibold shadow hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-300 transition duration-150">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24"
                            stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7" />
                        </svg>
                        Enregistrer
                    </button>
                    <a href="{{ route('patients.index') }}"
                        class="inline-flex items-center gap-2 px-6 py-3 rounded-lg bg-gray-100 text-gray-600 text-base font-semibold shadow hover:bg-gray-200 focus:outline-none focus:ring-2 focus:ring-gray-300 transition duration-150">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24"
                            stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M15 19l-7-7 7-7" />
                        </svg>
                        Annuler
                    </a>
                </div>

            </form>
        </div>
    @endsection
