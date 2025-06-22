@extends('layouts.app')

@section('content')
    <div class="container mx-auto px-4 py-8">
        <div class="max-w-2xl mx-auto bg-white rounded-lg shadow-md p-8">
            <h1 class="text-2xl font-bold text-gray-800 mb-6">Modifier le Rendez-vous</h1>

            <form action="{{ route('rendez-vous.update', $rendezVou->id) }}" method="POST">
                @csrf
                @method('PUT')
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div class="mb-4">
                        <label for="patient_id" class="block text-gray-700 text-sm font-bold mb-2">Patient</label>
                        <select id="patient_id" name="patient_id"
                            class="shadow border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline @error('patient_id') border-red-500 @enderror"
                            required>
                            @foreach ($patients as $patient)
                                <option value="{{ $patient->id }}"
                                    {{ old('patient_id', $rendezVou->patient_id) == $patient->id ? 'selected' : '' }}>
                                    {{ $patient->prenom }} {{ $patient->nom }}
                                </option>
                            @endforeach
                        </select>
                        @error('patient_id')
                            <p class="text-red-500 text-xs italic mt-2">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="mb-4">
                        <label for="user_id" class="block text-gray-700 text-sm font-bold mb-2">Assigné à</label>
                        <select id="user_id" name="user_id"
                            class="shadow border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline @error('user_id') border-red-500 @enderror"
                            required>
                            @foreach ($users as $user)
                                <option value="{{ $user->id }}"
                                    {{ old('user_id', $rendezVou->user_id) == $user->id ? 'selected' : '' }}>
                                    {{ $user->name }}
                                </option>
                            @endforeach
                        </select>
                        @error('user_id')
                            <p class="text-red-500 text-xs italic mt-2">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <div class="mb-4">
                    <label for="date_rendez_vous" class="block text-gray-700 text-sm font-bold mb-2">Date et Heure du
                        Rendez-vous</label>
                    <input type="datetime-local" id="date_rendez_vous" name="date_rendez_vous"
                        value="{{ old('date_rendez_vous', $rendezVou->date_rendez_vous->format('Y-m-d\TH:i')) }}"
                        class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline @error('date_rendez_vous') border-red-500 @enderror"
                        required>
                    @error('date_rendez_vous')
                        <p class="text-red-500 text-xs italic mt-2">{{ $message }}</p>
                    @enderror
                </div>

                <div class="mb-4">
                    <label for="statut" class="block text-gray-700 text-sm font-bold mb-2">Statut</label>
                    <select id="statut" name="statut"
                        class="shadow border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"
                        required>
                        <option value="Planifié" {{ old('statut', $rendezVou->statut) == 'Planifié' ? 'selected' : '' }}>
                            Planifié</option>
                        <option value="Confirmé" {{ old('statut', $rendezVou->statut) == 'Confirmé' ? 'selected' : '' }}>
                            Confirmé</option>
                        <option value="Annulé" {{ old('statut', $rendezVou->statut) == 'Annulé' ? 'selected' : '' }}>Annulé
                        </option>
                        <option value="Terminé" {{ old('statut', $rendezVou->statut) == 'Terminé' ? 'selected' : '' }}>
                            Terminé</option>
                    </select>
                    @error('statut')
                        <p class="text-red-500 text-xs italic mt-2">{{ $message }}</p>
                    @enderror
                </div>

                <div class="mb-6">
                    <label for="motif" class="block text-gray-700 text-sm font-bold mb-2">Motif du rendez-vous</label>
                    <textarea id="motif" name="motif" rows="4"
                        class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline @error('motif') border-red-500 @enderror">{{ old('motif', $rendezVou->motif) }}</textarea>
                    @error('motif')
                        <p class="text-red-500 text-xs italic mt-2">{{ $message }}</p>
                    @enderror
                </div>

                <div class="flex items-center justify-between">
                    <button type="submit"
                        class="bg-blue-600 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline">
                        Mettre à jour
                    </button>
                    <a href="{{ route('rendez-vous.index') }}"
                        class="inline-block align-baseline font-bold text-sm text-blue-500 hover:text-blue-800">
                        Annuler
                    </a>
                </div>
            </form>
        </div>
    </div>
@endsection
