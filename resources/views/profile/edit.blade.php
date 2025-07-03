@extends('layouts.app')

@section('content')
<div class="py-12">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
            <div class="p-6 bg-white border-b border-gray-200">
                <h2 class="text-2xl font-semibold text-gray-800 mb-6">Modifier mon profil</h2>
                
                @if (session('success'))
                    <div class="mb-4 p-4 bg-green-100 text-green-700 rounded">
                        {{ session('success') }}
                    </div>
                @endif
                
                <!-- Formulaire de mise à jour -->
                <form method="POST" action="{{ route('profile.update') }}" enctype="multipart/form-data" class="space-y-6">
                    @csrf
                    @method('PUT')
                    
                    <div class="bg-white shadow px-4 py-5 sm:rounded-lg sm:p-6">
                        <div class="md:grid md:grid-cols-3 md:gap-6">
                            <div class="md:col-span-1">
                                <h3 class="text-lg font-medium leading-6 text-gray-900">Photo de profil</h3>
                                <p class="mt-1 text-sm text-gray-500">
                                    Mettez à jour votre photo de profil.
                                </p>
                            </div>
                            <div class="mt-5 md:mt-0 md:col-span-2">
                                <livewire:profile-photo-upload :user="$user" :editable="true" />
                            </div>
                        </div>
                    </div>
                    
                    <div class="bg-white shadow px-4 py-5 sm:rounded-lg sm:p-6">
                        <div class="md:grid md:grid-cols-3 md:gap-6">
                            <div class="md:col-span-1">
                                <h3 class="text-lg font-medium leading-6 text-gray-900">Informations personnelles</h3>
                                <p class="mt-1 text-sm text-gray-500">
                                    Mettez à jour vos informations personnelles.
                                </p>
                            </div>
                            <div class="mt-5 md:mt-0 md:col-span-2">
                                <div class="space-y-6">
                                    <div>
                                        <label for="name" class="block text-sm font-medium text-gray-700">Nom complet</label>
                                        <input type="text" name="name" id="name" autocomplete="name" value="{{ old('name', $user->name) }}" 
                                               class="mt-1 focus:ring-blue-500 focus:border-blue-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md">
                                        @error('name')
                                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                        @enderror
                                    </div>

                                    <div>
                                        <label for="email" class="block text-sm font-medium text-gray-700">Adresse email</label>
                                        <input type="email" name="email" id="email" autocomplete="email" value="{{ old('email', $user->email) }}" 
                                               class="mt-1 focus:ring-blue-500 focus:border-blue-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md">
                                        @error('email')
                                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                        @enderror
                                    </div>
                                    
                                    @if($user->telephone)
                                    <div>
                                        <label for="telephone" class="block text-sm font-medium text-gray-700">Téléphone</label>
                                        <input type="tel" name="telephone" id="telephone" value="{{ old('telephone', $user->telephone) }}" 
                                               class="mt-1 focus:ring-blue-500 focus:border-blue-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md">
                                        @error('telephone')
                                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                        @enderror
                                    </div>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="flex justify-end space-x-3">
                        <a href="{{ route('profile.show') }}" class="inline-flex items-center px-4 py-2 border border-gray-300 shadow-sm text-sm font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                            Annuler
                        </a>
                        <button type="submit" class="inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md shadow-sm text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                            Enregistrer les modifications
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
